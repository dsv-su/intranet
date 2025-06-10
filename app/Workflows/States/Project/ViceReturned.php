<?php

namespace App\Workflows\States\Project;

class ViceReturned extends StatesConfig
{
    public static $name = 'vice_returned';

    public function status(): string
    {
        return 'vice_returned';
    }
}
