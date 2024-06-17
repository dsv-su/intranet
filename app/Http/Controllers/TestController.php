<?php

namespace App\Http\Controllers;

use App\Models\Dashboard;
use App\Workflows\passTestWorkflow;
use App\Workflows\TestWorkflow;
use Workflow\WorkflowStub;

class TestController extends Controller
{
   public function test()
   {
       return (new \Statamic\View\View)
           ->template('home.partials.search.staff')
           ->layout('mylayout');
   }

   public function testWorkflow()
   {
       $dashboard = Dashboard::find(1);
       $workflow = WorkflowStub::make(TestWorkflow::class);
       $dashboard->workflow_id = $workflow->id();
       $dashboard->save();
       $workflow->start($dashboard->id);
       $workflow->submit();
       return $workflow;
   }

   public function passTestWorkflow()
   {
       $workflow = WorkflowStub::make(passTestWorkflow::class);
       $workflow->start(2);
   }
}
