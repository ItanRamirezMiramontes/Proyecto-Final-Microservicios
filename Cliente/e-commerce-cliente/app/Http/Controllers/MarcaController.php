<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Exception;

class MarcaController extends Controller
{
    // GET: /api/marcas - OBTENER TODAS LAS MARCAS
    public function index()
    {
        try {
            // Consulta para obtener todas las marcas
            $marcas = DB::table('marcas')->get();
            
            // Respuesta exitosa con datos
            return response()->json([
                'success' => true,
                'data' => $marcas,
                'message' => 'Marcas obtenidas correctamente.'
            ], 200);
        } catch (Exception $e) {
            // Manejo de errores del servidor
            return response()->json([
                'success' => false,
                'error' => 'Error al obtener las marcas: ' . $e->getMessage()
            ], 500);
        }
    }

    // GET: /api/marcas/{id} - OBTENER UNA MARCA ESPECÍFICA
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
            // Buscar marca específica
            $marca = DB::table('marcas')->where('id', $id)->first();

            // Verificar si la marca existe
            if (!$marca) {
                return response()->json([
                    'success' => false,
                    'error' => 'No se encontró ninguna marca con ese ID.'
                ], 404);
            }

            // Retornar marca encontrada
            return response()->json([
                'success' => true, 
                'data' => $marca
            ], 200);
        } catch (Exception $e) {
            // Manejo de errores internos
            return response()->json([
                'success' => false,
                'error' => 'Error interno del servidor: ' . $e->getMessage()
            ], 500);
        }
    }

    // POST: /api/marcas - CREAR UNA NUEVA MARCA
    public function store(Request $req)
    {
        // Reglas de validación para crear marca
        $rules = [
            'nombre' => 'required|string|max:255|unique:marcas,nombre', 
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
            // Insertar marca y obtener ID generado
            $id = DB::table('marcas')->insertGetId([
                'nombre' => $req->nombre,
                'descripcion' => $req->descripcion,
                'imagen' => null // Valor por defecto
            ]);

            // Manejar upload de imagen si se proporcionó
            if ($id > 0 && $req->hasFile('imagen')) {
                $imagen = $req->file('imagen');
                $extension = $imagen->extension();
                $nuevo_nombre = "marca_" . $id . "." . $extension; 
                $ruta = $imagen->storeAs('imagenes_marcas', $nuevo_nombre, 'public'); 
                DB::table('marcas')->where('id', $id)->update([
                    'imagen' => $ruta 
                ]);
            }

            // Confirmar transacción
            DB::commit();

            // Obtener marca creada con datos completos
            $marca = DB::table('marcas')->where('id', $id)->first();

            // Respuesta de creación exitosa
            return response()->json([
                'success' => true,
                'message' => 'Marca creada exitosamente.',
                'data' => $marca
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

    // PUT/PATCH: /api/marcas/{id} - ACTUALIZAR MARCA EXISTENTE
    public function update(Request $req, $id)
    {
        // Validar ID numérico
        if (!is_numeric($id)) {
            return response()->json([
                'success' => false,
                'error' => 'El ID proporcionado no es válido.'
            ], 400);
        }

        // Verificar que la marca existe
        $marca = DB::table('marcas')->where('id', $id)->first();
        if (!$marca) {
            return response()->json([
                'success' => false,
                'error' => 'No se encontró ninguna marca con ese ID.'
            ], 404);
        }

        // Reglas de validación para actualización (sometimes = solo si se envía el campo)
        $rules = [
            'nombre' => 'sometimes|required|string|max:255|unique:marcas,nombre,' . $id, 
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
            DB::table('marcas')->where('id', $id)->update($validator->validated());

            // Manejar nueva imagen si se proporcionó
            if ($req->hasFile('imagen')) {
                $imagen = $req->file('imagen');
                $extension = $imagen->extension();
                $nuevo_nombre = "marca_" . $id . "." . $extension;
                $ruta = $imagen->storeAs('imagenes_marcas', $nuevo_nombre, 'public');
                DB::table('marcas')->where('id', $id)->update([
                    'imagen' => $ruta
                ]);
            }

            // Confirmar transacción
            DB::commit();

            // Obtener marca actualizada
            $actualizado = DB::table('marcas')->where('id', $id)->first();

            // Respuesta de actualización exitosa
            return response()->json([
                'success' => true,
                'message' => 'Marca actualizada correctamente.',
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

    // DELETE: /api/marcas/{id} - ELIMINAR MARCA
    public function destroy($id)
    {
        // Validar ID numérico
        if (!is_numeric($id)) {
            return response()->json([
                'success' => false,
                'error' => 'El ID proporcionado no es válido.'
            ], 400);
        }

        // Verificar que la marca existe
        $marca = DB::table('marcas')->where('id', $id)->first();
        if (!$marca) {
            return response()->json([
                'success' => false,
                'error' => 'No se encontró ninguna marca con ese ID.'
            ], 404);
        }

        try {
            // Verificar si la marca tiene productos asociados
            $productosCount = DB::table('productos')->where('marca_id', $id)->count();
            
            if ($productosCount > 0) {
                return response()->json([
                    'success' => false,
                    'error' => 'No se puede eliminar la marca porque tiene ' . $productosCount . ' producto(s) asociado(s).'
                ], 400);
            }

            // Eliminar marca permanentemente
            DB::table('marcas')->where('id', $id)->delete();

            // Respuesta de eliminación exitosa
            return response()->json([
                'success' => true,
                'message' => 'Marca eliminada correctamente.'
            ], 200);
        } catch (Exception $e) {
            // Manejo de errores en eliminación
            return response()->json([
                'success' => false,
                'error' => 'Error al eliminar marca: ' . $e->getMessage()
            ], 500);
        }
    }
}