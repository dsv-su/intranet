<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class ClearTest extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'clear-test';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        DB::table('failed_jobs')->truncate();
        DB::table('workflow_exceptions')->truncate();
        DB::table('workflow_logs')->truncate();
        DB::table('workflow_relationships')->truncate();
        DB::table('workflow_signals')->truncate();
        DB::table('workflow_timers')->truncate();
        DB::table('workflows')->truncate();
        DB::table('travel_requests')->truncate();
        DB::table('dashboards')->truncate();
        DB::table('manager_comments')->truncate();
        DB::table('fo_comments')->truncate();
        DB::table('head_comments')->truncate();
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');
    }
}
