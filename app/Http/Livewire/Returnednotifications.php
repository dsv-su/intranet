<?php

namespace App\Http\Livewire;

use App\Models\Dashboard;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use Statamic\Auth\User;

class Returnednotifications extends Component
{
    public $auth_user;
    public $user_roles;
    public $returned;

    public function mount()
    {
        $this->user_roles = $this->getUserRoles();
        $this->returned = Dashboard::where('user_id', $this->auth_user)
            ->where(function(Builder $query) {
                $query->where('state', 'manager_returned')
                    ->orWhere('state', 'fo_returned')
                    ->orWhere('state', 'head_returned');
            })
            ->get();
        if($this->returned == null) {
            $this->returned = collect([]);
        }

    }

    private function getUserRoles()
    {
        $this->auth_user = Auth::user()->id;
        $user = User::find($this->auth_user);
        $userrole = collect($user->roles());
        return $userrole->keys()->all();
    }
    public function render()
    {
        return view('livewire.returnednotifications');
    }
}
