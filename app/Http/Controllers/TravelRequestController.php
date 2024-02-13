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
        $this->middleware('show')->except(['create', 'submit']);
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
        $tr = TravelRequest::find($id);
        $formtype = 'show';

        return (new \Statamic\View\View)
            ->template('requests.travel.show')
            ->layout('mylayout')
            ->with(['tr' => $tr, 'formtype' => $formtype]);
    }


    public function create()
    {
        $countries = Country::all();

        //Projectleaders
        $roleIds = DB::table('role_user')->where('role_id', 'project_leader')->pluck('user_id');
        $projectleaders = User::whereIn('id', $roleIds)->get();

        //Unitheads
        $roleIds = DB::table('role_user')->where('role_id', 'unit_head')->pluck('user_id');
        $unitheads = User::whereIn('id', $roleIds)->get();
        return (new \Statamic\View\View)
                   ->template('requests.travel.create')
                   ->layout('mylayout')
                   ->with(['countries' => $countries, 'projectleaders' => $projectleaders,
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

            //Financial officer
            /*
            $roleIds = DB::table('role_user')->where('role_id', 'financial_officer')->pluck('user_id');
            $fo = User::whereIn('id', $roleIds)->first();
            */
            $fo = SettingsFo::find(1);

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

            // Create workflow
            $workflow = WorkflowStub::make(DSVRequestWorkflow::class);
            // start workflow [DashboardId]
            $workflow->start($dashboard->id);
            //Submit TR
            $workflow->submit();


            return redirect()->route('statamic.site');
        }
    }


}
