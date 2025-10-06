<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-100 leading-tight">
            {{ __('Gestão de Utilizadores') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8" 
             x-data="{ query: '', users: {{ $users->toJson() }}, filteredUsers: {{ $users->toJson() }} }"
             x-init="$watch('query', value => {
                filteredUsers = users.filter(user => 
                    user.name.toLowerCase().includes(value.toLowerCase()) || 
                    user.email.toLowerCase().includes(value.toLowerCase())
                );
             })">
            
            <!-- Campo de Filtro -->
            <div class="mb-6">
                <x-input-label for="search_user" value="Filtrar por Nome ou Email" />
                <x-text-input id="search_user" type="text" class="mt-1 block w-full" 
                              placeholder="Digite para filtrar a lista..." x-model="query" />
            </div>

            <!-- Grelha de Cards Filtrada -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                <template x-for="user in filteredUsers" :key="user.id">
                    <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm rounded-lg p-6 flex flex-col justify-between">
                        <div>
                            <div class="flex items-center justify-between mb-4">
                                <h3 class="font-bold text-lg text-gray-900 dark:text-gray-100" x-text="user.name"></h3>
                                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full"
                                      :class="{
                                        'bg-red-100 text-red-800 dark:bg-red-900 dark:text-red-300': user.role === 'admin',
                                        'bg-yellow-100 text-yellow-800 dark:bg-yellow-900 dark:text-yellow-300': user.role === 'superuser',
                                        'bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-300': user.role === 'user'
                                      }" x-text="user.role.charAt(0).toUpperCase() + user.role.slice(1)"></span>
                            </div>
                            <p class="text-sm text-gray-600 dark:text-gray-400" x-text="user.email"></p>
                        </div>
                        <div class="mt-4 pt-4 border-t border-gray-200 dark:border-gray-700">
                            <p class="text-xs text-gray-500 dark:text-gray-500">Membro desde: <span x-text="new Date(user.created_at).toLocaleDateString('pt-PT')"></span></p>
                        </div>
                    </div>
                </template>

                <!-- Mensagem se não houver resultados -->
                <template x-if="filteredUsers.length === 0">
                    <div class="col-span-full bg-white dark:bg-gray-800 overflow-hidden shadow-sm rounded-lg p-6 text-center">
                        <p class="text-gray-500 dark:text-gray-400">Nenhum utilizador encontrado com o termo "<span x-text="query"></span>".</p>
                    </div>
                </template>
            </div>
        </div>
    </div>
</x-app-layout>