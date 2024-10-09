<?php

namespace App\Workflows;

use App\Models\Dashboard;
use App\Traits\ProjectProSignals;
use App\Workflows\Notifications\NewProjectProposalNotification;
use App\Workflows\Partials\RequestStates;
use Workflow\ActivityStub;
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

        //Email to Head
        yield ActivityStub::make(NewProjectProposalNotification::class, RequestStates::UNIT_HEAD, $userRequest);

        //Wait for head to process request
        yield WorkflowStub::await(fn () => $this->HeadApproved() || $this->HeadDenied() || $this->HeadReturned());

        //Email to Vice
        yield ActivityStub::make(NewProjectProposalNotification::class, RequestStates::VICE, $userRequest);

        //Wait for vice to process request
        yield WorkflowStub::await(fn () => $this->ViceApproved() || $this->ViceDenied() || $this->ViceReturned());

        //Email to FO
        yield ActivityStub::make(NewProjectProposalNotification::class, RequestStates::FINACIAL_OFFICER, $userRequest);

        //End workflow
        return $this->stateMachine->state->status();
    }
}
