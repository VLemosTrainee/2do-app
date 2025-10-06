<?php

namespace App\Http\Requests; // <<< CORREÇÃO APLICADA AQUI

use Illuminate\Foundation\Http\FormRequest;

class UpdateTaskRequest extends FormRequest
{
    /**
     * Determina se o utilizador está autorizado a fazer este pedido.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Obtém as regras de validação que se aplicam ao pedido.
     */
    public function rules(): array
    {
        return [
            'title' => ['sometimes', 'required', 'string', 'max:255'],
            'description' => ['nullable', 'string'],
            'due_date' => ['nullable', 'date'],
            'priority' => ['sometimes', 'required', 'in:baixa,media,alta'],
            'assignees' => ['nullable', 'array'],
            'assignees.*' => ['exists:users,id'],
        ];
    }
}