<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-100 leading-tight">
            {{ __('Criar Nova Tarefa') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    
                    @php
                        // Prepara os IDs antigos para serem usados pelo Alpine/JS
                        $oldAssigneeIds = collect(old('assignees'));
                    @endphp

                    <form action="{{ route('tasks.store') }}" method="POST" class="space-y-6" 
                          x-data="{ 
                            projectId: '{{ old('project_id') }}',
                            teamMembers: [],
                            isLoadingMembers: false,
                            oldAssigneeIds: @js($oldAssigneeIds), // Passa o array de IDs antigos para o Alpine
                            
                            init() {
                                // Carrega membros se houver um projeto_id antigo após falha de validação
                                if (this.projectId) {
                                    this.fetchMembers(this.projectId);
                                }
                            },
                            
                            fetchMembers(projectId) {
                                if (!projectId) { this.teamMembers = []; return; }
                                this.isLoadingMembers = true;
                                // Rota para buscar membros do projeto
                                fetch(`/admin/projects/${projectId}/team-members`) 
                                    .then(response => response.json())
                                    .then(data => {
                                        this.teamMembers = data;
                                        this.isLoadingMembers = false;
                                    });
                            }
                          }">
                        
                        @csrf
                        
                        <!-- Campo Projeto -->
                        <div>
                            <x-input-label for="project_id" value="Projeto" />
                            <select id="project_id" name="project_id" x-model="projectId" @change="fetchMembers(projectId)" class="mt-1 block w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm" required>
                                <option value="" disabled>-- Escolha um projeto --</option>
                                @foreach($projects as $project)
                                    <option value="{{ $project->id }}" {{ old('project_id') == $project->id ? 'selected' : '' }}>{{ $project->name }}</option>
                                @endforeach
                            </select>
                            <x-input-error :messages="$errors->get('project_id')" class="mt-2" />
                        </div>
                        
                        <!-- Campo Título -->
                        <div>
                            <x-input-label for="title" value="Título da Tarefa" />
                            <x-text-input id="title" name="title" type="text" class="mt-1 block w-full" :value="old('title')" required autofocus />
                            <x-input-error :messages="$errors->get('title')" class="mt-2" />
                        </div>
                        
                        <!-- Descrição -->
                        <div>
                            <x-input-label for="description" value="Descrição (Opcional)" />
                            <textarea id="description" name="description" rows="3" class="mt-1 block w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm">{{ old('description') }}</textarea>
                            <x-input-error :messages="$errors->get('description')" class="mt-2" />
                        </div>

                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                            <!-- Data de Vencimento -->
                            <div>
                                <x-input-label for="due_date" value="Data de Vencimento" />
                                <x-text-input id="due_date" name="due_date" type="date" class="mt-1 block w-full" :value="old('due_date')" />
                                <x-input-error :messages="$errors->get('due_date')" class="mt-2" />
                            </div>
                            <!-- Prioridade -->
                            <div>
                                <x-input-label for="priority" value="Prioridade" />
                                <select id="priority" name="priority" class="mt-1 block w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm">
                                    @php $selectedPriority = old('priority', 'media'); @endphp
                                    <option value="baixa" {{ $selectedPriority == 'baixa' ? 'selected' : '' }}>Baixa</option>
                                    <option value="media" {{ $selectedPriority == 'media' ? 'selected' : '' }}>Média</option>
                                    <option value="alta" {{ $selectedPriority == 'alta' ? 'selected' : '' }}>Alta</option>
                                </select>
                                <x-input-error :messages="$errors->get('priority')" class="mt-2" />
                            </div>
                        </div>

                        <!-- Atribuir a Membros -->
                        <div>
                            <x-input-label for="assignees" value="Atribuir a Membros da Equipa (Múltipla Seleção)" />
                            <select name="assignees[]" id="assignees" multiple :disabled="!projectId || isLoadingMembers" class="mt-1 block w-full h-32 border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm">
                                <template x-if="isLoadingMembers">
                                    <option disabled>A carregar membros...</option>
                                </template>
                                <template x-if="!projectId && !isLoadingMembers">
                                    <option disabled>Selecione um projeto primeiro</option>
                                </template>
                                <template x-for="member in teamMembers" :key="member.id">
                                    <!-- CORRIGIDO: Usa a variável oldAssigneeIds do Alpine para verificar se o ID do membro está no array -->
                                    <option :value="member.id" x-text="member.name"
                                            :selected="oldAssigneeIds.includes(member.id.toString())">
                                    </option>
                                </template>
                            </select>
                            <x-input-error :messages="$errors->get('assignees')" class="mt-2" />
                        </div>
                        
                        <div class="flex justify-end pt-4">
                            <!-- Botão Voltar Corrigido usando tag <a> com estilos de secondary-button -->
                            <a href="{{ route('admin.tasks.index') }}" 
                               class="inline-flex items-center px-4 py-2 bg-white dark:bg-gray-800 border border-gray-300 dark:border-gray-500 rounded-md font-semibold text-xs text-gray-700 dark:text-gray-300 uppercase tracking-widest shadow-sm hover:bg-gray-50 dark:hover:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 dark:focus:ring-offset-gray-800 disabled:opacity-25 transition ease-in-out duration-150 ms-3">
                                {{ __('Voltar') }}
                            </a>
                            <x-primary-button class="ms-3">{{ __('Criar Tarefa') }}</x-primary-button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>