<?php

namespace App\Workflows\States\Project;

class Pending extends StatesConfig
{
    public static $name = 'pending';

    public function status(): string
    {
        return 'pending';
    }
}
