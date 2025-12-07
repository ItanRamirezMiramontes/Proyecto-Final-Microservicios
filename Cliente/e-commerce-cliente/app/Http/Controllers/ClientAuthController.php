<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Log;

class ClientAuthController extends Controller
{
    protected $baseApiUrl;

    public function __construct()
    {
        $this->baseApiUrl = rtrim(env('API_BASE_URL', 'http://localhost:8000/api'), '/');
    }

    // LOGIN & REGISTRO

    public function showLogin()
    {
        if (session()->has('client_token')) return redirect()->route('welcome');
        return view('auth.login');
    }

    public function showRegister()
    {
        if (session()->has('client_token')) return redirect()->route('welcome');
        return view('auth.register');
    }

    public function login(Request $request)
    {
        $request->validate(['email' => 'required|email', 'password' => 'required|string']);

        try {
            $response = Http::post("{$this->baseApiUrl}/login", [
                'email' => $request->email,
                'password' => $request->password
            ]);

            $data = $response->json();

            if ($response->successful() && ($data['success'] ?? false)) {
                $user = $data['data'] ?? $data['user'];
                $token = $data['access_token'] ?? $data['token'];

                if (isset($user['rol_id']) && $user['rol_id'] != 2) {
                    return back()->with('error', 'Esta cuenta no es de cliente.');
                }

                session(['client_token' => $token, 'client_user' => $user]);
                return redirect()->route('welcome')->with('success', '¡Bienvenido!');
            }
            return back()->with('error', $data['message'] ?? 'Credenciales incorrectas.');
        } catch (\Exception $e) {
            return back()->with('error', 'Error de conexión.');
        }
    }

    public function register(Request $request)
    {
        $request->validate([
            'nombre' => 'required|string|max:255',
            'apellido' => 'required|string|max:255',
            'email' => 'required|email',
            'password' => 'required|string|min:8|confirmed',
            'telefono' => 'nullable|string|max:20',
            'direccion' => 'nullable|string|max:500',
            'imagen' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        try {
            $data = $request->only(['nombre', 'apellido', 'email', 'password', 'password_confirmation', 'telefono', 'direccion']);
            $data['rol_id'] = 2;

            if ($request->hasFile('imagen')) {
                $response = Http::attach(
                    'imagen', 
                    file_get_contents($request->file('imagen')),
                    $request->file('imagen')->getClientOriginalName()
                )->post("{$this->baseApiUrl}/register", $data);
            } else {
                $response = Http::post("{$this->baseApiUrl}/register", $data);
            }

            $resp = $response->json();

            if ($response->successful() && ($resp['success'] ?? false)) {
                return $this->login($request);
            } else {
                if (isset($resp['error']) && is_array($resp['error'])) {
                    return back()->withErrors($resp['error'])->withInput();
                }
                return back()->with('error', $resp['message'] ?? 'Error al registrar.');
            }
        } catch (\Exception $e) {
            return back()->with('error', 'Error de conexión: ' . $e->getMessage());
        }
    }

    public function logout(Request $request)
    {
        $token = session('client_token');
        if ($token) {
            try { Http::withToken($token)->post("{$this->baseApiUrl}/logout"); } catch (\Exception $e) {}
        }
        session()->forget(['client_token', 'client_user']);
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect()->route('welcome');
    }

    // PERFIL & ACTUALIZACIÓN

    public function dashboard()
    {
        return redirect()->route('client.profile');
    }

    public function profile()
    {
        if (!Session::has('client_token')) return redirect()->route('client.login');
        
        return view('client.profile'); 
    }

    public function updateProfile(Request $request)
    {
        try {
            $request->validate([
                'nombre' => 'required|string|max:255',
                'apellido' => 'required|string|max:255',
                'email' => 'required|email',
                'telefono' => 'nullable|string|max:20',
                'direccion' => 'nullable|string|max:500',
                'imagen' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048'
            ]);

            $token = Session::get('client_token');
            $url = "{$this->baseApiUrl}/perfil"; 

            $http = Http::withToken($token);

            if ($request->hasFile('imagen')) {
                $file = $request->file('imagen');
                $response = $http->attach(
                    'imagen', 
                    file_get_contents($file->getRealPath()), 
                    $file->getClientOriginalName()
                )->post($url, [
                    'nombre' => $request->nombre,
                    'apellido' => $request->apellido,
                    'email' => $request->email,
                    'telefono' => $request->telefono,
                    'direccion' => $request->direccion,
                    '_method' => 'PUT' 
                ]);
            } else {
                $response = $http->put($url, [
                    'nombre' => $request->nombre,
                    'apellido' => $request->apellido,
                    'email' => $request->email,
                    'telefono' => $request->telefono,
                    'direccion' => $request->direccion,
                ]);
            }

            $body = $response->json();

            if ($response->successful() && ($body['success'] ?? false)) {
                $userActualizado = $body['data'];
                Session::put('client_user', $userActualizado);
                return back()->with('success', 'Perfil actualizado correctamente.');
            }

            if (isset($body['error']) && is_array($body['error'])) {
                return back()->withErrors($body['error'])->withInput();
            }

            return back()->with('error', $body['message'] ?? ($body['error'] ?? 'Error al actualizar.'));

        } catch (\Exception $e) {
            Log::error('Error updateProfile: ' . $e->getMessage());
            return back()->with('error', 'Error de conexión: ' . $e->getMessage());
        }
    }

    public function changePassword(Request $request)
    {
        $request->validate([
            'current_password' => 'required',
            'new_password' => 'required|min:8|confirmed',
        ]);
        return back()->with('info', 'Funcionalidad en construcción.');
    }

    // HELPERS

    public function construirUrlImagen($imagenPath)
    {
        if (!$imagenPath) return null;
        if (str_starts_with($imagenPath, 'http')) return $imagenPath;

        $baseHost = str_replace('/api', '', $this->baseApiUrl);
        return "{$baseHost}/storage/" . ltrim($imagenPath, '/');
    }
}