<?php

namespace App\Livewire\Pp;

use Livewire\Component;

class DsvCoordination extends Component
{
    public $visibility = 'hidden';

    public function no()
    {
        $this->visibility = 'block';
    }

    public function yes()
    {
        $this->visibility = 'hidden';
    }

    public function render()
    {
        return view('livewire.pp.dsv-coordination');
    }
}
