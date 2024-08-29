<?php

namespace App\Livewire;

use App\Services\Ldap\SukatUser;
use Illuminate\Support\Facades\App;
use Livewire\Component;

class SukatStaffSearch extends Component
{
    public $query;
    public $sukatusers;
    public $highlightIndex;
    public $person;

    public function mount()
    {
        $this->resetData();
        $this->defaultUser();
    }

    public function resetData()
    {
        $this->query = '';
        $this->sukatusers = [];
        $this->highlightIndex = 0;
    }

    public function incrementHighlight()
    {
        if ($this->highlightIndex === count($this->sukatusers) - 1) {
            $this->highlightIndex = 0;
            return;
        }
        $this->highlightIndex++;
    }

    public function decrementHighlight()
    {
        if ($this->highlightIndex === 0) {
            $this->highlightIndex = count($this->sukatusers) - 1;
            return;
        }
        $this->highlightIndex--;
    }

    public function defaultUser()
    {
        if(App::isLocal()) {
            $this->person = SukatUser::where('uid', '=', 'gwett')->first()->toArray();
        } else {
            $this->person = SukatUser::where('mail', '=', auth()->user()->email)->first()->toArray();
        }

    }

    public function selectUser($id=0)
    {
        if($id === 0) {
            $selecteduser = $this->sukatusers[$this->highlightIndex] ?? null;
        } else {
            $selecteduser = $this->sukatusers[$id] ?? null;
        }

        if ($selecteduser) {
            $this->person = $selecteduser;
        }
        $this->resetData();
        //dd($this->person);
    }


    public function updatedQuery()

    {
        $this->sukatusers = SukatUser::where('cn', 'starts_with', $this->query)->limit(5)->get()->toArray();
    }

    public function render()
    {
        return view('livewire.sukat-staff-search');
    }
}
