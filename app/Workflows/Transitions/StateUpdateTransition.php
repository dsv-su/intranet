<?php

namespace App\Workflows\Transitions;

use App\Models\Dashboard;
use App\Models\ProjectProposal;
use App\Models\TravelRequest;
use Workflow\Activity;

class StateUpdateTransition extends Activity
{
    protected $dashboard, $state, $req;

    public function execute($request)
    {
        //Retrive request dashboard
        $id = $request;
        $this->dashboard = Dashboard::find($id);

        //Update Transition state to request origin
        switch($this->dashboard->type) {
            //Travel request
            case('travelrequest'):
                $this->req = TravelRequest::find($this->dashboard->request_id);
                $this->req->state = $this->dashboard->state;
                $this->req->save();
                break;
            case('projectproposal'):
                $this->req = ProjectProposal::find($this->dashboard->request_id);
                $this->req->status_stage1 = $this->dashboard->state;
                $this->req->save();
                break;
        }
    }
}
