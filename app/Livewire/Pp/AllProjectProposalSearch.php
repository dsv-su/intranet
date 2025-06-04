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
    public bool $hideDenied = false;
    public bool $hideArchived = true;

    protected $listeners = [
        'pp-update' => '$refresh'
    ];

    public function updatedswitchDenied()
    {
        $this->hideDenied = !$this->hideDenied;
    }

    public function fetchProposals()
    {
        if ($this->hideDenied) {
            return ProjectProposal::with('dashboard')
                ->where(function($query) {
                    $query->where('name', 'like', '%'. $this->searchProposal .'%')
                        ->orWhere('pp', 'like', '%'. $this->searchProposal .'%');
                })
                ->where('pp->status', '!=', 'denied') // Dont retrive denied proposals
                ->paginate(6);
        } else {
            return ProjectProposal::with('dashboard')
                ->where(function($query) {
                    $query->where('name', 'like', '%'. $this->searchProposal .'%')
                        ->orWhere('pp', 'like', '%'. $this->searchProposal .'%');
                })
                ->orderBy('created_at', 'desc')
                ->paginate(6);
        }
    }

    public function render()
    {
        $user = Auth::user();
        /*
        $proposals = ProjectProposal::with('dashboard')
            ->where(function($query) {
                $query->where('name', 'like', '%'. $this->searchProposal .'%')
                    ->orWhere('pp', 'like', '%'. $this->searchProposal .'%');
            })
            //->where('pp->status', '!=', 'denied') // Dont retrive denied proposals
            ->paginate(6);
        */


        $proposals = $this->fetchProposals();
        return view('livewire.pp.all-project-proposal-search',
            ['proposals' => $proposals]);
    }
}
