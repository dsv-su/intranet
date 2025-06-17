<?php

namespace App\Livewire\Pp;

use App\Models\Dashboard;
use App\Services\Settings\ProposalsDirectory;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use Livewire\Features\SupportFileUploads\TemporaryUploadedFile;
use Livewire\Features\SupportFileUploads\WithFileUploads;

class ProposalDecisionUploader extends Component
{
    use WithFileUploads;

    const SENT = 'sent';

    public $proposal;
    public $dashboard;
    public $decisionfiles = [];
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
        $this->directory = ProposalsDirectory::MAIN . $this->proposal->id . ProposalsDirectory::DECISION;
        $this->dashboard = Dashboard::where('request_id', $this->proposal->id)->first();
        $this->allowUpload();
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

        if (in_array($user->id, $allowed_roles) && ($this->dashboard->state == self::SENT) ) {
            $this->allow = true;
        } else {
            $this->allow = false;
        }
    }

    public function finishUpload($name, $tmpPath, $isMultiple)
    {
        $this->toggleStored();
        $this->cleanupOldUploads();
        $decisionfiles = collect($tmpPath)->map(function ($i) {
            return TemporaryUploadedFile::createFromLivewire($i);
        })->toArray();
        $this->emitSelf('upload:finished', $name, collect($decisionfiles)->map->getFilename()->toArray());

        $decisionfiles = array_merge($this->getPropertyValue($name), $decisionfiles);
        $this->syncInput($name, $decisionfiles);
    }

    public function storefiles()
    {
        foreach($this->decisionfiles as $file) {
            $this->savedfiles[$file->getClientOriginalName()] = [
                'path' => $file->store(path: $this->directory),
                'tmp' => basename($file->getRealPath()),
                'size' => round($file->getSize()/1000),
                'date' => now()->format('d/m/Y'),
                'type' => 'decision',
                'review' => 'pending',
                'uploader' => Auth::user()->name
            ];
        }

        //Update files to model
        $this->updateProposal();

        //Toggled buttons
        $this->toggleStored();
        $this->decisionfiles = [];
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
        return view('livewire.pp.proposal-decision-uploader');
    }
}
