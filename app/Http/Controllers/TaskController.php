<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

use App\Http\Requests\StoreTaskRequest;
use App\Http\Requests\UpdateTaskRequest;
use App\Models\Project;
use App\Models\Task;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB; 
use Carbon\Carbon;

class TaskController extends Controller
{
    use AuthorizesRequests;

    /**
     * Mostra a lista de tarefas para utilizadores normais (Rota: /my-tasks).
     */
    public function index(Request $request)
    {
        $projects = Project::whereHas('team.members', function ($query) {
            $query->where('user_id', Auth::id());
        })->with(['tasks' => function ($query) use ($request) {
            $query->when($request->status === 'pendente', fn($q) => $q->whereNull('completed_at'));
            $query->when($request->status === 'concluida', fn($q) => $q->whereNotNull('completed_at'));
            $query->when($request->priority, fn($q, $p) => $q->where('priority', $p));
            $query->orderBy('due_date', 'asc');
        }])->get();

        return view('dashboard', compact('projects'));
    }

    /**
     * Exibe a página principal de gestão de tarefas PARA ADMINS (Rota: /admin/tasks).
     */
    public function adminIndex()
    {
        $projects = Project::orderBy('name')->get();
        $tasks = Task::with('project.team', 'assignees')->latest()->paginate(15);

        return view('admin.tasks.index', compact('projects', 'tasks'));
    }

    /**
     * Exibe o Dashboard/Overview para ADMINISTRADORES (Rota: /dashboard).
     */
    public function adminOverview()
    {
        // 1. Coleta de dados globais (KPIs)
        $totalTasks = Task::count();
        $completedTasksCount = Task::whereNotNull('completed_at')->count();
        $pendingTasksCount = $totalTasks - $completedTasksCount;
        
        // 2. Dados para o gráfico (Prioridade)
        $tasksByPriorityData = Task::select('priority', DB::raw('count(*) as count'))
                                   ->groupBy('priority')
                                   ->pluck('count', 'priority')
                                   ->all();

        $tasksByPriority = [
            'alta' => $tasksByPriorityData['alta'] ?? 0,
            'media' => $tasksByPriorityData['media'] ?? 0,
            'baixa' => $tasksByPriorityData['baixa'] ?? 0,
        ];
        
        // 3. Tarefas Urgentes (Pendentes e com vencimento próximo)
        $urgentTasks = Task::whereNull('completed_at')
                           ->orderBy('due_date', 'asc')
                           ->where('due_date', '<=', Carbon::now()->addWeeks(2))
                           ->take(7)
                           ->get();
                           
        // Retorna a view da dashboard com todos os dados
        return view('dashboard', compact(
            'totalTasks', 
            'completedTasksCount', 
            'pendingTasksCount', 
            'tasksByPriority', 
            'urgentTasks'
        ));
    }

    /**
     * Exibe o formulário para criar uma nova tarefa.
     */
    public function create()
    {
        $projects = Project::orderBy('name')->get();
        return view('admin.tasks.create', compact('projects'));
    }
    
    /**
     * Armazena uma nova tarefa na base de dados.
     */
    public function store(StoreTaskRequest $request)
    {
        $validated = $request->validated();
        $project = Project::findOrFail($validated['project_id']);
        $task = $project->tasks()->create($validated);

        if (!empty($validated['assignees'])) {
            $task->assignees()->sync($validated['assignees']);
        }

        return redirect()->route('admin.tasks.index')->with('success', 'Tarefa criada com sucesso!');
    }

    /**
     * Atualiza uma tarefa existente.
     */
    public function update(UpdateTaskRequest $request, Task $task)
    {
        $this->authorize('update', $task);
        
        $validated = $request->validated();
        
        // Processa o campo de conclusão
        $statusUpdate = [
            'completed_at' => $request->has('completed') ? ($task->completed_at ?? now()) : null
        ];

        $task->update(array_merge($validated, $statusUpdate)); 

        if ($request->has('assignees') || $task->assignees()->exists()) {
            $task->assignees()->sync($request->input('assignees') ?? []);
        }
        
        return back()->with('success', 'Tarefa atualizada com sucesso!');
    }

    /**
     * Marca uma tarefa como concluída ou pendente.
     */
    public function complete(Task $task)
    {
        $this->authorize('update', $task);
        
        $task->update(['completed_at' => $task->completed_at ? null : now()]);
        $message = $task->completed_at ? 'Tarefa marcada como concluída!' : 'Tarefa marcada como pendente.';
        return back()->with('success', $message);
    }

    /**
     * Apaga uma tarefa.
     */
    public function destroy(Task $task)
    {
        $this->authorize('delete', $task);
        
        $task->delete();
        return back()->with('success', 'Tarefa apagada com sucesso.');
    }

    public function edit(Task $task)
    {
        $this->authorize('update', $task);

        $projects = Project::orderBy('name')->get();
        $teamMembers = $task->project->team->members;

        return view('admin.tasks.edit', compact('task', 'projects', 'teamMembers'));
    }
}