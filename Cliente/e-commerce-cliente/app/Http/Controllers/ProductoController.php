<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Session;

class ProductoController extends Controller
{
    protected $baseApiUrl;

    public function __construct()
    {
        $this->baseApiUrl = rtrim(env('API_BASE_URL', 'http://localhost:8000/api'), '/');
    }

    /**
     * Muestra la tienda.
     */
    public function tienda(Request $request)
    {
        try {
            Log::info('=== INICIANDO TIENDA ===');
            Log::info('API URL: ' . $this->baseApiUrl);
            
            $params = [];
            
            // Filtro por categoría
            if ($request->filled('categoria_id')) {
                $params['categoria_id'] = $request->categoria_id;
            }
            
            // Filtro por marca
            if ($request->filled('marca_id')) {
                $params['marca_id'] = $request->marca_id;
            }

            // Búsqueda 
            if ($request->filled('q')) {
                $params['buscar'] = $request->q; 
            } elseif ($request->filled('buscar')) {
                $params['buscar'] = $request->buscar;
            }

            // 2. Obtener datos de la API
            $productosResponse = Http::timeout(10)->get("{$this->baseApiUrl}/productos", $params);
            $categoriasResponse = Http::timeout(10)->get("{$this->baseApiUrl}/categorias");
            $marcasResponse = Http::timeout(10)->get("{$this->baseApiUrl}/marcas");

            // 3. Procesar Productos
            $productos = [];
            if ($productosResponse->successful()) {
                $body = $productosResponse->json();
                if (isset($body['success']) && $body['success'] === true) {
                    $productos = $body['data']['data'] ?? $body['data'] ?? [];
                    $productos = $this->transformarProductosParaVista($productos);
                }
            }

            // 4. Procesar Categorías
            $categorias = [];
            if ($categoriasResponse->successful()) {
                $body = $categoriasResponse->json();
                if (isset($body['success']) && $body['success'] === true) {
                    $categorias = $body['data']['data'] ?? $body['data'] ?? [];
                }
            }

            // 5. Procesar Marcas
            $marcas = [];
            if ($marcasResponse->successful()) {
                $body = $marcasResponse->json();
                if (isset($body['success']) && $body['success'] === true) {
                    $marcas = $body['data']['data'] ?? $body['data'] ?? [];
                }
            }

            Log::info('Enviando a vista - Productos: ' . count($productos));

            // 6. Retornar vista con TODAS las variables necesarias para que no falle
            return view('tienda', [
                'productos' => $productos,
                'categorias' => $categorias,
                'marcas' => $marcas,
                'categoriaId' => $request->categoria_id, 
                'marcaId' => $request->marca_id,         
                'termino' => $request->q ?? $request->buscar 
            ]);

        } catch (\Exception $e) {
            Log::error('Error en tienda: ' . $e->getMessage());
            Session::flash('error', 'Error de conexión con la API.');
            
            return view('tienda', [
                'productos' => [], 
                'categorias' => [], 
                'marcas' => []
            ]);
        }
    }

    /**
     * Muestra el detalle de un producto específico
     */
    public function productoDetalle($id)
    {
        try {
            Log::info('Obteniendo detalle del producto ID: ' . $id);
            $response = Http::get("{$this->baseApiUrl}/productos/{$id}");

            if ($response->successful()) {
                $body = $response->json();
                
                if (isset($body['success']) && $body['success'] === true) {
                    $producto = $body['data'] ?? [];
                    
                    // Transformar el producto para la vista
                    $producto = $this->transformarProductoParaVista($producto);
                    
                    // Obtener productos relacionados
                    $productosRelacionados = $this->obtenerProductosRelacionados($producto);
                    
                    Log::info('Producto transformado para ID ' . $id);
                    Log::info('Productos relacionados: ' . count($productosRelacionados));
                    
                    return view('producto-detalle', compact('producto', 'productosRelacionados'));
                }
            }
            
            $body = $response->json();
            Session::flash('error', $body['error'] ?? 'Producto no encontrado.');
            return redirect()->route('tienda');

        } catch (\Exception $e) {
            Log::error('Error en productoDetalle: ' . $e->getMessage());
            Session::flash('error', 'Error al cargar el producto.');
            return redirect()->route('tienda');
        }
    }

    /**
     * Buscar productos 
     */
    public function buscar(Request $request)
    {
        return $this->tienda($request);
    }

    /**
     * Filtrar productos
     */
    public function filtrar(Request $request)
    {
        // Redirigimos a tienda pasando los parámetros
        return $this->tienda($request);
    }

    private function transformarProductosParaVista($productos)
    {
        $productosTransformados = [];
        
        if (!is_array($productos)) {
            return $productosTransformados;
        }
        
        foreach ($productos as $producto) {
            $productosTransformados[] = $this->transformarProductoParaVista($producto);
        }
        
        return $productosTransformados;
    }

    private function transformarProductoParaVista($producto)
    {
        if (!is_array($producto)) {
            return [];
        }
        
        // Extraer nombres de categoría y marca
        $categoriaNombre = null;
        $marcaNombre = null;
        
        if (isset($producto['categoria']) && is_array($producto['categoria'])) {
            $categoriaNombre = $producto['categoria']['nombre'] ?? null;
        } elseif (isset($producto['categoria_nombre'])) {
            $categoriaNombre = $producto['categoria_nombre'];
        }
        
        if (isset($producto['marca']) && is_array($producto['marca'])) {
            $marcaNombre = $producto['marca']['nombre'] ?? null;
        } elseif (isset($producto['marca_nombre'])) {
            $marcaNombre = $producto['marca_nombre'];
        }
        
        // Generar placeholder si no hay imagen
        $placeholderText = $producto['nombre'] ?? 'AutoParte';
        $placeholderUrl = 'https://placehold.co/600x400/EBF8FF/3182CE?text=' . urlencode(substr($placeholderText, 0, 20));
        
        return [
            'id' => $producto['id'] ?? 0,
            'nombre' => $producto['nombre'] ?? 'Sin nombre',
            'descripcion' => $producto['descripcion'] ?? 'Sin descripción',
            'precio' => $producto['precio'] ?? 0,
            'stock' => $producto['stock'] ?? 0,
            'categoria_id' => $producto['categoria_id'] ?? null,
            'marca_id' => $producto['marca_id'] ?? null,
            'categoria_nombre' => $categoriaNombre ?? 'Sin categoría',
            'marca_nombre' => $marcaNombre ?? null,
            'imagen_1_url' => $producto['imagen_1_url'] ?? $placeholderUrl,
            'imagen_2_url' => $producto['imagen_2_url'] ?? null,
            'imagen_3_url' => $producto['imagen_3_url'] ?? null,
        ];
    }

    private function obtenerProductosRelacionados($productoActual)
    {
        try {
            $categoriaId = $productoActual['categoria_id'] ?? null;
            $productoId = $productoActual['id'] ?? null;
            
            if (!$categoriaId || !$productoId) {
                return [];
            }

            $response = Http::get("{$this->baseApiUrl}/productos", [
                'categoria_id' => $categoriaId,
                'per_page' => 4
            ]);

            if ($response->successful()) {
                $body = $response->json();
                $productos = [];
                
                if (isset($body['success']) && $body['success'] === true) {
                    $productos = $body['data']['data'] ?? $body['data'] ?? [];
                    
                    $productosTransformados = [];
                    foreach ($productos as $producto) {
                        if (isset($producto['id']) && $producto['id'] == $productoId) {
                            continue;
                        }
                        
                        $productosTransformados[] = $this->transformarProductoParaVista($producto);
                        
                        if (count($productosTransformados) >= 3) {
                            break;
                        }
                    }
                    
                    return $productosTransformados;
                }
            }
        } catch (\Exception $e) {
            Log::error('Error al obtener productos relacionados: ' . $e->getMessage());
        }
        
        return [];
    }

    public function obtenerImagenPrincipal($producto)
    {
        if (!is_array($producto)) {
            return asset('images/producto-default.jpg');
        }
        
        if (isset($producto['imagen_1_url']) && $producto['imagen_1_url']) {
            return $producto['imagen_1_url'];
        }
        if (isset($producto['imagen_2_url']) && $producto['imagen_2_url']) {
            return $producto['imagen_2_url'];
        }
        if (isset($producto['imagen_3_url']) && $producto['imagen_3_url']) {
            return $producto['imagen_3_url'];
        }
        
        return asset('images/producto-default.jpg');
    }

    public function obtenerTodasImagenes($producto)
    {
        $imagenes = [];
        
        if (!is_array($producto)) {
            return $imagenes;
        }
        
        if (isset($producto['imagen_1_url']) && $producto['imagen_1_url']) {
            $imagenes[] = $producto['imagen_1_url'];
        }
        if (isset($producto['imagen_2_url']) && $producto['imagen_2_url']) {
            $imagenes[] = $producto['imagen_2_url'];
        }
        if (isset($producto['imagen_3_url']) && $producto['imagen_3_url']) {
            $imagenes[] = $producto['imagen_3_url'];
        }
        
        return $imagenes;
    }
}