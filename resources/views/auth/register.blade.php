<x-guest-layout>
    <!-- Header do Formulário -->
    <div class="auth-element text-center mb-8 opacity-0 translate-y-4 transition-all duration-700 ease-out">
        <a href="/">
            <x-application-logo class="w-24 h-auto mx-auto mb-4" />
        </a>
        <h2 class="text-2xl font-bold text-gray-800 dark:text-gray-200">Crie a sua conta</h2>
        <p class="text-gray-600 dark:text-gray-400 mt-1">Comece a organizar o seu dia.</p>
    </div>

    <form method="POST" action="{{ route('register') }}" class="space-y-4">
        @csrf
        <!-- Nome -->
        <div class="auth-element opacity-0 translate-y-4 transition-all duration-700 ease-out" style="transition-delay: 150ms;">
            <x-input-label for="name" value="Nome" class="sr-only" />
            <x-text-input id="name" type="text" name="name" :value="old('name')" required autofocus autocomplete="name" placeholder="O seu nome" class="w-full" />
            <x-input-error :messages="$errors->get('name')" class="mt-2" />
        </div>

        <!-- Email -->
        <div class="auth-element opacity-0 translate-y-4 transition-all duration-700 ease-out" style="transition-delay: 200ms;">
            <x-input-label for="email" value="Email" class="sr-only" />
            <x-text-input id="email" type="email" name="email" :value="old('email')" required autocomplete="username" placeholder="O seu email" class="w-full" />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <!-- Password -->
        <div class="auth-element opacity-0 translate-y-4 transition-all duration-700 ease-out" style="transition-delay: 250ms;">
            <x-input-label for="password" value="Password" class="sr-only" />
            <x-text-input id="password" type="password" name="password" required autocomplete="new-password" placeholder="Crie uma password" class="w-full" />
            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <!-- Confirmar Password -->
        <div class="auth-element opacity-0 translate-y-4 transition-all duration-700 ease-out" style="transition-delay: 300ms;">
            <x-input-label for="password_confirmation" value="Confirmar Password" class="sr-only" />
            <x-text-input id="password_confirmation" type="password" name="password_confirmation" required autocomplete="new-password" placeholder="Confirme a password" class="w-full" />
            <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
        </div>
        
        <!-- Botão de Ação -->
        <div class="auth-element opacity-0 translate-y-4 transition-all duration-700 ease-out" style="transition-delay: 350ms;">
            <x-primary-button class="w-full justify-center py-3">Registar</x-primary-button>
        </div>
    </form>
    
    <!-- Link para Login -->
    <div class="auth-element text-center mt-6 opacity-0 translate-y-4 transition-all duration-700 ease-out" style="transition-delay: 400ms;">
        <p class="text-sm text-gray-600 dark:text-gray-400">
            Já tem uma conta?
            <a href="{{ route('login') }}" class="page-transition-link font-semibold text-brand-primary hover:underline">Faça login.</a>
        </p>
    </div>
</x-guest-layout>