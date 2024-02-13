<?php

namespace App\Workflows\Partials;

use App\Models\Dashboard;
use App\Models\User;
use App\Services\Review\WorkflowHandler;

class CheckRoleforApprove
{
    public $dashboard;

    public function isSameManagerHead($request): bool
    {
        // Logic to check if the user and manager are the same person

        // Retrive request dashboard
        $id = $request[0];
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
