<?php

declare(strict_types=1);

namespace App\Http\Livewire\Select2;

use Livewire\Component;
use App\Models\Country;

/**
 * Single Select2 Component
 *
 * @package Blockpc\Select2Wire
 */
class CountrySelect2 extends Component
{
    public Country $Country;
    public $search;

    protected $listeners = [
        'set-Country' => 'set_Country',
        'clear'
    ];

    public function mount($country = 0)
    {
        if($country != 0) {
            $this->Country = Country::where('country',  $country)->first();
        } else {
            $this->Country = new Country;
        }

    }

    public function getOptionsProperty()
    {
        return Country::where('country', 'LIKE', "%{$this->search}%")->get();
    }

    public function render()
    {
        return view('livewire.select2.Country-select2', [
            'options' => $this->options,
        ]);
    }

    public function save()
    {
        $country = Country::where('country',$this->search)->first();
        if(!empty($country)) {
            $this->Country = $country;
        }
        $this->search = "";
    }

    public function select(Country $Country)
    {
        $this->Country = $Country;
        $this->emit('selectedCountry', $this->Country->id);
    }

    /** listener */
    public function clear()
    {
        $this->Country = new Country;
        $this->reset('search');
    }

    /** listener */
    public function set_Country(Country $Country)
    {
        $this->Country = $Country;
    }
}
