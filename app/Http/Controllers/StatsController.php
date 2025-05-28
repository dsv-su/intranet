<?php

namespace App\Http\Controllers;

use App\Models\DsvBudget;
use App\Models\ProjectProposal;
use App\Services\Budget\ReCalcBudget;
use Faker\Guesser\Name;
use IcehouseVentures\LaravelChartjs\Facades\Chartjs;
use Illuminate\Http\Request;
use Statamic\View\View;

class StatsController extends Controller
{
    public function preapproved()
    {
        $available_states = [
            'vice_approved',
            'complete',
            'head_approved',
            'fo_approved',
            'final_approved',
            'sent'
            ];

        $proposals = ProjectProposal::whereIn('status_stage1', $available_states)->count();
        $budget = DsvBudget::find(1);

        //Check first if there are stats to show
        if( $proposals > 0 && !empty(json_decode($budget->funding_org, true))) {
            //Recalculate
            $this->recalcBudget();
        } else {
            $viewData['breadcrumb'] = 'Stats are unavailable';
            return $this->createView('stats.unavailable', 'mylayout', $viewData);
        }

        $labels = [];
        $preapproved = [];
        $commited = [];
        $cost = [];
        $phd = [];

        //Research Subject preapproved and budget
        foreach ($budget->research_area as $key => $dsv) {
            $labels[] = strlen($key) > 20 ? substr($key, 0, 17) . '...' : $key; // Limit to 20 characters
            $preapproved[] = $dsv['preapproved'] ?? 0;
            $commited[] = $dsv['budget'] ?? 0;
            $cost[] = $dsv['cost'] ?? 0;
            $phd[] = $dsv['phd'] ?? 0;
        }

        //Funding Agency
        foreach (json_decode($budget->funding_org, true) as $key => $fundingOrg) {
            $org[] = strlen($key) > 20 ? substr($key, 0, 17) . '...' : $key; // Limit to 20 characters
            $orgStats[] = $fundingOrg;
        }

        //Preapproved
        $chart['researchsubject_preapproved'] = Chartjs::build()
            ->name('barChartPreapproved')
            ->type('bar')
            ->size(['width' => 400, 'height' => 200])
            ->labels($labels)
            ->datasets([
                [
                    "label" => "PreApproved",
                    'backgroundColor' => 'rgba(0, 123, 255, 1)', // Blue
                    'borderWidth' => 1,
                    'data' => $preapproved,
                    'categoryPercentage' => 0.6,
                    'barPercentage' => 0.6,
                    'yAxisID' => 'y-left' // Assign to left y-axis
                ],

            ]);
        //Commited budget
        $chart['researchsubject_commited'] = Chartjs::build()
            ->name('barChartCommited')
            ->type('bar')
            ->size(['width' => 400, 'height' => 200])
            ->labels($labels)
            ->datasets([
                [
                    "label" => "Commited budget (SEK)",
                    'backgroundColor' => 'rgba(0, 255, 0, 1)',
                    'borderWidth' => 1,
                    'data' => $commited,
                    'categoryPercentage' => 0.6,
                    'barPercentage' => 0.6,
                    'yAxisID' => 'y-left' // Assign to left y-axis
                ],

            ]);

        //PhD budget
        $chart['researchsubject_phd'] = Chartjs::build()
            ->name('barChartPhD')
            ->type('bar')
            ->size(['width' => 400, 'height' => 200])
            ->labels($labels)
            ->datasets([
                [
                    "label" => "PhD years",
                    'backgroundColor' => 'rgba(0, 123, 255, 1)', // Blue
                    'borderWidth' => 1,
                    'data' => $phd,
                    'categoryPercentage' => 0.6,
                    'barPercentage' => 0.6,
                    'yAxisID' => 'y-left' // Assign to left y-axis
                ],

            ]);

        //Chart Agency funding
        $chart['agency'] = Chartjs::build()
            ->name('barChartAgency')
            ->type('bar')
            ->size(['width' => 400, 'height' => 200])
            ->labels($org)
            ->datasets([
                [
                    "label" => "Funding organization",
                    'backgroundColor' => 'rgba(128, 0, 128, 1)',
                    'borderWidth' => 1,
                    'data' => $orgStats,
                    'categoryPercentage' => 0.6,
                    'barPercentage' => 0.6,
                    'yAxisID' => 'y-left' // Assign to left y-axis
                ],

            ]);

        $breadcrumb = 'Stats';
        return $this->createView('stats.proposal_stats', 'mylayout', compact('chart', 'breadcrumb'));
    }

    public function approved()
    {
        $available_states = [
            'granted'
        ];

        $proposals = ProjectProposal::whereIn('status_stage1', $available_states)->count();
        $budget = DsvBudget::find(1);

        //Check first if there are stats to show
        if( $proposals > 0 && !empty(json_decode($budget->funding_org, true))) {
            //Recalculate
            $this->recalcBudget();
        } else {
            $viewData['breadcrumb'] = 'Stats are unavailable';
            return $this->createView('stats.unavailable', 'mylayout', $viewData);
        }

        $labels = [];
        $approved = [];
        $commited = [];
        $cost = [];
        $phd = [];
        $final = [];
        $granted = [];

        //Research Subject approved and budget
        foreach ($budget->research_area as $key => $dsv) {
            $labels[] = strlen($key) > 20 ? substr($key, 0, 17) . '...' : $key; // Limit to 20 characters
            $approved[] = $dsv['approved'] ?? 0;
            $commited[] = $dsv['budget'] ?? 0;
            $cost[] = $dsv['cost'] ?? 0;
            $phd[] = $dsv['phd'] ?? 0;
            $final[] = $dsv['final'] ?? 0;
            $granted[] = $dsv['granted'] ?? 0;
        }

        //Funding Agency
        foreach (json_decode($budget->funding_org, true) as $key => $fundingOrg) {
            $org[] = strlen($key) > 20 ? substr($key, 0, 17) . '...' : $key; // Limit to 20 characters
            $orgStats[] = $fundingOrg;
        }

        //Approved
        $chart['researchsubject_approved'] = Chartjs::build()
            ->name('barChartApproved')
            ->type('bar')
            ->size(['width' => 400, 'height' => 200])
            ->labels($labels)
            ->datasets([
                [
                    "label" => "SEK",
                    'backgroundColor' => 'rgba(0, 123, 255, 1)', // Blue
                    'borderWidth' => 1,
                    'data' => $granted,
                    'categoryPercentage' => 0.6,
                    'barPercentage' => 0.6,
                    'yAxisID' => 'y-left' // Assign to left y-axis
                ],

            ]);
        //Final budget
        $chart['researchsubject_final'] = Chartjs::build()
            ->name('barChartFinal')
            ->type('bar')
            ->size(['width' => 400, 'height' => 200])
            ->labels($labels)
            ->datasets([
                [
                    "label" => "Granted total (SEK)",
                    'backgroundColor' => 'rgba(0, 255, 0, 1)',
                    'borderWidth' => 1,
                    'data' => $final,
                    'categoryPercentage' => 0.6,
                    'barPercentage' => 0.6,
                    'yAxisID' => 'y-left' // Assign to left y-axis
                ],

            ]);

        //PhD budget
        $chart['researchsubject_phd'] = Chartjs::build()
            ->name('barChartPhD')
            ->type('bar')
            ->size(['width' => 400, 'height' => 200])
            ->labels($labels)
            ->datasets([
                [
                    "label" => "PhD years",
                    'backgroundColor' => 'rgba(0, 123, 255, 1)', // Blue
                    'borderWidth' => 1,
                    'data' => $phd,
                    'categoryPercentage' => 0.6,
                    'barPercentage' => 0.6,
                    'yAxisID' => 'y-left' // Assign to left y-axis
                ],

            ]);

        //Chart Agency funding
        $chart['agency'] = Chartjs::build()
            ->name('barChartAgency')
            ->type('bar')
            ->size(['width' => 400, 'height' => 200])
            ->labels($org)
            ->datasets([
                [
                    "label" => "Funding organization",
                    'backgroundColor' => 'rgba(128, 0, 128, 1)',
                    'borderWidth' => 1,
                    'data' => $orgStats,
                    'categoryPercentage' => 0.6,
                    'barPercentage' => 0.6,
                    'yAxisID' => 'y-left' // Assign to left y-axis
                ],

            ]);

        $breadcrumb = 'Stats';

        return $this->createView('stats.proposal_approved', 'mylayout', compact('chart', 'breadcrumb'));
    }

    public function recalcBudget()
    {
        $calc = new ReCalcBudget();
        $calc->scan();

        return redirect()->back();
    }

    private function createView($template, $layout, $data)
    {
        return (new View)->template($template)->layout($layout)->with($data);
    }
}
