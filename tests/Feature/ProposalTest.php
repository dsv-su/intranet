<?php
namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Models\User;
use App\Models\ProjectProposal;

class ProposalTest extends TestCase
{
    use RefreshDatabase;

    // php artisan test --filter=ProposalTest //

    /** @test */
    public function user_can_submit_a_proposal_form()
    {
        // Create a user and authenticate
        $user = User::factory()->create();
        $this->actingAs($user);

        // Define the form data
        $formData = [
            'type' => 'create',
            'title' => 'Test Proposal Title',
            'objective' => 'This is a test objective for the research project.',
            'principal_investigator' => $user->name,
            'principal_investigator_email' => $user->email,
            'research_area' => 'Artificial Intelligence',
            'unit_head' => [1], // Assuming unit head ID is 1
            'program' => 'https://example.com/call-for-proposals',
            'decision_exp' => '2025-06-01',
            'start_date' => '2025-07-01',
            'submission_deadline' => '2025-08-01',
            'project_duration' => 24,
            'budget_project' => 1000000,
            'budget_dsv' => 500000,
            'currency' => 'sek',
            'oh_cost' => 10,
            'user_comments' => 'No additional comments.',
        ];

        // Send POST request to the route handling the form submission
        $response = $this->post(route('pp-submit'), $formData);

        // Assert that the response redirects successfully
        $response->assertRedirect();

        // Assert that the data was saved in the database
        $this->assertDatabaseHas('project_proposals', [
            'title' => 'Test Proposal Title',
            'objective' => 'This is a test objective for the research project.',
        ]);
    }

    /** @test */
    public function it_requires_mandatory_fields()
    {
        $user = User::factory()->create();
        $this->actingAs($user);

        // Send POST request with missing required fields
        $response = $this->post(route('pp-submit'), [
            'type' => 'create',
            'title' => '',
            'objective' => '',
        ]);

        // Assert that validation errors occur
        $response->assertSessionHasErrors(['title', 'objective']);
    }
}
