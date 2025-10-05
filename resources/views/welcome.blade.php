<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="h-full">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>2Do - Dê play no seu dia</title>

    <!-- Fonts & Styles -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,600,700&display.swap" rel="stylesheet" />
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="antialiased font-sans h-full bg-brand-light dark:bg-brand-dark text-brand-dark dark:text-brand-light">
    
    <!-- Header com links de navegação -->
    <header id="welcome-header" class="absolute top-0 right-0 p-6 lg:p-8 w-full z-20 opacity-0 transition-opacity duration-700">
        @if (Route::has('login'))
            <nav class="flex items-center justify-end space-x-4">
                @auth
                    <a href="{{ url('/dashboard') }}" class="page-transition-link px-5 py-2 text-sm font-semibold rounded-md ring-1 ring-transparent transition hover:text-brand-primary focus:outline-none focus-visible:ring-brand-primary">Dashboard</a>
                @else
                    <a href="{{ route('login') }}" class="page-transition-link px-5 py-2 text-sm font-semibold rounded-md ring-1 ring-transparent transition hover:text-brand-primary focus:outline-none focus-visible:ring-brand-primary">Log in</a>
                    @if (Route::has('register'))
                        <a href="{{ route('register') }}" class="page-transition-link px-5 py-2 text-sm font-semibold text-white dark:text-brand-dark bg-brand-primary rounded-md transition hover:bg-opacity-80 focus:outline-none focus-visible:ring-2 focus-visible:ring-offset-2 focus-visible:ring-brand-primary">Registar</a>
                    @endif
                @endauth
            </nav>
        @endif
    </header>

    <!-- Conteúdo Principal -->
    <main class="relative h-full flex flex-col items-center justify-center overflow-hidden p-6">
        <!-- Background Decorativo -->
        <div class="absolute -top-40 -right-40 w-96 h-96 bg-brand-primary/10 dark:bg-brand-primary/20 rounded-full blur-3xl animate-pulse"></div>
        <div class="absolute -bottom-40 -left-40 w-96 h-96 bg-brand-primary/10 dark:bg-brand-primary/20 rounded-full blur-3xl animate-pulse delay-1000"></div>

        <div id="welcome-content" class="text-center z-10 w-full max-w-4xl">
            <!-- Logotipo -->
            <div class="welcome-element opacity-0 translate-y-4 transition-all duration-700 ease-out">
                <x-application-logo class="w-48 h-auto mx-auto mb-6"/>
            </div>

            <!-- ================================================================= -->
            <!-- CORREÇÃO APLICADA AQUI -->
            <!-- ================================================================= -->
            <div class="welcome-element opacity-0 translate-y-4 transition-all duration-700 ease-out" style="transition-delay: 150ms;">
                <h1 class="text-3xl lg:text-5xl font-bold mb-4 h-48 lg:h-64 flex items-center justify-center text-transparent bg-clip-text bg-gradient-to-r from-brand-primary to-cyan-400">
                    <!-- Este DIV extra é a chave. O H1 vai centrar este div. -->
                    <!-- Dentro do div, o texto e o cursor fluem naturalmente. -->
                    <div>
                        <span id="motivational-phrase"></span>
                    </div>
                </h1>
            </div>

            <!-- Parágrafo Descritivo -->
            <div class="welcome-element opacity-0 translate-y-4 transition-all duration-700 ease-out" style="transition-delay: 300ms;">
                <p class="text-lg text-gray-600 dark:text-gray-400 max-w-2xl mx-auto mb-8">
                    A sua ferramenta simples e poderosa para tocar o seu dia. Organize as suas tarefas e dê ritmo ao seu tempo.
                </p>
            </div>
            
            <!-- Botão Call-to-Action -->
            <div class="welcome-element opacity-0 translate-y-4 transition-all duration-700 ease-out" style="transition-delay: 450ms;">
                @auth
                    <a href="{{ url('/dashboard') }}" class="page-transition-link inline-block px-8 py-3 text-lg font-semibold text-white dark:text-brand-dark bg-brand-primary rounded-lg shadow-lg transition-transform hover:scale-105 focus:outline-none focus-visible:ring-2 focus-visible:ring-offset-2 focus-visible:ring-brand-primary">Ir para a Dashboard</a>
                @else
                    <a href="{{ route('register') }}" class="page-transition-link inline-block px-8 py-3 text-lg font-semibold text-white dark:text-brand-dark bg-brand-primary rounded-lg shadow-lg transition-transform hover:scale-105 focus:outline-none focus-visible:ring-2 focus-visible:ring-offset-2 focus-visible:ring-brand-primary">Dê Play no seu Dia</a>
                @endauth
            </div>
        </div>
    </main>
</body>
</html>