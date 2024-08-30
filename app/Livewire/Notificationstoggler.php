<?php

namespace App\Livewire;

use App\Models\Dashboard;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use Statamic\Auth\User;

class Notificationstoggler extends Component
{
    public $auth_user;
    public $user_roles;
    public $requests;

    public function mount()
    {
        $this->user_roles = $this->getUserRoles();
        $manager = collect(Dashboard::where('state', 'submitted')->where('manager_id', $this->auth_user)->get());
        $fo = collect(Dashboard::where('state', 'manager_approved')->where('fo_id', $this->auth_user)->get());
        $head = collect(Dashboard::where('state', 'fo_approved')->where('head_id', $this->auth_user)->get());
        $this->requests = $manager->merge($fo)->merge($head);

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
        return view('livewire.notificationstoggler');
    }
}
