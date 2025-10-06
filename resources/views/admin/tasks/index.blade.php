<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col sm:flex-row justify-between items-center gap-4">
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-100 leading-tight">
                {{ __('Gestão de Tarefas') }}
            </h2>
            <!-- Botão para abrir a página de criação (Rota Corrigida) -->
            <a href="{{ route('admin.tasks.create') }}" class="w-full sm:w-auto inline-flex items-center px-4 py-2 bg-gray-800 dark:bg-gray-200 border border-transparent rounded-md font-semibold text-xs text-white dark:text-gray-800 uppercase tracking-widest hover:bg-gray-700 dark:hover:bg-white focus:bg-gray-700 dark:focus:bg-white active:bg-gray-900 dark:active:bg-gray-300 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 dark:focus:ring-offset-gray-800 transition ease-in-out duration-150">
                {{ __('Criar Nova Tarefa') }}
            </a>
        </div>
    </x-slot>

    <!-- ========================================================== -->
    <!-- INÍCIO: Lógica Alpine.js (Filtro e Edição Modal) -->
    <!-- ========================================================== -->
    <div class="py-12" 
         x-data="{
            // Dados para o filtro
            query: '',
            tasks: {{ $tasks->load('project.team', 'assignees')->toJson() }},
            filteredTasks: {{ $tasks->load('project.team', 'assignees')->toJson() }},
            
            filterTasks() {
                if (this.query.length < 2) {
                    this.filteredTasks = this.tasks;
                    return;
                }
                this.filteredTasks = this.tasks.filter(task => {
                    const searchTerm = this.query.toLowerCase();
                    const inTitle = task.title.toLowerCase().includes(searchTerm);
                    const inProject = task.project && task.project.name.toLowerCase().includes(searchTerm);
                    const inTeam = task.project && task.project.team && task.project.team.name.toLowerCase().includes(searchTerm);
                    const inAssignees = task.assignees.some(assignee => assignee.name.toLowerCase().includes(searchTerm));
                    return inTitle || inProject || inTeam || inAssignees;
                });
            },

            // Dados para o modal de edição
            isEditing: true, 
            taskToEdit: { id: null, title: '', project_id: '', priority: 'media', due_date: '', assignees: [], completed_at: null, description: '' },
            teamMembers: [],
            isLoadingMembers: false,
            
            openModal(task) {
                this.isEditing = true;
                // Clona o objeto e garante que a data está formatada para o input[type=date]
                let clonedTask = JSON.parse(JSON.stringify(task)); 
                if (clonedTask.due_date) {
                    clonedTask.due_date = clonedTask.due_date.split('T')[0];
                }
                this.taskToEdit = clonedTask;
                this.fetchMembers(task.project_id);
                $dispatch('open-modal', { name: 'task-form-modal' });
            },

            fetchMembers(projectId) {
                if (!projectId) { this.teamMembers = []; return; }
                this.isLoadingMembers = true;
                fetch(`/admin/projects/${projectId}/team-members`)
                    .then(response => response.json())
                    .then(data => {
                        this.teamMembers = data;
                        this.isLoadingMembers = false;
                    });
            }
         }"
         @edit-task.window="openModal($event.detail)">

        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-8">
            <!-- Card da Lista de Tarefas Existentes -->
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <h3 class="font-semibold text-lg pb-3 mb-4 dark:border-gray-700">Todas as Tarefas</h3>

                    <!-- Campo de Filtro "Live" -->
                    <div class="mb-6">
                        <x-input-label for="search_task" value="Filtrar por Tarefa, Projeto, Equipa ou Membro" />
                        <x-text-input id="search_task" type="text" class="mt-1 block w-full" 
                                      placeholder="Digite 2 ou mais caracteres para filtrar..." 
                                      x-model="query" 
                                      x-on:input.debounce.300ms="filterTasks()" />
                    </div>

                    <!-- Lista de Tarefas Filtrada -->
                    <div class="space-y-4">
                        <template x-for="task in filteredTasks" :key="task.id">
                            <!-- Ao clicar, disparamos a edição -->
                            <div @click="$dispatch('edit-task', task)" 
                                 class="flex items-center p-4 bg-white dark:bg-gray-800/50 rounded-lg shadow-sm border border-gray-200 dark:border-gray-700/50 cursor-pointer hover:shadow-md transition-all duration-300"
                                 :class="{ 'opacity-60': task.completed_at }">
                                
                                {{-- ** Checkbox de conclusão REMOVIDO daqui --}}

                                <div class="flex-grow">
                                    <div class="flex items-center justify-between">
                                        <p class="font-semibold text-lg text-gray-900 dark:text-gray-100" 
                                           :class="{ 'line-through': task.completed_at }" 
                                           x-text="task.title">
                                        </p>
                                        <div class="flex items-center space-x-2 text-sm">
                                            
                                            <!-- Indicador de Status (Adicionado) -->
                                            <span class="px-2 py-1 text-xs font-semibold rounded-full" 
                                                  :class="task.completed_at ? 'bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-300' : 'bg-red-100 text-red-800 dark:bg-red-900 dark:text-red-300'" 
                                                  x-text="task.completed_at ? 'Concluída' : 'Pendente'">
                                            </span>

                                            <!-- Prioridade -->
                                            <span class="px-2 py-1 text-xs font-semibold rounded-full" 
                                                  :class="{
                                                    'bg-red-100 text-red-800 dark:bg-red-900 dark:text-red-300': task.priority === 'alta',
                                                    'bg-yellow-100 text-yellow-800 dark:bg-yellow-900 dark:text-yellow-300': task.priority === 'media',
                                                    'bg-blue-100 text-blue-800 dark:bg-blue-900 dark:text-blue-300': task.priority === 'baixa',
                                                  }" x-text="task.priority.charAt(0).toUpperCase() + task.priority.slice(1)">
                                            </span>
                                            
                                            <!-- Data de Vencimento -->
                                            <template x-if="task.due_date">
                                                <span class="text-gray-500 dark:text-gray-400">
                                                    Vence: <span x-text="new Date(task.due_date).toLocaleDateString('pt-PT')"></span>
                                                </span>
                                            </template>
                                        </div>
                                    </div>

                                    <template x-if="task.description"><p class="text-sm text-gray-600 dark:text-gray-400 mt-1" x-text="task.description"></p></template>
                                    
                                    <!-- Atribuídos e Detalhes do Projeto/Equipe -->
                                    <div class="mt-3 flex flex-wrap items-center space-x-4 text-xs text-gray-500 dark:text-gray-400">
                                        <template x-if="task.project">
                                            <span x-text="'Projeto: ' + task.project.name" class="font-semibold"></span>
                                        </template>
                                        
                                        <template x-if="task.assignees && task.assignees.length > 0">
                                            <div class="flex items-center space-x-2">
                                                <span class="font-semibold">Atribuído a:</span>
                                                <div class="flex -space-x-2">
                                                    <template x-for="assignee in task.assignees.slice(0, 3)" :key="assignee.id">
                                                        <div class="w-6 h-6 bg-gray-200 dark:bg-gray-700 rounded-full flex items-center justify-center text-xs font-bold text-gray-600 dark:text-gray-300 ring-2 ring-white dark:ring-gray-800" :title="assignee.name">
                                                            <span x-text="assignee.name.charAt(0).toUpperCase()"></span>
                                                        </div>
                                                    </template>
                                                    <template x-if="task.assignees.length > 3">
                                                        <div class="w-6 h-6 bg-gray-300 dark:bg-gray-600 rounded-full flex items-center justify-center text-xs font-bold text-gray-500 dark:text-gray-200 ring-2 ring-white dark:ring-gray-800" :title="'+' + (task.assignees.length - 3) + ' outros'">
                                                            <span x-text="'+' + (task.assignees.length - 3)"></span>
                                                        </div>
                                                    </template>
                                                </div>
                                            </div>
                                        </template>
                                    </div>
                                </div>

                                <!-- Botão de Apagar (com @click.stop para evitar o modal) -->
                                <div class="flex-shrink-0 ml-4 flex items-center space-x-2" @click.stop>
                                    <form :action="`/tasks/${task.id}`" method="POST">
                                        @csrf @method('DELETE')
                                        <button type="submit" class="text-gray-400 hover:text-red-500" title="Apagar Tarefa" onclick="return confirm('Tem a certeza?')">
                                            <svg class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor"><path fill-rule="evenodd" d="M9 2a1 1 0 00-.894.553L7.382 4H4a1 1 0 000 2v10a2 2 0 002 2h8a2 2 0 002-2V6a1 1 0 100-2h-3.382l-.724-1.447A1 1 0 0011 2H9zM7 8a1 1 0 012 0v6a1 1 0 11-2 0V8zm5-1a1 1 0 00-1 1v6a1 1 0 102 0V8a1 1 0 00-1-1z" clip-rule="evenodd" /></svg>
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </template>
                        
                        <template x-if="filteredTasks.length === 0">
                            <div class="text-center py-8 text-gray-500">
                                <p x-show="query === ''">Nenhuma tarefa encontrada.</p>
                                <p x-show="query !== ''">Nenhuma tarefa encontrada para "<span x-text="query" class="font-semibold"></span>".</p>
                            </div>
                        </template>
                    </div>

                    <div class="mt-6">
                         {{-- Paginação... --}}
                    </div>
                </div>
            </div>
        </div>
        
        <!-- MODAL PARA EDITAR TAREFA -->
        <x-modal name="task-form-modal" focusable>
            <form :action="`/tasks/${taskToEdit.id}`" method="POST" class="p-6 space-y-6">
                @csrf
                <input type="hidden" name="_method" value="PATCH">
                
                <h2 class="text-lg font-medium text-gray-900 dark:text-gray-100">{{ __('Editar Tarefa') }}</h2>
                
                <!-- CHECKBOX DE CONCLUSÃO (MOVIMENTADO PARA O MODAL) -->
                <div class="pt-4 pb-2 border-b dark:border-gray-700">
                    <label class="flex items-center">
                        <!-- O nome do campo é 'completed', você deve processar isto no seu TaskController@update -->
                        <input type="checkbox" name="completed" value="1" 
                               :checked="!!taskToEdit.completed_at"
                               class="rounded dark:bg-gray-900 border-gray-300 dark:border-gray-700 text-indigo-600 shadow-sm focus:ring-indigo-500 dark:focus:ring-indigo-600 dark:focus:ring-offset-gray-800">
                        <span class="ms-2 text-sm text-gray-600 dark:text-gray-400 font-medium">Tarefa Concluída?</span>
                    </label>
                    <template x-if="taskToEdit.completed_at">
                        <p class="text-xs text-gray-500 mt-1">Concluída em: <span x-text="new Date(taskToEdit.completed_at).toLocaleString('pt-PT', { year: 'numeric', month: 'short', day: 'numeric', hour: '2-digit', minute: '2-digit' })"></span></p>
                    </template>
                </div>
                
                <div>
                    <x-input-label for="project_id" value="Projeto" />
                    <!-- ID do Projeto continua desabilitado para edição -->
                    <select id="project_id" name="project_id" x-model="taskToEdit.project_id" class="mt-1 block w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-brand-primary dark:focus:border-brand-primary focus:ring-brand-primary dark:focus:ring-brand-primary rounded-md shadow-sm" disabled>
                        <option value="" disabled>-- Escolha um projeto --</option>
                        @foreach($projects as $project)
                            <option value="{{ $project->id }}">{{ $project->name }}</option>
                        @endforeach
                    </select>
                </div>
                
                <div>
                    <x-input-label for="title" value="Título da Tarefa" />
                    <x-text-input id="title" name="title" type="text" class="mt-1 block w-full" x-model="taskToEdit.title" required />
                </div>
                
                <div>
                    <x-input-label for="description" value="Descrição" />
                    <textarea id="description" name="description" rows="3" class="mt-1 block w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-brand-primary dark:focus:border-brand-primary focus:ring-brand-primary dark:focus:ring-brand-primary rounded-md shadow-sm" x-model="taskToEdit.description"></textarea>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div>
                        <x-input-label for="due_date" value="Data de Vencimento" />
                        <x-text-input id="due_date" name="due_date" type="date" class="mt-1 block w-full" x-model="taskToEdit.due_date" />
                    </div>
                    <div>
                        <x-input-label for="priority" value="Prioridade" />
                        <select id="priority" name="priority" x-model="taskToEdit.priority" class="mt-1 block w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-brand-primary dark:focus:border-brand-primary focus:ring-brand-primary dark:focus:ring-brand-primary rounded-md shadow-sm">
                            <option value="baixa">Baixa</option><option value="media">Média</option><option value="alta">Alta</option>
                        </select>
                    </div>
                </div>

                <div>
                    <x-input-label for="assignees" value="Atribuir a Membros" />
                    <select name="assignees[]" id="assignees" multiple :disabled="!taskToEdit.project_id || isLoadingMembers" class="mt-1 block w-full h-32 border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-brand-primary dark:focus:border-brand-primary focus:ring-brand-primary dark:focus:ring-brand-primary rounded-md shadow-sm">
                        <template x-for="member in teamMembers" :key="member.id">
                            <option :value="member.id" x-text="member.name" :selected="taskToEdit.assignees.map(a => a.id).includes(member.id)"></option>
                        </template>
                    </select>
                </div>
                
                <div class="flex justify-end pt-4 border-t dark:border-gray-700">
                    <x-secondary-button type="button" x-on:click="$dispatch('close')">{{ __('Cancelar') }}</x-secondary-button>
                    <x-primary-button class="ms-3">{{ __('Salvar Alterações') }}</x-primary-button>
                </div>
            </form>
        </x-modal>
    </div>
</x-app-layout>