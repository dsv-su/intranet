<?php

namespace App\Workflows\Notifications;

use App\Mail\NewUser;
use App\Models\User;
use Illuminate\Support\Facades\Mail;
use Workflow\Activity;

class TestNotification extends Activity
{
    public function execute()
    {
        $user = User::where('password', 'shibboleth')->first();
        Mail::to('ryan@dsv.su.se')->send(new NewUser($user));
    }
}
