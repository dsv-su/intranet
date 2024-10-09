<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProjectProposal extends Model
{
    use HasFactory;
    use HasUuids;

    protected $fillable = ['created', 'state', 'name', 'pp'];
    protected $casts = ['pp' => 'array',];

}
