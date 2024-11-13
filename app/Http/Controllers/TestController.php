<?php

namespace App\Http\Controllers;

use App\Models\Dashboard;
use App\Models\ProjectProposal;
use App\Models\SettingsFo;
use App\Models\User;
use Carbon\Carbon;
use GuzzleHttp\Client;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class TestController extends Controller
{

   public function test()
   {
       $user = Auth::user();

       $proposals = ProjectProposal::with('dashboard')
           ->where('id', '9d768256-9084-4bf6-8fed-363d064b4387')
           ->get();
        foreach ($proposals as $proposal) {
            dd($proposal->allowEdit());
        }


       /*return (new \Statamic\View\View)
           ->template('home.partials.search.staff')
           ->layout('mylayout');*/
   }
}
