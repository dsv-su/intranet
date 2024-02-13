<?php

namespace App\Http\Controllers;

use App\Models\Dashboard;
use App\Models\SettingsFo;
use App\Models\TravelRequest;
use App\Services\Review\RequestReviewHandler;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ReviewController extends Controller
{
    public function __construct()
    {
        $this->middleware('review');
    }

    public function show($id)
    {
        $tr = TravelRequest::find($id);
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
            ->with(['tr' => $tr, 'formtype' => $formtype]);
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
                $tr = TravelRequest::find($req);
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
