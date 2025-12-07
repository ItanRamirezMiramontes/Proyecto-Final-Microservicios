<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Storage;
use Exception;

class ProductoController extends Controller
{
    // GET: /api/productos - OBTENER TODOS LOS PRODUCTOS CON FILTROS
    public function index(Request $request)
    {
        try {
            // 1. Iniciar la consulta 
            $query = DB::table('productos')
                ->leftJoin('categorias', 'productos.categoria_id', '=', 'categorias.id')
                ->leftJoin('marcas', 'productos.marca_id', '=', 'marcas.id')
                ->select(
                    'productos.*',
                    'categorias.nombre as categoria_nombre',
                    'marcas.nombre as marca_nombre'
                );

            // 2. Aplicar filtro de Categoría 
            if ($request->filled('categoria_id')) {
                $query->where('productos.categoria_id', $request->categoria_id);
            }

            // 3. Aplicar filtro de Marca 
            if ($request->filled('marca_id')) {
                $query->where('productos.marca_id', $request->marca_id);
            }

            // 4. Aplicar filtro de Búsqueda 
            if ($request->filled('buscar')) {
                $termino = $request->buscar;
                $query->where(function($q) use ($termino) {
                    $q->where('productos.nombre', 'like', '%' . $termino . '%')
                      ->orWhere('productos.descripcion', 'like', '%' . $termino . '%');
                });
            }

            // 5. Ejecutar la consulta final
            $productos = $query->get();
            
            // Procesar URLs de imágenes para cada producto
            $productos = $this->procesarUrlsImagenes($productos);

            // Respuesta exitosa con datos
            return response()->json([
                'success' => true,
                'data' => $productos,
                'message' => 'Productos obtenidos correctamente.'
            ], 200);

        } catch (Exception $e) {
            // Manejo de errores del servidor
            return response()->json([
                'success' => false,
                'error' => 'Error al obtener los productos: ' . $e->getMessage()
            ], 500);
        }
    }

    // GET: /api/productos/{id} - OBTENER UN PRODUCTO ESPECÍFICO
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
            // Buscar producto específico con JOIN
            $producto = DB::table('productos')
                ->leftJoin('categorias', 'productos.categoria_id', '=', 'categorias.id')
                ->leftJoin('marcas', 'productos.marca_id', '=', 'marcas.id')
                ->select(
                    'productos.*',
                    'categorias.nombre as categoria_nombre',
                    'marcas.nombre as marca_nombre'
                )
                ->where('productos.id', $id)
                ->first();

            // Verificar si el producto existe
            if (!$producto) {
                return response()->json([
                    'success' => false,
                    'error' => 'No se encontró ningún producto con ese ID.'
                ], 404);
            }

            // Procesar URLs de imágenes para este producto
            $producto = $this->procesarUrlsImagenesProducto($producto);

            // Retornar producto encontrado
            return response()->json([
                'success' => true, 
                'data' => $producto
            ], 200);
        } catch (Exception $e) {
            // Manejo de errores internos
            return response()->json([
                'success' => false,
                'error' => 'Error interno del servidor: ' . $e->getMessage()
            ], 500);
        }
    }

    // POST: /api/productos - CREAR UN NUEVO PRODUCTO
    public function store(Request $req)
    {
        // Reglas de validación para crear producto
        $rules = [
            'nombre' => 'required|string|max:255',
            'descripcion' => 'nullable|string',
            'precio' => 'required|numeric|min:0',
            'stock' => 'required|integer|min:0',
            'categoria_id' => 'nullable|exists:categorias,id',
            'marca_id' => 'nullable|exists:marcas,id',
            'imagen_1' => 'sometimes|image|mimes:jpeg,png,jpg|max:2048',
            'imagen_2' => 'sometimes|image|mimes:jpeg,png,jpg|max:2048',
            'imagen_3' => 'sometimes|image|mimes:jpeg,png,jpg|max:2048',
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
            // Insertar producto y obtener ID generado
            $id = DB::table('productos')->insertGetId([
                'nombre' => $req->nombre,
                'descripcion' => $req->descripcion,
                'precio' => $req->precio,
                'stock' => $req->stock,
                'categoria_id' => $req->categoria_id,
                'marca_id' => $req->marca_id,
                'imagen_1' => null,
                'imagen_2' => null,
                'imagen_3' => null
            ]);

            if ($id > 0) {
                $this->manejarImagenesProducto($req, $id);
            }

            // Confirmar transacción
            DB::commit();

            // Obtener producto creado con datos completos
            $producto = DB::table('productos')
                ->leftJoin('categorias', 'productos.categoria_id', '=', 'categorias.id')
                ->leftJoin('marcas', 'productos.marca_id', '=', 'marcas.id')
                ->select(
                    'productos.*',
                    'categorias.nombre as categoria_nombre',
                    'marcas.nombre as marca_nombre'
                )
                ->where('productos.id', $id)
                ->first();

            // Procesar URLs de imágenes para el producto creado
            $producto = $this->procesarUrlsImagenesProducto($producto);

            // Respuesta de creación exitosa
            return response()->json([
                'success' => true,
                'message' => 'Producto creado exitosamente.',
                'data' => $producto
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

    // PUT/PATCH: /api/productos/{id} - ACTUALIZAR PRODUCTO EXISTENTE
    public function update(Request $req, $id)
    {
        // Validar ID numérico
        if (!is_numeric($id)) {
            return response()->json([
                'success' => false,
                'error' => 'El ID proporcionado no es válido.'
            ], 400);
        }

        // Verificar que el producto existe
        $producto = DB::table('productos')->where('id', $id)->first();
        if (!$producto) {
            return response()->json([
                'success' => false,
                'error' => 'No se encontró ningún producto con ese ID.'
            ], 404);
        }

        // Reglas de validación para actualización
        $rules = [
            'nombre' => 'sometimes|required|string|max:255',
            'descripcion' => 'nullable|string',
            'precio' => 'sometimes|required|numeric|min:0',
            'stock' => 'sometimes|required|integer|min:0',
            'categoria_id' => 'nullable|exists:categorias,id',
            'marca_id' => 'nullable|exists:marcas,id',
            'imagen_1' => 'sometimes|image|mimes:jpeg,png,jpg|max:2048',
            'imagen_2' => 'sometimes|image|mimes:jpeg,png,jpg|max:2048',
            'imagen_3' => 'sometimes|image|mimes:jpeg,png,jpg|max:2048',
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
            DB::table('productos')->where('id', $id)->update($validator->validated());

            // Manejar nuevas imágenes si se proporcionaron
            $this->manejarImagenesProducto($req, $id);

            // Confirmar transacción
            DB::commit();

            // Obtener producto actualizado
            $actualizado = DB::table('productos')
                ->leftJoin('categorias', 'productos.categoria_id', '=', 'categorias.id')
                ->leftJoin('marcas', 'productos.marca_id', '=', 'marcas.id')
                ->select(
                    'productos.*',
                    'categorias.nombre as categoria_nombre',
                    'marcas.nombre as marca_nombre'
                )
                ->where('productos.id', $id)
                ->first();

            // Procesar URLs de imágenes para el producto actualizado
            $actualizado = $this->procesarUrlsImagenesProducto($actualizado);

            // Respuesta de actualización exitosa
            return response()->json([
                'success' => true,
                'message' => 'Producto actualizado correctamente.',
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

    // DELETE: /api/productos/{id} - ELIMINAR PRODUCTO
    public function destroy($id)
    {
        // Validar ID numérico
        if (!is_numeric($id)) {
            return response()->json([
                'success' => false,
                'error' => 'El ID proporcionado no es válido.'
            ], 400);
        }

        // Verificar que el producto existe
        $producto = DB::table('productos')->where('id', $id)->first();
        if (!$producto) {
            return response()->json([
                'success' => false,
                'error' => 'No se encontró ningún producto con ese ID.'
            ], 404);
        }

        try {
            // Eliminar las imágenes del producto si existen
            $this->eliminarImagenesProducto($producto);

            // Eliminar producto permanentemente
            DB::table('productos')->where('id', $id)->delete();

            // Respuesta de eliminación exitosa
            return response()->json([
                'success' => true,
                'message' => 'Producto eliminado correctamente.'
            ], 200);
        } catch (Exception $e) {
            // Manejo de errores en eliminación
            return response()->json([
                'success' => false,
                'error' => 'Error al eliminar producto: ' . $e->getMessage()
            ], 500);
        }
    }


    private function manejarImagenesProducto(Request $req, $productoId)
    {
        $camposImagen = ['imagen_1', 'imagen_2', 'imagen_3'];
        $updates = [];

        foreach ($camposImagen as $index => $campo) {
            if ($req->hasFile($campo)) {
                $imagen = $req->file($campo);
                $extension = $imagen->extension();
                $nuevo_nombre = "producto_" . $productoId . "_" . ($index + 1) . "." . $extension;
                $ruta = $imagen->storeAs('imagenes_productos', $nuevo_nombre, 'public');
                $updates[$campo] = $ruta;
            }
        }

        if (!empty($updates)) {
            DB::table('productos')->where('id', $productoId)->update($updates);
        }
    }

    private function procesarUrlsImagenes($productos)
    {
        return collect($productos)->map(function ($producto) {
            return $this->procesarUrlsImagenesProducto($producto);
        })->toArray();
    }

    private function procesarUrlsImagenesProducto($producto)
    {
        if (!$producto) return $producto;
        
        $productoArray = (array) $producto;
        $camposImagen = ['imagen_1', 'imagen_2', 'imagen_3'];
        
        foreach ($camposImagen as $campo) {
            if (isset($productoArray[$campo]) && $productoArray[$campo]) {
                $productoArray[$campo . '_url'] = url("/storage/{$productoArray[$campo]}");
            } else {
                $productoArray[$campo . '_url'] = null;
            }
        }
        
        return is_object($producto) ? (object) $productoArray : $productoArray;
    }

    private function eliminarImagenesProducto($producto)
    {
        $camposImagen = ['imagen_1', 'imagen_2', 'imagen_3'];
        
        foreach ($camposImagen as $campo) {
            if ($producto->$campo && Storage::disk('public')->exists($producto->$campo)) {
                Storage::disk('public')->delete($producto->$campo);
            }
        }
    }
}