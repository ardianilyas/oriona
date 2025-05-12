<?php

namespace App\Models;

use App\Enums\ProjectRole;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Project extends Model
{
    /** @use HasFactory<\Database\Factories\ProjectFactory> */
    use HasFactory, HasUuids;

    protected $guarded = ['id'];

    protected function casts(): array
    {
        return [
            'created_at' => 'datetime: l, d F Y',
        ];
    }

    public function creator(): BelongsTo {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function members(): BelongsToMany {
        return $this->belongsToMany(User::class, 'project_members')
            ->withPivot(['role'])
            ->withTimestamps()
            ->using(ProjectMember::class)
            ->orderBy('project_members.role', 'asc');
    }

    public function isManager(User $user): bool {
        $managerRole = [ProjectRole::Admin, ProjectRole::ProjectManager];

        $member = $this->members()->where('user_id', $user->id)->first();
        
        return $member && in_array($member->pivot->role, $managerRole);
    }

    public function tasks(): HasMany {
        return $this->hasMany(Task::class);
    }
}
