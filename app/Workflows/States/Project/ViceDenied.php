<?php

namespace App\Workflows\States\Project;

class ViceDenied extends StatesConfig
{
    public static $name = 'vice_denied';

    public function status(): string
    {
        return 'vice_denied';
    }
}
