<?php

namespace App\Http\Controllers;

use App\Models\Dashboard;
use App\Models\DsvBudget;
use App\Models\HeadGroup;
use App\Models\ProjectProposal;
use App\Models\ResearchArea;
use App\Models\SettingsFo;
use App\Models\TravelRequest;
use App\Models\User;
use App\Services\Review\RequestReviewHandler;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Statamic\View\View;

class ReviewController extends Controller
{
    public function __construct()
    {
        $this->middleware(['web', 'auth', 'dsv']);
        $this->middleware('review')->except(['pp_view']);
    }

    public function pp_view($id)
    {
        $viewData = $this->prepareProjectProposalData();
        $viewData['proposal'] = ProjectProposal::find($id);
        $viewData['dashboard'] = Dashboard::where('request_id', $id)->first();
        $viewData['type'] = 'view';
        //dd($viewData);
        return $this->createView('pp.create', 'mylayout', $viewData);
    }

    public function pp_review($id)
    {
        $viewData = $this->prepareProjectProposalData();
        $viewData['proposal'] = ProjectProposal::find($id);
        $viewData['dashboard'] = Dashboard::where('request_id', $id)->first();
        $viewData['budget'] = DsvBudget::find(1);
        $viewData['type'] = 'review';
        //dd($viewData);
        return $this->createView('pp.create', 'mylayout', $viewData);
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

    public function show($id)
    {
        $dashboard = Dashboard::find($id);
        $tr = TravelRequest::find($dashboard->request_id);
        // Retrieve the currently authenticated user's ID
        $user = Auth::user();
        // Check if user is FO
        $fo = SettingsFo::find(1);

        if($user->id == $fo->user_id) {
            $formtype = 'fo_review';
        } else {
            $formtype = 'review';
        }

        return (new \Statamic\View\View)
            ->template('requests.travel.show')
            ->layout('mylayout')
            ->with(['tr' => $tr, 'formtype' => $formtype, 'dashboard' => $dashboard]);
    }

    public function review(Request $request, $req)
    {
        //Check request type
        $dashboard = Dashboard::find($req);

        // Retrieve the currently authenticated user's ID
        $user = Auth::user();

        //Mobile or desktop review
        if($request->comment_mobile == null) {
            $comment = $request->comment;
        } else {
            $comment = $request->comment_mobile;
        }

        //Approve
        $handler = new RequestReviewHandler($dashboard, $user, $comment, $request->decicion);
        $handler->review();

        return redirect('/')->with('status', 'Request updated');
    }

    public function fo_review(Request $request, $req)
    {
        //Check request type
        $dashboard = Dashboard::find($req);

        switch($dashboard->type) {
            case('travelrequest'):
                //Update project id
                $tr = TravelRequest::find($dashboard->request_id);
                $tr->project = $request->project;
                $tr->save();
                break;
        }

        // Retrieve the currently authenticated user's ID
        $user = Auth::user();

        //Mobile or desktop review
        if($request->comment_mobile == null) {
            $comment = $request->comment;
        } else {
            $comment = $request->comment_mobile;
        }

        //Approve
        $handler = new RequestReviewHandler($dashboard, $user, $comment, $request->decicion);
        $handler->review();

        return redirect('/')->with('status', 'Request updated');
    }



}
