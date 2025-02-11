<?php

namespace App\Livewire\Pp;

use Illuminate\Support\Facades\Artisan;
use Livewire\Component;

class ResearchArea extends Component
{
    public $areas = [];
    public $add_area;

    protected $listeners = [
        'add_refresh' => '$refresh'
    ];

    public function updateArea($index)
    {
        // Ensure we access the correct key from the array
        $areaData = $this->areas[$index];

        // Find the ResearchArea model and update it
        $area = \App\Models\ResearchArea::find($areaData['id']);
        if ($area) {
            $area->name = $areaData['name'];
            $area->save();
        }
    }

    public function addArea()
    {
        $flight = \App\Models\ResearchArea::create([
            'name' => $this->add_area,
        ]);
        $this->add_area = '';
        $this->dispatch('add_refresh');
    }

    public function remove($id)
    {
        dd($id);
    }

    public function resetAreas()
    {
        Artisan::call('/usr/bin/php artisan clear-areas');
        $this->reset();
    }

    public function render()
    {
        $ns = \App\Models\ResearchArea::all();
        foreach($ns as $key => $n) {
            $this->areas[$key]['id'] = $n->id;
            $this->areas[$key]['name'] = $n->name;
        }

        return view('livewire.pp.research-area');
    }
}
