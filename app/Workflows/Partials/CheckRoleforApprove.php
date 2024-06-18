<?php

namespace App\Workflows\Partials;

use App\Models\Dashboard;

class CheckRoleforApprove
{
    public $dashboard;

    public function isSameUserManager($request): bool
    {
        // Logic to check if the user and manager are the same person

        // Retrive request dashboard
        //$id = $request[0];
        $id = $request;
        $this->dashboard = Dashboard::find($id);

        //Users
        $user = $this->dashboard->user_id;
        $manager = $this->dashboard->manager_id;

        if($user == $manager) {
            return true;
        }

        return false;
    }

    public function isSameManagerHead($request): bool
    {
        // Logic to check if the manager and head are the same person

        // Retrive request dashboard
        //$id = $request[0];
        $id = $request;
        $this->dashboard = Dashboard::find($id);

        //Users
        $manager = $this->dashboard->manager_id;
        $head = $this->dashboard->head_id;

        if($manager == $head) {
            return true;
        }

        return false;
    }

}
