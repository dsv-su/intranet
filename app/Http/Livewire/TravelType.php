<?php

namespace App\Http\Livewire;

use Livewire\Component;

class TravelType extends Component
{
    public $country;
    public $tabselected;
    public $inputvalue;

    public function mount($resume = null)
    {
        $this->tabselected = 1;
        $this->inputvalue = null;

        if($resume == 'Sverige') {
            $this->selectedCountry(999);
            $this->tabselected = 2;
            $this->inputvalue = 'domestic';
            $this->country = 'Sverige';
        } else {
            $this->country = $resume;
        }
    }

    public function selectedCountry($type)
    {
        $this->emit('clear', $type);
        $this->emit('selectedCountry', $type);
    }


    public function render()
    {
        return view('livewire.travel-type');
    }
}
