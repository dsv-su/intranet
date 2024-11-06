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
use Carbon\Carbon;
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
                        $workflowhandler->HeadApprove();
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

    public function submit(Request $request)
    {
        //dd($request->all());

        // Finacial officer
        $fo = SettingsFo::find(1);

        //Retrive authenticated user
        $user = Auth::user();
        $pp = new \App\Models\ProjectProposal();
        $pp->user_id = auth()->id();

        //Retrive name of proposal
        $pp->name = $request->title;
        $pp->created = Carbon::createFromFormat('d/m/Y', now()->format('d/m/Y'))->timestamp;

        //Initial status
        $pp->status_stage1 = 'pending';
        $pp->status_stage2 = 'pending';
        $pp->status_stage3 = 'pending';

        //Formdata
        $pp->pp = [
            'title' => $request->title,
            'objective' => $request->objective,
            'principal_investigator' => $request->principal_investigator,
            'principal_investigator_email' => $request->principal_investigator_email,
            'co_investigator_name' => $request->coinvestigator_name,
            'co_investigator_email' => $request->coinvestigator_email,
            'research_area' => $request->research_area,
            'unit_head' => $request->unit_head,
            'dsvcoordinating' => $request->dsvcoordinating,
            'other_coordination' => $request->other_coordination,
            'eu_wallenberg' => $request->eu_wallenberg,
            'funding_organization' => $request->organization,
            'program' => $request->program,
            'decision_exp' => $request->decision_exp,
            'start_date' => $request->start_date,
            'submission_deadline' => $request->submission,
            'project_duration' => $request->duration,
            'budget_project' => $request->budget_project,
            'budget_dsv' => $request->budget_dsv,
            'currency' => $request->currency,
            'cofinancing_needed' => $request->cofinancing,
            'other_cofinancing' => $request->other_cofinancing,
            'oh_cost' => $request->oh_cost,
            'user_comments' => $request->user_comments,
            'submitted' => $pp->created,
            'status' => $pp->status
        ];

        //Save formdata
        $pp->save();

        // Find or create Dashboard instance
        $dashboardData = [
            'request_id' => $pp->id,
            'name' => $request->title,
            'created' => Carbon::createFromFormat('d/m/Y', now()->format('d/m/Y'))->timestamp,
            'status' => 'unread',
            'type' => 'projectproposal',
            'user_id' => auth()->id(),
            'manager_id' => $request->unit_head,
            'fo_id' => $fo->user_id,
            'head_id' => $request->unit_head,
            'vice_id' => $this->getViceHeadUserId()
        ];

        //Create new dashboard instance
        $dashboard = Dashboard::where('request_id', $pp->id)->first();
        if (!$dashboard) {
            $dashboard = Dashboard::create($dashboardData);
        } else {
            $dashboard->update($dashboardData);
        }

        //Start workflow
        $workflow = $this->createAndStartWorkflow($dashboard);

        //WorkflowID
        $this->workflowID = $workflow->id();

        return redirect()->route('pp', 'my')->with('success', 'Item successfully created!');
    }

    protected function comments_update($id, $comment)
    {
        //Proposal user comments
        $proposal = ProjectProposal::find($id);
        $user_comments = $proposal->pp['user_comments'];

        //Timestamp
        $timestamp = now()->format('d/m/Y');
        $user = auth()->user()->name;
        $tag = '***';
        $comments_tag = $tag . '  ' . $user . '  ' . $timestamp . '  ' . $tag;

        //Merge with reviewer comments

        return ProjectProposal::where('id', $id)
            ->update(['pp->user_comments' =>
                Str::of($user_comments . $comments_tag)->newLine()->append($comment)->newLine()->newLine()
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
