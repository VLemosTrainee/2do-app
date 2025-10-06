<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Team extends Model
{
    use HasFactory;

    // É mais seguro usar $fillable ou $guarded. $guarded = [] é mais rápido para agora.
    protected $guarded = [];

    /**
     * A equipa pertence a um utilizador (o seu dono/criador).
     */
    public function owner(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    /**
     * A equipa tem muitos membros (utilizadores).
     * ESTE É O MÉTODO QUE ESTAVA EM FALTA.
     */
    public function members(): BelongsToMany
    {
        return $this->belongsToMany(User::class);
    }

    /**
     * A equipa tem muitos projetos.
     */
    public function projects(): HasMany
    {
        return $this->hasMany(Project::class);
    }
}