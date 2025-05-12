<?php

namespace App\Http\Controllers;

use App\Enums\ProjectRole;
use App\Http\Requests\CreateProjectRequest;
use App\Http\Requests\UpdateProjectRequest;
use App\Models\Project;
use App\Models\User;
use App\Services\ProjectService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProjectController extends Controller
{
    public function __construct(protected ProjectService $projectService)
    {
        
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $projects = $this->projectService->getAllProjects();
        return inertia('Projects/Index', compact('projects'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return inertia('Projects/Create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(CreateProjectRequest $request)
    {
        $data = $request->validated();
        $data['user_id'] = Auth::id();

        $this->projectService->createProject($data);

        return redirect()->route('dashboard.projects.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(Project $project)
    {
        $project->load(['creator', 'members']);

        $roles = ProjectRole::cases();

        $user = Auth::user();

        $isManager = $project->isManager($user);

        return inertia('Projects/Show', compact('project', 'roles', 'isManager'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Project $project)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateProjectRequest $request, Project $project)
    {
        $this->projectService->updateProject($project, $request->validated());

        return back();
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Project $project)
    {
        $this->projectService->deleteProject($project);

        return back();
    }

    public function assignRole(Request $request, Project $project, User $user) {
        $this->projectService->assignRole($project, $user, $request->role);

        return back();
    }
}
