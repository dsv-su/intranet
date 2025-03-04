<?php

namespace App\Workflows\States\Project;

class Submitted extends StatesConfig
{
    public static $name = 'submitted';

    public function status(): string
    {
        return 'submitted';
    }
}
