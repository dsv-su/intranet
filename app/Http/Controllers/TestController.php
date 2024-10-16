<?php

namespace App\Http\Controllers;

use App\Models\Dashboard;
use App\Models\ProjectProposal;
use App\Models\SettingsFo;
use App\Models\User;
use Carbon\Carbon;
use GuzzleHttp\Client;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class TestController extends Controller
{
   public function test()
   {
       return (new \Statamic\View\View)
           ->template('home.partials.search.staff')
           ->layout('mylayout');
   }

   public function pp()
   {
       return (new \Statamic\View\View)
           ->template('pp.index')
           ->layout('mylayout');
   }
}
