<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name', '2Do') }}</title>

    <!-- Fonts & Styles -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display.swap" rel="stylesheet" />
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="font-sans text-brand-dark antialiased">
    <div class="min-h-screen bg-brand-light dark:bg-brand-dark grid lg:grid-cols-2">
        <!-- Coluna da Esquerda (Conteúdo Dinâmico: Login ou Registo) -->
        <main class="flex flex-col items-center justify-center p-6 sm:p-12">
            <div class="w-full max-w-md">
                {{ $slot }}
            </div>
        </main>

        <!-- Coluna da Direita (Visual Fixo) -->
        <aside id="auth-visual-column" class="hidden lg:flex flex-col items-center justify-center bg-brand-primary p-12 text-white text-center relative overflow-hidden opacity-0 transition-opacity duration-1000 ease-in">
            <!-- Elementos decorativos -->
            <div class="absolute -top-20 -right-20 w-48 h-48 bg-white/10 rounded-full"></div>
            <div class="absolute -bottom-24 -left-16 w-56 h-56 bg-white/10 rounded-full"></div>

            <div class="z-10">
                <h2 class="text-4xl font-bold mb-4">Toque o ritmo do seu dia.</h2>
                <p class="text-lg max-w-sm">
                    Com o 2Do, as suas tarefas entram em sintonia. Dê play no que importa, organize e dê ritmo ao seu tempo.
                </p>
            </div>
        </aside>
    </div>
</body>
</html>