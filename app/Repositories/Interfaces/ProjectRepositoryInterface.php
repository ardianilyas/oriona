<?php

namespace App\Repositories\Interfaces;

use App\Models\User;
use App\Models\Project;

interface ProjectRepositoryInterface
{
    public function getUserProjects();
    public function find(Project $project);
    public function create(array $data, User $user);
    public function update(Project $project, array $data);
    public function delete(Project $project);
    public function assignRole(Project $project, User $user, string $role);
    public function invite(User $user, Project $project);
}
