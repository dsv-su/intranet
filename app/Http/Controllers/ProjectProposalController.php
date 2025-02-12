<?php

namespace App\Http\Controllers;

use App\Models\Dashboard;
use App\Models\ProjectProposal;
use App\Models\ResearchArea;
use App\Models\SettingsFo;
use App\Models\User;
use App\Services\Review\DashboardRole;
use App\Services\Review\WorkflowHandler;
use App\Workflows\DSVProjectPWorkflow;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Statamic\View\View;
use Workflow\WorkflowStub;

class ProjectProposalController extends Controller
{
    public function __construct()
    {
        $this->middleware(['web', 'auth', 'dsv']);
    }

    public function pp($slug)
    {
        switch($slug) {
            case 'my':
                $page = $slug;
                $breadcrumb = 'My proposals';
                break;
            case 'awaiting':
                $page = $slug;
                $breadcrumb = 'Awaiting review';
                break;
            case 'all':
                $page = $slug;
                $breadcrumb = 'Proposals';
                break;
        }

        return (new \Statamic\View\View)
            ->template('pp.index')
            ->with(['page' => $page, 'breadcrumb' => $breadcrumb])
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

    public function decision(Request $request)
    {
        //Update comments
        $this->comments_update($request->id, $request->comment);

        //Trigger signal
        $dashboard = Dashboard::where('request_id', $request->id)->first();
        $role = new DashboardRole($dashboard, $user = auth()->user());
        $workflowhandler = new WorkflowHandler($dashboard->workflow_id);

        switch($request->decision) {
            case 'approve':
                switch($role->check()) {
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

                    case 'vice':
                        $workflowhandler->ViceApprove();
                        break;
                    case 'fo':
                        $workflowhandler->FOApprove();
                        break;
                }
                break;
            case 'deny':
                switch($role->check()) {
                    case 'head':
                        $workflowhandler->HeadDeny();
                        break;
                    case 'vice':
                        $workflowhandler->ViceDeny();
                        break;
                    case 'fo':
                        $workflowhandler->FODeny();
                        break;
                }
                break;
            case 'return':
                switch($role->check()) {
                    case 'head':
                        $workflowhandler->HeadReturn();
                        break;
                    case 'vice':
                        $workflowhandler->ViceReturn();
                        break;
                    case 'fo':
                        $workflowhandler->FOReturn();
                        break;
                }
                break;
        }

        return redirect()->route('pp', ['slug' =>'awaiting']);
    }

    public function create()
    {
        $viewData = $this->prepareProjectProposalData();
        $viewData['type'] = 'create';

        return $this->createView('pp.create', 'mylayout', $viewData);
    }

    public function upload($id)
    {
        $viewData = $this->prepareProjectProposalData();
        $viewData['proposal'] = ProjectProposal::find($id);
        $viewData['dashboard'] = Dashboard::where('request_id', $id)->first();
        $viewData['type'] = 'view';
        $viewData['upload'] = true;
        //dd($viewData);
        return $this->createView('pp.create', 'mylayout', $viewData);
    }

    public function submit(Request $request)
    {
        // Validate and retrieve request data
        $this->validateRequest($request);
        //dd($request->all(), $request->unit_head);
        // Financial officer and authenticated user retrieval
        $foUserId = SettingsFo::find(1)?->user_id;

        //User
        $userId = Auth::user()->id;

        //Timestamp
        $timestamp = now()->startOfDay()->timestamp;

        //Check submit type
        switch ($request->type) {
            case 'create':
                // Create Project Proposal instance
                $pp = new \App\Models\ProjectProposal();

                $pp->fill([
                    'user_id' => $userId,
                    'name' => $request->title,
                    'created' => $timestamp,
                    'status_stage1' => 'pending',
                    'status_stage2' => 'pending',
                    'status_stage3' => 'pending',
                    'pp' => $request->only([
                            'title', 'objective', 'principal_investigator', 'principal_investigator_email',
                            'co_investigator_name', 'co_investigator_email', 'research_area', 'unit_head',
                            'dsvcoordinating', 'other_coordination', 'eu_wallenberg', 'funding_organization',
                            'program', 'decision_exp', 'start_date', 'submission_deadline', 'project_duration', 'budget_project',
                            'budget_dsv', 'currency', 'cofinancing', 'other_cofinancing', 'oh_cost', 'user_comments'
                        ]) + [
                            'submitted' => $timestamp,
                            'status' => 'pending'
                        ],
                    'files' => []
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
                    'manager_id' => $request->unit_head[0],
                    'fo_id' => $foUserId,
                    'head_id' => $request->unit_head[0],
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

                // Start workflow and store workflow ID
                $workflow = $this->createAndStartWorkflow($pp->dashboard);
                $this->workflowID = $workflow->id();

                return redirect()->route('pp', 'my')->with('success', 'Your Project proposal has successfully been submitted!');

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
                            'co_investigator_name', 'co_investigator_email', 'research_area', 'unit_head',
                            'dsvcoordinating', 'other_coordination', 'eu_wallenberg', 'funding_organization',
                            'program', 'decision_exp', 'start_date', 'submission_deadline', 'project_duration', 'budget_project',
                            'budget_dsv', 'currency', 'cofinancing', 'other_cofinancing', 'oh_cost', 'user_comments'
                        ])]);
                // Save Project Proposal
                $pp->save();
                $this->comments_update($request->id, $request->edit_comments, 'edit');
                return redirect()->route('pp', 'my')->with('success', 'Proposal successfully updated!');
                break;
            case 'resume':
                dd($request->type);
                break;
        }
        dd('Error');

    }

    protected function validateRequest(Request $request)
    {
        $rules = [
            'title' => 'required',
            'objective' => 'required',
            'principal_investigator' => 'required',
            'project_duration' => 'required|numeric|integer',
            'oh_cost' => 'required|numeric|max:56'
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
        if($type == 'edit') {
            $comments_tag = $tag . '  ' . 'Proposal has been edited by ' . $user . '  ' . $timestamp . '  ' . $tag;
        } else {
            $comments_tag = $tag . '  ' . $user . '  ' . $timestamp . '  ' . $tag;
        }


        //Merge with reviewer comments

        return ProjectProposal::where('id', $id)
            ->update(['pp->user_comments' =>
                Str::of($user_comments)->newLine()
                    ->append($comments_tag)
                    ->newLine()
                    ->append($comment)
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

    private function getViceHeadUserId(): string
    {
        return DB::table('role_user')
            ->where('role_id', 'vice_head')
            ->value('user_id');
    }

    private function prepareProjectProposalData()
    {
        $roleIdsUnitHead = $this->getUserIdsByGroup('enhetschef');
        $unitheads = User::whereIn('id', $roleIdsUnitHead)->get();
        $research_areas = ResearchArea::all();

        return [
            'unitheads' => $unitheads,
            'research_areas' => $research_areas
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
