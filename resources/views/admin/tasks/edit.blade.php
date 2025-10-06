<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-100 leading-tight">
                {{ __('Editar Tarefa') }}
            </h2>
            <!-- Botão para Voltar -->
            <a href="{{ url()->previous() }}" class="inline-flex items-center px-4 py-2 bg-gray-200 dark:bg-gray-600 border border-transparent rounded-md font-semibold text-xs text-gray-800 dark:text-gray-200 uppercase tracking-widest hover:bg-gray-300 dark:hover:bg-gray-500 transition ease-in-out duration-150">
                &larr; Voltar
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-2xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <form action="{{ route('tasks.update', $task) }}" method="POST" class="space-y-6">
                        @csrf
                        @method('PATCH')
                        
                        <h3 class="text-lg font-medium text-gray-900 dark:text-gray-100">
                            Tarefa: <span class="font-bold">{{ $task->title }}</span>
                        </h3>
                        
                        <div>
                            <x-input-label for="project_id" value="Projeto" />
                            <select id="project_id" name="project_id" class="mt-1 block w-full ..." disabled>
                                <option value="{{ $task->project->id }}">{{ $task->project->name }}</option>
                            </select>
                            <p class="mt-1 text-xs text-gray-500">O projeto de uma tarefa não pode ser alterado.</p>
                        </div>
                        
                        <div>
                            <x-input-label for="title" value="Título da Tarefa" />
                            <x-text-input id="title" name="title" type="text" class="mt-1 block w-full" :value="old('title', $task->title)" required />
                        </div>

                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                            <div>
                                <x-input-label for="due_date" value="Data de Vencimento" />
                                <x-text-input id="due_date" name="due_date" type="date" class="mt-1 block w-full" :value="old('due_date', $task->due_date?->format('Y-m-d'))" />
                            </div>
                            <div>
                                <x-input-label for="priority" value="Prioridade" />
                                <select id="priority" name="priority" class="mt-1 block w-full ...">
                                    <option value="baixa" @selected(old('priority', $task->priority) == 'baixa')>Baixa</option>
                                    <option value="media" @selected(old('priority', $task->priority) == 'media')>Média</option>
                                    <option value="alta" @selected(old('priority', $task->priority) == 'alta')>Alta</option>
                                </select>
                            </div>
                        </div>

                        <div>
                            <x-input-label for="assignees" value="Atribuir a Membros" />
                            <select name="assignees[]" id="assignees" multiple class="mt-1 block w-full h-32 ...">
                                @foreach($teamMembers as $member)
                                    <option value="{{ $member->id }}" @selected($task->assignees->contains($member))>
                                        {{ $member->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        
                        <div class="flex items-center gap-4">
                            <x-primary-button>{{ __('Salvar Alterações') }}</x-primary-button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>