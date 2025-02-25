<?php

namespace App\Workflows\States\Project;

class HeadDenied extends StatesConfig
{
    public static $name = 'head_denied';

    public function status(): string
    {
        return 'head_denied';
    }
}
