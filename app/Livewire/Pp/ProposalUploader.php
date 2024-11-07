<?php

namespace App\Livewire\Pp;

use App\Livewire\ProjectProposal;
use Livewire\Component;
use Livewire\Features\SupportFileUploads\TemporaryUploadedFile;
use Livewire\Features\SupportFileUploads\WithFileUploads;

class ProposalUploader extends Component
{
    use WithFileUploads;

    public $proposal;
    public $files = [];
    public $savedfiles = [];
    public $stored = false;

    protected $listeners = [
        'upload' => '$refresh'
    ];

    public function mount($proposal)
    {
        $this->proposal = $proposal;
    }

    public function finishUpload($name, $tmpPath, $isMultiple)

    {
        $this->toggleStored();
        $this->cleanupOldUploads();
        $files = collect($tmpPath)->map(function ($i) {
            return TemporaryUploadedFile::createFromLivewire($i);
        })->toArray();
        $this->emitSelf('upload:finished', $name, collect($files)->map->getFilename()->toArray());

        $files = array_merge($this->getPropertyValue($name), $files);
        $this->syncInput($name, $files);

    }

    public function storefiles()
    {
        foreach($this->files as $file) {
           $this->savedfiles[$file->getClientOriginalName()] = basename($file->store(path: 'proposals/'. $this->proposal->id));
        }

        //Update files to model
        $this->updateProposal();

        //Toggled buttons
        $this->toggleStored();
    }

    public function updateProposal()
    {
        $this->proposal->files = array_merge($this->proposal->files, $this->savedfiles);
        $this->proposal->save();
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
        return view('livewire.pp.proposal-uploader');
    }
}
