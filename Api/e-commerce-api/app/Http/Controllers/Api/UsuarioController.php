<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Exception;

class UsuarioController extends Controller
{
    // GET: /api/roles - OBTENER TODOS LOS ROLES
    public function getRoles()
    {
        try {
            $roles = DB::table('roles')->select('id', 'nombre')->get();
            
            return response()->json([
                'success' => true,
                'data' => $roles,
                'message' => 'Roles obtenidos correctamente.'
            ], 200);
        } catch (Exception $e) {
            return response()->json([
                'success' => false,
                'error' => 'Error al obtener roles: ' . $e->getMessage()
            ], 500);
        }
    }

    // POST: /api/usuarios - CREAR NUEVO USUARIO 
    public function store(Request $req)
    {
        $rules = [
            'nombre' => 'required|string|max:255',          
            'apellido' => 'required|string|max:255',        
            'email' => 'required|email|unique:usuarios,email', 
            'password' => 'required|string|min:8',          
            'telefono' => 'nullable|string|max:20',         
            'direccion' => 'nullable|string|max:500',       
            'rol_id' => 'required|exists:roles,id',         
            'imagen' => 'sometimes|image|mimes:jpeg,png,jpg|max:2048', 
        ];

        // Ejecutar validación
        $validator = Validator::make($req->all(), $rules);
        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'error' => $validator->errors()
            ], 400);
        }

        // Iniciar transacción para asegurar consistencia de datos
        DB::beginTransaction();
        try {
            // Preparar datos para inserción
            $userData = [
                'nombre' => $req->nombre,
                'apellido' => $req->apellido,
                'email' => $req->email,
                'password' => Hash::make($req->password),
                'telefono' => $req->telefono,
                'direccion' => $req->direccion,
                'rol_id' => $req->rol_id,
                'imagen' => null 
            ];

            // Insertar usuario y obtener ID generado
            $id = DB::table('usuarios')->insertGetId($userData);

            // Manejar upload de imagen 
            if ($id > 0 && $req->hasFile('imagen')) {
                $imagen = $req->file('imagen');
                $extension = $imagen->extension();
                $nuevo_nombre = "usuario_" . $id . "." . $extension;
                $ruta = $imagen->storeAs('imagenes_usuarios', $nuevo_nombre, 'public'); 
                
                // Actualizar ruta de imagen en la base de datos
                DB::table('usuarios')->where('id', $id)->update([
                    'imagen' => $ruta
                ]);
            }

            // Confirmar transacción
            DB::commit();

            // Obtener usuario creado con datos completos
            $usuario = DB::table('usuarios')
                ->join('roles', 'usuarios.rol_id', '=', 'roles.id')
                ->select('usuarios.*', 'roles.nombre as rol_nombre')
                ->where('usuarios.id', $id)
                ->first();

            // Respuesta de creación exitosa
            return response()->json([
                'success' => true,
                'message' => 'Usuario creado exitosamente.',
                'data' => $usuario
            ], 201);
        } catch (Exception $e) {
            // Revertir transacción en caso de error
            DB::rollBack();
            return response()->json([
                'success' => false,
                'error' => 'Error interno del servidor: ' . $e->getMessage()
            ], 500);
        }
    }

    // POST: /api/register
    public function register(Request $req)
    {
        return $this->store($req);
    }

    // GET: /api/usuarios - OBTENER TODOS LOS USUARIOS
    public function index()
    {
        try {
            // Consulta con JOIN para obtener usuarios con nombre de rol
            $usuarios = DB::table('usuarios')
                ->join('roles', 'usuarios.rol_id', '=', 'roles.id')
                ->select('usuarios.*', 'roles.nombre as rol_nombre')
                ->get();
            
            // Respuesta exitosa con datos
            return response()->json([
                'success' => true,
                'data' => $usuarios,
                'message' => 'Usuarios obtenidos correctamente.'
            ], 200);
        } catch (Exception $e) {
            // Manejo de errores del servidor
            return response()->json([
                'success' => false,
                'error' => 'Error al obtener los registros: ' . $e->getMessage()
            ], 500);
        }
    }

    // GET: /api/usuarios/{id} - OBTENER UN USUARIO ESPECÍFICO
    public function show($id)
    {
        // Validar que el ID sea numérico
        if (!is_numeric($id)) {
            return response()->json([
                'success' => false,
                'error' => 'El ID proporcionado no es válido.'
            ], 400);
        }

        try {
            // Buscar usuario específico con JOIN a roles
            $usuario = DB::table('usuarios')
                ->join('roles', 'usuarios.rol_id', '=', 'roles.id')
                ->select('usuarios.*', 'roles.nombre as rol_nombre')
                ->where('usuarios.id', $id)
                ->first();

            // Verificar si el usuario existe
            if (!$usuario) {
                return response()->json([
                    'success' => false,
                    'error' => 'No se encontró ningún registro con ese ID.'
                ], 404);
            }

            // Retornar usuario encontrado
            return response()->json([
                'success' => true, 
                'data' => $usuario
            ], 200);
        } catch (Exception $e) {
            // Manejo de errores internos
            return response()->json([
                'success' => false,
                'error' => 'Error interno del servidor: ' . $e->getMessage()
            ], 500);
        }
    }

    // PUT: /api/usuarios/{id} 
public function update(Request $req, $id)
{
    // Validar ID numérico
    if (!is_numeric($id)) {
        return response()->json([
            'success' => false,
            'error' => 'El ID proporcionado no es válido.'
        ], 400);
    }

    // Verificar que el usuario existe
    $usuario = DB::table('usuarios')->where('id', $id)->first();
    if (!$usuario) {
        return response()->json([
            'success' => false,
            'error' => 'No se encontró ningún registro con ese ID.'
        ], 404);
    }

    // Reglas de validación para actualización
    $rules = [
        'nombre' => 'sometimes|required|string|max:255',
        'apellido' => 'sometimes|required|string|max:255',
        'email' => 'sometimes|required|email|unique:usuarios,email,' . $id, 
        'password' => 'sometimes|string|min:8',
        'telefono' => 'nullable|string|max:20',
        'direccion' => 'nullable|string|max:500',
        'rol_id' => 'sometimes|required|exists:roles,id',
        'imagen' => 'sometimes|image|mimes:jpeg,png,jpg|max:2048',
    ];

    // Ejecutar validación
    $validator = Validator::make($req->all(), $rules);
    if ($validator->fails()) {
        return response()->json([
            'success' => false,
            'error' => $validator->errors()
        ], 400);
    }

    // Iniciar transacción
    DB::beginTransaction();
    try {
        // OBTENER DATOS VALIDADOS -
        $validatedData = $req->only(['nombre', 'apellido', 'email', 'telefono', 'direccion', 'rol_id']);
        
        // Filtrar valores nulos/vacíos
        $updateData = array_filter($validatedData, function($value) {
            return $value !== null && $value !== '';
        });
        
        if ($req->filled('password')) {
            $updateData['password'] = Hash::make($req->password);
        }
        
        // Verificar que hay datos para actualizar
        if (empty($updateData)) {
            return response()->json([
                'success' => false,
                'error' => 'No se proporcionaron datos para actualizar.'
            ], 400);
        }
        
        $updateData['updated_at'] = now();

        // Actualizar campos
        DB::table('usuarios')->where('id', $id)->update($updateData);

        if ($req->hasFile('imagen')) {
            $imagen = $req->file('imagen');
            $extension = $imagen->extension();
            $nuevo_nombre = "usuario_" . $id . "." . $extension;
            $ruta = $imagen->storeAs('imagenes_usuarios', $nuevo_nombre, 'public');
            
            // Actualizar ruta de imagen
            DB::table('usuarios')->where('id', $id)->update([
                'imagen' => $ruta
            ]);
        }

        // Confirmar transacción
        DB::commit();

        // Obtener usuario actualizado
        $actualizado = DB::table('usuarios')
            ->join('roles', 'usuarios.rol_id', '=', 'roles.id')
            ->select('usuarios.*', 'roles.nombre as rol_nombre')
            ->where('usuarios.id', $id)
            ->first();

        // Respuesta de actualización exitosa
        return response()->json([
            'success' => true,
            'message' => 'Usuario actualizado correctamente.',
            'data' => $actualizado
        ], 200);
    } catch (Exception $e) {
        // Revertir en caso de error
        DB::rollBack();
        return response()->json([
            'success' => false,
            'error' => 'Error interno del servidor: ' . $e->getMessage()
        ], 500);
    }
}

    // DELETE: /api/usuarios/{id} - ELIMINAR USUARIO
    public function destroy($id)
    {
        // Validar ID numérico
        if (!is_numeric($id)) {
            return response()->json([
                'success' => false,
                'error' => 'El ID proporcionado no es válido.'
            ], 400);
        }

        // Verificar que el usuario existe
        $usuario = DB::table('usuarios')->where('id', $id)->first();
        if (!$usuario) {
            return response()->json([
                'success' => false,
                'error' => 'No se encontró ningún registro con ese ID.'
            ], 404);
        }

        try {
            // Iniciar transacción para eliminar
            DB::beginTransaction();

            // Eliminar imagen del storage si existe
            if ($usuario->imagen) {
                Storage::disk('public')->delete($usuario->imagen);
            }

            // Eliminar usuario permanentemente
            DB::table('usuarios')->where('id', $id)->delete();

            // Confirmar transacción
            DB::commit();

            // Respuesta de eliminación exitosa
            return response()->json([
                'success' => true,
                'message' => 'Usuario eliminado correctamente.'
            ], 200);
        } catch (Exception $e) {
            // Revertir en caso de error
            DB::rollBack();
            // Manejo de errores en eliminación
            return response()->json([
                'success' => false,
                'error' => 'Error al eliminar usuario: ' . $e->getMessage()
            ], 500);
        }
    }
}