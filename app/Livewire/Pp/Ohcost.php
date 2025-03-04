<?php

namespace App\Livewire\Pp;

use Livewire\Component;

class Ohcost extends Component
{
    public $type;
    public int $ohcost;
    public $progress = false, $progress_25 = false, $progress_50 = false, $progress_75 = false, $progress_100 = false;
    public $exceed = false;
    public $proposal;

    protected $listeners = [
        'progress-refresh' => '$refresh'
    ];

    public function mount($type, $proposal)
    {
        $this->type = $type;
        $this->proposal = $proposal;
        if($this->proposal) {
            $this->ohcost = $proposal->pp['oh_cost'] ?? 0;
        }
    }


    public function updatedOhcost()
    {
        $this->exceed = false;
        $this->progress_25 = false;
        $this->progress_50 = false;
        $this->progress_75 = false;
        $this->progress_100 = false;

        if($this->ohcost ?? false) {
            switch(true) {
                case (int)$this->ohcost <= 14:
                    $this->progress = true;
                    $this->progress_25 = true;
                    break;
                case (int)$this->ohcost > 14 && (int)$this->ohcost <= 28:
                    $this->progress = true;
                    $this->progress_50 = true;
                    break;
                case (int)$this->ohcost > 28 && (int)$this->ohcost <= 42:
                    $this->progress = true;
                    $this->progress_75 = true;
                    break;
                case (int)$this->ohcost > 42 && (int)$this->ohcost <= 56:
                    $this->progress = true;
                    $this->progress_100 = true;
                    break;
                case (int)$this->ohcost >  56:
                    $this->progress = false;
                    $this->exceed = true;
                    break;
                default:
                    $this->progress = false;
                    $this->progress_25 = false;
                    $this->progress_50 = false;
                    $this->progress_75 = false;
                    $this->progress_100 = false;
            }
        } else {
            $this->exceed = false;
            $this->progress = false;
            $this->progress_25 = false;
            $this->progress_50 = false;
            $this->progress_75 = false;
        }

        //$this->dispatch('progress-refresh');
    }

    /*public function hydrate()
    {
        $this->ohcost;
    }*/

    public function render()
    {
        return view('livewire.pp.ohcost');
    }
}
