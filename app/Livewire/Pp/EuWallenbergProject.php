<?php

namespace App\Livewire\Pp;

use Livewire\Component;

class EuWallenbergProject extends Component
{
    public $visibility = 'hidden';
    public $proposal;

    public function mount($proposal = null)
    {
        $this->proposal = $proposal;
        $this->check();
    }

    public function check()
    {
        if($this->proposal->pp['eu_wallenberg'] ?? false) {
            if($this->proposal->pp['eu_wallenberg'] == 'no') {
                $this->no();
            }
            elseif ($this->proposal->pp['eu_wallenberg'] == 'yes') {
                $this->yes();
            }
        }

    }

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
