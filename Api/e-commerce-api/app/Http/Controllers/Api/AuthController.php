<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;
use Exception;
use App\Models\Usuario;

class AuthController extends Controller
{
    // POST: /api/login - AUTENTICAR USUARIO EXISTENTE
    public function login(Request $req)
    {
        // Reglas de validación para login
        $rules = [
            'email' => 'required|email',
            'password' => 'required|string'
        ];

        // Validar datos de entrada
        $validator = Validator::make($req->all(), $rules);
        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'error' => $validator->errors()
            ], 400);
        }

        try {
            // Buscar usuario por email usando Eloquent
            $usuario = Usuario::where('email', $req->email)->first();

            // Verificar si el usuario existe
            if (!$usuario) {
                return response()->json([
                    'success' => false,
                    'error' => 'Credenciales inválidas.'
                ], 401);
            }

            // Verificar si la contraseña coincide usando Hash
            if (!Hash::check($req->password, $usuario->password)) {
                return response()->json([
                    'success' => false,
                    'error' => 'Credenciales inválidas.'
                ], 401);
            }

            // Generar token de autenticación
            $token = $usuario->createToken('auth_token')->plainTextToken;

            // Retornar respuesta exitosa con token y datos del usuario
            return response()->json([
                'success' => true,
                'message' => 'Acceso autorizado.',
                'token' => $token,
                'data' => $usuario
            ], 200);

        } catch (Exception $e) {
            return response()->json([
                'success' => false,
                'error' => 'Error interno del servidor: ' . $e->getMessage()
            ], 500);
        }
    }


    // POST: /api/logout - CERRAR SESIÓN DEL USUARIO
    public function logout(Request $request)
    {
        try {
            // Eliminar el token de acceso actual del usuario autenticado
            $request->user()->currentAccessToken()->delete();

            // Retornar confirmación de cierre de sesión
            return response()->json([
                'success' => true,
                'message' => 'Sesión cerrada exitosamente.'
            ], 200);
        } catch (Exception $e) {
            // Manejar errores durante el logout
            return response()->json([
                'success' => false,
                'error' => 'Error al cerrar sesión: ' . $e->getMessage()
            ], 500);
        }
    }

    // GET: /api/user - OBTENER DATOS DEL USUARIO AUTENTICADO
    public function user(Request $request)
    {
        try {
            // Obtener usuario autenticado desde el token
            $user = $request->user();
            
            // Cargar relación de rol
            $user->load('rol');

            // Retornar datos del usuario autenticado
            return response()->json([
                'success' => true,
                'data' => $user
            ], 200);
        } catch (Exception $e) {
            // Manejar errores al obtener datos del usuario
            return response()->json([
                'success' => false,
                'error' => 'Error al obtener usuario: ' . $e->getMessage()
            ], 500);
        }
    }
}