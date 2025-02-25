<?php

namespace App\Livewire\Pp;

use App\Models\Dashboard;
use App\Models\FundingOrganization;
use App\Models\ProjectProposal;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class ProjectProposalHome extends Component
{
    public $proposals;
    public $myproposals;
    public $awaiting;
    public $funding_organizations;

    public function mount(ProjectProposal $proposals)
    {
        $this->proposals = $proposals;
        $user = Auth::user();
        $this->my($user);
        $this->awaiting($user);
        $this->funding_organizations = FundingOrganization::all()->count();
    }

    public function hydrate()
    {
        $user = Auth::user();
        $this->awaiting($user);
    }

    public function my($user)
    {
        $this->myproposals = $this->proposals::where('user_id', $user->id)->get();
    }

    public function awaiting($user)
    {
        $this->awaiting = Dashboard::where('type', 'projectproposal')
            ->where(function ($query) use ($user) {
                $query->where('state', 'submitted')
                    ->where('vice_id', $user->id)
                    ->orWhere(function ($query) use ($user) {
                        $query->where('state', 'head_approved')
                            ->where('fo_id', $user->id);
                    })->orWhere(function ($query) use ($user) {
                        $query->where('state', 'complete')
                            ->whereJsonContains('unit_head_approved', [$user->id => 0]);
                    });
            })
            ->count();

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
