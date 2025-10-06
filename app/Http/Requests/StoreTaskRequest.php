<?php

namespace App\Http\Requests;

use App\Models\Project;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class StoreTaskRequest extends FormRequest
{
    /**
     * Determina se o utilizador está autorizado a fazer este pedido.
     */
    public function authorize(): bool
    {
        // Encontra o projeto e verifica se o utilizador pode vê-lo (é membro da equipa).
        // Se for admin, a Policy também pode dar permissão.
        $project = Project::find($this->input('project_id'));
        
        return $project && Auth::user()->can('view', $project);
    }

    /**
     * Obtém as regras de validação que se aplicam ao pedido.
     */
    public function rules(): array
    {
        return [
            'project_id' => ['required', 'exists:projects,id'],
            'title' => ['required', 'string', 'max:255'],
            'description' => ['nullable', 'string'],
            'due_date' => ['nullable', 'date'],
            'priority' => ['required', 'in:baixa,media,alta'],
            'assignees' => ['nullable', 'array'],
            'assignees.*' => ['exists:users,id'],
        ];
    }
}