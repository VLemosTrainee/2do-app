<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware) {
        $middleware->alias([
            'admin' => \App\Http\Middleware\EnsureUserIsAdmin::class,
        ]);
    })
    ->withExceptions(function (Exceptions $exceptions): void {
        //
    })
    // ==========================================================
    // ADICIONE ESTE NOVO MÉTODO E O PROVIDER DENTRO DELE
    // ==========================================================
    ->withProviders([
        App\Providers\AuthServiceProvider::class, // Regista o nosso provider de autorização
        Laravel\Fortify\FortifyServiceProvider::class, // Regista o provider do Fortify
    ])
    // ==========================================================
    ->create();