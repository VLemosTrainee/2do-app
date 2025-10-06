<x-app-layout>
    <!-- ... (x-slot name="header") ... -->

    <!-- ========================================================== -->
    <!-- INÍCIO: Alpine.js para gerir o estado de edição -->
    <!-- ========================================================== -->
    <div class="py-12" 
         x-data="{ 
            isEditing: false, 
            taskToEdit: null, 
            formAction: '{{ route('tasks.store') }}',
            formMethod: 'POST',
            openModal(task = null) {
                if (task) {
                    this.isEditing = true;
                    this.taskToEdit = task;
                    this.formAction = `/tasks/${task.id}`;
                    this.formMethod = 'PATCH';
                } else {
                    this.isEditing = false;
                    this.taskToEdit = { id: null, title: '', priority: 'media', due_date: '', assignees: [] };
                    this.formAction = '{{ route('tasks.store') }}';
                    this.formMethod = 'POST';
                }
                $dispatch('open-modal', { name: 'task-form' });
            }
         }">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <!-- ... (Card de Informações Gerais do Projeto) ... -->

            <!-- Lista de Tarefas -->
            <h3 class="text-lg font-semibold text-gray-800 dark:text-gray-100 mb-4">Tarefas do Projeto</h3>
            <div class="space-y-4">
                @forelse ($project->tasks as $task)
                    <!-- Passamos o evento `openModal` para o componente -->
                    <x-task-item :task="$task" @edit-task.window="openModal($event.detail)" />
                @empty
                    <!-- ... (mensagem de sem tarefas) ... -->
                @endforelse
            </div>
        </div>
    
        <!-- ========================================================== -->
        <!-- Modal de Criar/Editar Tarefa -->
        <!-- ========================================================== -->
        <x-modal name="task-form">
            <form :action="formAction" method="POST" class="p-6 space-y-6">
                @csrf
                <!-- O método do formulário será PATCH na edição -->
                <template x-if="isEditing"><input type="hidden" name="_method" value="PATCH"></template>
                
                <h2 class="text-lg font-medium text-gray-900 dark:text-gray-100" x-text="isEditing ? 'Editar Tarefa' : 'Adicionar Nova Tarefa ao Projeto \'{{ $project->name }}\''"></h2>

                <input type="hidden" name="project_id" value="{{ $project->id }}">
                
                <div>
                    <x-input-label for="title" value="Título da Tarefa" />
                    <x-text-input id="title" name="title" type="text" class="mt-1 block w-full" x-model="taskToEdit.title" required />
                </div>
                
                <!-- ... (outros campos do formulário: due_date, priority) ... -->
                <!-- Adapte-os para usar x-model, ex: x-model="taskToEdit.due_date" -->
                
                <div>
                    <x-input-label for="assignees">Atribuir a:</x-input-label>
                    <select name="assignees[]" id="assignees" multiple class="mt-1 block w-full h-32 ...">
                        @foreach($project->team->members as $member)
                            <option value="{{ $member->id }}" 
                                    :selected="taskToEdit && taskToEdit.assignees.map(a => a.id).includes({{ $member->id }})">
                                {{ $member->name }}
                            </option>
                        @endforeach
                    </select>
                </div>
                
                <div class="flex justify-end pt-4 border-t dark:border-gray-700">
                    <x-secondary-button x-on:click="$dispatch('close')">{{ __('Cancelar') }}</x-secondary-button>
                    <x-primary-button class="ms-3" x-text="isEditing ? 'Salvar Alterações' : 'Salvar Tarefa'"></x-primary-button>
                </div>
            </form>
        </x-modal>
    </div>
</x-app-layout>