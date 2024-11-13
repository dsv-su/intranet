<?php

namespace App\Livewire\Pp;

use App\Models\ProjectProposal;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use Livewire\WithPagination;

class AllProjectProposalSearch extends Component
{
    use WithPagination;

    public string $searchProposal = "";
    public $review = false;
    public $resume = false;

    protected $listeners = [
        'pp-update' => '$refresh'
    ];

    public function render()
    {
        $user = Auth::user();
        $proposals = ProjectProposal::with('dashboard')
            ->where(function($query) {
                $query->where('name', 'like', '%'. $this->searchProposal .'%')
                    ->orWhere('pp', 'like', '%'. $this->searchProposal .'%');
            })
            ->paginate(6);

        return view('livewire.pp.all-project-proposal-search',
            ['proposals' => $proposals]);
    }
}
