<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class CheckUserStatus
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Verifica si el usuario está autenticado
        if (Auth::guard('web')->check()) { // Asegúrate de usar el guard "web"
            // Verifica si el usuario tiene status_id = 2 (inactivo)
            if (Auth::guard('web')->user()->status_id == 2) {
                // Cierra la sesión y redirige al login con un mensaje
                Auth::guard('web')->logout();
                return redirect()->route('login')->withErrors(['status' => 'Tu cuenta está inactiva. Contacta al administrador.']);
            }
        }

        return $next($request);
    }
}
