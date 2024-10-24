<?php

namespace App\Livewire\Pp;

use Livewire\Component;

class Cofinancing extends Component
{
    public $visibility = false;

    public function cofinancing()
    {
        $this->visibility = !$this->visibility;
    }

    public function render()
    {
        return view('livewire.pp.cofinancing');
    }
}
