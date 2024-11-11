<?php

namespace App\Livewire\Pp;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Livewire\Component;
use Livewire\Features\SupportFileUploads\TemporaryUploadedFile;
use Livewire\Features\SupportFileUploads\WithFileUploads;
use ZipArchive;

class ProposalUploader extends Component
{
    use WithFileUploads;

    public $proposal;
    public $files = [];
    public $savedfiles = [];
    public $stored = false;
    public $directory;

    protected $listeners = [
        'upload_refresh' => '$refresh'
    ];

    public function mount($proposal)
    {
        $this->proposal = $proposal;
        $this->directory = '/proposals/' . $this->proposal->id;
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
            $this->savedfiles[$file->getClientOriginalName()] = [
                'path' => basename($file->store(path: 'proposals/'. $this->proposal->id)),
                'tmp' => basename($file->getRealPath()),
                'size' => round($file->getSize()/1000),
                'date' => now()->format('d/m/Y'),
                'uploader' => Auth::user()->name
                ];
        }

        //Update files to model
        $this->updateProposal();

        //Toggled buttons
        $this->toggleStored();
        $this->files = [];
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

    public function removefile($id)
    {
        // Get the current files array
        $files = $this->proposal->files;
        $remove = $this->directory .'/'. $files[$id]['path'];

        //For debugging
        //$livewireID = $files[$id]['path'];
        //$tmp = $files[$id]['tmp'];

        if (Storage::exists($remove)) {
            Storage::delete($remove);
        }

        // Remove the specific item by key
        if (isset($files[$id])) {
            unset($files[$id]);
        }

        // Save the modified array back to the property
        $this->proposal->files = $files;

        // Persist changes to the database
        $this->proposal->save();

    }

    public function removefolder()
    {
        $this->proposal->files = [];
        Storage::deleteDirectory($this->directory);
        $this->proposal->save();
        $this->files = [];
    }

    public function downloadfile($id)
    {
        // Get the current files array
        $files = $this->proposal->files;
        $downloadfile = $this->directory .'/'. $files[$id]['path'];

        return Storage::download($downloadfile, $id);
    }

    public function downloadfolder()
    {
        $files = Storage::files($this->directory);
        $originalfiles = $this->proposal->files;
        $zip = new ZipArchive;
        $zipFileName = "download/" . 'ProjectProposal-' . $this->proposal->name . '.zip';
        $zipFilePath = public_path($zipFileName);

        // Ensure the download directory exists
        if (!file_exists(public_path('download'))) {
            mkdir(public_path('download'), 0777, true);
        }

        // Open the zip file for writing
        if ($zip->open($zipFilePath, ZipArchive::CREATE) === TRUE) {
            foreach ($files as $file) {
                $filePath = Storage::path($file); // Get absolute path
                // Match name from model
                foreach ($originalfiles as $key => $orignal) {
                    if($orignal['path'] == basename($file)) {
                        $set_zipname = $key;
                    }
                }
                // Create zip
                if (file_exists($filePath)) { // Check if file exists
                    $zip->addFile($filePath, $set_zipname);
                }
            }
            $zip->close();
        } else {
            return response()->json(['error' => 'Could not create zip file'], 500);
        }

        // Return response with download and delete after sending
        return response()->download($zipFilePath)->deleteFileAfterSend(true);

    }

    public function render()
    {
        return view('livewire.pp.proposal-uploader');
    }
}
