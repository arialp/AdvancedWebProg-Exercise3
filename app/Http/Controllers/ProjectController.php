<?php

namespace App\Http\Controllers;

use App\Models\Project;
use Illuminate\Http\Request;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class ProjectController extends Controller
{
    use AuthorizesRequests;
    public function index()
    {
        $managedProjects = auth()->user()->managedProjects;
        $joinedProjects = auth()->user()->joinedProjects;

        return view('projects.index', compact('managedProjects', 'joinedProjects'));
    }

    public function create()
    {
        $users = \App\Models\User::where('id', '!=', auth()->id())->get();
        return view('projects.create', compact('users'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'price' => 'nullable|numeric',
            'start_date' => 'nullable|date',
            'end_date' => 'nullable|date',
            'team_members' => 'nullable|array',
            'team_members.*' => 'exists:users,id',
        ]);

        $project = auth()->user()->managedProjects()->create($validated);

        if (!empty($validated['team_members'])) {
            $project->teamMembers()->sync($validated['team_members']);
        }

        return redirect()->route('projects.index')->with('success', __('Project created successfully.'));
    }

    public function show(Project $project)
    {
        $this->authorize('view', $project);
        return view('projects.show', compact('project'));
    }

    public function edit(Project $project)
    {
        $this->authorize('update', $project);
        $users = \App\Models\User::where('id', '!=', auth()->id())->get();
        return view('projects.edit', compact('project', 'users'));
    }

    public function update(Request $request, Project $project)
    {
        $this->authorize('update', $project);

        if (auth()->user()->id === $project->manager_id) {
            $validated = $request->validate([
                'name' => 'required|string|max:255',
                'description' => 'nullable|string',
                'price' => 'nullable|numeric',
                'done_jobs' => 'nullable|integer',
                'start_date' => 'nullable|date',
                'end_date' => 'nullable|date',
                'team_members' => 'nullable|array',
                'team_members.*' => 'exists:users,id',
            ]);

            $project->update($validated);

            if (isset($validated['team_members'])) {
                $project->teamMembers()->sync($validated['team_members']);
            } else {
                $project->teamMembers()->detach();
            }
        } else {
            // Team member can only update done_jobs
            $validated = $request->validate([
                'done_jobs' => 'required|integer',
            ]);
            $project->update(['done_jobs' => $validated['done_jobs']]);
        }

        return redirect()->route('projects.index')->with('success', __('Project updated successfully.'));
    }

    public function destroy(Project $project)
    {
        $this->authorize('delete', $project);
        $project->delete();
        return redirect()->route('projects.index')->with('success', __('Project deleted successfully.'));
    }
}
