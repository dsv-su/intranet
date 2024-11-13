<?php

namespace App\Models;

use App\Workflows\States\DashboardState;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Support\Facades\Auth;
use Spatie\ModelStates\HasStates;

class ProjectProposal extends Model
{
    use HasFactory, HasStates, HasUuids;

    protected $fillable = ['user_id', 'name', 'created', 'status_stage1' ,'status_stage2', 'status_stage3', 'pp', 'files'];
    protected $casts = [
        'pp' => 'array',
        'files' => 'array',
    ];

    /**
     * Get the dashboard item associated with the proposal.
     */
    public function dashboard(): HasOne
    {
        return $this->hasOne(Dashboard::class, 'request_id');
    }

    public function allowEdit()
    {
        $user = Auth::user();
        $dashboard = Dashboard::where('request_id', $this->id)->first();

        $allowed_roles = [$dashboard->user_id, $dashboard->head_id, $dashboard->vice_id, $dashboard->fo_id];

        // && $dashboard->state == 'fo_approved' //alternative for only approved proposals
        if (in_array($user->id, $allowed_roles)) {
            return true;
        } else {
            return false;
        }
    }
}
