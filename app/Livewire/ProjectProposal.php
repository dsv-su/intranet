<?php

namespace App\Livewire;

use App\Models\Dashboard;
use App\Models\SettingsFo;
use App\Services\Review\WorkflowHandler;
use App\Workflows\DSVProjectPWorkflow;
use Carbon\Carbon;
use Livewire\Component;
use Workflow\WorkflowStub;

class ProjectProposal extends Component
{
    public $progress = 'Waiting', $progressColor;
    public $name = '';
    public $status = '';
    public $upload;
    public $uh = false;
    public $vh = false;
    public $workflowID;

    public function mount()
    {
        $this->progressColor = 'bg-blue-100';
        $this->upload = 'hidden';
    }

    public function submit_application()
    {
        // Find or create the financial officer
        $fo = SettingsFo::find(1);
        $pp = new \App\Models\ProjectProposal();
        $pp->name = $this->name;
        $pp->created = Carbon::createFromFormat('d/m/Y', now()->format('d/m/Y'))->timestamp;
        $pp->state = 'submitted';
        $pp->pp = ['title' => $this->name, 'main resercher' => 'Ryan Dias', 'co-applicants' => 'Jenny Lind, Jason Bourne'];
        $pp->save();
        // Find or create Dashboard instance
        $dashboardData = [
            'request_id' => $pp->id,
            'name' => $this->name,
            'created' => Carbon::createFromFormat('d/m/Y', now()->format('d/m/Y'))->timestamp,
            'state' => 'submitted',
            'status' => 'unread',
            'type' => 'projectproposal',
            'user_id' => auth()->id(),
            'manager_id' => '9d2400f8-4789-4a91-a22a-fb9a97fbf27f',
            'fo_id' => '9d2400f8-4789-4a91-a22a-fb9a97fbf27f',
            'head_id' => '9d2400f8-4789-4a91-a22a-fb9a97fbf27f'
        ];

        //Create new dashboard instance
        $dashboard = Dashboard::where('request_id', $pp->id)->first();
        if (!$dashboard) {
            $dashboard = Dashboard::create($dashboardData);
        } else {
            $dashboard->update($dashboardData);
        }

        //Start workflow
        $workflow = $this->createAndStartWorkflow($dashboard);

        //WorkflowID
        $this->workflowID = $workflow->id();

        //Update status
        $this->setStatus('submitted');
        $this->setProgress('Submitted');

    }

    protected function createAndStartWorkflow($dashboard)
    {
        $workflow = WorkflowStub::make(DSVProjectPWorkflow::class);
        $dashboard->workflow_id = $workflow->id();
        $dashboard->save();
        $workflow->start($dashboard);
        $workflow->submit();
        return $workflow;
    }

    public function setProgress($status)
    {
        $this->progress = $status;
        $this->progressColor = 'bg-yellow-100';

    }

    public function setStatus($status)
    {
        $this->status = $status;
    }

    public function UHApprove()
    {
        $workflowhandler = new WorkflowHandler($this->workflowID);
        $workflowhandler->HeadApprove();

        $this->setProgress('UH Approved');
        $this->uh = true;
        $this->checkApprove();
    }

    public function UHDeny()
    {
        $this->setProgress('UH Denied');
        $this->progressColor = 'bg-red-100';
    }

    public function VHApprove()
    {
        $workflowhandler = new WorkflowHandler($this->workflowID);
        $workflowhandler->ViceApprove();

        $this->setProgress('VH Approved');
        $this->vh = true;
        $this->checkApprove();
    }

    public function VHDeny()
    {
        $this->setProgress('VH Denied');
        $this->progressColor = 'bg-red-100';
    }

    public function checkApprove()
    {
        if($this->uh && $this->vh) {
            $this->upload = '';
            $this->setProgress('Application Approved');
            $this->progressColor = 'bg-green-300';
        }
    }

    public function render()
    {
        return view('livewire.project-proposal');
    }
}
