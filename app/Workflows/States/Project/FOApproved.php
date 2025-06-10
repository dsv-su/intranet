<?php

namespace App\Workflows\States\Project;

class FOApproved extends StatesConfig
{
    public static $name = 'fo_approved';

    public function status(): string
    {
        return 'fo_approved';
    }
}
