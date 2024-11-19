<?php

namespace App\Workflows\Notifications;

use App\Mail\NotifyRequestApproved;
use App\Mail\NotifyUserChangedState;
use App\Models\Dashboard;
use App\Models\User;
use Illuminate\Support\Facades\Mail;
use Workflow\Activity;

class StateUpdateNotification extends Activity
{
    protected $dashboard;

    /***********************
     * @param $request
     *
     * Returned or Denied Notification
     */

    public function execute($request)
    {
        //Retrive request dashboard
        //$id = $request[0];
        $id = $request;
        $this->dashboard = Dashboard::find($id);

        //Users
        $user = User::find($this->dashboard->user_id);
        $manager = User::find($this->dashboard->manager_id);
        $fo = User::find($this->dashboard->fo_id);
        $head = User::find($this->dashboard->head_id);
        $vice = User::find($this->dashboard->vice_id);

        //Notify user of changed Request State
        $state = $this->dashboard->state;

        switch($state) {
            case('manager_returned'):
            case('manager_denied'):
                //Notify
                Mail::to($user->email)->send(new NotifyUserChangedState($user, $manager, $this->dashboard));
                break;
            case('fo_returned'):
            case('fo_denied'):
                //Notify
                Mail::to($user->email)->send(new NotifyUserChangedState($user, $fo, $this->dashboard));
                break;
            case('head_returned'):
            case('head_denied'):
                //Notify
                Mail::to($user->email)->send(new NotifyUserChangedState($user, $head, $this->dashboard));
                break;
            case('vice_returned'):
            case('vice_denied'):
                //Notify
                Mail::to($user->email)->send(new NotifyUserChangedState($user, $vice, $this->dashboard));
                break;
            case('fo_approved'):
                //Approved Request
                //Notify
                Mail::to($user->email)->send(new NotifyRequestApproved($user, $this->dashboard));
        }
    }
}
