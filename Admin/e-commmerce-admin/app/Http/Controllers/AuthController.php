<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class AuthController extends Controller
{
    /**
     * Mostrar formulario de login
     */
    public function showLogin()
    {
        // Si ya está autenticado, redirigir al dashboard
        if (session()->has('auth_token') && session()->has('user')) {
            return redirect()->route('dashboard');
        }
        
        return view('auth.login');
    }

    /**
     * Procesar login
     */
    public function login(Request $request)
    {
        // Validar datos del formulario
        $request->validate([
            'email' => 'required|email',
            'password' => 'required|string'
        ]);

        try {
            // Hacer petición a la API para login
            $response = Http::post('http://localhost:8000/api/login', [
                'email' => $request->email,
                'password' => $request->password
            ]);

            $data = $response->json();

            if ($data['success']) {
                // Verificar si es administrador (rol_id = 1)
                if ($data['data']['rol_id'] == 1) {
                    // Guardar token y datos del usuario en sesión
                    session([
                        'auth_token' => $data['token'],
                        'user' => $data['data']
                    ]);
                    
                    return redirect()->route('dashboard')
                        ->with('success', '¡Bienvenido al panel de administración!');
                } else {
                    return back()->with('error', 'No tienes permisos de administrador para acceder a este panel.');
                }
            } else {
                return back()->with('error', $data['error'] ?? 'Credenciales incorrectas. Verifica tu email y contraseña.');
            }
        } catch (\Exception $e) {
            return back()->with('error', 'Error de conexión con el servidor. Intenta nuevamente.');
        }
    }

    /**
     * Cerrar sesión
     */
    public function logout(Request $request)
    {
        $token = session('auth_token');
        
        // Hacer logout en la API si existe token
        if ($token) {
            try {
                Http::withToken($token)
                    ->timeout(10)
                    ->post('http://localhost:8000/api/logout');
            } catch (\Exception $e) {
                // Continuar aunque falle el logout en la API
            }
        }
        
        // Limpiar sesión local
        session()->forget(['auth_token', 'user']);
        
        return redirect()->route('login')
            ->with('success', 'Sesión cerrada correctamente.');
    }
}