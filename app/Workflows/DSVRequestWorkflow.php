<?php

namespace App\Workflows;

use App\Workflows\Notifications\NewRequestNotification;
use App\Workflows\Notifications\StateUpdateNotification;
use App\Workflows\Partials\CheckRoleforApprove;
use App\Workflows\Partials\RequestStates;
use App\Workflows\Transitions\StateUpdateTransition;
use Finite\State\State;
use Finite\State\StateInterface;
use Finite\StatefulInterface;
use Finite\StateMachine\StateMachine;
use Workflow\ActivityStub;
use Workflow\Models\StoredWorkflow;
use Workflow\SignalMethod;
use Workflow\Workflow;
use Workflow\WorkflowStub;

class DSVRequestWorkflow extends Workflow implements StatefulInterface
{
    private $state;
    private $stateMachine;
    protected $checkRole;

    public function setFiniteState($state)
    {
        $this->state = $state;
    }

    public function getFiniteState()
    {
        return $this->state;
    }

    //Signal Submit
    #[SignalMethod]
    public function submit()
    {
        $this->stateMachine->apply('submit');
    }

    //Signal Manager
    #[SignalMethod]
    public function manager_approve()
    {
        $this->stateMachine->apply('managerapprove');
    }

    #[SignalMethod]
    public function manager_return()
    {
        $this->stateMachine->apply('managerreturn');
    }

    #[SignalMethod]
    public function manager_deny()
    {
        $this->stateMachine->apply('managerdeny');
    }

    //Signal FO
    #[SignalMethod]
    public function fo_approve()
    {
        $this->stateMachine->apply('foapprove');
    }

    #[SignalMethod]
    public function fo_return()
    {
        $this->stateMachine->apply('foreturn');
    }

    #[SignalMethod]
    public function fo_deny()
    {
        $this->stateMachine->apply('fodeny');
    }

    //Signal Head
    #[SignalMethod]
    public function head_approve()
    {
        $this->stateMachine->apply('headapprove');
    }

    #[SignalMethod]
    public function head_return()
    {
        $this->stateMachine->apply('headreturn');
    }

    #[SignalMethod]
    public function head_deny()
    {
        $this->stateMachine->apply('headdeny');
    }

    //Wait for statechange
    public function isSubmitted()
    {
        return $this->stateMachine->getCurrentState()->getName() === 'submitted';
    }

    //Manager
    public function ManagerApproved()
    {
        return $this->stateMachine->getCurrentState()->getName() === 'manager_approved';
    }

    public function ManagerReturned()
    {
        return $this->stateMachine->getCurrentState()->getName() === 'manager_returned';
    }

    public function ManagerDenied()
    {
        return $this->stateMachine->getCurrentState()->getName() === 'manager_denied';
    }

    //Finacial officer
    public function FOApproved()
    {
        return $this->stateMachine->getCurrentState()->getName() === 'fo_approved';
    }

    public function FOReturned()
    {
        return $this->stateMachine->getCurrentState()->getName() === 'fo_returned';
    }

    public function FODenied()
    {
        return $this->stateMachine->getCurrentState()->getName() === 'fo_denied';
    }

    //Head
    public function HeadApproved()
    {
        return $this->stateMachine->getCurrentState()->getName() === 'head_approved';
    }

    public function HeadReturned()
    {
        return $this->stateMachine->getCurrentState()->getName() === 'head_returned';
    }

    public function HeadDenied()
    {
        return $this->stateMachine->getCurrentState()->getName() === 'head_denied';
    }

    public function __construct(
        public StoredWorkflow $storedWorkflow, ...$arguments) {
        parent::__construct($storedWorkflow, $arguments);

        $this->checkRole = new CheckRoleforApprove();
        $this->stateMachine = new StateMachine();
        //Initial
        $this->stateMachine->addState(new State('created', StateInterface::TYPE_INITIAL));

        //Submitted
        $this->stateMachine->addState('submitted');

        //Manager
        $this->stateMachine->addState('manager_approved');
        $this->stateMachine->addState(new State('manager_denied', StateInterface::TYPE_FINAL));
        $this->stateMachine->addState('manager_returned');

        //FO
        $this->stateMachine->addState('fo_approved');
        $this->stateMachine->addState(new State('fo_denied', StateInterface::TYPE_FINAL));
        $this->stateMachine->addState('fo_returned');

        //Head
        $this->stateMachine->addState('head_approved');
        $this->stateMachine->addState(new State('head_denied', StateInterface::TYPE_FINAL));
        $this->stateMachine->addState('head_returned');

        //Transitions
        $this->stateMachine->addTransition('submit', 'created', 'submitted');

        //Manager
        $this->stateMachine->addTransition('managerapprove', 'submitted', 'manager_approved');
        $this->stateMachine->addTransition('managerreturn', 'submitted', 'manager_returned');
        $this->stateMachine->addTransition('managerdeny', 'submitted', 'manager_denied');

        //Head
        $this->stateMachine->addTransition('headapprove', 'manager_approved', 'head_approved');
        $this->stateMachine->addTransition('headreturn', 'manager_approved', 'head_returned');
        $this->stateMachine->addTransition('headdeny', 'manager_approved', 'head_denied');

        //FO
        $this->stateMachine->addTransition('foapprove', 'head_approved', 'fo_approved');
        $this->stateMachine->addTransition('foreturn', 'head_approved', 'fo_returned');
        $this->stateMachine->addTransition('fodeny', 'head_approved', 'fo_denied');

        //Initialize
        $this->stateMachine->setObject($this);
        $this->stateMachine->initialize();
    }


    public function execute($userRequest)
    {
        //Submitted by requester
        yield WorkflowStub::await(fn () => $this->isSubmitted());

        //Fire email to manager
        yield ActivityStub::make(NewRequestNotification::class, RequestStates::MANAGER, $userRequest);

        //Wait for manager to process request
        yield WorkflowStub::await(fn () => $this->ManagerApproved() || $this->ManagerDenied() || $this->ManagerReturned());

        // Handle managers decision
        $newState = $this->getState();

        // Activities
        $commonActivities = $this->getCommonActivities($userRequest, $newState);

        switch ($newState) {
            case RequestStates::MANAGER_APPROVED:
                // Request has been approved by manager
                yield $commonActivities[0];
                break;
            case RequestStates::MANAGER_RETURNED:
            case RequestStates::MANAGER_DENIED:
                // Request had been returned or denied by manager
                foreach ($commonActivities as $activity) {
                    yield $activity;
                }
                //End workflow
                return $this->stateMachine->getCurrentState()->getName();
        }


        if($this->checkRole->isSameManagerHead($userRequest)) {

            // Manager and Head is same person
            $this->head_approve();

            // Retrive new state
            $newState = $this->getState();
            $commonActivities = $this->getCommonActivities($userRequest, $newState);

            // Await stateupdate
            yield $commonActivities[0];

            // Notify FO
            yield ActivityStub::make(NewRequestNotification::class, RequestStates::FINACIAL_OFFICER, $userRequest);

        } else {

            // Notify Head
            yield ActivityStub::make(NewRequestNotification::class, RequestStates::UNIT_HEAD, $userRequest);

            //Wait for Head to process request
            yield WorkflowStub::await(fn () => $this->HeadApproved() || $this->HeadDenied() || $this->HeadReturned());

            //Handle Head decision
            $newState = $this->getState();
            $commonActivities = $this->getCommonActivities($userRequest, $newState);

            switch ($newState) {
                case RequestStates::HEAD_APPROVED:
                    //Request has been approved by head
                    yield $commonActivities[0];
                    //Notify FO
                    yield ActivityStub::make(NewRequestNotification::class, RequestStates::FINACIAL_OFFICER, $userRequest);
                    break;
                case RequestStates::HEAD_RETURNED:
                case RequestStates::HEAD_DENIED:
                    //Request has been returned or denied by head
                    foreach ($commonActivities as $activity) {
                        yield $activity;
                    }
                    //End workflow
                    return $this->stateMachine->getCurrentState()->getName();
            }

        }

        //Wait for financialofficer to process request
        yield WorkflowStub::await(fn () => $this->FOApproved() || $this->FODenied() || $this->FOReturned());

        //Handle FO decision
        $newState = $this->getState();
        $commonActivities = $this->getCommonActivities($userRequest, $newState);

        switch ($newState) {
            case RequestStates::FO_APPROVED:
                //Request has been approved by fo
                foreach ($commonActivities as $activity) {
                    yield $activity;
                }
                break;
            case RequestStates::FO_RETURNED:
            case RequestStates::FO_DENIED:
                //Request has been returned or denied by fo
                foreach ($commonActivities as $activity) {
                    yield $activity;
                }
                //End workflow
                return $this->stateMachine->getCurrentState()->getName();
        }

        //End workflow
        return $this->stateMachine->getCurrentState()->getName();
    }

    protected function getState()
    {
        return $this->stateMachine->getCurrentState()->getName();
    }

    protected function getCommonActivities($userRequest, $newState)
    {
        return [
            ActivityStub::make(StateUpdateTransition::class, $newState, $userRequest),
            ActivityStub::make(StateUpdateNotification::class, $userRequest),
        ];
    }

}
