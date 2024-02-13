<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;

class TestController extends Controller
{
    public function test()
   {

   }

   public function truncate()
   {
       DB::statement('SET FOREIGN_KEY_CHECKS=0;');
       DB::table('workflow_exceptions')->truncate();
       DB::table('workflow_logs')->truncate();
       DB::table('workflow_relationships')->truncate();
       DB::table('workflow_signals')->truncate();
       DB::table('workflow_timers')->truncate();
       DB::table('workflows')->truncate();
       DB::table('manager_comments')->truncate();
       DB::table('fo_comments')->truncate();
       DB::table('head_comments')->truncate();
       DB::table('travel_requests')->truncate();
       DB::table('dashboards')->truncate();
       DB::statement('SET FOREIGN_KEY_CHECKS=1;');
       return redirect('/');
   }

}
