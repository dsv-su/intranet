<?php

namespace App\Livewire;

use App\Models\Dashboard;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use Statamic\Auth\User;

class Requestnotifications extends Component
{
    public $auth_user;
    public $user_roles;
    public $requests;

    public function mount()
    {
        $this->user_roles = $this->getUserRoles();
        $this->getRequests();
    }

    public function getRequests()
    {
        $manager = collect(Dashboard::where('state', 'submitted')->where('manager_id', $this->auth_user)->get());
        $head = collect(Dashboard::where('state', 'manager_approved')->where('head_id', $this->auth_user)->get());
        $fo = collect(Dashboard::where('state', 'head_approved')->where('fo_id', $this->auth_user)->get());
        $this->requests = $manager->merge($fo)->merge($head);
    }

    public function hydrate()
    {
        $this->getRequests();
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
        return view('livewire.requestnotifications');
    }
}
