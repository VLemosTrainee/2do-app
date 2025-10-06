<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo; // Importar BelongsTo
use Illuminate\Database\Eloquent\Relations\HasMany;   // Importar HasMany
use App\Models\Task; // <-- ADICIONE ESTA LINHA


class Project extends Model
{
    use HasFactory;

    /**
     * The attributes that aren't mass assignable.
     */
    protected $guarded = []; // Proteção contra Mass Assignment

    /**
     * Um projeto pertence a uma equipa.
     * ESTE É O MÉTODO QUE ESTAVA EM FALTA.
     */
    public function team(): BelongsTo
    {
        return $this->belongsTo(Team::class);
    }

    /**
     * Um projeto tem muitas tarefas.
     */
    public function tasks(): HasMany
    {
        return $this->hasMany(Task::class);
    }
}