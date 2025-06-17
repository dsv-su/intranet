<?php

namespace Database\Seeders;

use App\Models\Dashboard;
use App\Models\ProjectProposal;
use App\Models\User;
use App\Workflows\DSVProjectPWorkflow;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Workflow\WorkflowStub;

class ProposalSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faker = \Faker\Factory::create();

        // Generate
        $userId = '9e25a704-50e2-41b9-9133-742dc24b3cef';
        $foUserId = '9e25a704-50e2-41b9-9133-742dc24b3cef';
        $viceId = '9e25a704-50e2-41b9-9133-742dc24b3cef';

        for ($i = 0; $i < 4; $i++) {
            $timestamp = now()->startOfDay()->timestamp;

            // Create a new proposal directly
            $pp = new ProjectProposal();
            $pp->user_id = $userId;
            $pp->name = $name = $i . '' .$faker->sentence(4);
            $pp->created = $timestamp;
            $pp->status_stage1 = 'pending';
            $pp->status_stage2 = 'pending';
            $pp->status_stage3 = 'submitted';
            $json = '{
                      "Proposal.pdf": {
                        "path":"proposals/9f25b0c4-4685-488d-90fa-5ed572f72770/draft//53bymbb7MAkyEO7HVRC8VbKjyqRYU5zCd7yT6T4A.pdf",
                        "tmp":"f32qNekWqmJCznUjC0z1iv9xcjs21w-metaTWFudWFsX2ludGVybndlYmJlbi5wZGY=-.pdf",
                        "size":488,
                        "date":"13/06/2025",
                        "type":"draft",
                        "review":"pending",
                        "uploader":"Admin User"
                      },
                      "budget.xlsx": {
                        "path":"proposals/9f25b0c4-4685-488d-90fa-5ed572f72770/budget//2JinNo2iaCG8mrSVwS3Iky5R1Cm4SV2kn99XBAtt.xlsx",
                        "tmp":"p56yqLRR3G92DPFAonOeoMQ9XzO8za-metaRFNDMDE2MzEuanBn-.jpg",
                        "size":2224,
                        "date":"13/06/2025",
                        "type":"budget",
                        "review":"pending",
                        "uploader":"Admin User"
                      }
                    }';
            // Decode into an associative array
            $data = json_decode($json, true);
            /*
            if ($i % 2 === 1) {
                $pp->files = $data;
            } else{
                $pp->files = [];
            }*/
            $pp->files = $data;

            $pp->pp = [
                'title' => $name,
                'objective' => $faker->paragraph(),
                'principal_investigator' => $faker->name(),
                'principal_investigator_email' => $faker->safeEmail(),
                'co_investigator_name' => [$faker->name()],
                'co_investigator_email' => [$faker->safeEmail()],
                'research_area' => 'Business Process Management and Enterprise Modeling',
                'dsvcoordinating' => 'yes',
                'other_coordination' => $faker->word(),
                'eu' => 'no',
                'eu_wallenberg' => 'no',
                'funding_organization' => 'Vinnova',
                'cofinancing' => $faker->boolean(),
                'other_cofinancing' => $faker->word(),
                'project_duration' => $faker->numberBetween(1, 5),
                'unit_head' => ['9e25a704-50e2-41b9-9133-742dc24b3cef'],
                'program' => $faker->word(),
                'decision_exp' => '15/06/2025',
                'start_date' => '16/06/2025',
                'submission_deadline' => '30/06/2025',
                'budget_project' => $faker->randomFloat(0, 10000, 500000),
                'budget_dsv' => $faker->randomFloat(0, 5000, 100000),
                'budget_phd' => 1,
                'currency' => 'SEK',
                'oh_cost' => 10,
                'cofinancing_needed' => 100,
                'user_comments' => $faker->sentence(),
                'submitted' => $timestamp,
                'status' => 'pending',
            ];

            $pp->save();

            // Create corresponding dashboard entry
            $dashboardData = [
                'request_id' => $pp->id,
                'name' => $pp->name,
                'created' => $timestamp,
                'status' => 'unread',
                'type' => 'projectproposal',
                'user_id' => $userId,
                'fo_id' => $foUserId,
                'vice_id' => $viceId,
            ];

            $dashboard = Dashboard::updateOrCreate(['request_id' => $pp->id], $dashboardData);
            // Create unit head approved array
            $unit_head = ['9e25a704-50e2-41b9-9133-742dc24b3cef'];

            $dashboard->unit_heads = $unit_head;
            $unit_head_approved = [];
            foreach ($unit_head as $uh) {
                $unit_head_approved[$uh] = 0;
            }
            // Encode associative array to JSON
            $dashboard->unit_head_approved = json_encode($unit_head_approved);
            $dashboard->save();
            if (count($unit_head) > 1) {
                //Flag multiple
                $dashboard->multiple_heads = true;
                $dashboard->save();
            }
            $workflow = WorkflowStub::make(DSVProjectPWorkflow::class);
            $dashboard->workflow_id = $workflow->id();
            $dashboard->save();
            $workflow->start($dashboard);
            $workflow->submit();
        }
    }
}
