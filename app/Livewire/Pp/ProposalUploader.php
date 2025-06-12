<?php

namespace App\Livewire\Pp;

use App\Models\Dashboard;
use App\Models\ProjectProposal;
use App\Services\Review\WorkflowHandler;
use App\Services\Settings\ProposalsDirectory;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Livewire\Component;
use Livewire\Features\SupportFileUploads\TemporaryUploadedFile;
use Livewire\Features\SupportFileUploads\WithFileUploads;
use ZipArchive;

class ProposalUploader extends Component
{
    use WithFileUploads;

    const PREAPPROVED = 'vice_approved';
    const SUBMITTED = 'submitted';
    const APPROVED = 'final_approved';

    public $proposal;
    public $dashboard;
    public $files = [];
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
        $this->directory = ProposalsDirectory::MAIN . $this->proposal->id . ProposalsDirectory::DRAFT;
        if($this->dashboard = Dashboard::where('request_id', $this->proposal->id)->first()) {
            $this->allowUpload();
        } else {
            $this->allow = true;
        }
    }

    public function checkFileStatus()
    {
        $files = is_array($this->proposal->files ?? null) ? $this->proposal->files : [];
        if($this->dashboard) {
            $workflowhandler = new WorkflowHandler($this->dashboard->workflow_id);
        }


        if (count($files) >= 2) {
            if($this->dashboard) {
                //Signal workflow
                $workflowhandler->UploadedFiles();
            }
            return $this->reportStageStatus('uploaded');
        } else {
            if($this->dashboard) {
                //Signal workflow
                $workflowhandler->RemovedFile();
            }
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
                'path' => $file->store(path: $this->directory),
                'tmp' => basename($file->getRealPath()),
                'size' => round($file->getSize()/1000),
                'date' => now()->format('d/m/Y'),
                'type' => 'draft',
                'review' => 'pending',
                'uploader' => Auth::user()->name
                ];
        }

        //Update files to model
        $this->updateProposal();
        $this->checkFileStatus();

        //Toggled buttons
        $this->toggleStored();
        $this->files = [];
    }

    public function updateProposal()
    {
        $this->proposal->files = array_merge($this->proposal->files, $this->savedfiles);
        $this->proposal->save();
        $this->savedfiles = [];
        //$this->dispatch('upload_refresh');
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
        $remove = $files[$id]['path'];

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
        $this->checkFileStatus();
    }

    public function removefolder()
    {
        $this->proposal->files = [];
        Storage::deleteDirectory(ProposalsDirectory::MAIN . $this->proposal->id . ProposalsDirectory::DRAFT);
        Storage::deleteDirectory(ProposalsDirectory::MAIN . $this->proposal->id . ProposalsDirectory::BUDGET);
        Storage::deleteDirectory(ProposalsDirectory::MAIN . $this->proposal->id . ProposalsDirectory::FINAL);
        $this->proposal->save();
        $this->files = [];
        $this->reportStageStatus('pending');
    }

    public function downloadfile($id)
    {
        // Get the current files array
        $files = $this->proposal->files;
        $downloadfile = $files[$id]['path'];

        return Storage::download($downloadfile, $id);
    }

    public function downloadfolder()
    {
        $draft = Storage::files(ProposalsDirectory::MAIN . $this->proposal->id . ProposalsDirectory::DRAFT);
        $budget = Storage::files(ProposalsDirectory::MAIN . $this->proposal->id . ProposalsDirectory::BUDGET);
        $final = Storage::files(ProposalsDirectory::MAIN . $this->proposal->id . ProposalsDirectory::FINAL);
        $files = array_merge($draft, $budget, $final);

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
                    if(basename($orignal['path']) == basename($file)) {
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
