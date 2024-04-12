<?php

namespace App\Http\Controllers;

use App\Models\Country;
use App\Models\Dashboard;
use App\Models\SettingsFo;
use App\Models\TravelRequest;
use App\Models\User;
use App\Workflows\DSVRequestWorkflow;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Workflow\WorkflowStub;

class TravelRequestController extends Controller
{

    public function __construct()
    {
        $this->middleware('show')->except(['create', 'resume', 'submit']);
        $this->middleware(['checklang', 'locale']);
    }

    /**
     * Show the TravelRequest form for a given user.
     *
     * @param  int  $id
     * @return \Statamic\View\View
     */
    public function show($id)
    {
        $dashboard = Dashboard::find($id);
        $tr = TravelRequest::find($dashboard->request_id);
        if($tr->state == 'manager_returned' or $tr->state == 'head_returned' or $tr->state == 'fo_returned') {
            $formtype = 'returned';
        } else {
            $formtype = 'show';
        }


        return (new \Statamic\View\View)
            ->template('requests.travel.show')
            ->layout('mylayout')
            ->with(['tr' => $tr, 'formtype' => $formtype]);
    }

    public function resume(TravelRequest $tr)
    {
        //Type
        $type = 'resume';

        //Countries
        $countries = Country::all();

        //Projectleaders
        $roleIds = DB::table('group_user')->where('group_id', 'projektledare')->pluck('user_id');
        $projectleaders = User::whereIn('id', $roleIds)->get();

        //Unitheads
        $roleIds = DB::table('group_user')->where('group_id', 'enhetschef')->pluck('user_id');
        $unitheads = User::whereIn('id', $roleIds)->get();

        //Dashboard
        $dashboard = Dashboard::where('request_id', $tr->id)->first();

        return (new \Statamic\View\View)
            ->template('requests.travel.create')
            ->layout('mylayout')
            ->with(['type' => $type, 'tr' => $tr, 'dashboard' => $dashboard, 'countries' => $countries, 'projectleaders' => $projectleaders,
                'unitheads' => $unitheads]);
    }

    public function create()
    {
        //Type
        $type = 'create';

        //Countries
        $countries = Country::all();

        //Projectleaders
        $roleIds = DB::table('group_user')->where('group_id', 'projektledare')->pluck('user_id');
        $projectleaders = User::whereIn('id', $roleIds)->get();

        //Unitheads

        $roleIds = DB::table('group_user')->where('group_id', 'enhetschef')->pluck('user_id');
        $unitheads = User::whereIn('id', $roleIds)->get();

        return (new \Statamic\View\View)
                   ->template('requests.travel.create')
                   ->layout('mylayout')
                   ->with(['type' => $type, 'countries' => $countries, 'projectleaders' => $projectleaders,
            'unitheads' => $unitheads]);

    }

    public function submit(Request $request)
    {
        // Ensure the request method is POST
        $this->validateRequest($request);

        // Find or create the financial officer
        $fo = SettingsFo::find(1);

        // Create or update TravelRequest
        $travelRequestData = $request->only([
            'name', 'purpose', 'project', 'country', 'paper', 'contribution',
            'other_costs', 'days', 'flight', 'hotel', 'daily',
            'conference', 'other_costs', 'total'
        ]);

        // Convert dates to unix format
        $departureDate = Carbon::createFromFormat('d/m/Y', $request->departure)->timestamp;
        $returnDate = Carbon::createFromFormat('d/m/Y', $request->return)->timestamp;
        $travelRequestData['departure'] = $departureDate;
        $travelRequestData['return'] = $returnDate;
        $travelRequestData['created'] = Carbon::createFromFormat('d/m/Y', now()->format('d/m/Y'))->timestamp;

        //Set initial state
        $travelRequestData['state'] = 'submitted';

        $travelRequest = TravelRequest::find($request->id);
        if (!$travelRequest) {
            $travelRequest = TravelRequest::create($travelRequestData);
        } else {
            $travelRequest->update($travelRequestData);
        }

        // Find or create Dashboard instance
        $dashboardData = [
            'request_id' => $travelRequest->id,
            'name' => $request->name,
            'created' => Carbon::createFromFormat('d/m/Y', now()->format('d/m/Y'))->timestamp,
            'state' => 'submitted',
            'status' => 'unread',
            'type' => 'travelrequest',
            'user_id' => auth()->id(),
            'manager_id' => $request->project_leader,
            'fo_id' => $fo->user_id,
            'head_id' => $request->unit_head
        ];

        $dashboard = Dashboard::where('request_id', $request->id)->first();
        if (!$dashboard) {
            $dashboard = Dashboard::create($dashboardData);
        } else {
            $dashboard->update($dashboardData);
        }

        // Create and start workflow
        $workflow = $this->createAndStartWorkflow($dashboard);

        return redirect()->route('statamic.site');
    }

    protected function validateRequest(Request $request)
    {
        return $this->validate($request, [
            'purpose' => 'required',
            'project' => 'required',
            'country' => 'required',
            'project_leader' => 'required',
            'unit_head' => 'required',
            'departure' => 'required',
            'return' => 'required'
        ]);
    }

    protected function createAndStartWorkflow($dashboard)
    {
        $workflow = WorkflowStub::make(DSVRequestWorkflow::class);
        $dashboard->workflow_id = $workflow->id();
        $dashboard->save();
        $workflow->start($dashboard->id);
        $workflow->submit();
        return $workflow;
    }
}
