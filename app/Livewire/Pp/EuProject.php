<?php

namespace App\Livewire\Pp;

use Livewire\Component;

class EuProject extends Component
{
    public $visibility = 'hidden';
    public $checkbox = 'block';
    public $proposal;

    protected $listeners = [
        'org_wallenberg' => 'wallenberg_org',
        'org_reset' => 'wallenberg_reset'
    ];

    public function mount($proposal = null)
    {
        $this->proposal = $proposal;
        $this->check();
    }

    public function check()
    {
        if($this->proposal->pp['eu'] ?? false) {
            if($this->proposal->pp['eu'] == 'no') {
                $this->no();
            }
            elseif ($this->proposal->pp['eu'] == 'yes') {
                $this->yes();
            }
        }

    }

    public function yes()
    {
        $this->visibility = 'block';
        $this->dispatch('eu_hide');
    }

    public function no()
    {
        $this->visibility = 'hidden';
        $this->dispatch('eu_show');
    }

    public function wallenberg_org()
    {
        $this->checkbox = 'hidden';
    }

    public function wallenberg_reset()
    {
        $this->checkbox = 'block';
        $this->no();
        $this->check();
    }

    public function render()
    {
        return view('livewire.pp.eu-project');
    }
}
