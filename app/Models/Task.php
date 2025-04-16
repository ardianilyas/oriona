<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Task extends Model
{
    /** @use HasFactory<\Database\Factories\TaskFactory> */
    use HasFactory, HasUuids;

    protected $guarded = ['id'];

    public function project(): BelongsTo {
        return $this->belongsTo(Project::class);
    }

    public function user(): BelongsTo {
        return $this->belongsTo(User::class);
    }
}
