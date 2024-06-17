<?php

namespace App\Workflows;

use App\Workflows\Notifications\passTestNotification;
use Workflow\ActivityStub;
use Workflow\Workflow;

class passTestWorkflow extends Workflow
{
    public function execute($userRequest)
    {
        $result = yield ActivityStub::make(passTestNotification::class, $userRequest);

        return $result;
    }
}
