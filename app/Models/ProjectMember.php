<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\Pivot;

class ProjectMember extends Pivot
{
    /** @use HasFactory<\Database\Factories\ProjectMemberFactory> */
    use HasFactory, HasUuids;
    
    protected $table = 'project_members';
    protected $guarded = ['id'];

    public function casts(): array {
        return [
            'created_at' => 'datetime: l, d F Y H:i:s',
        ];
    }
}
