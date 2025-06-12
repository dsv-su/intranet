<?php

namespace App\Workflows;

use App\Models\Dashboard;
use App\Traits\ProjectProSignals;
use App\Workflows\Notifications\CompletProjectProposalNotification;
use App\Workflows\Notifications\NewFinalApprovalNotification;
use App\Workflows\Notifications\NewPreApprovalNotification;
use App\Workflows\Notifications\NewProjectProposalNotification;
use App\Workflows\Notifications\RequestFilesUploadNotification;
use App\Workflows\Notifications\StateUpdateNotification;
use App\Workflows\Partials\RequestStates;
use App\Workflows\Transitions\Stage2UpdateTransition;
use App\Workflows\Transitions\StateUpdateTransition;
use Workflow\ActivityStub;
use Workflow\Models\StoredWorkflow;
use Workflow\Workflow;
use Workflow\WorkflowStub;

class ProjectWorkflow extends Workflow
{

    /***
     * Workflow for the PREAPPROVAL (not in use)
     */

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

        //Submitted by requester
        yield WorkflowStub::await(fn () => $this->isSubmitted());

        //Update pp with dashboardstate
        $commonActivities = $this->getCommonActivities($userRequest);
        yield $commonActivities[0];

        //Preapproval request Email to Vice
        yield ActivityStub::make(NewPreApprovalNotification::class, RequestStates::VICE, $userRequest);

        //Wait for vice decision
        yield WorkflowStub::await(fn () => ($this->ViceApproved() || $this->ViceDenied() || $this->ViceReturned()));

        //Handle vice decision
        $newState = $this->getState();
        $commonActivities = $this->getCommonActivities($userRequest);

        // Await stateupdate
        yield $commonActivities[0];

        switch ($newState) {
            case RequestStates::VICE_APPROVED:
                //Email user to complete proposal
                yield ActivityStub::make(CompletProjectProposalNotification::class, RequestStates::USER, $userRequest);
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

        //Wait for completed proposal
        yield WorkflowStub::await(fn () => ($this->Completed()));

        //Check for files
        if(!$this->UploadedFiles()) {
            //Notify user request files upload
            yield ActivityStub::make(RequestFilesUploadNotification::class, $userRequest);
        }

        //Wait for user to upload files
        yield WorkflowStub::await(fn () => ($this->UploadedFiles()));

        //Update state progress
        $commonActivities = $this->getCommonActivities($userRequest);
        yield $commonActivities[0];

        //Email to Head
        yield ActivityStub::make(NewProjectProposalNotification::class, RequestStates::UNIT_HEAD, $userRequest);

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
                //Update stage2
                yield ActivityStub::make(Stage2UpdateTransition::class, $userRequest);
                //Email to FO for review
                yield ActivityStub::make(NewProjectProposalNotification::class, RequestStates::FINACIAL_OFFICER, $userRequest);
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

                //Update stage2
                yield ActivityStub::make(Stage2UpdateTransition::class, $userRequest);

                //Final approval request Email to Vice
                yield ActivityStub::make(NewFinalApprovalNotification::class, RequestStates::VICE, $userRequest);

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
