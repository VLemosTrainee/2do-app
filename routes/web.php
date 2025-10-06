<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\TaskController; 
use App\Http\Controllers\Admin\TeamController;
use App\Http\Controllers\Admin\ProjectController;
use App\Http\Controllers\Admin\UserController;
use Illuminate\Support\Facades\DB; 

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

Route::get('/', function () {
    return view('welcome');
});

// DASHBOARD (ACESSÍVEL APENAS PARA ADMINS)
Route::get('/dashboard', [TaskController::class, 'adminOverview']) 
    ->middleware(['auth', 'verified', 'admin'])
    ->name('dashboard');

// ROTA DE TAREFAS PARA USUÁRIOS COMUNS (ou lista simples)
Route::get('/my-tasks', [TaskController::class, 'index']) 
    ->middleware(['auth', 'verified'])
    ->name('tasks.my_index');


// Rotas de Perfil e Ações de Tarefas (acessíveis a todos os logados)
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // CRUD de Tarefas
    Route::post('/tasks', [TaskController::class, 'store'])->name('tasks.store');
    Route::get('/tasks/{task}/edit', [TaskController::class, 'edit'])->name('tasks.edit');
    Route::patch('/tasks/{task}', [TaskController::class, 'update'])->name('tasks.update');
    Route::patch('/tasks/{task}/complete', [TaskController::class, 'complete'])->name('tasks.complete');
    Route::delete('/tasks/{task}', [TaskController::class, 'destroy'])->name('tasks.destroy');
});

// Grupo de Rotas de ADMINISTRAÇÃO
Route::middleware(['auth', 'admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/users', [UserController::class, 'index'])->name('users.index');
    Route::get('/users/search', [UserController::class, 'search'])->name('users.search');

    Route::get('/teams/search', [TeamController::class, 'search'])->name('teams.search');
    Route::resource('teams', TeamController::class);

    Route::get('/projects/search', [ProjectController::class, 'search'])->name('projects.search');
    Route::get('/projects/{project}/team-members', [ProjectController::class, 'getTeamMembers'])->name('projects.team-members');
    Route::resource('projects', ProjectController::class);
    
    // Rota de Gestão Detalhada de Tarefas (A lista de index.blade.php)
    Route::get('/tasks', [TaskController::class, 'adminIndex'])->name('tasks.index'); 
    
    // Rota de Criação de Tarefas
    Route::get('/tasks/create', [TaskController::class, 'create'])->name('tasks.create'); 
});

require __DIR__.'/auth.php';