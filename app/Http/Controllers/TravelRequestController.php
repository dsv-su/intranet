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
        if ($request->isMethod('post')) {
            //Second validation
            $this->validate($request, [
                'purpose' => 'required',
                'project' => 'required',
                'country' => 'required',
                'project_leader' => 'required',
                'unit_head' => 'required',
                'start' => 'required',
                'end' => 'required'
            ]);
            //dd($request->all());
            //Financial officer
            /*
            $roleIds = DB::table('role_user')->where('role_id', 'financial_officer')->pluck('user_id');
            $fo = User::whereIn('id', $roleIds)->first();
            */
            $fo = SettingsFo::find(1);
            //Find first or create new
            if($travelrequest = TravelRequest::find($request->id)) {
                //Update existing
                $travelrequest->name = $request->name;
                $travelrequest->created = Carbon::createFromFormat('d/m/Y', now()->format('d/m/Y'))->timestamp;
                $travelrequest->state = 'submitted';
                $travelrequest->purpose = $request->purpose;
                $travelrequest->project = $request->project;
                $travelrequest->country = $request->country;
                $travelrequest->paper =  $request->paper ?? false;
                $travelrequest->contribution = $request->contribution;
                $travelrequest->other = $request->reason;
                $travelrequest->departure = Carbon::createFromFormat('d/m/Y', $request->start)->timestamp;
                $travelrequest->return = Carbon::createFromFormat('d/m/Y', $request->end)->timestamp;
                $travelrequest->days = $request->days;
                $travelrequest->flight = $request->flight;
                $travelrequest->hotel = $request->hotel;
                $travelrequest->daily = $request->daily;
                $travelrequest->conference = $request->conference;
                $travelrequest->other_costs = $request->other;
                $travelrequest->total = $request->total;
                $travelrequest->save();
            } else {
                //Create a new Travelreqeust
                $travelrequest = TravelRequest::create([
                    'name' => $request->name,
                    'created' => Carbon::createFromFormat('d/m/Y', now()->format('d/m/Y'))->timestamp,
                    'state' => 'submitted',
                    'purpose' => $request->purpose,
                    'project' => $request->project,
                    'country' => $request->country,
                    'paper' =>  $request->paper ?? false,
                    'contribution' => $request->contribution,
                    'other' => $request->reason,
                    'departure' => Carbon::createFromFormat('d/m/Y', $request->start)->timestamp,
                    'return' => Carbon::createFromFormat('d/m/Y', $request->end)->timestamp,
                    'days' => $request->days,
                    'flight' => $request->flight,
                    'hotel' => $request->hotel,
                    'daily' => $request->daily,
                    'conference' => $request->conference,
                    'other_costs' => $request->other,
                    'total' => $request->total,

                ]);
            }

            //Find or create Dashboard instance
            if($dashboard = Dashboard::where('request_id', $request->id)->first()) {
                $dashboard->request_id = $travelrequest->id;
                $dashboard->name = $request->name;
                $dashboard->created = Carbon::createFromFormat('d/m/Y', now()->format('d/m/Y'))->timestamp;
                $dashboard->state = 'submitted';
                $dashboard->status = 'unread';
                $dashboard->type = 'travelrequest';
                $dashboard->user_id = auth()->user()->id;
                $dashboard->manager_id = $request->project_leader;
                $dashboard->fo_id = $fo->user_id;
                $dashboard->head_id = $request->unit_head;
                $dashboard->save();
            } else {
                //Create a new Dashboard post
                $dashboard = Dashboard::create([
                    'request_id' => $travelrequest->id,
                    'name' => $request->name,
                    'created' => Carbon::createFromFormat('d/m/Y', now()->format('d/m/Y'))->timestamp,
                    'state' => 'submitted',
                    'status' => 'unread',
                    'type' => 'travelrequest',
                    'user_id' => auth()->user()->id,
                    'manager_id' => $request->project_leader,
                    'fo_id' => $fo->user_id,
                    'head_id' => $request->unit_head
                ]);
            }


            // Create workflow
            $workflow = WorkflowStub::make(DSVRequestWorkflow::class);
            //Store workflowId in dashboard
            $dashboard->workflow_id = $workflow->id();
            $dashboard->save();
            // start workflow [DashboardId]
            $workflow->start($dashboard->id);
            //Submit TR
            $workflow->submit();

            return redirect()->route('statamic.site');
        }
    }


}
