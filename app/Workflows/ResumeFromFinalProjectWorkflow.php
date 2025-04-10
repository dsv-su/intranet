<?php

namespace App\Workflows;

use App\Models\Dashboard;
use App\Traits\ProjectProSignals;
use App\Workflows\Notifications\NewFinalApprovalNotification;
use App\Workflows\Notifications\NewProjectProposalNotification;
use App\Workflows\Notifications\ResumeProjectProposalNotification;
use App\Workflows\Notifications\StateUpdateNotification;
use App\Workflows\Partials\RequestStates;
use App\Workflows\Transitions\Stage2UpdateTransition;
use App\Workflows\Transitions\StateUpdateTransition;
use Workflow\ActivityStub;
use Workflow\Models\StoredWorkflow;
use Workflow\Workflow;
use Workflow\WorkflowStub;

class ResumeFromFinalProjectWorkflow extends Workflow
{
    private $stateMachine;
    protected $heads;

    use ProjectProSignals;

    //Submitt
    public function isSubmitted()
    {
        return $this->stateMachine->state->status() === 'submitted';
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

    //Completed
    public function Completed()
    {
        return $this->stateMachine->state->status() === 'complete';
    }

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

    //Uploaded files
    public function UploadedFiles()
    {
        return $this->files_uploaded;
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

    //Final approval
    public function FinalApproved()
    {
        return $this->stateMachine->state->status() === 'final_approved';
    }

    public function FinalReturned()
    {
        return $this->stateMachine->state->status() === 'final_returned';
    }

    public function FinalDenied()
    {
        return $this->stateMachine->state->status() === 'final_denied';
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

        //Update proposal state
        yield ActivityStub::make(StateUpdateTransition::class, $userRequest);

        //Final approval request Email to Vice
        yield ActivityStub::make(NewFinalApprovalNotification::class, RequestStates::VICE, $userRequest);

        //Wait for Final decision
        yield WorkflowStub::await(fn () => ($this->FinalApproved() || $this->FinalDenied() || $this->FinalReturned()));

        //Notify user
        $commonActivities = $this->getCommonActivities($userRequest);
        foreach ($commonActivities as $activity) {
            yield $activity;
        }

        //Update stage2
        yield ActivityStub::make(Stage2UpdateTransition::class, $userRequest);

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

    protected function getHeads($userRequest)
    {
        return ActivityStub::make(HeadsStatus::class, $userRequest);
    }
}
