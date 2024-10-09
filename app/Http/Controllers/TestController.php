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

    public function submit(Request $request)
    {
        // Find or create the financial officer
        $fo = SettingsFo::find(1);
        $pp = new ProjectProposal();
        $pp->name = $request->name;
        $pp->created = Carbon::createFromFormat('d/m/Y', now()->format('d/m/Y'))->timestamp;
        $pp->state = 'submitted';
        $pp->pp = ['title' => $request->name, 'main resercher' => 'Ryan Dias', 'co-applicants' => 'Jenny Lind, Jason Bourne'];
        $pp->save();
        // Find or create Dashboard instance
        $dashboardData = [
            'request_id' => $pp->id,
            'name' => $request->name,
            'created' => Carbon::createFromFormat('d/m/Y', now()->format('d/m/Y'))->timestamp,
            'state' => 'submitted',
            'status' => 'unread',
            'type' => 'projectpoposal',
            'user_id' => auth()->id(),
            'manager_id' => '9d2400f8-4789-4a91-a22a-fb9a97fbf27f',
            'fo_id' => '9d2400f8-4789-4a91-a22a-fb9a97fbf27f',
            'head_id' => '9d2400f8-4789-4a91-a22a-fb9a97fbf27f'
        ];

        //Create new dashboard instance
        $dashboard = Dashboard::where('request_id', $request->id)->first();
        if (!$dashboard) {
            $dashboard = Dashboard::create($dashboardData);
        } else {
            $dashboard->update($dashboardData);
        }

        return (new \Statamic\View\View)
            ->template('pp.index')
            ->layout('mylayout');
    }

    public function show()
    {
        $project = ProjectProposal::latest()->first();
        $pp = $project->pp;
        return (new \Statamic\View\View)
            ->template('pp.show',)
            ->layout('mylayout', )
            ->with(['pp' => $pp]);
    }
}
