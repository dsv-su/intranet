<?php

namespace Database\Seeders;

use App\Models\ResearchArea;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DsvBudgetsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Get all research areas
        $researchAreas = ResearchArea::pluck('name')->toArray();

        // Create a JSON structure where each research area is an object with 'preapproved' = 0
        $researchAreaData = [];
        foreach ($researchAreas as $area) {
            $researchAreaData[$area] = [
                'preapproved' => 0,
                'budget' => 0,
                'cost' => 0,
                'approved' => 0,
                'final' => 0,
            ];
        }

        // Insert into dsv_budgets table
        DB::table('dsv_budgets')->insert([
            'research_area' => json_encode($researchAreaData),
            'preapproved_total' => 0,
            'budget_total' => 0,
            'cost_total' => 0,
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }
}
