<?php

namespace App\Livewire\Pp;

use App\Models\SettingsOh;
use Livewire\Component;

class Ohcost extends Component
{
    public $type;
    public int $ohcost;
    public $progress = false, $progress_25 = false, $progress_50 = false, $progress_75 = false, $progress_100 = false;
    public $exceed = false;
    public $proposal;
    public $max, $threshold_1, $threshold_2, $threshold_3;

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
        $oh_settings = SettingsOh::first();
        $this->max = $oh_settings->oh_max;
        $this->threshold();
    }

    public function threshold(): void
    {
        $this->threshold_1 = round($this->max/4);
        $this->threshold_2 = round($this->max/3);
        $this->threshold_3 = round($this->max/2);
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
                case (int)$this->ohcost <= $this->threshold_1:
                    $this->progress = true;
                    $this->progress_25 = true;
                    break;
                case (int)$this->ohcost > $this->threshold_1 && (int)$this->ohcost <= $this->threshold_2:
                    $this->progress = true;
                    $this->progress_50 = true;
                    break;
                case (int)$this->ohcost > $this->threshold_2 && (int)$this->ohcost <= $this->threshold_3:
                    $this->progress = true;
                    $this->progress_75 = true;
                    break;
                case (int)$this->ohcost > $this->threshold_3 && (int)$this->ohcost <= $this->max:
                    $this->progress = true;
                    $this->progress_100 = true;
                    break;
                case (int)$this->ohcost >  $this->max:
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
