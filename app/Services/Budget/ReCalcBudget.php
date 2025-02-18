<?php

namespace App\Services\Budget;

use App\Models\DsvBudget;
use App\Models\ProjectProposal;

class ReCalcBudget
{
    protected $research_area = [];

    public function scan()
    {
        $proposals = ProjectProposal::all();
        $budget = DsvBudget::find(1);
        foreach($proposals as $proposal) {
            if($proposal->status->stage1 == 'vice_approved') {
                $this->research_area[$proposal->pp['research_area']]['preapproved']++;
            }

        }
    }
}
