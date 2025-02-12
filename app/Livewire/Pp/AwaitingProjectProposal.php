<?php

namespace App\Livewire\Pp;

use App\Models\Dashboard;
use App\Models\ProjectProposal;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class AwaitingProjectProposal extends Component
{
    public $review = false;
    public $resume = false;

    public function render()
    {
        //Awaiting proposals
        $user = Auth::user();
        $awaitingDashboard = Dashboard::where('type', 'projectproposal')
            ->where(function ($query) use ($user) {
                $query->where('state', 'submitted')
                    ->whereJsonContains('unit_head_approved', [$user->id => 0])
                    ->orWhere(function ($query) use ($user) {
                        $query->where('state', 'head_approved')
                            ->where('vice_id', $user->id);
                    })->orWhere(function ($query) use ($user) {
                        $query->where('state', 'vice_approved')
                            ->where('fo_id', $user->id);
                    });
            })
            ->pluck('request_id');

        $proposals = ProjectProposal::with('dashboard')
            ->whereIn('id', $awaitingDashboard)
            ->get();

        $this->review = true;

        return view('livewire.pp.awaiting-project-proposal',
        ['proposals' => $proposals]);
    }
}
