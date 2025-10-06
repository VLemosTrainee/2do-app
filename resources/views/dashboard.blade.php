<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-100 leading-tight">
            {{ __('Dashboard Administrativa de Tarefas') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-10">

            <!-- ========================================================== -->
            <!-- 1. CARDS DE KPIS (KEY PERFORMANCE INDICATORS) -->
            <!-- ========================================================== -->
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
                
                <!-- KPI 1: Total de Tarefas -->
                <div class="bg-white dark:bg-gray-800 p-6 rounded-xl shadow-lg border-l-4 border-indigo-500 transition hover:shadow-xl">
                    <p class="text-sm font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">Total de Tarefas</p>
                    <div class="mt-1 flex items-center justify-between">
                        <span class="text-3xl font-bold text-gray-900 dark:text-gray-100">{{ $totalTasks }}</span>
                        <svg class="w-8 h-8 text-indigo-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2m-9 0V3h4m0 2h4"/></svg>
                    </div>
                </div>

                <!-- KPI 2: Tarefas Concluídas -->
                <div class="bg-white dark:bg-gray-800 p-6 rounded-xl shadow-lg border-l-4 border-green-500 transition hover:shadow-xl">
                    <p class="text-sm font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">Concluídas</p>
                    <div class="mt-1 flex items-center justify-between">
                        <span class="text-3xl font-bold text-gray-900 dark:text-gray-100">{{ $completedTasksCount }}</span>
                        <svg class="w-8 h-8 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                    </div>
                </div>

                <!-- KPI 3: Tarefas Pendentes -->
                <div class="bg-white dark:bg-gray-800 p-6 rounded-xl shadow-lg border-l-4 border-yellow-500 transition hover:shadow-xl">
                    <p class="text-sm font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">Pendentes</p>
                    <div class="mt-1 flex items-center justify-between">
                        <span class="text-3xl font-bold text-gray-900 dark:text-gray-100">{{ $pendingTasksCount }}</span>
                        <svg class="w-8 h-8 text-yellow-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                    </div>
                </div>
                
                <!-- KPI 4: Progresso -->
                @php
                    $percentage = ($totalTasks > 0) ? round(($completedTasksCount / $totalTasks) * 100) : 0;
                @endphp
                <div class="bg-white dark:bg-gray-800 p-6 rounded-xl shadow-lg border-l-4 border-purple-500 transition hover:shadow-xl">
                    <p class="text-sm font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">Progresso Geral</p>
                    <div class="mt-1 flex items-center justify-between">
                        <span class="text-3xl font-bold text-gray-900 dark:text-gray-100">{{ $percentage }}%</span>
                        <svg class="w-8 h-8 text-purple-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M3 14h18m-9-4v8"/></svg>
                    </div>
                </div>
            </div>

            <!-- ========================================================== -->
            <!-- 2. NAVEGAÇÃO RÁPIDA DE ADMINISTRAÇÃO (CORES INTENSAS) -->
            <!-- ========================================================== -->
            <h3 class="font-semibold text-lg text-gray-800 dark:text-gray-100 mt-8 mb-4">Acessos Rápidos de Gestão</h3>
            <div class="grid grid-cols-2 sm:grid-cols-4 gap-6">
                
                {{-- Botão 1: Gerir Usuários (Teal Intenso) --}}
                <a href="{{ route('admin.users.index') }}" 
                   class="flex flex-col items-center justify-center p-6 bg-white dark:bg-gray-800 rounded-xl shadow-xl ring-2 ring-teal-500/50 
                          transform hover:shadow-2xl hover:bg-teal-600 hover:-translate-y-1 transition duration-300 group">
                    <svg class="w-10 h-10 text-teal-600 dark:text-teal-400 group-hover:text-white transition duration-300" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M15 19.128a9.38 9.38 0 0 0 2.625.372 9.337 9.337 0 0 0 4.125-.97C20.625 18.045 19.75 18 18.75 18c-2.483 0-4.5 2.017-4.5 4.5v.5H4.5v-.5a4.5 4.5 0 0 1 4.5-4.5h6zM12 11.25a3 3 0 1 0 0-6 3 3 0 0 0 0 6z" />
                    </svg>
                    <span class="mt-3 text-sm font-semibold text-gray-800 dark:text-gray-200 group-hover:text-white transition duration-300">
                        Gerir Usuários
                    </span>
                </a>

                {{-- Botão 2: Gerir Projetos (Cyan Intenso) --}}
                <a href="{{ route('admin.projects.index') }}" 
                   class="flex flex-col items-center justify-center p-6 bg-white dark:bg-gray-800 rounded-xl shadow-xl ring-2 ring-cyan-500/50 
                          transform hover:shadow-2xl hover:bg-cyan-600 hover:-translate-y-1 transition duration-300 group">
                    <svg class="w-10 h-10 text-cyan-600 dark:text-cyan-400 group-hover:text-white transition duration-300" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M3.75 12h16.5m-16.5 0a2.25 2.25 0 0 0 0 4.5h16.5a2.25 2.25 0 0 0 0-4.5m-16.5 0a2.25 2.25 0 0 1 0-4.5h16.5a2.25 2.25 0 0 1 0 4.5m-16.5 4.5a2.25 2.25 0 0 0 0 4.5h16.5a2.25 2.25 0 0 0 0-4.5" />
                    </svg>
                    <span class="mt-3 text-sm font-semibold text-gray-800 dark:text-gray-200 group-hover:text-white transition duration-300">
                        Gerir Projetos
                    </span>
                </a>
                
                {{-- Botão 3: Gerir Equipes (Verde, Alto Contraste para Pessoas) --}}
                <a href="{{ route('admin.teams.index') }}" 
                   class="flex flex-col items-center justify-center p-6 bg-white dark:bg-gray-800 rounded-xl shadow-xl ring-2 ring-green-500/50 
                          transform hover:shadow-2xl hover:bg-green-600 hover:-translate-y-1 transition duration-300 group">
                    <svg class="w-10 h-10 text-green-600 dark:text-green-400 group-hover:text-white transition duration-300" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M17.982 18.725A7.488 7.488 0 0 0 12 15.75a7.488 7.488 0 0 0-5.982 2.975m11.963 0a7.5 7.5 0 1 0-11.963 0m11.963 0A8.966 8.966 0 0 1 12 21a8.966 8.966 0 0 1-5.982-2.325M12 7.5a3 3 0 1 0 0-6 3 3 0 0 0 0 6Z" />
                    </svg>
                    <span class="mt-3 text-sm font-semibold text-gray-800 dark:text-gray-200 group-hover:text-white transition duration-300">
                        Gerir Equipes
                    </span>
                </a>
                
                {{-- Botão 4: Gerir Tarefas (Roxo Intenso) --}}
                <a href="{{ route('admin.tasks.index') }}" 
                   class="flex flex-col items-center justify-center p-6 bg-white dark:bg-gray-800 rounded-xl shadow-xl ring-2 ring-purple-500/50 
                          transform hover:shadow-2xl hover:bg-purple-600 hover:-translate-y-1 transition duration-300 group">
                    <svg class="w-10 h-10 text-purple-600 dark:text-purple-400 group-hover:text-white transition duration-300" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M9 12h3.75M9 15h3.75M9 18h3.75m3-6h.008v.008H15v-.008Zm0 3h.008v.008H15v-.008Zm0 3h.008v.008H15v-.008Zm-9.75-9.75h10.5a2.25 2.25 0 0 1 2.25 2.25v10.5a2.25 2.25 0 0 1-2.25 2.25H5.25a2.25 2.25 0 0 1-2.25-2.25V7.5a2.25 2.25 0 0 1 2.25-2.25Z" />
                    </svg>
                    <span class="mt-3 text-sm font-semibold text-gray-800 dark:text-gray-200 group-hover:text-white transition duration-300">
                        Gerir Tarefas
                    </span>
                </a>
            </div>
            
            <hr class="dark:border-gray-700">


            <!-- ========================================================== -->
            <!-- 3. DISTRIBUIÇÃO DE PRIORIDADES (NÚMEROS FIXOS GIGANTES) -->
            <!-- ========================================================== -->
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">

                <!-- Coluna 1: DISTRIBUIÇÃO DE PRIORIDADES (2/3 da largura em telas grandes) -->
                <div class="lg:col-span-2 space-y-6">
                    
                    <div class="bg-white dark:bg-gray-800 p-6 rounded-xl shadow-lg">
                        <h3 class="text-lg font-semibold text-gray-900 dark:text-gray-100 mb-4 border-b dark:border-gray-700 pb-2">Distribuição de Prioridades</h3>
                        
                        <!-- Contadores Fixos Gigantes (Substituindo o Count Up) -->
                        <div class="grid grid-cols-3 gap-4 py-6 items-end"> 
                            
                            {{-- Alta Prioridade --}}
                            <div class="text-center">
                                <div class="mb-4">
                                    <span class="text-8xl font-extrabold leading-none text-red-400 dark:text-red-400">
                                        {{ $tasksByPriority['alta'] }}
                                    </span>
                                </div>
                                <span class="text-lg font-bold text-red-500">Alta</span>
                            </div>
                            
                            {{-- Média Prioridade --}}
                            <div class="text-center">
                                <div class="mb-4">
                                    <span class="text-8xl font-extrabold leading-none text-yellow-400 dark:text-yellow-400">
                                        {{ $tasksByPriority['media'] }}
                                    </span>
                                </div>
                                <span class="text-lg font-bold text-yellow-500">Média</span>
                            </div>
                            
                            {{-- Baixa Prioridade --}}
                            <div class="text-center">
                                <div class="mb-4">
                                    <span class="text-8xl font-extrabold leading-none text-blue-600 dark:text-blue-400">
                                        {{ $tasksByPriority['baixa'] }}
                                    </span>
                                </div>
                                <span class="text-lg font-bold text-blue-500">Baixa</span>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Coluna 2: Tarefas Urgentes (1/3 da largura em telas grandes) -->
                <div class="lg:col-span-1">
                    <div class="bg-white dark:bg-gray-800 p-6 rounded-xl shadow-lg h-full">
                        <h3 class="text-lg font-semibold text-gray-900 dark:text-gray-100 mb-4 border-b dark:border-gray-700 pb-2">Tarefas Mais Urgentes (Próximas 2 Semanas)</h3>
                        
                        @if($urgentTasks->isEmpty())
                            <p class="text-gray-500 dark:text-gray-400 text-sm">Não há tarefas urgentes pendentes no momento.</p>
                        @else
                            <ul class="space-y-3">
                                @foreach($urgentTasks as $task)
                                    <li class="p-3 bg-gray-50 dark:bg-gray-700 rounded-lg shadow-sm hover:bg-gray-100 dark:hover:bg-gray-600 transition duration-150">
                                        <p class="font-medium text-gray-900 dark:text-gray-100 text-sm truncate" 
                                           title="{{ $task->title }}">
                                           {{ $task->title }}
                                        </p>
                                        <div class="flex justify-between items-center text-xs mt-1">
                                            <span class="text-gray-600 dark:text-gray-400">
                                                Vence: {{ \Carbon\Carbon::parse($task->due_date)->format('d/m/Y') }}
                                            </span>
                                            <span class="px-2 py-0.5 text-xs font-semibold rounded-full 
                                                @if($task->priority == 'alta') bg-red-100 text-red-800 dark:bg-red-900 dark:text-red-300
                                                @elseif($task->priority == 'media') bg-yellow-100 text-yellow-800 dark:bg-yellow-900 dark:text-yellow-300
                                                @else bg-blue-100 text-blue-800 dark:bg-blue-900 dark:text-blue-300
                                                @endif">
                                                {{ ucfirst($task->priority) }}
                                            </span>
                                        </div>
                                    </li>
                                @endforeach
                            </ul>
                            
                            <div class="mt-4 text-right">
                                <a href="{{ route('admin.tasks.index') }}" class="text-sm font-medium text-indigo-600 dark:text-indigo-400 hover:text-indigo-500">
                                    Ir para Gestão de Tarefas &rarr;
                                </a>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
            
        </div>
    </div>
</x-app-layout>

{{-- O bloco scripts agora está vazio ou pode ser removido --}}
{{-- @push('scripts') --}}
{{-- @endpush --}}