<?php

namespace App\Repositories\Interfaces;

use App\Models\Project;

interface ProjectRepositoryInterface
{
    public function getUserProjects();
    public function find(Project $project);
    public function create(array $data);
    public function update(Project $project, array $data);
    public function delete(Project $project);
}
