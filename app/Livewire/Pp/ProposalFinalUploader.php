<?php

namespace App\Livewire\Pp;

use App\Models\Dashboard;
use App\Services\Review\WorkflowHandler;
use App\Services\Settings\ProposalsDirectory;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Livewire\Component;
use Livewire\Features\SupportFileUploads\TemporaryUploadedFile;
use Livewire\Features\SupportFileUploads\WithFileUploads;

class ProposalFinalUploader extends Component
{
    use WithFileUploads;

    const PREAPPROVED = 'vice_approved';
    const COMPLETE = 'complete';
    const APPROVED = 'final_approved';

    public $proposal;
    public $dashboard;
    public $finalfiles = [];
    public $savedfiles = [];
    public $stored = false;
    public $directory;
    public $allow;
    public $type;

    protected $listeners = [
        'upload_refresh' => '$refresh'
    ];

    public function mount($proposal, $type)
    {
        $this->proposal = $proposal;
        $this->type = $type;
        $this->directory = ProposalsDirectory::MAIN . $this->proposal->id . ProposalsDirectory::FINAL;
        $this->dashboard = Dashboard::where('request_id', $this->proposal->id)->first();
        $this->allowUpload();
    }

    public function checkFileStatus()
    {
        /*
        $finalfiles = is_array($this->proposal->files ?? null) ? $this->proposal->files : [];
        $workflowhandler = new WorkflowHandler($this->dashboard->workflow_id);

        if (count($finalfiles) >= 2) {
            //Signal workflow
            $workflowhandler->UploadedFiles();
            return $this->reportStageStatus('uploaded');
        } else {
            //Signal workflow
            $workflowhandler->RemovedFile();
        }

        return $this->reportStageStatus('waiting');
        */
    }

    public function reportStageStatus($status)
    {
        $this->proposal->status_stage2 = $status;
        $this->proposal->save();
    }

    public function allowUpload()
    {
        $user = Auth::user();

        $allowed_roles = [$this->dashboard->user_id, $this->dashboard->head_id, $this->dashboard->vice_id, $this->dashboard->fo_id];

        if (in_array($user->id, $allowed_roles) && ($this->dashboard->state == self::PREAPPROVED or $this->dashboard->state == self::COMPLETE or $this->dashboard->state == self::APPROVED) ) {
            $this->allow = true;
        } else {
            $this->allow = false;
        }
    }

    public function finishUpload($name, $tmpPath, $isMultiple)

    {
        $this->toggleStored();
        $this->cleanupOldUploads();
        $finalfiles = collect($tmpPath)->map(function ($i) {
            return TemporaryUploadedFile::createFromLivewire($i);
        })->toArray();
        $this->emitSelf('upload:finished', $name, collect($finalfiles)->map->getFilename()->toArray());

        $finalfiles = array_merge($this->getPropertyValue($name), $finalfiles);
        $this->syncInput($name, $finalfiles);
    }

    public function storefiles()
    {
        foreach($this->finalfiles as $file) {
            $this->savedfiles[$file->getClientOriginalName()] = [
                'path' => $file->store(path: $this->directory),
                'tmp' => basename($file->getRealPath()),
                'size' => round($file->getSize()/1000),
                'date' => now()->format('d/m/Y'),
                'type' => 'final',
                'uploader' => Auth::user()->name
            ];
        }

        //Update files to model
        $this->updateProposal();
        //$this->checkFileStatus();

        //Toggled buttons
        $this->toggleStored();
        $this->finalfiles = [];
        $this->dispatch('upload_refresh');
    }

    public function updateProposal()
    {
        $this->proposal->files = array_merge($this->proposal->files, $this->savedfiles);
        $this->proposal->save();
        $this->savedfiles = [];
    }

    public function checkToggle()
    {
        if($this->stored) {
            $this->toggleStored();
        }
    }

    public function toggleStored()
    {
        $this->stored = !$this->stored;
    }

    public function render()
    {
        return view('livewire.pp.proposal-final-uploader');
    }
}
