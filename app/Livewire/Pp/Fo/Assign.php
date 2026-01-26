<?php

namespace App\Livewire\Pp\Fo;

use App\Models\Dashboard;
use App\Models\ProjectProposal;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Livewire\Component;

class Assign extends Component
{
    public ProjectProposal $proposal;
    public $fos;
    public $fo_user_id;
    public $finaceOfficers;

    public function mount(ProjectProposal $proposal)
    {
        $this->proposal = $proposal;
        $this->fo_user_id = $proposal->foUser->id;
        $this->getFO();
    }

    public function updatedFoUserId($value)
    {
        Dashboard::where('request_id', $this->proposal->id)->update(['fo_id' => $value]);
    }

    public function getFO()
    {
        $ids = DB::table('group_user')->where('group_id', 'ekonomi')->pluck('user_id');
        $this->fos = User::whereIn('id', $ids)->get();
        $this->finaceOfficers = $this->fos->pluck('id')->toArray();
    }

    public function render()
    {
        return view('livewire.pp.fo.assign');
    }
}

