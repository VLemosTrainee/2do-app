<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// Grupo de Rotas de Administração
Route::middleware(['auth', 'admin'])->prefix('admin')->name('admin.')->group(function () {
    // Rota para a gestão de utilizadores (simples por agora)
    Route::get('/users', function() {
        return view('admin.users.index', ['users' => \App\Models\User::all()]);
    })->name('users.index');

    // Rotas para gestão de Equipas e Projetos
    Route::resource('teams', TeamController::class);
    Route::resource('projects', ProjectController::class);
});

require __DIR__.'/auth.php';
