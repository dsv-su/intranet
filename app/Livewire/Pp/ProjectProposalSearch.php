<?php

namespace App\Livewire\Pp;

use App\Models\ProjectProposal;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use Livewire\WithPagination;

class ProjectProposalSearch extends Component
{
    use WithPagination;

    public string $searchProposal = "";

    protected $listeners = [
        'pp-update' => '$refresh'
    ];

    public function render()
    {
        $user = Auth::user();
        $proposals = ProjectProposal::with('dashboard')
            ->where('user_id', $user->id)
            ->where(function($query) {
                $query->where('name', 'like', '%'. $this->searchProposal .'%')
                    ->orWhere('pp', 'like', '%'. $this->searchProposal .'%');
            })
            ->paginate(3);

        return view('livewire.pp.project-proposal-search',
        ['proposals' => $proposals]);
    }
}
