<?php

namespace App\Livewire\Pp;

use Livewire\Component;

class ProposalFiles extends Component
{
    public $proposal;

    protected $listeners = [
        'upload' => '$refresh'
    ];

    public function mount($proposal)
    {
        $this->proposal = $proposal;
    }

    public function removefile($id)
    {
        // Get the current files array
        $files = $this->proposal->files;

        // Remove the specific item by key
        if (isset($files[$id])) {
            unset($files[$id]);
        }

        // Save the modified array back to the property
        $this->proposal->files = $files;

        // Persist changes to the database
        $this->proposal->save();

        $this->dispatch('upload');
    }

    public function render()
    {
        return view('livewire.pp.proposal-files');
    }
}
