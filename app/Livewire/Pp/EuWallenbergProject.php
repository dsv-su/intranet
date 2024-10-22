<?php

namespace App\Livewire\Pp;

use Livewire\Component;

class EuWallenbergProject extends Component
{
    public $visibility = 'hidden';

    public function yes()
    {
        $this->visibility = 'block';
    }

    public function no()
    {
        $this->visibility = 'hidden';
    }

    public function render()
    {
        return view('livewire.pp.eu-wallenberg-project');
    }
}
