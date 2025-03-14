<?php

namespace App\Services\Budget;

use App\Models\DsvBudget;
use App\Models\ProjectProposal;
use Illuminate\Support\Facades\Artisan;

class ReCalcBudget
{

    public function scan()
    {
        //Reset budget table
        Artisan::call('clear-areas');

        $available_states = [
            'vice_approved',
            'complete',
            'head_approved',
            'fo_approved',
            'final_approved'
        ];

        //Retrive proposal data
        $count = [];
        $commited = [];
        $commited_phd = [];
        $total_preapproved = 0;
        $total_dsv_budget = 0;
        $total_project_budget = 0;
        $total_phd = 0;
        $proposals = ProjectProposal::whereIn('status_stage1', $available_states)->get();
        $budget = DsvBudget::find(1);

        // Retrieve research_area as an array
        $researchAreas = $budget->getAttribute('research_area') ?? [];

        foreach ($proposals as $proposal) {
            // Update research area counts
            $researchArea = $proposal->pp['research_area'];
            $researchAreaBudget = $proposal->pp['budget_dsv'] ?? 0;
            $researchAreaPhd = $proposal->pp['budget_phd'] ?? 0;
            $projectBudget = $proposal->pp['budget_project'] ?? 0;

            // Ensure research area exists
            if (!isset($researchAreas[$researchArea])) {
                $researchAreas[$researchArea] = [
                    'preapproved' => 0,
                    'budget' => 0,
                    'phd' => 0
                ];
            }

            // Initialize arrays properly
            if (!isset($count[$researchArea])) {
                $count[$researchArea] = 0;
            }

            if (!isset($commited[$researchArea])) {
                $commited[$researchArea] = 0;
            }

            if (!isset($commited_phd[$researchArea])) {
                $commited_phd[$researchArea] = 0;
            }

            // Increment counters
            $count[$researchArea]++;
            $commited[$researchArea] += $researchAreaBudget;
            $commited_phd[$researchArea] += $researchAreaPhd;
            $total_dsv_budget += $researchAreaBudget;
            $total_project_budget += $projectBudget;
            $total_phd += $researchAreaPhd;
        }

        // Update research area counts
        foreach ($count as $researchArea => $newCount) {
            $researchAreas[$researchArea]['preapproved'] = $newCount;
            $total_preapproved = $newCount;
            $researchAreas[$researchArea]['budget'] = $commited[$researchArea];
            $researchAreas[$researchArea]['phd'] = $commited_phd[$researchArea];
        }

        // Set the modified researchAreas array back to the model
        $budget->setAttribute('research_area', $researchAreas);

        //Count occurences of each funding agency
        $agencyCounts = [];
        $org = [];
        $orgStats = [];

        foreach ($proposals as $proposal) {
            if (!empty($proposal->pp['funding_organization'])) {
                $agencyCounts[] = $proposal->pp['funding_organization'];
            }
        }

        // Count occurrences of each agency
        $agencyStats = array_count_values($agencyCounts);

        // Create arrays
        foreach( $agencyStats as $agency => $agencyCount) {
            $org[] = $agency;
            $orgStats[] = $agencyCount;
        }

        // Retrieve funding organizations as an array
        $fundingOrgs = $budget->getAttribute('funding_org') ?? [];

        //Update funding org array
        foreach( $org as $key => $name) {
            $fundingOrgs[$name] = $orgStats[$key];
        }

        // Set the modified researchAreas array back to the model
        $budget->setAttribute('funding_org', $fundingOrgs);

        // Set the modified budget back to the model
        $budget->setAttribute('preapproved_total', $total_preapproved);
        $budget->setAttribute('budget_dsv_total', $total_dsv_budget);
        $budget->setAttribute('budget_project_total', $total_project_budget);
        $budget->setAttribute('phd_total', $total_phd);

        // Save changes
        $budget->save();

    }


}
