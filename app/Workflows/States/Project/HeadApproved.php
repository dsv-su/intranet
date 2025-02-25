<?php

namespace App\Workflows\States\Project;

class HeadApproved extends StatesConfig
{
    public static $name = 'head_approved';

    public function status(): string
    {
        return 'head_approved';
    }
}
