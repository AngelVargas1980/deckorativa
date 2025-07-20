<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class RoleMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response) $next
     */
    public function handle($request, Closure $next, $role)
    {
        // Verificar si el rol del usuario coincide con el rol solicitado
        if ($role && auth()->user()->rol !== $role) {
            return redirect()->route('inicio');  // Redirige a la página de inicio si el rol no coincide
        }

        return $next($request);  // Continuar con la solicitud si el rol es correcto
    }



    //Notas: strtolower() para hacer una comparación insensible a mayúsculas/minúsculas.


}
