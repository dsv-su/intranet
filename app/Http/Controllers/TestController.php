<?php

namespace App\Http\Controllers;

use App\Models\SettingsFo;
use Carbon\Carbon;
use GuzzleHttp\Client;
use Illuminate\Http\Request;

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

    public function submit(Request $request)
    {
        // Find or create the financial officer
        $fo = SettingsFo::find(1);

        // Find or create Dashboard instance
        $dashboardData = [
            'request_id' => $travelRequest->id,
            'name' => $request->name,
            'created' => Carbon::createFromFormat('d/m/Y', now()->format('d/m/Y'))->timestamp,
            'state' => 'submitted',
            'status' => 'unread',
            'type' => 'travelrequest',
            'user_id' => auth()->id(),
            'manager_id' => $request->project_leader,
            'fo_id' => $fo->user_id,
            'head_id' => $request->unit_head
        ];
    }
}
