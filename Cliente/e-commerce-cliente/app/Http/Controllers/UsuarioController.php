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

        // Iniciar transacción
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

            // Insertar usuario y obtener ID
            $id = DB::table('usuarios')->insertGetId($userData);

            // Manejar upload de imagen 
            if ($id > 0 && $req->hasFile('imagen')) {
                $imagen = $req->file('imagen');
                $extension = $imagen->extension();
                $nuevo_nombre = "usuario_" . $id . "." . $extension;
                $ruta = $imagen->storeAs('imagenes_usuarios', $nuevo_nombre, 'public'); 
                
                // Actualizar ruta de imagen en la BD
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

            return response()->json([
                'success' => true,
                'message' => 'Usuario creado exitosamente.',
                'data' => $usuario
            ], 201);
        } catch (Exception $e) {
            DB::rollBack();
            return response()->json([
                'success' => false,
                'error' => 'Error interno del servidor: ' . $e->getMessage()
            ], 500);
        }
    }

    // POST: /api/register - REGISTRAR NUEVO USUARIO 
    public function register(Request $req)
    {
        return $this->store($req);
    }

    // GET: /api/usuarios - OBTENER TODOS LOS USUARIOS
    public function index()
    {
        try {
            $usuarios = DB::table('usuarios')
                ->join('roles', 'usuarios.rol_id', '=', 'roles.id')
                ->select('usuarios.*', 'roles.nombre as rol_nombre')
                ->get();
            
            return response()->json([
                'success' => true,
                'data' => $usuarios,
                'message' => 'Usuarios obtenidos correctamente.'
            ], 200);
        } catch (Exception $e) {
            return response()->json([
                'success' => false,
                'error' => 'Error al obtener los registros: ' . $e->getMessage()
            ], 500);
        }
    }

    // GET: /api/usuarios/{id} - OBTENER UN USUARIO
    public function show($id)
    {
        if (!is_numeric($id)) {
            return response()->json([
                'success' => false,
                'error' => 'El ID proporcionado no es válido.'
            ], 400);
        }

        try {
            $usuario = DB::table('usuarios')
                ->join('roles', 'usuarios.rol_id', '=', 'roles.id')
                ->select('usuarios.*', 'roles.nombre as rol_nombre')
                ->where('usuarios.id', $id)
                ->first();

            if (!$usuario) {
                return response()->json([
                    'success' => false,
                    'error' => 'No se encontró ningún registro con ese ID.'
                ], 404);
            }

            return response()->json([
                'success' => true, 
                'data' => $usuario
            ], 200);
        } catch (Exception $e) {
            return response()->json([
                'success' => false,
                'error' => 'Error interno del servidor: ' . $e->getMessage()
            ], 500);
        }
    }

    // PUT: /api/usuarios/{id} - ACTUALIZAR USUARIO 
    public function update(Request $req, $id)
    {
        // 1. Validar ID
        if (!is_numeric($id)) {
            return response()->json(['success' => false, 'error' => 'ID inválido.'], 400);
        }

        // 2. Verificar existencia del usuario
        $usuario = DB::table('usuarios')->where('id', $id)->first();
        if (!$usuario) {
            return response()->json(['success' => false, 'error' => 'Usuario no encontrado.'], 404);
        }

        // 3. Reglas de validación
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

        $validator = Validator::make($req->all(), $rules);
        if ($validator->fails()) {
            return response()->json(['success' => false, 'error' => $validator->errors()], 400);
        }

        // 4. Iniciar Transacción
        DB::beginTransaction();
        try {
            // Obtenemos los datos validados
            $updateData = $validator->validated();

            if (isset($updateData['imagen'])) {
                unset($updateData['imagen']); 
            }
            
            if (isset($updateData['password'])) {
                $updateData['password'] = Hash::make($updateData['password']);
            }

            // Manejar la imagen por separado
            if ($req->hasFile('imagen')) {
                if ($usuario->imagen && Storage::disk('public')->exists($usuario->imagen)) {
                    Storage::disk('public')->delete($usuario->imagen);
                }

                $imagen = $req->file('imagen');
                $extension = $imagen->extension();
                $nuevo_nombre = "usuario_" . $id . "." . $extension;
                $ruta = $imagen->storeAs('imagenes_usuarios', $nuevo_nombre, 'public');
                
                $updateData['imagen'] = $ruta;
            }

            // Realizar la actualización en Base de Datos solo si hay datos para actualizar
            if (!empty($updateData)) {
                DB::table('usuarios')->where('id', $id)->update($updateData);
            }

            DB::commit();

            // Obtener el usuario actualizado para devolverlo al front
            $actualizado = DB::table('usuarios')
                ->join('roles', 'usuarios.rol_id', '=', 'roles.id')
                ->select('usuarios.*', 'roles.nombre as rol_nombre')
                ->where('usuarios.id', $id)
                ->first();

            return response()->json([
                'success' => true,
                'message' => 'Usuario actualizado correctamente.',
                'data' => $actualizado
            ], 200);

        } catch (Exception $e) {
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
        if (!is_numeric($id)) {
            return response()->json(['success' => false, 'error' => 'ID inválido.'], 400);
        }

        $usuario = DB::table('usuarios')->where('id', $id)->first();
        if (!$usuario) {
            return response()->json(['success' => false, 'error' => 'Usuario no encontrado.'], 404);
        }

        try {
            DB::beginTransaction();

            // Eliminar imagen del storage si existe
            if ($usuario->imagen) {
                Storage::disk('public')->delete($usuario->imagen);
            }

            // Eliminar registro
            DB::table('usuarios')->where('id', $id)->delete();

            DB::commit();

            return response()->json([
                'success' => true,
                'message' => 'Usuario eliminado correctamente.'
            ], 200);
        } catch (Exception $e) {
            DB::rollBack();
            return response()->json([
                'success' => false,
                'error' => 'Error al eliminar usuario: ' . $e->getMessage()
            ], 500);
        }
    }
}