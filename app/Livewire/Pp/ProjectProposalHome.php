<?php

namespace App\Livewire\Pp;

use App\Models\ProjectProposal;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class ProjectProposalHome extends Component
{
    public $proposals;
    public $myproposals;

    public function mount(ProjectProposal $proposals)
    {
        $this->proposals = $proposals;
        $this->my();
    }

    public function my()
    {
        $user = Auth::user();
        $this->myproposals = $this->proposals::where('user_id', $user->id)->get();
    }

    public function allproposals()
    {
        $this->dispatch('allproposals');
    }

    public function render()
    {
        return view('livewire.pp.project-proposal-home');
    }
}
