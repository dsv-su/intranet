<?php

namespace App\Workflows\States\Project;

class ViceApproved extends StatesConfig
{
    public static $name = 'vice_approved';

    public function status(): string
    {
        return 'vice_approved';
    }
}
