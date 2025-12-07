<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Symfony\Component\HttpFoundation\Response;

class AdminAuth
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Verificar si existe token en sesión
        if (!session()->has('auth_token')) {
            return redirect()->route('login')->with('error', 'Por favor inicia sesión para acceder al panel administrativo.');
        }

        // Verificar token con API
        $token = session('auth_token');
        
        try {
            // Hacer petición a la API para verificar el token y obtener datos del usuario
            $response = Http::withToken($token)
                ->timeout(30)
                ->get('http://localhost:8000/api/user');
            
            if ($response->successful()) {
                $userData = $response->json();
                
                if ($userData['success']) {
                    $user = $userData['data'];
                    
                    // Verificar si es administrador (rol_id = 1)
                    if ($user['rol_id'] != 1) {
                        session()->forget(['auth_token', 'user']);
                        return redirect()->route('login')->with('error', 'No tienes permisos para acceder al panel de administración.');
                    }
                    
                    // Guardar usuario en sesión
                    session(['user' => $user]);
                    return $next($request);
                }
            }
            
            // Si la respuesta no fue exitosa
            session()->forget(['auth_token', 'user']);
            return redirect()->route('login')->with('error', 'Tu sesión ha expirado. Por favor inicia sesión nuevamente.');
            
        } catch (\Exception $e) {
            session()->forget(['auth_token', 'user']);
            return redirect()->route('login')->with('error', 'Error de conexión con el servidor. Intenta nuevamente.');
        }
    }
}