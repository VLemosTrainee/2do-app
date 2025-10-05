<?php
namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class EnsureUserIsAdmin
{
    public function handle(Request $request, Closure $next): Response
    {
        // Verifica se o utilizador está logado E se a sua role é 'admin'
        if (! $request->user() || ! $request->user()->isAdmin()) {
            abort(403, 'Acesso Não Autorizado.');
        }

        return $next($request);
    }
}