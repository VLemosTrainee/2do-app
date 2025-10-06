<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-100 leading-tight">
            {{ __('Criar Nova Equipa') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-2xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <form action="{{ route('admin.teams.store') }}" method="POST" class="space-y-6">
                        @csrf
                        <div>
                            <x-input-label for="name" :value="__('Nome da Equipa')" />
                            <x-text-input id="name" name="name" type="text" class="mt-1 block w-full" required autofocus />
                        </div>

                        <div>
                            <x-input-label for="members" :value="__('Membros da Equipa')" />
                            <select name="members[]" id="members" multiple class="mt-1 block w-full h-64 border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-brand-primary dark:focus:border-brand-primary focus:ring-brand-primary dark:focus:ring-brand-primary rounded-md shadow-sm">
                                @foreach($users as $user)
                                    <option value="{{ $user->id }}">{{ $user->name }} ({{ $user->email }})</option>
                                @endforeach
                            </select>
                            <p class="mt-2 text-sm text-gray-500 dark:text-gray-400">Segure a tecla Ctrl (ou Cmd no Mac) para selecionar múltiplos utilizadores.</p>
                        </div>
                        
                        <div class="flex items-center gap-4">
                            <x-primary-button>{{ __('Criar Equipa') }}</x-primary-button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>