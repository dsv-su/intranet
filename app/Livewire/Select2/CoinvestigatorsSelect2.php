<?php

declare(strict_types=1);

namespace App\Livewire\Select2;

use App\Services\Ldap\SukatUser;
use Illuminate\Support\Facades\App;
use Livewire\Component;

class CoinvestigatorsSelect2 extends Component
{
    public $query;
    public $sukatusers;
    public $highlightIndex;
    public $person;
    public $coinvestigators = [];
    public $coinvestigators_external = [];
    public $external = 'hidden';
    public $external_coinvestigators_name, $external_coinvestigators_email;

    public function mount()
    {
        $this->resetData();
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

        $this->coinvestigators[] = $this->person;
        $this->resetData();
    }

    public function remove($key)
    {
        unset($this->coinvestigators[$key]);
    }

    public function addExternal()
    {
        $this->external = 'block';
    }

    public function add_external()
    {
        $this->coinvestigators[] = [
            'displayname' => array($this->external_coinvestigators_name),
            'mail' => array($this->external_coinvestigators_email)
        ];

        $this->external_coinvestigators_name = '';
        $this->external_coinvestigators_email = '';
        $this->external = 'hidden';
    }


    public function updatedQuery()

    {
        $this->sukatusers = SukatUser::where('cn', 'starts_with', $this->query)->limit(5)->get()->toArray();
    }

    public function render()
    {
        return view('livewire.select2.Coinvestigators-select2');
    }
}
