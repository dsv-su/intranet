<?php

namespace App\Services\Budget;

use App\Models\DsvBudget;
use App\Models\ProjectProposal;

class Budget
{
    protected $budget, $proposal, $research_area;

    public function __construct(ProjectProposal $proposal)
    {
        $this->budget = DsvBudget::find(1);
        $this->proposal = $proposal;
    }

    public function preapproved_increment($researchAreaToUpdate)
    {
        $this->research_area = $this->budget->research_area;
        // Ensure decoding was successful
        if (!is_array($this->research_area)) {
            $research_area = [];
        }
        // Ensure the research area exists
        if (!isset($this->research_area[$researchAreaToUpdate])) {
            $this->research_area[$researchAreaToUpdate] = ['preapproved' => 0];
        }
        // Increment the 'preapproved' count for the specific research area
        $this->research_area[$researchAreaToUpdate]['preapproved']++;

        //Update research_area
        $this->budget->research_area = $this->research_area;

        //Update total
        $this->budget->preapproved_total++;

        // Save the updated JSON
        $this->budget->save();
    }

    public function budget_increment($researchAreaToUpdate)
    {
        $this->research_area = $this->budget->research_area;
        // Ensure decoding was successful
        if (!is_array($this->research_area)) {
            $research_area = [];
        }
        // Ensure the research area exists
        if (!isset($this->research_area[$researchAreaToUpdate])) {
            $this->research_area[$researchAreaToUpdate] = ['budget' => 0];
        }
        // Increase the 'budget' for the specific research area
        $this->research_area[$researchAreaToUpdate]['budget'] += $this->proposal->pp['budget_dsv'] ?? 0;


        //Update research_area
        $this->budget->research_area = $this->research_area;

        //Update dsv total
        $this->budget->budget_dsv_total += $this->proposal->pp['budget_dsv'] ?? 0;

        //Update project total
        $this->budget->budget_project_total += $this->proposal->pp['budget_project'] ?? 0;

        // Save the updated JSON
        $this->budget->save();
    }

    public function phd_increment($researchAreaToUpdate)
    {
        $this->research_area = $this->budget->research_area;
        // Ensure decoding was successful
        if (!is_array($this->research_area)) {
            $research_area = [];
        }
        // Ensure the research area exists
        if (!isset($this->research_area[$researchAreaToUpdate])) {
            $this->research_area[$researchAreaToUpdate] = ['phd' => 0];
        }
        // Increase the 'phd-budget' for the specific research area
        $this->research_area[$researchAreaToUpdate]['phd'] += $this->proposal->pp['budget_phd'] ?? 0;


        //Update research_area
        $this->budget->research_area = $this->research_area;

        //Update total
        $this->budget->phd_total += $this->proposal->pp['budget_phd'] ?? 0;

        // Save the updated JSON
        $this->budget->save();
    }

    public function cost_increment($researchAreaToUpdate)
    {
        $this->research_area = $this->budget->research_area;
        // Ensure decoding was successful
        if (!is_array($this->research_area)) {
            $research_area = [];
        }
        // Ensure the research area exists
        if (!isset($this->research_area[$researchAreaToUpdate])) {
            $this->research_area[$researchAreaToUpdate] = ['cost' => 0];
        }
        // Increase the 'cost' for the specific research area
        $this->research_area[$researchAreaToUpdate]['cost'] += $this->proposal->pp['cofinancing_needed'] ?? 0;


        //Update research_area
        $this->budget->research_area = $this->research_area;

        //Update total
        $this->budget->cost_total += $this->proposal->pp['cofinancing_needed'] ?? 0;

        // Save the updated JSON
        $this->budget->save();
    }
}
