<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Project;
use App\Models\Team;
use Illuminate\Http\Request;

class ProjectController extends Controller
{
    public function index()
    {
        return view('admin.projects.index', ['projects' => Project::with('team')->get()]);
    }
    
    public function create()
    {
        // Passa todas as equipas para o dropdown na view
        $teams = Team::all();
        return view('admin.projects.create', compact('teams'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'description' => ['nullable', 'string'],
            'team_id' => ['required', 'exists:teams,id'],
            'start_date' => ['required', 'date'],
            'end_date' => ['required', 'date', 'after_or_equal:start_date'],
        ]);

        Project::create($request->all());

        return redirect()->route('admin.projects.index')->with('success', 'Projeto criado com sucesso.');
    }

    // Este será o novo "dashboard" de tarefas
    public function show(Project $project)
    {
        $project->load('tasks.assignees', 'team.members'); // Carrega as relações necessárias
        return view('admin.projects.show', compact('project'));
    }
}