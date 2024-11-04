<?php

namespace App\Services\Review;

use App\Models\Dashboard;
use App\Models\User;

class DashboardRole
{
    private $dashboard;
    private $reviewer;

    public function __construct(Dashboard $dashboard, User $reviewer)
    {
        $this->dashboard = $dashboard;
        $this->reviewer = $reviewer;
    }

    public function check()
    {
        // Map states to role fields
        $roles = [
            'submitted' => 'head_id',
            'head_approved' => 'vice_id',
            'vice_approved' => 'fo_id',
        ];

        // Get the state as a string
        $currentState = (string) $this->dashboard->state; // Ensure it's a string

        // Check if the current state is in the roles mapping
        if (array_key_exists($currentState, $roles) && $this->dashboard->{$roles[$currentState]} == $this->reviewer->id) {
            return $this->getRoleFromState($currentState);
        }

        return false;
    }

    private function getRoleFromState($state)
    {
        $roleMapping = [
            'submitted' => 'head',
            'head_approved' => 'vice',
            'vice_approved' => 'fo',
        ];

        return $roleMapping[$state] ?? false; // Return the role or false if not found
    }
}

