<?php

declare(strict_types=1);

namespace App\Livewire\Select2;

use App\Models\FundingOrganization;
use Livewire\Component;

class OrgSelect2 extends Component
{
    public FundingOrganization $organization;
    public $search;

    protected $listeners = [
        'set-Org' => 'set_Org',
        'clearorganization'
    ];

    public function mount()
    {
        $this->organization = new FundingOrganization;
    }

    public function getOptionsProperty()
    {
        return FundingOrganization::where('name', 'LIKE', "%{$this->search}%")->get();
    }

    public function save()
    {
        $country = FundingOrganization::where('name',$this->search)->first();
        if(!empty($organization)) {
            $this->organization = $organization;
            $this->dispatch('selectedOrganization', $this->organization->id);
        }
        $this->search = "";
    }

    public function select(FundingOrganization $organization)
    {
        $this->organization = $organization;
        $this->dispatch('selectedOrganization', $this->organization->id);
    }

    public function render()
    {
        return view('livewire.select2.Org-select2', [
            'options' => $this->options,
        ]);
    }

    /** listener */
    public function clearorganization()
    {
        $this->organization = new Fundingorganization;
        $this->reset('search');
    }

    /** listener */
    public function set_Org(FundingOrganization $organization)
    {
        $this->organization = $organization;
    }
}
