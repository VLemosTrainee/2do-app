<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col sm:flex-row justify-between items-center gap-4">
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-100 leading-tight">
                {{ __('Gestão de Projetos') }}
            </h2>
            <a href="{{ route('admin.projects.create') }}">
                <x-primary-button class="w-full sm:w-auto">{{ __('Criar Novo Projeto') }}</x-primary-button>
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <!-- =============================================== -->
        <!-- INÍCIO: Lógica Alpine.js para o Filtro em Tempo Real -->
        <!-- =============================================== -->
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8"
             x-data="{ 
                query: '', 
                projects: {{ $projects->load('team')->toJson() }}, 
                filteredProjects: {{ $projects->load('team')->toJson() }} 
             }"
             x-init="$watch('query', value => {
                filteredProjects = projects.filter(project => 
                    project.name.toLowerCase().includes(value.toLowerCase()) ||
                    (project.team && project.team.name.toLowerCase().includes(value.toLowerCase()))
                );
             })">

            <!-- Campo de Filtro -->
            <div class="mb-6">
                <x-input-label for="search_project" value="Filtrar por Nome do Projeto ou Equipa" />
                <x-text-input id="search_project" type="text" class="mt-1 block w-full" 
                              placeholder="Digite para filtrar a lista..." x-model="query" />
            </div>
            
            <!-- =============================================== -->
            <!-- FIM: Lógica Alpine.js -->
            <!-- =============================================== -->

            <!-- Grelha de Cards Filtrada -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                <!-- O loop agora é feito com a diretiva x-for do Alpine.js -->
                <template x-for="project in filteredProjects" :key="project.id">
                    <a :href="`/admin/projects/${project.id}`" class="block bg-white dark:bg-gray-800 overflow-hidden shadow-sm rounded-lg transition-transform hover:scale-105 hover:shadow-lg">
                        <div class="p-6">
                            <h3 class="font-bold text-lg text-gray-900 dark:text-gray-100 truncate" x-text="project.name"></h3>
                            <p class="text-sm text-gray-600 dark:text-gray-400 mt-2">Equipa: <span class="font-semibold" x-text="project.team ? project.team.name : 'N/A'"></span></p>
                            <p class="text-sm text-gray-600 dark:text-gray-400">Prazo: <span class="font-semibold" x-text="new Date(project.end_date).toLocaleDateString('pt-PT')"></span></p>
                            <div class="mt-4 pt-4 border-t border-gray-200 dark:border-gray-700 text-center">
                                <span class="text-brand-primary font-semibold">Ver Tarefas &rarr;</span>
                            </div>
                        </div>
                    </a>
                </template>

                <!-- Mensagem se não houver resultados para a pesquisa -->
                <template x-if="filteredProjects.length === 0">
                    <div class="col-span-full bg-white dark:bg-gray-800 overflow-hidden shadow-sm rounded-lg p-6 text-center">
                        <p class="text-gray-500 dark:text-gray-400" x-show="query !== ''">Nenhum projeto encontrado com o termo "<span x-text="query"></span>".</p>
                        <p class="text-gray-500 dark:text-gray-400" x-show="query === '' && projects.length === 0">Nenhum projeto criado.</p>
                        <a x-show="query === '' && projects.length === 0" href="{{ route('admin.projects.create') }}" class="mt-4 inline-block">
                            <x-primary-button>{{ __('Crie o primeiro!') }}</x-primary-button>
                        </a>
                    </div>
                </template>
            </div>
        </div>
    </div>
</x-app-layout>