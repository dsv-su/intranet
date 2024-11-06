<?php

namespace App\Livewire\Pp;

use Livewire\Component;
use Livewire\Features\SupportFileUploads\TemporaryUploadedFile;
use Livewire\Features\SupportFileUploads\WithFileUploads;

class ProposalUploader extends Component
{
    use WithFileUploads;

    public $files = [];

    public function finishUpload($name, $tmpPath, $isMultiple)

    {
        $this->cleanupOldUploads();
        $files = collect($tmpPath)->map(function ($i) {
            return TemporaryUploadedFile::createFromLivewire($i);
        })->toArray();
        $this->emitSelf('upload:finished', $name, collect($files)->map->getFilename()->toArray());

        $files = array_merge($this->getPropertyValue($name), $files);
        $this->syncInput($name, $files);
    }

    public function render()
    {
        return view('livewire.pp.proposal-uploader');
    }
}
