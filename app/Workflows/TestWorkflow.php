<?php

namespace App\Workflows;

use Workflow\ActivityStub;
use Workflow\Workflow;
use App\Workflows\Notifications\TestNotification;

class TestWorkflow extends Workflow
{
    public function execute()
    {
        $result = yield ActivityStub::make(TestNotification::class);

        return $result;
    }
}
