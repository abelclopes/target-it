<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class CheckRole
{
    public function handle(Request $request, Closure $next, ...$roles)
    {
        // Verifica se o usuário está autenticado
        if (!$request->user()) {
            return response()->json(['message' => 'Unauthorized, sem permissão 401'], 401);
        }

        // Verifica se o usuário tem pelo menos uma das roles necessárias
        if (!$request->user()->hasAnyRole($roles)) {
            return response()->json(['message' => 'Unauthorized, sem permissão 403'], 403);
        }

        return $next($request);
    }
}
