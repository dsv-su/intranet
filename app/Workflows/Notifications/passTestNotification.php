<?php

namespace App\Workflows\Notifications;

use App\Mail\NewUser;
use App\Models\User;
use Illuminate\Support\Facades\Mail;
use Workflow\Activity;

class passTestNotification extends Activity
{
    public function execute($id)
    {
        if($id) {
            $user = User::where('password', 'shibboleth')->first();
            Mail::to('ryan@dsv.su.se')->send(new NewUser($user));
        }
    }
}
