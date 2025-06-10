<?php

namespace App\Http\Controllers;

use App\Mail\GrantNotificationVice;
use App\Models\Dashboard;
use App\Models\DsvBudget;
use App\Models\ProjectProposal;
use App\Models\ResearchArea;
use App\Models\SettingsFo;
use App\Models\SettingsOh;
use App\Models\User;
use App\Services\Budget\Budget;
use App\Services\Review\DashboardRole;
use App\Services\Review\WorkflowHandler;
use App\Services\Role\RoleHandler;
use App\Workflows\DSVProjectPWorkflow;
use App\Workflows\Partials\RequestStates;
use App\Workflows\ProjectWorkflow;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;
use Statamic\View\View;
use Workflow\WorkflowStub;

class ProposalController extends Controller
{
    public function __construct()
    {
        $this->middleware(['web', 'auth', 'dsv']);
    }
    public function pp($slug)
    {
        // Check if form is enabled
        if (!SettingsOh::first()->form_enable) {
            return (new \Statamic\View\View)
                ->template('pp.disabled')
                ->with(['breadcrumb' => 'Disabled'])
                ->layout('mylayout');
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
            ])
            ->layout('mylayout');
    }
    public function pp_edit($id)
    {
        $viewData = $this->prepareProjectProposalData();
        $viewData['proposal'] = ProjectProposal::find($id);
        $viewData['dashboard'] = Dashboard::where('request_id', $id)->first();
        $viewData['type'] = 'edit';

        return $this->createView('pp.create', 'mylayout', $viewData);
    }

    public function pp_resume($id)
    {
        $viewData = $this->prepareProjectProposalData();
        $viewData['proposal'] = ProjectProposal::find($id);
        $viewData['dashboard'] = Dashboard::where('request_id', $id)->first();
        $viewData['budget'] = DsvBudget::find(1);
        $viewData['type'] = 'resume';

        return $this->createView('pp.create', 'mylayout', $viewData);
    }
    public function create()
    {
        $viewData = $this->prepareProjectProposalData();
        $viewData['type'] = 'preapproval';

        return $this->createView('pp.create', 'mylayout', $viewData);
    }

    public function pp_complete($id)
    {
        $viewData = $this->prepareProjectProposalData();
        $viewData['proposal'] = ProjectProposal::find($id);
        $viewData['dashboard'] = Dashboard::where('request_id', $id)->first();
        $viewData['type'] = 'complete';

        return $this->createView('pp.create', 'mylayout', $viewData);
    }

    public function upload($id)
    {
        $viewData = $this->prepareProjectProposalData();
        $viewData['proposal'] = ProjectProposal::find($id);
        $viewData['dashboard'] = Dashboard::where('request_id', $id)->first();
        $viewData['type'] = 'complete';
        $viewData['upload'] = true;
        //dd($viewData);
        return $this->createView('pp.create', 'mylayout', $viewData);
    }

    /***
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */

    public function submit(Request $request)
    {
        // Validate and retrieve request data
        $this->validateRequest($request);

        // Financial officer and authenticated user retrieval
        $foUserId = SettingsFo::find(1)?->user_id;

        //User
        $userId = Auth::user()->id;

        //Timestamp
        $timestamp = now()->startOfDay()->timestamp;

        //Check submit type
        switch ($request->type) {
            case 'preapproval':
                $pp = ProjectProposal::find($request->id);
                $pp->fill([
                    'user_id' => $userId,
                    'name' => $request->title,
                    'created' => $timestamp,
                    'status_stage1' => 'pending',
                    'status_stage2' => 'pending',
                    'status_stage3' => 'submitted',
                    'pp' => $request->only([
                            'title', 'objective', 'principal_investigator', 'principal_investigator_email',
                            'co_investigator_name', 'co_investigator_email', 'research_area',
                            'dsvcoordinating', 'other_coordination', 'eu', 'eu_wallenberg', 'funding_organization',
                            'cofinancing', 'other_cofinancing', 'project_duration', 'unit_head', 'program', 'decision_exp', 'funding_organization',
                            'start_date', 'submission_deadline',
                            'budget_project', 'budget_dsv', 'budget_phd', 'currency', 'oh_cost', 'cofinancing_needed','user_comments'
                        ]) + [
                            'submitted' => $timestamp,
                            'status' => 'pending'
                        ]
                ]);
                // Save Project Proposal
                $pp->save();

                // Dashboard instance creation or update
                $dashboardData = [
                    'request_id' => $pp->id,
                    'name' => $request->title,
                    'created' => $timestamp,
                    'status' => 'unread',
                    'type' => 'projectproposal',
                    'user_id' => $userId,
                    'fo_id' => $foUserId,
                    'vice_id' => $this->getViceHeadUserId()
                ];

                $dashboard = Dashboard::updateOrCreate(['request_id' => $pp->id], $dashboardData);
                // Create unit head approved array
                $uh_group = $dashboard;
                $uh_group->unit_heads = $request->unit_head;
                $unit_head_approved = [];
                foreach ($request->unit_head as $uh) {
                    $unit_head_approved[$uh] = 0;
                }
                // Encode associative array to JSON
                $uh_group->unit_head_approved = json_encode($unit_head_approved);
                $uh_group->save();
                if (count($request->unit_head) > 1) {
                    //Flag multiple
                    $uh_group->multiple_heads = true;
                    $uh_group->save();
                }

                //Budget
                $budget = new Budget($pp);
                $budget->budget_increment($pp->pp['research_area']);
                $budget->phd_increment($pp->pp['research_area']);
                $budget->cost_increment($pp->pp['research_area']);

                // Start workflow and store workflow ID
                $workflow = $this->createAndStartWorkflow($pp->dashboard);
                $this->workflowID = $workflow->id();

                //Check files
                $this->checkFileStatus($pp);

                return redirect()->route('pp', 'my')->with('success', 'Your Project proposal draft has successfully been submitted!');
                break;
            case 'complete':
                $pp = ProjectProposal::find($request->id);
                $existingPp = $pp->pp; // Get existing JSON attribute as an array
                // Merge new values while keeping existing subattributes
                $updatedPp = array_merge($existingPp, $request->only([
                    'unit_head', 'program', 'decision_exp', 'funding_organization',
                    'start_date', 'submission_deadline',
                    'budget_project', 'budget_dsv', 'budget_phd', 'currency', 'oh_cost', 'cofinancing_needed', 'user_comments'
                ]), [
                    'submitted' => now(),
                    'status' => 'completed'
                ]);

                // Update only the 'co_investigator_name' and 'co_investigator_email' attributes
                $updatedPp['co_investigator_name'] = $request->co_investigator_name;
                $updatedPp['co_investigator_email'] = $request->co_investigator_email;


                // Update the model without clearing existing 'files'
                $pp->update([
                    'pp' => $updatedPp,  // Merged JSON attributes
                ]);
                $pp->save();

                $this->comments_update($request->id, $request->edit_comments, 'completed');

                $dashboard = Dashboard::where('request_id',  $pp->id)->first();
                // Create unit head approved array
                $uh_group = $dashboard;
                $uh_group->unit_heads = $request->unit_head;
                $unit_head_approved = [];
                foreach ($request->unit_head as $uh) {
                    $unit_head_approved[$uh] = 0;
                }
                // Encode associative array to JSON
                $uh_group->unit_head_approved = json_encode($unit_head_approved);
                $uh_group->save();
                if (count($request->unit_head) > 1) {
                    //Flag multiple
                    $uh_group->multiple_heads = true;
                    $uh_group->save();
                }
                //Budget
                $budget = new Budget($pp);
                $budget->budget_increment($pp->pp['research_area']);
                $budget->phd_increment($pp->pp['research_area']);
                $budget->cost_increment($pp->pp['research_area']);


                if($dashboard->state == 'submitted' && count($pp->files) > 0) {

                    //Transition
                    $workflowhandler = new WorkflowHandler($dashboard->workflow_id);
                    $workflowhandler->Completed();

                    return redirect()->route('pp', 'my')->with('success', 'Your Project proposal files have successfully been uploaded!');
                } else {
                    return redirect()->route('pp', 'my')->with('success', 'Your Project proposal has been updated!');
                }

                break;
            case 'edit':
                //
                //dd($request->all());
                $pp = ProjectProposal::find($request->id);
                $pp->update([
                    'user_id' => $userId,
                    'name' => $request->title,
                    'created' => $timestamp,
                    'pp' => $request->only([
                        'title', 'objective', 'principal_investigator', 'principal_investigator_email',
                        'co_investigator_name', 'co_investigator_email', 'research_area',
                        'dsvcoordinating', 'other_coordination', 'eu', 'eu_wallenberg', 'funding_organization',
                        'cofinancing', 'other_cofinancing', 'project_duration', 'unit_head', 'program', 'decision_exp', 'funding_organization',
                        'start_date', 'submission_deadline',
                        'budget_project', 'budget_dsv', 'budget_phd', 'currency', 'oh_cost', 'cofinancing_needed','user_comments'
                    ])]);
                // Save Project Proposal
                $pp->save();
                $this->comments_update($request->id, $request->edit_comments, 'edit');
                return redirect()->route('pp', 'my')->with('success', 'Proposal successfully updated!');
                break;
            case 'resume':
                $pp = ProjectProposal::find($request->id);
                $pp->update([
                    'user_id' => $userId,
                    'name' => $request->title,
                    'created' => $timestamp,
                    'pp' => $request->only([
                        'title', 'objective', 'principal_investigator', 'principal_investigator_email',
                        'co_investigator_name', 'co_investigator_email', 'research_area', 'unit_head',
                        'dsvcoordinating', 'other_coordination', 'eu', 'eu_wallenberg', 'funding_organization',
                        'program', 'decision_exp', 'start_date', 'submission_deadline', 'project_duration', 'budget_project',
                        'budget_dsv', 'budget_phd', 'currency', 'cofinancing', 'other_cofinancing', 'oh_cost', 'user_comments'
                    ])]);
                // Save Project Proposal
                $pp->save();
                $this->comments_update($request->id, $request->edit_comments, 'resumed');
                // Dashboard instance creation or update
                $dashboardData = [
                    'request_id' => $pp->id,
                    'name' => $request->title,
                    'created' => $timestamp,
                    'user_id' => $userId,
                    'fo_id' => $foUserId,
                    'vice_id' => $this->getViceHeadUserId()
                ];

                $dashboard = Dashboard::updateOrCreate(['request_id' => $pp->id], $dashboardData);

                // Resume workflow and store workflow ID
                $this->resumeWorkflow($dashboard);

                return redirect()->route('pp', 'my')->with('success', 'Proposal successfully updated!');
                break;
            case 'sent':
                $pp = ProjectProposal::find($request->id);
                // Check if final application has been uploaded
                $files = is_array($pp->files ?? null) ? $pp->files : [];

                // Search for a file with type == 'final'
                $finalFile = collect($files)->first(function ($file) {
                    return isset($file['type']) && $file['type'] === 'final';
                });

                if ($finalFile) {
                    // A final file exists
                    $existingPp = $pp->pp; // Get existing JSON attribute as an array
                    // Merge new values while keeping existing subattributes
                    $updatedPp = array_merge($existingPp, [
                        'submitted' => now(),
                        'status' => 'sent'
                    ]);
                    // Update the model without clearing existing 'files'
                    $pp->update([
                        'pp' => $updatedPp,  // Merged JSON attributes
                    ]);
                    //Set status sent
                    $pp->status_stage1 = 'sent';
                    $pp->save();
                    $dashboard = Dashboard::where('request_id', $request->id)->first();
                    $dashboard->state = 'sent';
                    $dashboard->save();

                    return redirect()->route('pp', 'my')->with('success', 'Your proposal has been successfully registered as sent. Thank you!');
                } else {
                    // No final file found
                    return redirect()->route('pp', 'my')->with('error', 'Please make sure to upload your final application before the reporting');
                }
                break;
            case 'granted':
                $pp = ProjectProposal::find($request->id);
                $existingPp = $pp->pp; // Get existing JSON attribute as an array
                // Merge new values while keeping existing subattributes
                $updatedPp = array_merge($existingPp, $request->only([
                    'granted', 'cofinanced_promised', 'phd_promised', 'granted_comments'
                ]), [
                    'submitted' => now(),
                    'status' => 'granted'
                ]);
                // Update the model without clearing existing 'files'
                $pp->update([
                    'pp' => $updatedPp,  // Merged JSON attributes
                ]);
                //Set status sent
                $pp->status_stage1 = 'granted';
                $pp->save();
                $dashboard = Dashboard::where('request_id', $request->id)->first();
                $dashboard->state = 'granted';
                $dashboard->save();

                //Comments stamp
                $this->comments_update($request->id, $request->edit_comments, 'granted');
                //Send email to vice and fo
                $user = User::find($dashboard->user_id);
                $vice = $this->getViceHeadUser();
                Mail::to($vice->email)->send(new GrantNotificationVice($user, $vice, $dashboard));

                return redirect()->route('pp', 'my')->with('success', 'Your project proposal has been successfully registered as a granted project!');
                break;
            case 'rejected':
                $pp = ProjectProposal::find($request->id);
                $existingPp = $pp->pp; // Get existing JSON attribute as an array
                // Merge new values while keeping existing subattributes
                $updatedPp = array_merge($existingPp, $request->only([
                    'rejected', 'rejected_comments'
                ]), [
                    'submitted' => now(),
                    'status' => 'denied'
                ]);
                // Update the model without clearing existing 'files'
                $pp->update([
                    'pp' => $updatedPp,  // Merged JSON attributes
                ]);
                $pp->save();
                $dashboard = Dashboard::where('request_id', $request->id)->first();
                $dashboard->state = 'denied';
                $dashboard->save();
                //Comments stamp
                $this->comments_update($request->id, $request->edit_comments, 'rejected');

                //Send email to vice and fo
                $user = User::find($dashboard->user_id);
                $vice = $this->getViceHeadUser();
                //Mail::to($vice->email)->send(new GrantNotificationVice($user, $vice, $dashboard));

                return redirect()->route('pp', 'my')->with('success', 'Your project proposal has been registered as a denied project!');
                break;
        }
        dd('Error');

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
                    case 'vice':
                        //Signal state change
                        $workflowhandler->ViceApprove();
                        //Update budget stats
                        $proposal = ProjectProposal::find($dashboard->request_id);
                        $budget = new Budget($proposal);
                        //Preapproval count
                        $budget->preapproved_increment($proposal->pp['research_area']);
                        //Budget (Disabled)
                        //$budget->budget_increment($proposal->pp['research_area']);
                        break;
                    case 'head':
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
                        break;

                    case 'fo':
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
                    case 'vice':
                        $workflowhandler->ViceDeny();
                        break;
                    case 'head':
                        $workflowhandler->HeadDeny();
                        break;
                    case 'fo':
                        $workflowhandler->FODeny();
                        break;
                }
                break;
            case 'return':
                //Update comments
                $this->comments_update($request->id, $request->comment, 'returned');
                switch($role->check()) {
                    case 'vice':
                        $workflowhandler->ViceReturn();
                        break;
                    case 'head':
                        $workflowhandler->HeadReturn();
                        break;
                    case 'fo':
                        $workflowhandler->FOReturn();
                        break;
                    case 'vice_final':
                        $workflowhandler->FinalReturn();
                        break;
                }
                break;
        }
        return redirect()->route('pp', ['slug' =>'awaiting']);
    }

    public function pp_sent($id)
    {
        $viewData = $this->prepareProjectProposalData();
        $viewData['proposal'] = ProjectProposal::find($id);
        $viewData['dashboard'] = Dashboard::where('request_id', $id)->first();
        $viewData['type'] = 'sent';

        return $this->createView('pp.create', 'mylayout', $viewData);
    }

    public function pp_granted($id)
    {
        $viewData = $this->prepareProjectProposalData();
        $viewData['proposal'] = ProjectProposal::find($id);
        $viewData['dashboard'] = Dashboard::where('request_id', $id)->first();
        $viewData['type'] = 'granted';

        return $this->createView('pp.create', 'mylayout', $viewData);
    }

    public function pp_rejected($id)
    {
        $viewData = $this->prepareProjectProposalData();
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
        //$workflow = WorkflowStub::make(ProjectWorkflow::class);
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
            case(RequestStates::VICE_RETURNED):
                dd('ViceReturned');
                break;
            case(RequestStates::HEAD_RETURNED):
                $dashboard->state = RequestStates::COMPLETED;
                $dashboard->save();
                $workflow = WorkflowStub::make(\App\Workflows\ResumeFromUHProjectWorkflow::class);
                break;
            case(RequestStates::FO_RETURNED):
                $dashboard->state = RequestStates::HEAD_APPROVED;
                $dashboard->save();
                $workflow = WorkflowStub::make(\App\Workflows\ResumeFromFOProjectWorkflow::class);
                break;
            case(RequestStates::FINAL_RETURNED):
                $dashboard->state = RequestStates::FO_APPROVED;
                $dashboard->save();
                $workflow = WorkflowStub::make(\App\Workflows\ResumeFromFinalProjectWorkflow::class);
                break;
        }

        $dashboard->workflow_id = $workflow->id();
        $dashboard->save();
        $workflow->start($dashboard);

        return $workflow;
    }
    /***
     * Private functions
     */

    private function checkFileStatus($proposal)
    {
        $files = is_array($proposal->files ?? null) ? $proposal->files : [];
        $workflowhandler = new WorkflowHandler($proposal->dashboard->workflow_id);

        if (count($files) >= 2) {
            //Signal workflow
            $workflowhandler->UploadedFiles();
            return true;
        } else {
            //Signal workflow
            $workflowhandler->RemovedFile();
        }

        return true;
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

    private function prepareProjectProposalData()
    {
        $roleIdsUnitHead = $this->getUserIdsByGroup('enhetschef');
        $unitheads = User::whereIn('id', $roleIdsUnitHead)->get();
        $research_areas = ResearchArea::all();

        $proposal = new \App\Models\ProjectProposal();
        //User
        $userId = Auth::user()->id;
        //Timestamp
        $timestamp = now()->startOfDay()->timestamp;
        $proposal->fill([
            'user_id' => $userId,
            'name' => '',
            'created' => $timestamp,
            'status_stage1' => 'pending',
            'status_stage2' => 'pending',
            'status_stage3' => 'pending',
            'files' => []
        ]);
        // Save Project Proposal
        $proposal->save();

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
