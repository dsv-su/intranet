<?php

namespace App\Workflows\States\Project;

class FOReturned extends StatesConfig
{
    public static $name = 'fo_returned';

    public function status(): string
    {
        return 'fo_returned';
    }
}
