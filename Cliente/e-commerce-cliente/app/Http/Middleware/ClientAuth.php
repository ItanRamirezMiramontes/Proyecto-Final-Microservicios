<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Symfony\Component\HttpFoundation\Response;

class ClientAuth
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Verificar si existe token en sesión
        if (!session()->has('client_token')) {
            return redirect()->route('auth.login')->with('error', 'Por favor inicia sesión para acceder a esta página.');
        }

        // Verificar token con API
        $token = session('client_token');
        
        try {
            // Hacer petición a la API para verificar el token y obtener datos del usuario
            $response = Http::withHeaders([
                'Authorization' => 'Bearer ' . $token,
                'Accept' => 'application/json'
            ])->timeout(30)
              ->get('http://localhost:8000/api/user');
            
            if ($response->successful()) {
                $userData = $response->json();
                
                if ($userData['success'] ?? false) {
                    $user = $userData['data'] ?? $userData['user'];
                    
                    if (isset($user['rol_id']) && $user['rol_id'] != 2) {
                        session()->forget(['client_token', 'client_user']);
                        return redirect()->route('auth.login')->with('error', 'No tienes permisos para acceder al panel de cliente.');
                    }
                    
                    // Guardar usuario en sesión
                    session(['client_user' => $user]);
                    return $next($request);
                }
            }
            
            // Si la respuesta no fue exitosa
            session()->forget(['client_token', 'client_user']);
            return redirect()->route('auth.login')->with('error', 'Tu sesión ha expirado. Por favor inicia sesión nuevamente.');
            
        } catch (\Exception $e) {
            // Error de conexión - si ya tenemos datos de usuario, permitir continuar
            if (session()->has('client_user')) {
                return $next($request);
            }
            
            session()->forget(['client_token', 'client_user']);
            return redirect()->route('auth.login')->with('error', 'Error de conexión con el servidor. Intenta nuevamente.');
        }
    }
}