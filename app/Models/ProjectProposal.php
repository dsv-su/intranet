<?php

namespace App\Models;

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

        $allowed_roles_I = [$dashboard?->user_id, $dashboard?->vice_id, $dashboard?->fo_id];
        $allowed_roles_II = is_array($dashboard?->unit_heads) ? $dashboard->unit_heads : [$dashboard->unit_heads];
        $allowed_roles = array_filter(array_merge($allowed_roles_I, $allowed_roles_II)); // Remove null values
        // && $dashboard->state == 'fo_approved' //alternative for only approved proposals
        return in_array($user->id, $allowed_roles);
    }

    public function allowComplete(): bool
    {
        $user = Auth::user();
        $dashboard = Dashboard::where('request_id', $this->id)->first();

        if (!$dashboard || (string) $dashboard->state !== 'submitted') {
            return false;
        }

        return $user->id === $dashboard->user_id;
    }

    public function allowUpload(): bool
    {
        $user = Auth::user();
        $dashboard = Dashboard::where('request_id', $this->id)->first();

        if (!$dashboard || !in_array((string)$dashboard->state, ['submitted'])) {
            return false;
        }

        return $user->id === $dashboard->user_id;
    }

    public function allowSend(): bool
    {
        $user = Auth::user();
        $dashboard = Dashboard::where('request_id', $this->id)->first();

        if (!$dashboard || (string) $dashboard->state !== 'final_approved') {
            return false;
        }

        return $user->id === $dashboard->user_id;
    }

    public function allowGrant(): bool
    {
        $user = Auth::user();
        $dashboard = Dashboard::where('request_id', $this->id)->first();

        if (!$dashboard || (string) $dashboard->state !== 'sent') {
            return false;
        }

        return $user->id === $dashboard->user_id;
    }

    public function allowReject(): bool
    {
        $user = Auth::user();
        $dashboard = Dashboard::where('request_id', $this->id)->first();

        if (!$dashboard || (string) $dashboard->state !== 'sent') {
            return false;
        }

        return $user->id === $dashboard->user_id;
    }

}
