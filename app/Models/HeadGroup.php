<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HeadGroup extends Model
{
    use HasFactory, HasUuids;
    protected $fillable = ['unit_heads'];
    protected $casts = [
        'unit_heads' => 'array',
    ];
}
