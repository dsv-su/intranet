<?php

namespace App\Livewire\Pp;

use App\Models\Dashboard;
use App\Services\Settings\ProposalsDirectory;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use Livewire\Features\SupportFileUploads\TemporaryUploadedFile;
use Livewire\Features\SupportFileUploads\WithFileUploads;

class ProposalBudgetUploader extends Component
{
    use WithFileUploads;

    const PREAPPROVED = 'vice_approved';
    const SUBMITTED = 'submitted';
    const APPROVED = 'final_approved';

    public $proposal;
    public $dashboard;
    public $budgetfiles = [];
    public $savedfiles = [];
    public $stored = false;
    public $directory;
    public $allow;
    public $type;
    public $resumed = ['vice_returned', 'head_returned', 'fo_returned', 'final_returned'];

    protected $listeners = [
        'upload_refresh' => '$refresh'
    ];

    public function mount($proposal, $type)
    {
        $this->proposal = $proposal;
        $this->type = $type;
        $this->directory = ProposalsDirectory::MAIN . $this->proposal->id . ProposalsDirectory::BUDGET;
        if($this->dashboard = Dashboard::where('request_id', $this->proposal->id)->first()) {
            $this->allowUpload();
        } else {
            $this->allow = true;
        }
    }

    public function checkFileStatus()
    {
        $budgetfiles = is_array($this->proposal->files ?? null) ? $this->proposal->files : [];

        if (count($budgetfiles) >= 2) {
            return $this->reportStageStatus('uploaded');
        }

        return $this->reportStageStatus('waiting');
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

        if (in_array($user->id, $allowed_roles) && ($this->dashboard->state == self::PREAPPROVED or $this->dashboard->state == self::SUBMITTED or $this->dashboard->state == self::APPROVED or in_array($this->dashboard->state, $this->resumed)) ) {
            $this->allow = true;
        } else {
            $this->allow = false;
        }
    }

    public function finishUpload($name, $tmpPath, $isMultiple)

    {
        $this->toggleStored();
        $this->cleanupOldUploads();
        $budgetfiles = collect($tmpPath)->map(function ($i) {
            return TemporaryUploadedFile::createFromLivewire($i);
        })->toArray();
        $this->emitSelf('upload:finished', $name, collect($budgetfiles)->map->getFilename()->toArray());

        $budgetfiles = array_merge($this->getPropertyValue($name), $budgetfiles);
        $this->syncInput($name, $budgetfiles);
    }

    public function storefiles()
    {
        foreach($this->budgetfiles as $file) {
            $this->savedfiles[$file->getClientOriginalName()] = [
                'path' => $file->store(path: $this->directory),
                'tmp' => basename($file->getRealPath()),
                'size' => round($file->getSize()/1000),
                'date' => now()->format('d/m/Y'),
                'type' => 'budget',
                'review' => 'pending',
                'uploader' => Auth::user()->name
            ];
        }

        //Update files to model
        $this->updateProposal();
        $this->checkFileStatus();

        //Toggled buttons
        $this->toggleStored();
        $this->budgetfiles = [];
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
        return view('livewire.pp.proposal-budget-uploader');
    }
}
