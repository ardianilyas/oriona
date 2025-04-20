<?php
        
namespace App\Services;

use App\Models\Project;
use App\Repositories\ProjectRepository;

class ProjectService
{
    public function __construct(protected ProjectRepository $projectRepository)
    {
        
    }

    public function getAllProjects() {
        return $this->projectRepository->getUserProjects();
    }

    public function getProject(Project $project) {
        return $this->projectRepository->find($project);
    }

    public function createProject(array $data) {
        return $this->projectRepository->create($data);
    }

    public function updateProject(Project $project, array $data) {
        return $this->projectRepository->update($project, $data);
    }

    public function deleteProject(Project $project) {
        return $this->projectRepository->delete($project);
    }
}
