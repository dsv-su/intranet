<?php

namespace App\Workflows\States\Project;

class FODenied extends StatesConfig
{
    public static $name = 'fo_denied';

    public function status(): string
    {
        return 'fo_denied';
    }
}
