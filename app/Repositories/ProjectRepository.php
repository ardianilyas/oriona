<?php

namespace App\Repositories;

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

    public function create(array $data)
    {
        return Project::create($data);
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
