<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckRole
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next, string $role): Response
    {
        // Verifica se o user está autenticado
        if (!$request->user()) {
            abort(403, 'Acesso negado. Precisas de estar autenticado.');
        }

        // Se o user não tiver o role necessário, redireciona
        if (!$request->user()->hasRole($role)) {
            abort(403, 'Acesso negado. Não tens permissão para aceder a esta página.');
        }
        return $next($request);
    }
}
