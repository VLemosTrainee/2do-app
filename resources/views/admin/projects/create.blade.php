<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-100 leading-tight">
            {{ __('Criar Novo Projeto') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-2xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <form action="{{ route('admin.projects.store') }}" method="POST" class="space-y-6">
                        @csrf
                        <div>
                            <x-input-label for="name" :value="__('Nome do Projeto')" />
                            <x-text-input id="name" name="name" type="text" class="mt-1 block w-full" required />
                        </div>
                        <div>
                            <x-input-label for="description" :value="__('Descrição')" />
                            <textarea id="description" name="description" rows="4" class="mt-1 block w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-brand-primary dark:focus:border-brand-primary focus:ring-brand-primary dark:focus:ring-brand-primary rounded-md shadow-sm"></textarea>
                        </div>
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                            <div>
                                <x-input-label for="start_date" :value="__('Data de Início')" />
                                <x-text-input id="start_date" name="start_date" type="date" class="mt-1 block w-full" required />
                            </div>
                            <div>
                                <x-input-label for="end_date" :value="__('Data de Entrega')" />
                                <x-text-input id="end_date" name="end_date" type="date" class="mt-1 block w-full" required />
                            </div>
                        </div>
                        <div>
                            <x-input-label for="team_id" :value="__('Atribuir à Equipa')" />
                            <select id="team_id" name="team_id" class="mt-1 block w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-brand-primary dark:focus:border-brand-primary focus:ring-brand-primary dark:focus:ring-brand-primary rounded-md shadow-sm" required>
                                <option value="" disabled selected>Selecione uma equipa</option>
                                @foreach($teams as $team)
                                    <option value="{{ $team->id }}">{{ $team->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="flex items-center gap-4">
                            <x-primary-button>{{ __('Criar Projeto') }}</x-primary-button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>