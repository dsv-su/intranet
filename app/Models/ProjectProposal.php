<?php

namespace App\Models;

use App\Workflows\States\DashboardState;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Spatie\ModelStates\HasStates;

class ProjectProposal extends Model
{
    use HasFactory, HasStates, HasUuids;

    protected $fillable = ['created', 'status', 'name', 'pp'];
    protected $casts = [
        'pp' => 'array',
    ];

    /**
     * Get the dashboard item associated with the proposal.
     */
    public function dashboard(): HasOne
    {
        return $this->hasOne(Dashboard::class, 'request_id');
    }
}
