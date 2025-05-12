<?php

namespace App\Repositories;

use App\Enums\ProjectRole;
use App\Models\User;
use App\Models\Project;
use Illuminate\Support\Facades\Auth;
use App\Repositories\Interfaces\ProjectRepositoryInterface;

class ProjectRepository implements ProjectRepositoryInterface
{
    public function getUserProjects()
    {
        return Auth::user()->projects()->latest('updated_at')->get();
    }

    public function find(Project $project)
    {
        return $project;
    }

    public function create(array $data, User $user)
    {
        $project = Project::create($data);
        
        $project->members()->attach($user->id, [
            'role' => ProjectRole::Admin->value,
        ]);

        return $project;
    }

    public function update(Project $project, array $data)
    {
        $project->update($data);
        return $project;
    }

    public function delete(Project $project)
    {
        return $project->delete();
    }

    public function assignRole(Project $project, User $user, string $role) {
        return $project->members()->updateExistingPivot($user->id, ['role' => $role]);
    }
}
