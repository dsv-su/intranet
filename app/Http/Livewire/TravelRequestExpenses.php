<?php

namespace App\Http\Livewire;

use App\Models\Country;
use App\Models\TravelRequest;
use Carbon\Carbon;
use DateTime;
use Livewire\Component;

class TravelRequestExpenses extends Component
{
    public $total;
    public $flight;
    public $hotel;
    public $daily;
    public $conference;
    public $other;
    public $days;
    public $countryname;
    public $start, $end;
    public $tr;

    protected $listeners = [
        'selectedCountry',
        'changeStartDate' => 'changeStartDate',
        'changeEndDate' => 'changeEndDate'
    ];

    public function mount()
    {
        $this->days = 0;
        $this->flight = $this->tr->flight ?? null;
        $this->hotel = $this->tr->hotel ?? null;
        $this->daily = $this->tr->daily ?? null;
        $this->countryname = $this->tr->country ?? null;
        $this->conference = $this->tr->conference ?? null;
        $this->other = $this->tr->other_costs ?? null;
        $this->days = $this->tr->days ?? null;
        $this->total = $this->tr->total ?? null;
    }

    public function changeStartDate($date)
    {
        $this->start = $date;

        $this->days = Carbon::parse(Carbon::createFromFormat('d/m/Y', $this->start))->diffInDays(Carbon::createFromFormat('d/m/Y', $this->end ?? $this->start));
    }

    public function changeEndDate($date)
    {
        $this->end = $date;

        $this->days = Carbon::parse(Carbon::createFromFormat('d/m/Y', $this->start ?? $this->end))->diffInDays(Carbon::createFromFormat('d/m/Y', $this->end));



    }

    public function hydrate()
    {
        if(!empty($this->start)) {
            $this->days = Carbon::parse(Carbon::createFromFormat('d/m/Y', $this->start))->diffInDays(Carbon::createFromFormat('d/m/Y', $this->end));
        }

    }

    public function selectedCountry($id)
    {
        $country = Country::find($id);
        $this->daily = $country->allowance;
        $this->countryname = $country->country;
        $this->summarize();
    }

    public function getDays($value)
    {
        $this->days = $value;
        $this->summarize();
    }

    public function countryAllowance($id)
    {
        $country = Country::find($id);
        $this->daily = $country->allowance;
        $this->countryname = $country->country;
        $this->summarize();
    }

    public function updatedFlight()
    {
        $this->summarize();
    }

    public function updatedHotel()
    {
        $this->summarize();
    }

    public function updatedDaily()
    {
        $this->summarize();
    }

    public function updatedConference()
    {
        $this->summarize();
    }

    public function updatedOther()
    {
        $this->summarize();
    }

    public function render()
    {
        return view('livewire.travel-request-expenses');
    }

    private function summarize()
    {
        $this->total = (int)$this->flight + (int)$this->hotel + ((int)$this->daily * (int)$this->days) + (int)$this->conference + (int)$this->other;
    }
}
