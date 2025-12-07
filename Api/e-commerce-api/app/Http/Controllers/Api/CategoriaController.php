<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Exception;

class CategoriaController extends Controller
{
    // GET: /api/categorias - OBTENER TODAS LAS CATEGORÍAS
    public function index()
    {
        try {
            // Consulta para obtener todas las categorías
            $categorias = DB::table('categorias')->get();
            
            // Respuesta exitosa con datos
            return response()->json([
                'success' => true,
                'data' => $categorias,
                'message' => 'Categorías obtenidas correctamente.'
            ], 200);
        } catch (Exception $e) {
            // Manejo de errores del servidor
            return response()->json([
                'success' => false,
                'error' => 'Error al obtener las categorías: ' . $e->getMessage()
            ], 500);
        }
    }

    // GET: /api/categorias/{id} - OBTENER UNA CATEGORÍA ESPECÍFICA
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
            // Buscar categoría específica
            $categoria = DB::table('categorias')->where('id', $id)->first();

            // Verificar si la categoría existe
            if (!$categoria) {
                return response()->json([
                    'success' => false,
                    'error' => 'No se encontró ninguna categoría con ese ID.'
                ], 404);
            }

            // Retornar categoría encontrada
            return response()->json([
                'success' => true, 
                'data' => $categoria
            ], 200);
        } catch (Exception $e) {
            // Manejo de errores internos
            return response()->json([
                'success' => false,
                'error' => 'Error interno del servidor: ' . $e->getMessage()
            ], 500);
        }
    }

    // POST: /api/categorias - CREAR UNA NUEVA CATEGORÍA
    public function store(Request $req)
    {
        // Reglas de validación para crear categoría
        $rules = [
            'nombre' => 'required|string|max:255|unique:categorias,nombre', 
            'descripcion' => 'nullable|string',                            
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
            // Insertar categoría y obtener ID generado
            $id = DB::table('categorias')->insertGetId([
                'nombre' => $req->nombre,
                'descripcion' => $req->descripcion,
                'imagen' => null 
            ]);

            // Manejar upload de imagen si se proporcionó
            if ($id > 0 && $req->hasFile('imagen')) {
                $imagen = $req->file('imagen');
                $extension = $imagen->extension();
                $nuevo_nombre = "categoria_" . $id . "." . $extension; 
                $ruta = $imagen->storeAs('imagenes_categorias', $nuevo_nombre, 'public'); // Guardar en storage
                DB::table('categorias')->where('id', $id)->update([
                    'imagen' => $ruta // Actualizar ruta de imagen
                ]);
            }

            // Confirmar transacción
            DB::commit();

            // Obtener categoría creada con datos completos
            $categoria = DB::table('categorias')->where('id', $id)->first();

            // Respuesta de creación exitosa
            return response()->json([
                'success' => true,
                'message' => 'Categoría creada exitosamente.',
                'data' => $categoria
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

    // PUT/PATCH: /api/categorias/{id} - ACTUALIZAR CATEGORÍA EXISTENTE
    public function update(Request $req, $id)
    {
        // Validar ID numérico
        if (!is_numeric($id)) {
            return response()->json([
                'success' => false,
                'error' => 'El ID proporcionado no es válido.'
            ], 400);
        }

        // Verificar que la categoría existe
        $categoria = DB::table('categorias')->where('id', $id)->first();
        if (!$categoria) {
            return response()->json([
                'success' => false,
                'error' => 'No se encontró ninguna categoría con ese ID.'
            ], 404);
        }

        // Reglas de validación para actualización
        $rules = [
            'nombre' => 'sometimes|required|string|max:255|unique:categorias,nombre,' . $id, 
            'descripcion' => 'nullable|string',
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
            // Actualizar solo los campos validados
            DB::table('categorias')->where('id', $id)->update($validator->validated());

            // Manejar nueva imagen si se proporcionó
            if ($req->hasFile('imagen')) {
                $imagen = $req->file('imagen');
                $extension = $imagen->extension();
                $nuevo_nombre = "categoria_" . $id . "." . $extension;
                $ruta = $imagen->storeAs('imagenes_categorias', $nuevo_nombre, 'public');
                DB::table('categorias')->where('id', $id)->update([
                    'imagen' => $ruta
                ]);
            }

            // Confirmar transacción
            DB::commit();

            // Obtener categoría actualizada
            $actualizado = DB::table('categorias')->where('id', $id)->first();

            // Respuesta de actualización exitosa
            return response()->json([
                'success' => true,
                'message' => 'Categoría actualizada correctamente.',
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

    // DELETE: /api/categorias/{id} - ELIMINAR CATEGORÍA
    public function destroy($id)
    {
        // Validar ID numérico
        if (!is_numeric($id)) {
            return response()->json([
                'success' => false,
                'error' => 'El ID proporcionado no es válido.'
            ], 400);
        }

        // Verificar que la categoría existe
        $categoria = DB::table('categorias')->where('id', $id)->first();
        if (!$categoria) {
            return response()->json([
                'success' => false,
                'error' => 'No se encontró ninguna categoría con ese ID.'
            ], 404);
        }

        try {
            // Verificar si la categoría tiene productos asociados
            $productosCount = DB::table('productos')->where('categoria_id', $id)->count();
            
            if ($productosCount > 0) {
                return response()->json([
                    'success' => false,
                    'error' => 'No se puede eliminar la categoría porque tiene ' . $productosCount . ' producto(s) asociado(s).'
                ], 400);
            }

            // Eliminar categoría permanentemente
            DB::table('categorias')->where('id', $id)->delete();

            // Respuesta de eliminación exitosa
            return response()->json([
                'success' => true,
                'message' => 'Categoría eliminada correctamente.'
            ], 200);
        } catch (Exception $e) {
            // Manejo de errores en eliminación
            return response()->json([
                'success' => false,
                'error' => 'Error al eliminar categoría: ' . $e->getMessage()
            ], 500);
        }
    }
}