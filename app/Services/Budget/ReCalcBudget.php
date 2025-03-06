<?php

namespace App\Services\Budget;

use App\Models\DsvBudget;
use App\Models\ProjectProposal;
use Illuminate\Support\Facades\Artisan;

class ReCalcBudget
{

    public function scan()
    {
        Artisan::call('clear-areas');

        $count = [];
        $commited = [];
        $proposals = ProjectProposal::all();
        $budget = DsvBudget::find(1);

        // Retrieve research_area as an array
        $researchAreas = $budget->getAttribute('research_area') ?? [];

        // Update research area counts

        foreach ($proposals as $proposal) {
            $researchArea = $proposal->pp['research_area'];
            $researchAreaBudget = $proposal->pp['budget_dsv'] ?? 0;

            // Ensure research area exists
            if (!isset($researchAreas[$researchArea])) {
                $researchAreas[$researchArea] = [
                    'preapproved' => 0,
                    'budget' => 0
                ];
            }

            // Initialize count and committed arrays properly
            if (!isset($count[$researchArea])) {
                $count[$researchArea] = 0;
            }

            if (!isset($commited[$researchArea])) {
                $commited[$researchArea] = 0;
            }

            // Increment counters
            $count[$researchArea]++;
            $commited[$researchArea] += $researchAreaBudget;
        }

        // Update research area counts
        foreach ($count as $researchArea => $newCount) {
            $researchAreas[$researchArea]['preapproved'] = $newCount;
            $researchAreas[$researchArea]['budget'] = $commited[$researchArea];
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

        // Save changes
        $budget->save();

    }


}
