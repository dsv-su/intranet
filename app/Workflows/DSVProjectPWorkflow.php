<?php

namespace App\Workflows;

use App\Models\Dashboard;
use App\Traits\ProjectProSignals;
use App\Workflows\Notifications\NewProjectProposalNotification;
use App\Workflows\Notifications\StateUpdateNotification;
use App\Workflows\Partials\RequestStates;
use App\Workflows\StatusUpdates\PPStatusUpdateUsersStage1;
use App\Workflows\Transitions\StateUpdateTransition;
use Workflow\ActivityStub;
use Workflow\ChildWorkflow;
use Workflow\ChildWorkflowStub;
use Workflow\Models\StoredWorkflow;
use Workflow\Workflow;
use Workflow\WorkflowStub;

class DSVProjectPWorkflow extends Workflow
{
    private $stateMachine;
    use ProjectProSignals;

    //Head
    public function HeadApproved()
    {
        return $this->stateMachine->state->status() === 'head_approved';
    }

    public function HeadReturned()
    {
        return $this->stateMachine->state->status() === 'head_returned';
    }

    public function HeadDenied()
    {
        return $this->stateMachine->state->status() === 'head_denied';
    }

    //Vice
    public function ViceApproved()
    {
        return $this->stateMachine->state->status() === 'vice_approved';
    }

    public function ViceReturned()
    {
        return $this->stateMachine->state->status() === 'vice_returned';
    }

    public function ViceDenied()
    {
        return $this->stateMachine->state->status() === 'vice_denied';
    }

    //Finacial officer
    public function FOApproved()
    {
        return $this->stateMachine->state->status() === 'fo_approved';
    }

    public function FOReturned()
    {
        return $this->stateMachine->state->status() === 'fo_returned';
    }

    public function FODenied()
    {
        return $this->stateMachine->state->status() === 'fo_denied';
    }

    //Wait for statechange
    public function isSubmitted()
    {
        return $this->stateMachine->state->status() === 'submitted';
    }

    public function __construct(
        public StoredWorkflow $storedWorkflow, Dashboard $dashboard, ...$arguments)
    {
        parent::__construct($storedWorkflow, $dashboard, $arguments);
        $this->stateMachine = $dashboard;
    }

    public function execute(Dashboard $dashboard)
    {
        //Dashboard
        $userRequest = $dashboard->id;

        //Submitted by requester
        yield WorkflowStub::await(fn () => $this->isSubmitted());

        //Update pp with dashboardstate
        $commonActivities = $this->getCommonActivities($userRequest);
        yield $commonActivities[0];

        //Email to Head
        yield ActivityStub::make(NewProjectProposalNotification::class, RequestStates::UNIT_HEAD, $userRequest);
        //yield ActivityStub::make(PPStatusUpdateUsersStage1::class, RequestStates::UNIT_HEAD, 'review', $userRequest);

        //Email to Vice
        yield ActivityStub::make(NewProjectProposalNotification::class, RequestStates::VICE, $userRequest);
        //yield ActivityStub::make(PPStatusUpdateUsersStage1::class, RequestStates::VICE, 'review', $userRequest);

        //Wait for head decision
        yield WorkflowStub::await(fn () => ($this->HeadApproved() || $this->HeadDenied() || $this->HeadReturned()));

        //Handle Head decision
        $newState = $this->getState();
        $commonActivities = $this->getCommonActivities($userRequest);

        // Await stateupdate
        yield $commonActivities[0];

        switch ($newState) {
            case RequestStates::HEAD_APPROVED:
                //Request has been approved by head

                //Notify vice
                //TODO

                break;
            case RequestStates::HEAD_RETURNED:
            case RequestStates::HEAD_DENIED:
                //Request has been returned or denied by head
                foreach ($commonActivities as $activity) {
                    yield $activity;
                }
                //End workflow
                return $this->stateMachine->state->status();
        }

        //Wait for vice decision
        yield WorkflowStub::await(fn () => ($this->ViceApproved() || $this->ViceDenied() || $this->ViceReturned()));

        //Handle vice decision
        $newState = $this->getState();
        $commonActivities = $this->getCommonActivities($userRequest);

        // Await stateupdate
        yield $commonActivities[0];

        switch ($newState) {
            case RequestStates::VICE_APPROVED:
                //Request has been approved by head

                //Notify
                //TODO

                break;
            case RequestStates::VICE_RETURNED:
            case RequestStates::VICE_DENIED:
            //Request has been returned or denied by vice
            foreach ($commonActivities as $activity) {
                yield $activity;
            }

                //End workflow
                return $this->stateMachine->state->status();
        }

        //Request has been approved by head and vice
        //Email to FO
        yield ActivityStub::make(NewProjectProposalNotification::class, RequestStates::FINACIAL_OFFICER, $userRequest);

        //Wait for FO decision
        yield WorkflowStub::await(fn () => ($this->FOApproved() || $this->FODenied() || $this->FOReturned()));

        //Handle FO decision
        $newState = $this->getState();
        $commonActivities = $this->getCommonActivities($userRequest);

        // Await stateupdate
        yield $commonActivities[0];

        switch ($newState) {
            case RequestStates::FO_APPROVED:
                //Request has been approved by fo
                foreach ($commonActivities as $activity) {
                    yield $activity;
                }

                break;
            case RequestStates::FO_RETURNED:
            case RequestStates::FO_DENIED:
                //Request has been returned or denied by FO
                foreach ($commonActivities as $activity) {
                    yield $activity;
                }
                //End workflow
                return $this->stateMachine->state->status();
        }

        //End workflow
        return $this->stateMachine->state->status();
    }

    protected function getState()
    {
        return $this->stateMachine->state->status();
    }

    protected function getCommonActivities($userRequest)
    {
        return [
            ActivityStub::make(StateUpdateTransition::class, $userRequest),
            ActivityStub::make(StateUpdateNotification::class, $userRequest),
        ];
    }
}
