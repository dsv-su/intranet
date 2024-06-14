<?php

namespace App\Http\Controllers;

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
       $workflow = WorkflowStub::make(TestWorkflow::class);
       $workflow->start();
   }

   public function passTestWorkflow()
   {
       $workflow = WorkflowStub::make(passTestWorkflow::class);
       $workflow->start(2);
   }
}
