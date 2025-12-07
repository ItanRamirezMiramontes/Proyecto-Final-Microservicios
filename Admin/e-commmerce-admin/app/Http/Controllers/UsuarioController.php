<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Session;

class UsuarioController extends Controller
{
    // URL base de la API
    protected $baseApiUrl;

    public function __construct()
    {
        $this->baseApiUrl = rtrim(env('API_BASE_URL'), '/');
    }

    /**
     * Muestra la lista de usuarios.
     */
    public function index()
    {
        try {
            // INYECTAMOS EL TOKEN AUNQUE SEA PÚBLICA (BUENA PRÁCTICA)
            $response = Http::withToken(session('auth_token'))
                ->timeout(10)
                ->get("{$this->baseApiUrl}/usuarios");

            if ($response->successful()) {
                $body = $response->json();
                
                if ($body['success'] ?? false) {
                    $usuarios = $body['data'];
                    return view('usuarios.index', compact('usuarios'));
                } else {
                    Session::flash('error', $body['error'] ?? 'Error desconocido al obtener usuarios.');
                }
            } else {
                Session::flash('error', 'Error ' . $response->status() . ': No se pudo conectar con la API.');
            }

        } catch (\Exception $e) {
            Log::error('HTTP Error index: ' . $e->getMessage());
            Session::flash('error', 'La API no está disponible.');
        }

        return view('usuarios.index', ['usuarios' => []]);
    }

    /**
     * Muestra el formulario para crear.
     */
    public function create()
    {
        try {
            // OBTENER ROLES (Pública, pero enviamos token por seguridad)
            $response = Http::withToken(session('auth_token'))
                ->timeout(10)
                ->get("{$this->baseApiUrl}/roles");
            
            $roles = [];
            if ($response->successful()) {
                $body = $response->json();
                $roles = $body['success'] ? ($body['data'] ?? []) : [];
            }
        } catch (\Exception $e) {
            $roles = [];
            Log::error('Error roles: ' . $e->getMessage());
        }

        return view('usuarios.create', compact('roles'));
    }

    /**
     * Guarda un nuevo usuario (REQUIERE TOKEN OBLIGATORIO).
     */
    public function store(Request $request)
    {
        try {
            $data = $request->except(['_token', 'password_confirmation']);
            
            // 1. RECUPERAR TOKEN DE SESIÓN
            $token = session('auth_token');

            // 2. CONFIGURAR CLIENTE HTTP CON TOKEN
            $httpRequest = Http::withToken($token)->timeout(30);
            
            // 3. ENVIAR PETICIÓN (Multipart si hay imagen, Form si no)
            if ($request->hasFile('imagen')) {
                $multipartData = [];
                
                foreach ($data as $key => $value) {
                    if ($key !== 'imagen' && $value !== null) {
                        $multipartData[] = [
                            'name' => $key,
                            'contents' => $value
                        ];
                    }
                }
                
                $multipartData[] = [
                    'name' => 'imagen',
                    'contents' => fopen($request->file('imagen')->getRealPath(), 'r'),
                    'filename' => $request->file('imagen')->getClientOriginalName()
                ];
                
                $response = $httpRequest->asMultipart()->post("{$this->baseApiUrl}/usuarios", $multipartData);
            } else {
                $response = $httpRequest->asForm()->post("{$this->baseApiUrl}/usuarios", $data);
            }
            
            // 4. MANEJAR RESPUESTA
            if ($response->successful()) {
                $body = $response->json();
                if ($body['success'] ?? false) {
                    Session::flash('success', 'Usuario creado exitosamente.');
                    return redirect()->route('usuarios.index');
                }
            }
            
            // MANEJO DE ERRORES (400, 422, 500)
            $body = $response->json();
            if ($response->status() == 400 && is_array($body['error'] ?? null)) {
                return redirect()->back()->withErrors($body['error'])->withInput();
            } else {
                $msg = $body['error'] ?? 'Error al crear usuario. Status: ' . $response->status();
                Session::flash('error', $msg);
                return redirect()->back()->withInput();
            }

        } catch (\Exception $e) {
            Log::error('HTTP Error store: ' . $e->getMessage());
            Session::flash('error', 'Error inesperado: ' . $e->getMessage());
            return redirect()->back()->withInput();
        }
    }

    /**
     * Muestra formulario de edición.
     */
    public function edit($id)
    {
        try {
            $token = session('auth_token');

            // Obtener usuario
            $userResp = Http::withToken($token)->get("{$this->baseApiUrl}/usuarios/{$id}");
            // Obtener roles
            $rolesResp = Http::withToken($token)->get("{$this->baseApiUrl}/roles");

            if ($userResp->successful() && ($userResp->json()['success'] ?? false)) {
                $usuario = $userResp->json()['data'];
                
                $roles = [];
                if ($rolesResp->successful() && ($rolesResp->json()['success'] ?? false)) {
                    $roles = $rolesResp->json()['data'];
                }

                return view('usuarios.edit', compact('usuario', 'roles'));
            }

            Session::flash('error', 'No se pudo cargar la información del usuario.');
            return redirect()->route('usuarios.index');

        } catch (\Exception $e) {
            Log::error('HTTP Error edit: ' . $e->getMessage());
            Session::flash('error', 'Error de red.');
            return redirect()->route('usuarios.index');
        }
    }

   /**
     * Actualiza usuario 
     */
    public function update(Request $request, $id)
    {
        try {
            $data = $request->except(['_token', '_method', 'password_confirmation']);
            
            if (empty($data['password'])) {
                unset($data['password']);
            }
            
            $token = session('auth_token');
            $httpRequest = Http::withToken($token)->timeout(30);
            
            if ($request->hasFile('imagen')) {
                $multipartData = [];
                
                // 1. Agregar campos de texto
                foreach ($data as $key => $value) {
                    if ($key !== 'imagen' && $value !== null) {
                        $multipartData[] = [ 'name' => $key, 'contents' => $value ];
                    }
                }
                
                // 2. Agregar el archivo
                $multipartData[] = [
                    'name' => 'imagen',
                    'contents' => fopen($request->file('imagen')->getRealPath(), 'r'),
                    'filename' => $request->file('imagen')->getClientOriginalName()
                ];

                $multipartData[] = [
                    'name' => '_method',
                    'contents' => 'PUT'
                ];
                
                $response = $httpRequest->asMultipart()->post("{$this->baseApiUrl}/usuarios/{$id}", $multipartData);

            } else {
                $response = $httpRequest->asForm()->put("{$this->baseApiUrl}/usuarios/{$id}", $data);
            }
            
            if ($response->successful()) {
                $body = $response->json();
                if ($body['success'] ?? false) {
                    Session::flash('success', 'Usuario actualizado correctamente.');
                    return redirect()->route('usuarios.index');
                }
            }
            
            $body = $response->json();
            if ($response->status() == 400 && is_array($body['error'] ?? null)) {
                return redirect()->back()->withErrors($body['error'])->withInput();
            } else {
                Session::flash('error', $body['error'] ?? 'Error al actualizar.');
                return redirect()->back()->withInput();
            }

        } catch (\Exception $e) {
            Log::error('HTTP Error update: ' . $e->getMessage());
            Session::flash('error', 'Error crítico: ' . $e->getMessage());
            return redirect()->back()->withInput();
        }
    }

    /**
     * Ver detalle.
     */
    public function show($id)
    {
        try {
            $response = Http::withToken(session('auth_token'))
                ->get("{$this->baseApiUrl}/usuarios/{$id}");

            if ($response->successful()) {
                $body = $response->json();
                if ($body['success'] ?? false) {
                    $usuario = $body['data'];
                    return view('usuarios.show', compact('usuario'));
                }
            }
            Session::flash('error', 'Usuario no encontrado.');
            return redirect()->route('usuarios.index');

        } catch (\Exception $e) {
            Session::flash('error', 'Error de red.');
            return redirect()->route('usuarios.index');
        }
    }

    /**
     * Eliminar usuario (REQUIERE TOKEN OBLIGATORIO).
     */
    public function destroy($id)
    {
        try {
            // ENVIAMOS DELETE CON TOKEN
            $response = Http::withToken(session('auth_token'))
                ->delete("{$this->baseApiUrl}/usuarios/{$id}");
            
            $body = $response->json();

            if ($response->successful() && ($body['success'] ?? false)) {
                Session::flash('success', 'Usuario eliminado correctamente.');
            } else {
                Session::flash('error', $body['error'] ?? 'No se pudo eliminar el usuario.');
            }

        } catch (\Exception $e) {
            Log::error('HTTP Error destroy: ' . $e->getMessage());
            Session::flash('error', 'Error de conexión al eliminar.');
        }

        return redirect()->route('usuarios.index');
    }
}