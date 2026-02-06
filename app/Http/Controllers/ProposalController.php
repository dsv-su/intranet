<?php

namespace App\Http\Controllers;

use App\Jobs\SendFinalToRegistrator;
use App\Jobs\SendGrantToRegistrator;
use App\Mail\GrantNotificationVice;
use App\Mail\SentNotificationVice;
use App\Models\BudgetTemplate;
use App\Models\Dashboard;
use App\Models\DsvBudget;
use App\Models\ProjectProposal;
use App\Models\ResearchArea;
use App\Models\SettingsFo;
use App\Models\SettingsFoEu;
use App\Models\SettingsOh;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use App\Services\Budget\Budget;
use App\Services\Budget\ReCalcBudget;
use App\Services\Review\DashboardRole;
use App\Services\Review\ProposalFileReviewService;
use App\Services\Review\WorkflowHandler;
use App\Services\Role\RoleHandler;
use App\Services\Send\FilesForRegistrator;
use App\Workflows\DSVProjectPWorkflow;
use App\Workflows\Partials\RequestStates;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Statamic\View\View;
use Workflow\WorkflowStub;

class ProposalController extends Controller
{
    public function __construct()
    {
        $this->middleware(['web', 'auth', 'dsv']);
    }
    public function pp($slug = 'my')
    {
        // Check if form is enabled
        if (!SettingsOh::first()->form_enable) {
            return (new \Statamic\View\View)
                ->template('pp.disabled')
                ->with(['breadcrumb' => 'Disabled']);
                //->layout('mylayout');
        }

        // User roles handling (testmode)
        $roles = (new RoleHandler(auth()->user()))->show();

        // Slug mapping
        $breadcrumbs = [
            'my' => 'My proposals',
            'awaiting' => 'Awaiting review',
            'all' => 'Proposals',
        ];

        return (new \Statamic\View\View)
            ->template('pp.index')
            ->with([
                'page' => $slug,
                'breadcrumb' => $breadcrumbs[$slug] ?? 'Unknown',
                'roles' => $roles
            ]);
            //->layout('mylayout');
    }
    public function pp_edit($id)
    {
        $viewData = $this->prepareProjectProposalData($id);
        $viewData['proposal'] = ProjectProposal::find($id);
        $viewData['dashboard'] = Dashboard::where('request_id', $id)->first();
        $viewData['type'] = 'edit';

        return $this->createView('pp.create', 'mylayout', $viewData);
    }

    public function pp_resume($id)
    {
        $viewData = $this->prepareProjectProposalData($id);
        $viewData['proposal'] = ProjectProposal::find($id);
        $viewData['dashboard'] = Dashboard::where('request_id', $id)->first();
        $viewData['budget'] = DsvBudget::find(1);
        $viewData['type'] = 'resume';

        return $this->createView('pp.create', 'mylayout', $viewData);
    }

    public function usermanual()
    {
        $manual = 'PPManual.pdf';
        return Storage::download($manual);
    }
    public function budget()
    {
        $template     = BudgetTemplate::first();
        $files        = $template->files;
        $firstFile    = reset($files);
        $downloadPath = $firstFile['path'];

        return Storage::download($downloadPath,'dsv_budgettemplate.xlsx');
    }

    public function create()
    {
        $viewData = $this->prepareProjectProposalData();
        $viewData['type'] = 'preapproval';

        return $this->createView('pp.create', 'mylayout', $viewData);
    }

    public function pp_complete($id)
    {
        $viewData = $this->prepareProjectProposalData($id);
        $viewData['proposal'] = ProjectProposal::find($id);
        $viewData['dashboard'] = Dashboard::where('request_id', $id)->first();
        $viewData['type'] = 'complete';

        return $this->createView('pp.create', 'mylayout', $viewData);
    }

    public function upload($id)
    {
        $viewData = $this->prepareProjectProposalData($id);
        $viewData['proposal'] = ProjectProposal::find($id);
        $viewData['dashboard'] = Dashboard::where('request_id', $id)->first();
        $viewData['type'] = 'complete';
        $viewData['upload'] = true;

        return $this->createView('pp.create', 'mylayout', $viewData);
    }

    /***
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */

    /**
     * Submit
     */
    public function submit(Request $request)
    {
        $this->validateRequest($request);

        $userId = $request->user()->id;
        $submittedAt = now();
        $createdTs = $submittedAt->copy()->startOfDay()->timestamp;

        return match ($request->type) {
            'preapproval' => $this->handlePreapproval($request, $userId, $submittedAt, $createdTs),
            'complete'    => $this->handleComplete($request, $userId, $submittedAt),
            'edit'        => $this->handleEdit($request, $userId, $submittedAt, $createdTs),
            'resume'      => $this->handleResume($request, $userId, $submittedAt, $createdTs),
            'sent'        => $this->handleSent($request, $submittedAt),
            'granted'     => $this->handleGranted($request, $submittedAt),
            'rejected'    => $this->handleRejected($request, $submittedAt),
            'review'      => $this->handleReview($request, $submittedAt),
            default       => abort(422, 'Invalid submit type'),
        };
    }

    /* -------------------------------------------------------------------------
     | Handlers
     * ---------------------------------------------------------------------- */

    private function handlePreapproval(Request $request, string $userId, Carbon $submittedAt, int $createdTs)
    {
        return DB::transaction(function () use ($request, $userId, $submittedAt, $createdTs) {

            $pp = ProjectProposal::findOrFail($request->id);

            $pp->fill([
                'user_id' => $userId,
                'name' => $request->title,
                'created' => $createdTs,
                'status_stage1' => 'pending',
                'status_stage2' => 'pending',
                'status_stage3' => 'submitted',
                'pp' => $this->buildPpPayload($request, [
                    'submitted' => $submittedAt->toISOString(),
                    'status' => 'pending',
                ]),
            ])->save();

            $dashboard = $this->upsertDashboardWithUnitHeads(
                $pp,
                $request,
                $this->dashboardBaseData($pp, $request, $userId, $createdTs, 'unread')
            );

            // Start workflow and store workflow ID
            $this->createAndStartWorkflow($dashboard);

            // Check files
            $this->checkFileStatus($pp);

            return redirect()->route('pp', 'my')
                ->with('success', 'Your Project proposal draft has successfully been submitted!');
        });
    }

    private function handleComplete(Request $request, string $userId, Carbon $submittedAt)
    {
        return DB::transaction(function () use ($request, $userId, $submittedAt) {

            $pp = ProjectProposal::findOrFail($request->id);

            // Merge JSON safely (recursive) and preserve existing keys such as 'files'
            $updatedPp = $this->mergePp($pp->pp ?? [], [
                ...$request->only([
                    'unit_head', 'program', 'decision_exp', 'funding_organization',
                    'start_date', 'submission_deadline',
                    'budget_project', 'budget_dsv', 'budget_phd', 'currency',
                    'oh_cost', 'cofinancing_needed', 'user_comments'
                ]),
                'submitted' => $submittedAt->toISOString(),
                'status' => 'completed',
                // Explicitly keep these (as you did)
                'co_investigator_name' => $request->co_investigator_name,
                'co_investigator_email' => $request->co_investigator_email,
                'co_investigator_type' => $request->co_investigator_type,
                'co_investigator_role' => $request->co_investigator_role,
            ]);

            $pp->update(['pp' => $updatedPp]);

            $this->comments_update($pp->id, $request->edit_comments, 'completed');

            $dashboard = Dashboard::query()
                ->where('request_id', $pp->id)
                ->firstOrFail();

            $this->setUnitHeadsOnDashboard($dashboard, (array) $request->unit_head);

            if ($this->checkFiles($pp)) {
                $workflowhandler = new WorkflowHandler($dashboard->workflow_id);
                $workflowhandler->Completed();

                return redirect()->route('pp', 'my')
                    ->with('success', 'Your Project proposal files have successfully been uploaded!');
            }

            return redirect()->route('pp', 'my')
                ->with('success', 'Your Project proposal has been updated!');
        });
    }

    private function handleEdit(Request $request, string $userId, Carbon $submittedAt, int $createdTs)
    {
        return DB::transaction(function () use ($request, $userId, $submittedAt, $createdTs) {

            $pp = ProjectProposal::findOrFail($request->id);

            $pp->fill([
                'user_id' => $userId,
                'name' => $request->title,
                'created' => $createdTs,
                'pp' => $this->buildPpPayload($request, [
                    'submitted' => $submittedAt->toISOString(),
                    'status' => 'edited',
                ]),
            ])->save();

            $this->comments_update($pp->id, $request->edit_comments, 'edit');

            $dashboard = $this->upsertDashboardWithUnitHeads(
                $pp,
                $request,
                $this->dashboardBaseData($pp, $request, $userId, $createdTs, 'edited')
            );

            return redirect()->route('pp', 'my')->with('success', 'Proposal successfully updated!');
        });
    }

    private function handleResume(Request $request, string $userId, Carbon $submittedAt, int $createdTs)
    {
        return DB::transaction(function () use ($request, $userId, $submittedAt, $createdTs) {

            $pp = ProjectProposal::findOrFail($request->id);

            // TODO Resume doesn't set status/submitted
            $pp->fill([
                'user_id' => $userId,
                'name' => $request->title,
                'created' => $createdTs,
                'pp' => $this->buildPpPayload($request, []), // no forced status
            ])->save();

            $this->comments_update($pp->id, $request->edit_comments, 'resumed');

            $dashboard = Dashboard::updateOrCreate(
                ['request_id' => $pp->id],
                ['request_id' => $pp->id, 'name' => $request->title]
            );

            $this->resumeWorkflow($dashboard);
            $this->checkFileStatus($pp);

            return redirect()->route('pp', 'my')->with('success', 'Proposal successfully resumed!');
        });
    }

    private function handleSent(Request $request, Carbon $submittedAt)
    {
        return DB::transaction(function () use ($request, $submittedAt) {

            $pp = ProjectProposal::findOrFail($request->id);

            $files = is_array($pp->files ?? null) ? $pp->files : [];
            $finalFile = collect($files)->first(fn ($file) => isset($file['type']) && $file['type'] === 'final');

            if (!$finalFile) {
                return redirect()->route('pp', 'my')
                    ->with('error', 'Please make sure to upload your final application before the reporting');
            }

            $pp->update([
                'pp' => $this->mergePp($pp->pp ?? [], [
                    'submitted' => $submittedAt->toISOString(),
                    'status' => 'sent',
                ]),
                'status_stage1' => 'sent',
            ]);

            $dashboard = Dashboard::query()->where('request_id', $pp->id)->firstOrFail();
            $dashboard->state = 'sent';
            $dashboard->save();

            // Create attachment zip
            $reg = new FilesForRegistrator($pp);
            $reg->storeFiles();

            // Dispatch + mail after commit so we don't notify if DB fails
            DB::afterCommit(function () use ($pp, $dashboard) {
                $filePath = public_path('download/' . $pp->id . '/' . 'ProjectProposal-' . $pp->name . '.zip');

                $user = User::find($pp->dashboard->user_id);
                SendFinalToRegistrator::dispatch($user, $pp->dashboard, $filePath);

                $submitter = User::find($dashboard->user_id);
                $vice = $this->getViceHeadUser();
                Mail::to($vice->email)->send(new SentNotificationVice($submitter, $vice, $dashboard));
            });

            return redirect()->route('pp', 'my')
                ->with('success', 'Your proposal has been successfully registered as sent. Thank you!');
        });
    }

    private function handleGranted(Request $request, Carbon $submittedAt)
    {
        return DB::transaction(function () use ($request, $submittedAt) {

            $pp = ProjectProposal::findOrFail($request->id);

            $pp->update([
                'pp' => $this->mergePp($pp->pp ?? [], [
                    ...$request->only(['granted', 'cofinanced_promised', 'phd_promised', 'granted_comments']),
                    'submitted' => $submittedAt->toISOString(),
                    'status' => 'granted',
                ]),
                'status_stage1' => 'granted',
            ]);

            $dashboard = Dashboard::query()->where('request_id', $pp->id)->firstOrFail();
            $dashboard->state = 'granted';
            $dashboard->save();

            $this->comments_update($pp->id, $request->edit_comments, 'granted');

            $reg = new FilesForRegistrator($pp);
            $reg->storeDecisionLetter();

            DB::afterCommit(function () use ($pp, $dashboard) {
                $filePath = public_path('download/' . $pp->id . '/' . 'ProjectProposal-' . $pp->name . '.zip');

                $user = User::find($pp->dashboard->user_id);
                SendGrantToRegistrator::dispatch($user, $pp->dashboard, $filePath);

                $submitter = User::find($dashboard->user_id);
                $vice = $this->getViceHeadUser();
                Mail::to($vice->email)->send(new GrantNotificationVice($submitter, $vice, $dashboard));
            });

            return redirect()->route('pp', 'my')
                ->with('success', 'Your project proposal has been successfully registered as a granted project!');
        });
    }

    private function handleRejected(Request $request, Carbon $submittedAt)
    {
        return DB::transaction(function () use ($request, $submittedAt) {

            $pp = ProjectProposal::findOrFail($request->id);

            $pp->update([
                'pp' => $this->mergePp($pp->pp ?? [], [
                    ...$request->only(['rejected', 'rejected_comments']),
                    'submitted' => $submittedAt->toISOString(),
                    'status' => 'denied',
                ]),
            ]);

            $dashboard = Dashboard::query()->where('request_id', $pp->id)->firstOrFail();
            $dashboard->state = 'denied';
            $dashboard->save();

            $this->comments_update($pp->id, $request->edit_comments, 'rejected');

            $reg = new FilesForRegistrator($pp);
            $reg->storeDecisionLetter();

            DB::afterCommit(function () use ($pp) {
                $filePath = public_path('download/' . $pp->id . '/' . 'ProjectProposal-' . $pp->name . '.zip');

                $user = User::find($pp->dashboard->user_id);

                // NOTE: Your original code dispatches SendGrantToRegistrator here too.
                // If you have a separate "SendRejectedToRegistrator", swap it in.
                SendGrantToRegistrator::dispatch($user, $pp->dashboard, $filePath);
            });

            return redirect()->route('pp', 'my')
                ->with('success', 'Your project proposal has been registered as a denied project!');
        });
    }

    private function handleReview(Request $request, Carbon $submittedAt)
    {
        return DB::transaction(function () use ($request, $submittedAt) {

            $pp = ProjectProposal::findOrFail($request->id);

            $pp->update([
                'pp' => $this->mergePp($pp->pp ?? [], [
                    ...$request->only(['budget_project', 'budget_dsv', 'cofinancing_needed', 'budget_php']),
                    'submitted' => $submittedAt->toISOString(),
                    'status' => 'revised',
                ]),
            ]);

            $this->comments_update($pp->id, 'The budget has been revised by the financial administrator.', 'updated');

            return redirect()->back()
                ->withFragment('project_budget')
                ->with('success', 'Budget has been updated')
                ->withInput();
        });
    }

    /* -------------------------------------------------------------------------
     | Shared helpers (reduce duplication)
     * ---------------------------------------------------------------------- */

    private function buildPpPayload(Request $request, array $overrides = []): array
    {
        // Keep your original list as the base
        $base = $request->only([
            'title', 'objective', 'principal_investigator', 'principal_investigator_email',
            'co_investigator_name', 'co_investigator_email', 'co_investigator_type', 'co_investigator_role',
            'research_area', 'dsvcoordinating', 'other_coordination', 'eu', 'eu_wallenberg',
            'funding_organization', 'cofinancing', 'other_cofinancing', 'project_duration',
            'unit_head', 'program', 'decision_exp', 'start_date', 'submission_deadline',
            'budget_project', 'budget_dsv', 'budget_phd', 'currency', 'oh_cost',
            'cofinancing_needed', 'user_comments'
        ]);

        return $base + $overrides;
    }

    private function mergePp(array $existing, array $incoming): array
    {
        // Recursive safe merge so nested structures aren't blown away
        return array_replace_recursive($existing, $incoming);
    }

    private function dashboardBaseData(ProjectProposal $pp, Request $request, string $userId, int $createdTs, string $status): array
    {
        ['fo' => $foUserId, 'fo_eu' => $foEuUserId] = $this->getFoIds();

        $euYes = $this->truthy(data_get($pp->pp, 'eu'));
        $foId = $euYes ? $foEuUserId : $foUserId;

        return [
            'request_id' => $pp->id,
            'name'       => $request->title,
            'created'    => $createdTs,
            'status'     => $status,
            'type'       => 'projectproposal',
            'user_id'    => $userId,
            'fo_id'      => $foId,
            'vice_id'    => $this->getViceHeadUserId(),
        ];
    }

    private function upsertDashboardWithUnitHeads(ProjectProposal $pp, Request $request, array $dashboardData): Dashboard
    {
        $dashboard = Dashboard::updateOrCreate(
            ['request_id' => $pp->id],
            $dashboardData
        );

        $this->setUnitHeadsOnDashboard($dashboard, (array) $request->unit_head);

        return $dashboard;
    }

    private function setUnitHeadsOnDashboard(Dashboard $dashboard, array $unitHeads): void
    {
        $unitHeads = array_values(array_filter($unitHeads, fn ($v) => $v !== null && $v !== ''));

        $dashboard->unit_heads = $unitHeads;
        $dashboard->unit_head_approved = collect($unitHeads)
            ->mapWithKeys(fn ($uh) => [$uh => 0])
            ->toJson();

        $dashboard->multiple_heads = count($unitHeads) > 1;
        $dashboard->save();
    }

    private function getFoIds(): array
    {
        return Cache::remember('fo_ids', 600, function () {
            return [
                'fo'    => SettingsFo::query()->whereKey(1)->value('user_id'),
                'fo_eu' => SettingsFoEu::query()->whereKey(1)->value('user_id'),
            ];
        });
    }

    private function truthy($value): bool
    {
        // Handles 'yes', '1', 1, true, 'true', etc.
        if (is_string($value)) {
            $value = strtolower(trim($value));
            if (in_array($value, ['yes', 'y'], true)) return true;
            if (in_array($value, ['no', 'n'], true)) return false;
        }
        return filter_var($value, FILTER_VALIDATE_BOOL);
    }

    public function decision(Request $request)
    {
        //Trigger signal
        $dashboard = Dashboard::where('request_id', $request->id)->first();
        $role = new DashboardRole($dashboard, $user = auth()->user());
        $workflowhandler = new WorkflowHandler($dashboard->workflow_id);
        //dd($request->decision, $user, $role->check());
        switch($request->decision) {
            case 'approve':
                //Update comments
                $this->comments_update($request->id, $request->comment, 'approved');
                switch($role->check()) {
                    case 'head':
                        //Approve draft file
                        (new ProposalFileReviewService($request->id))
                            ->approvePendingByType('draft');
                        //Flag approved
                        $headGroup = $dashboard;
                        $unitHeadApproved = json_decode($headGroup->unit_head_approved, true);
                        $keyToUpdate = $user->id;

                        if (isset($unitHeadApproved[$keyToUpdate]) && $unitHeadApproved[$keyToUpdate] === 0) {
                            $unitHeadApproved[$keyToUpdate] = 1;
                        }
                        $headGroup->unit_head_approved = json_encode($unitHeadApproved);
                        $headGroup->save();

                        if (!in_array(0, json_decode($dashboard->unit_head_approved, true))) {
                            $workflowhandler->HeadApprove();
                        }

                        //Update budget stats
                        $proposal = ProjectProposal::find($dashboard->request_id);
                        $budget = new Budget($proposal);
                        //Preapproval count
                        $budget->preapproved_increment($proposal->pp['research_area']);
                        $budget->budget_increment($proposal->pp['research_area']);
                        $budget->phd_increment($proposal->pp['research_area']);
                        $budget->cost_increment($proposal->pp['research_area']);
                        break;
                    case 'fo':
                        //Approve budgetfile
                        (new ProposalFileReviewService($request->id))
                            ->approvePendingByType('budget');
                        //Signal state change
                        $workflowhandler->FOApprove();
                        break;
                    case 'vice_final':
                        $workflowhandler->FinalApprove();
                        break;
                }
                break;
            case 'deny':
                //Update comments
                $this->comments_update($request->id, $request->comment, 'denied');
                switch($role->check()) {
                    case 'head':
                        $workflowhandler->HeadDeny();
                        $calc = new ReCalcBudget();
                        $calc->scan();
                        break;
                    case 'fo':
                        $workflowhandler->FODeny();
                        $calc = new ReCalcBudget();
                        $calc->scan();
                        break;
                    case 'vice_final':
                        $workflowhandler->FinalDeny();
                        break;
                }
                break;
            case 'return':
                //Update comments
                $this->comments_update($request->id, $request->comment, 'returned');
                switch($role->check()) {
                    case 'head':
                        $workflowhandler->HeadReturn();
                        $calc = new ReCalcBudget();
                        $calc->scan();
                        break;
                    case 'fo':
                        $workflowhandler->FOReturn();
                        $calc = new ReCalcBudget();
                        $calc->scan();
                        break;
                    case 'vice_final':
                        $workflowhandler->FinalReturn();
                        $calc = new ReCalcBudget();
                        $calc->scan();
                        break;
                }
                break;
        }
        return redirect()->route('pp', ['slug' =>'awaiting']);
    }

    public function pp_sent($id)
    {
        $viewData = $this->prepareProjectProposalData($id);
        $viewData['proposal'] = ProjectProposal::find($id);
        $viewData['dashboard'] = Dashboard::where('request_id', $id)->first();
        $viewData['type'] = 'sent';

        return $this->createView('pp.create', 'mylayout', $viewData);
    }

    public function pp_granted($id)
    {
        $viewData = $this->prepareProjectProposalData($id);
        $viewData['proposal'] = ProjectProposal::find($id);
        $viewData['dashboard'] = Dashboard::where('request_id', $id)->first();
        $viewData['type'] = 'granted';

        return $this->createView('pp.create', 'mylayout', $viewData);
    }

    public function pp_rejected($id)
    {
        $viewData = $this->prepareProjectProposalData($id);
        $viewData['proposal'] = ProjectProposal::find($id);
        $viewData['dashboard'] = Dashboard::where('request_id', $id)->first();
        $viewData['type'] = 'rejected';

        return $this->createView('pp.create', 'mylayout', $viewData);
    }

    protected function validateRequest(Request $request)
    {
        $rules = [
            'title' => 'required',
            'objective' => 'required',
            'principal_investigator' => 'required',
            //'project_duration' => 'required|numeric|integer',
            //'oh_cost' => 'required|numeric|max:56'
        ];

        return $this->validate($request, $rules);
    }

    protected function comments_update($id, $comment, $type = null)
    {
        //Proposal user comments
        $proposal = ProjectProposal::find($id);
        $user_comments = $proposal->pp['user_comments'] ?? '';

        //Timestamp
        $timestamp = now()->format('d/m/Y');
        $user = auth()->user()->name;
        $tag = '**';

        switch ($type) {
            case 'edit':
                $comments_tag = $tag . '  ' . 'Proposal has been EDITED by ' . $user . '  ' . $timestamp . '  ' . $tag;
                break;
            case 'completed':
                $comments_tag = $tag . '  ' . 'Proposal has been COMPLETED by ' . $user . '  ' . $timestamp . '  ' . $tag;
                break;
            case 'approved':
                $comments_tag = $tag . '  ' . 'Proposal has been APPROVED by ' . $user . '  ' . $timestamp . '  ' . $tag;
                break;
            case 'returned':
                $comments_tag = $tag . '  ' . 'Proposal has been RETURNED by ' . $user . '  ' . $timestamp . '  ' . $tag;
                break;
            case 'denied':
                $comments_tag = $tag . '  ' . 'Proposal has been DENIED by ' . $user . '  ' . $timestamp . '  ' . $tag;
                break;
            case 'resumed':
                $comments_tag = $tag . '  ' . 'Proposal has been RESUMED by ' . $user . '  ' . $timestamp . '  ' . $tag;
                break;
            case 'granted':
                $comments_tag = $tag . '  ' . 'Proposal has been GRANTED reported by ' . $user . '  ' . $timestamp . '  ' . $tag;
                break;
            case 'rejected':
                $comments_tag = $tag . '  ' . 'Proposal has been REJECTED reported by ' . $user . '  ' . $timestamp . '  ' . $tag;
                break;
            case 'updated':
                $comments_tag = $tag . '  ' . 'Proposal has been REVISED by ' . $user . '  ' . $timestamp . '  ' . $tag;
                break;
            default:
                $comments_tag = $tag . '  ' . $user . '  ' . $timestamp . '  ' . $tag;
                break;
        }

        //Merge with reviewer comments
        return ProjectProposal::where('id', $id)
            ->update(['pp->user_comments' =>
                Str::of($user_comments)->newLine()
                    ->append($comments_tag)
                    ->newLine()
                    ->append($comment)
                    ->newLine()
                    ->newLine()
            ]);
    }

    protected function createAndStartWorkflow($dashboard)
    {
        $workflow = WorkflowStub::make(DSVProjectPWorkflow::class);
        $dashboard->workflow_id = $workflow->id();
        $dashboard->save();
        $workflow->start($dashboard);
        $workflow->submit();
        return $workflow;
    }

    protected function resumeWorkflow($dashboard)
    {
        switch($dashboard->state) {
            case(RequestStates::HEAD_RETURNED):
                $dashboard->state = RequestStates::SUBMITTED;
                $dashboard->save();
                $workflow = WorkflowStub::make(\App\Workflows\ResumeFromUHProjectWorkflow::class);
                break;
            case(RequestStates::FO_RETURNED):
                $dashboard->state = RequestStates::SUBMITTED;
                $dashboard->save();
                $workflow = WorkflowStub::make(\App\Workflows\ResumeFromFOProjectWorkflow::class);
                break;
            case(RequestStates::FINAL_RETURNED):
                $dashboard->state = RequestStates::SUBMITTED;
                $dashboard->save();
                $workflow = WorkflowStub::make(\App\Workflows\ResumeFromFinalProjectWorkflow::class);
                break;
        }
        $dashboard->workflow_id = $workflow->id();
        $dashboard->save();
        $workflow->start($dashboard);
        $workflow->submit();

        return $workflow;
    }

    /***
     * Private functions
     */

    private function checkFiles($proposal): bool
    {
        return $proposal->hasAtLeastFilesOfType('draft', 1)
            && $proposal->hasAtLeastFilesOfType('budget', 1);
    }

    private function checkFileStatus($proposal)
    {
        $workflowhandler = new WorkflowHandler($proposal->dashboard->workflow_id);

        if ($this->checkFiles($proposal)) {
            //Signal workflow
            $workflowhandler->UploadedFiles();

            //Budgetfiles
            if($proposal->isTypeFullyApproved('budget')) {
                $workflowhandler->BudgetFileUnchanged();
            } else {
                $workflowhandler->BudgetFileChanged();
            }

            //Draftfiles
            if($proposal->isTypeFullyApproved('draft')) {
                $workflowhandler->DraftFileUnchanged();
            } else {
                $workflowhandler->DraftFileChanged();
            }
            return true;
        } else {
            //Signal workflow
            $workflowhandler->RemovedFile();
        }
        return false;
    }

    private function getViceHeadUserId(): string
    {
        return DB::table('role_user')
            ->where('role_id', 'vice_head')
            ->value('user_id');
    }

    private function getViceHeadUser()
    {
        $viceUserID = DB::table('role_user')
            ->where('role_id', 'vice_head')
            ->value('user_id');
        return User::find($viceUserID);
    }

    private function prepareProjectProposalData(?string $id = null)
    {
        $roleIdsUnitHead = $this->getUserIdsByGroup('enhetschef');
        $unitheads = User::whereIn('id', $roleIdsUnitHead)->get();
        $research_areas = ResearchArea::all();

        if ($id) {
            // Edit existing, or create if not found
            $proposal = \App\Models\ProjectProposal::firstOrNew(['id' => $id]);
        } else {
            // Create new
            $proposal = new \App\Models\ProjectProposal();
        }

        //User
        $userId = Auth::user()->id;

        if (! $proposal->exists) {
            $proposal->fill([
                'user_id' => $userId,
                'name' => '',
                'created' => now()->startOfDay()->timestamp,
                'status_stage1' => 'pending',
                'status_stage2' => 'pending',
                'status_stage3' => 'pending',
                'files' => [],
            ]);
            $proposal->save();
        }

        return [
            'unitheads' => $unitheads,
            'research_areas' => $research_areas,
            'proposal' => $proposal
        ];
    }

    private function getUserIdsByGroup($group)
    {
        return DB::table('group_user')->where('group_id', $group)->pluck('user_id');
    }

    private function createView($template, $layout, $data)
    {
        return (new View)->template($template)->layout($layout)->with($data);
    }
}
