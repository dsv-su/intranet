<?php

namespace App\Livewire;

use App\Models\Dashboard;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use Statamic\Auth\User;

class Mobileindicator extends Component
{
    public $auth_user;
    public $user_roles;
    public $dashboard;

    public function mount()
    {
        $this->dashboard = null;
        $this->user_roles = $this->getUserRoles();
        $this->checkDashboard();
    }

    public function checkDashboard()
    {
        //Check dashboard
        //Tasks
        $manager = collect(Dashboard::where('state', 'submitted')->where('manager_id', $this->auth_user)->get());
        $head = collect(Dashboard::where('state', 'manager_approved')->where('head_id', $this->auth_user)->get());
        $fo = collect(Dashboard::where('state', 'head_approved')->where('fo_id', $this->auth_user)->get());
        //User
        $manager_return = collect(Dashboard::where('state', 'manager_returned')->where('user_id', $this->auth_user)->where('status', 'unread')->get());
        $manager_deny = collect(Dashboard::where('state', 'manager_denied')->where('user_id', $this->auth_user)->where('status', 'unread')->get());
        $fo_return = collect(Dashboard::where('state', 'fo_returned')->where('user_id', $this->auth_user)->where('status', 'unread')->get());
        $fo_deny = collect(Dashboard::where('state', 'fo_denied')->where('user_id', $this->auth_user)->where('status', 'unread')->get());
        $head_return = collect(Dashboard::where('state', 'head_returned')->where('user_id', $this->auth_user)->where('status', 'unread')->get());
        $head_deny = collect(Dashboard::where('state', 'head_denied')->where('user_id', $this->auth_user)->where('status', 'unread')->get());

        $this->dashboard = $manager->merge($fo)->merge($head)
            ->merge($manager_return)->merge($manager_deny)
            ->merge($fo_return)->merge($fo_deny)
            ->merge($head_return)->merge($head_deny);
    }
    public function hydrate()
    {
        $this->checkDashboard();
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
        return view('livewire.mobileindicator');
    }
}
