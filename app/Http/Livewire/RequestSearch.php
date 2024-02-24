<?php

namespace App\Http\Livewire;

use App\Models\Dashboard;
use App\Models\TravelRequest;
use Livewire\Component;

class RequestSearch extends Component
{

    public $searchTerm;
    public $dashboards;

    public function render()
    {
        $searchTerm = '%' . $this->searchTerm . '%';
        $this->dashboards = Dashboard::with(['user', 'travel'])
            ->where('name', 'like', $searchTerm)
            ->orWhereHas('user', function ($query) use ($searchTerm) {
                $query->where('name', 'LIKE', $searchTerm ?? '')
                    ->orWhere('email', 'LIKE', $searchTerm ?? '');
            })
            ->orWhereHas('travel', function ($query) use ($searchTerm) {
                $query->where('project', 'LIKE', $searchTerm ?? '')
                        ->orWhere('country', 'LIKE', $searchTerm ?? '')
                        ->orWhere('purpose', 'LIKE', $searchTerm ?? '')
                        ->orWhere('id', 'LIKE', $searchTerm ?? '');
            })
            ->get();

        return view('livewire.request-search');
    }
}
