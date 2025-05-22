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

class ProposalBudgetUploader extends Component
{
    use WithFileUploads;

    const PREAPPROVED = 'vice_approved';
    const COMPLETE = 'complete';
    const APPROVED = 'final_approved';

    public $proposal;
    public $dashboard;
    public $budgetfiles = [];
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
        $this->directory = ProposalsDirectory::MAIN . $this->proposal->id . ProposalsDirectory::BUDGET;
        $this->dashboard = Dashboard::where('request_id', $this->proposal->id)->first();
        $this->allowUpload();
    }

    public function checkFileStatus()
    {
        $budgetfiles = is_array($this->proposal->budgetfiles ?? null) ? $this->proposal->budgetfiles : [];

        if (count($budgetfiles) >= 2) {
            //Signal workflow
            $workflowhandler = new WorkflowHandler($this->dashboard->workflow_id);
            $workflowhandler->UploadedFiles();

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
        //$dashboard = Dashboard::where('request_id', $this->proposal->id)->first();

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
                'path' => basename($file->store(path: $this->directory)),
                'tmp' => basename($file->getRealPath()),
                'size' => round($file->getSize()/1000),
                'date' => now()->format('d/m/Y'),
                'type' => 'budget',
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

    public function removefile($id)
    {
        // Get the current files array
        $budgetfiles = $this->proposal->files;
        $remove = $this->directory . $budgetfiles[$id]['path'];

        //For debugging
        //$livewireID = $budgetfiles[$id]['path'];
        //$tmp = $budgetfiles[$id]['tmp'];

        if (Storage::exists($remove)) {
            Storage::delete($remove);
        }

        // Remove the specific item by key
        if (isset($budgetfiles[$id])) {
            unset($budgetfiles[$id]);
        }

        // Save the modified array back to the property
        $this->proposal->files = $budgetfiles;

        // Persist changes to the database
        $this->proposal->save();
        $this->checkFileStatus();
    }

    /*public function removefolder()
    {
        $this->proposal->files = [];
        Storage::deleteDirectory($this->directory);
        $this->proposal->save();
        $this->budgetfiles = [];
        $this->reportStageStatus('pending');
    }*/

    public function downloadfile($id)
    {
        // Get the current files array
        $budgetfiles = $this->proposal->files;
        $downloadfile = $this->directory . $budgetfiles[$id]['path'];

        return Storage::download($downloadfile, $id);
    }

    /*public function downloadfolder()
    {
        $budgetfiles = Storage::files($this->directory);
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
            foreach ($budgetfiles as $file) {
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

    }*/

    public function render()
    {
        return view('livewire.pp.proposal-budget-uploader');
    }
}
