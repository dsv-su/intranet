<?php

namespace App\Workflows\States\Project;

class HeadReturned extends StatesConfig
{
    public static $name = 'head_returned';

    public function status(): string
    {
        return 'head_returned';
    }
}
