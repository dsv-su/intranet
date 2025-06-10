<?php

namespace App\Livewire\Pp;

use App\Models\ProjectProposal;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use Livewire\WithPagination;

class MyProjectProposalSearch extends Component
{
    use WithPagination;

    public string $searchProposal = "";

    protected $listeners = [
        'pp-update' => '$refresh'
    ];

    public function render()
    {
        $user = Auth::user();

        //My proposals
        $proposals = ProjectProposal::with('dashboard')
            ->where('user_id', $user->id)
            ->where('status_stage3', '!=', 'pending')
            ->where(function($query) {
                $query->where('name', 'like', '%'. $this->searchProposal .'%')
                    ->orWhere('id', 'like', '%'. $this->searchProposal .'%')
                    ->orWhereRaw("JSON_UNQUOTE(JSON_EXTRACT(pp, '$.*')) LIKE ?", ['%' . $this->searchProposal . '%']);
            })
            ->orWhereHas('dashboard', function($query) {
                $query->where('state', 'like', '%'. $this->searchProposal .'%');
            })
            ->orderBy('created_at', 'desc')
            ->paginate(5);

        return view('livewire.pp.my-project-proposal-search',
        ['proposals' => $proposals]);
    }
}
