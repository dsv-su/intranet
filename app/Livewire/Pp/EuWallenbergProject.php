<?php

namespace App\Livewire\Pp;

use Livewire\Component;

class EuWallenbergProject extends Component
{
    public $visibility = 'hidden';
    public $checkbox = 'block';
    public $proposal;
    public $wallenbergOrg = false;

    protected $listeners = [
        'eu_hide' => 'hideCheckbox',
        'eu_show' => 'showCheckbox',
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

    public function hideCheckbox()
    {
        $this->checkbox = 'hidden';
    }

    public function showCheckbox()
    {
        $this->checkbox = 'block';
    }

    public function wallenberg_org()
    {
        $this->wallenbergOrg = true;
        $this->yes();
    }

    public function wallenberg_reset()
    {
        $this->wallenbergOrg = false;
        $this->no();
        $this->check();
    }

    public function render()
    {
        return view('livewire.pp.eu-wallenberg-project');
    }
}
