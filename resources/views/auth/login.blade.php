<x-guest-layout>
    <!-- Header do Formulário -->
    <div class="auth-element text-center mb-8 opacity-0 translate-y-4 transition-all duration-700 ease-out">
        <a href="/">
            <x-application-logo class="w-24 h-auto mx-auto mb-4" />
        </a>
        <h2 class="text-2xl font-bold text-gray-800 dark:text-gray-200">Bem-vindo de volta!</h2>
        <p class="text-gray-600 dark:text-gray-400 mt-1">Faça login para continuar a organizar.</p>
    </div>

    <!-- Status da Sessão (ex: link de reset enviado) -->
    <div class="auth-element mb-4 opacity-0 translate-y-4 transition-all duration-700 ease-out" style="transition-delay: 150ms;">
        <x-auth-session-status :status="session('status')" />
    </div>

    <form method="POST" action="{{ route('login') }}" class="space-y-6">
        @csrf
        <!-- Email -->
        <div class="auth-element opacity-0 translate-y-4 transition-all duration-700 ease-out" style="transition-delay: 200ms;">
            <x-input-label for="email" value="Email" class="sr-only" />
            <x-text-input id="email" type="email" name="email" :value="old('email')" required autofocus autocomplete="username" placeholder="O seu email" class="w-full" />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <!-- Password -->
        <div class="auth-element opacity-0 translate-y-4 transition-all duration-700 ease-out" style="transition-delay: 250ms;">
            <x-input-label for="password" value="Password" class="sr-only" />
            <x-text-input id="password" type="password" name="password" required autocomplete="current-password" placeholder="A sua password" class="w-full" />
            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <!-- Opções (Lembrar-me & Esqueceu-se da password) -->
        <div class="auth-element flex items-center justify-between opacity-0 translate-y-4 transition-all duration-700 ease-out" style="transition-delay: 300ms;">
            <label for="remember_me" class="inline-flex items-center">
                <input id="remember_me" type="checkbox" class="rounded border-gray-300 dark:border-gray-700 text-brand-primary shadow-sm focus:ring-brand-primary dark:focus:ring-offset-gray-800" name="remember">
                <span class="ms-2 text-sm text-gray-600 dark:text-gray-400">Lembrar-me</span>
            </label>
            @if (Route::has('password.request'))
                <a class="page-transition-link underline text-sm text-brand-primary hover:text-opacity-80 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-brand-primary" href="{{ route('password.request') }}">Esqueceu-se da password?</a>
            @endif
        </div>

        <!-- Botão de Ação -->
        <div class="auth-element opacity-0 translate-y-4 transition-all duration-700 ease-out" style="transition-delay: 350ms;">
            <x-primary-button class="w-full justify-center py-3">Entrar</x-primary-button>
        </div>
    </form>
    
    <!-- Link para Registar -->
    <div class="auth-element text-center mt-6 opacity-0 translate-y-4 transition-all duration-700 ease-out" style="transition-delay: 400ms;">
        <p class="text-sm text-gray-600 dark:text-gray-400">
            Não tem uma conta?
            <a href="{{ route('register') }}" class="page-transition-link font-semibold text-brand-primary hover:underline">Crie uma agora.</a>
        </p>
    </div>
</x-guest-layout>