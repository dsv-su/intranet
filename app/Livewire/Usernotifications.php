<?php

namespace App\Livewire;

use App\Models\Dashboard;
use Statamic\Auth\User;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class Usernotifications extends Component
{
    public $auth_user;
    public $user_roles;
    public $user_requests;

    public function mount()
    {
        $this->user_roles = $this->getUserRoles();
        //Limit notifications
        $this->user_requests = Dashboard::where('user_id', $this->auth_user)->orderBy('created_at', 'desc')->limit(10)->get();
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
        return view('livewire.usernotifications');
    }
}
