<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col sm:flex-row justify-between items-center gap-4">
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-100 leading-tight">
                {{ __('Gestão de Equipas') }}
            </h2>
            <a href="{{ route('admin.teams.create') }}"><x-primary-button class="w-full sm:w-auto">{{ __('Criar Nova Equipa') }}</x-primary-button></a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8"
             x-data="{ query: '', teams: {{ $teams->toJson() }}, filteredTeams: {{ $teams->toJson() }} }"
             x-init="$watch('query', value => {
                filteredTeams = teams.filter(team => 
                    team.name.toLowerCase().includes(value.toLowerCase())
                );
             })">
            
            <!-- Campo de Filtro -->
            <div class="mb-6">
                <x-input-label for="search_team" value="Filtrar por Nome da Equipa" />
                <x-text-input id="search_team" type="text" class="mt-1 block w-full" 
                              placeholder="Digite para filtrar a lista..." x-model="query" />
            </div>

            <!-- Grelha de Cards Filtrada -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                <template x-for="team in filteredTeams" :key="team.id">
                    <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm rounded-lg p-6">
                        <h3 class="font-bold text-lg text-gray-900 dark:text-gray-100 truncate" x-text="team.name"></h3>
                        <p class="text-sm text-gray-600 dark:text-gray-400 mt-2 font-semibold">Membros (<span x-text="team.members.length"></span>):</p>
                        <ul class="mt-2 space-y-1 text-sm text-gray-700 dark:text-gray-300">
                            <template x-for="member in team.members.slice(0, 5)" :key="member.id">
                                <li class="truncate" x-text="member.name"></li>
                            </template>
                            <template x-if="team.members.length > 5">
                                <li class="text-gray-400 text-xs" x-text="'+ ' + (team.members.length - 5) + ' outros'"></li>
                            </template>
                        </ul>
                    </div>
                </template>

                 <!-- Mensagem se não houver resultados -->
                <template x-if="filteredTeams.length === 0">
                    <div class="col-span-full bg-white dark:bg-gray-800 overflow-hidden shadow-sm rounded-lg p-6 text-center">
                        <p class="text-gray-500 dark:text-gray-400">Nenhuma equipa encontrada com o termo "<span x-text="query"></span>".</p>
                    </div>
                </template>
            </div>
        </div>
    </div>
</x-app-layout>