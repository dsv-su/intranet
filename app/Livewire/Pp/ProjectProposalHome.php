<?php

namespace App\Livewire\Pp;

use App\Models\Dashboard;
use App\Models\FundingOrganization;
use App\Models\ProjectProposal;
use App\Services\Awaiting\AwaitingDashboard;
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
        $awiting = new AwaitingDashboard($user);
        $this->awaiting =  $awiting->proposals()->count();
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
