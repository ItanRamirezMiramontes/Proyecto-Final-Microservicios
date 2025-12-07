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
        $this->baseApiUrl = rtrim(env('API_BASE_URL'), '/');
    }

    /**
     * Muestra la lista de productos
     */
    public function index()
    {
        try {
            // Obtener productos, categorías y marcas
            $productosResponse = Http::get("{$this->baseApiUrl}/productos");
            $categoriasResponse = Http::get("{$this->baseApiUrl}/categorias");
            $marcasResponse = Http::get("{$this->baseApiUrl}/marcas");

            $productos = [];
            $categorias = [];
            $marcas = [];

            if ($productosResponse->successful()) {
                $body = $productosResponse->json();
                $productos = $body['success'] ? ($body['data'] ?? []) : [];
            }

            if ($categoriasResponse->successful()) {
                $body = $categoriasResponse->json();
                $categorias = $body['success'] ? ($body['data'] ?? []) : [];
            }

            if ($marcasResponse->successful()) {
                $body = $marcasResponse->json();
                $marcas = $body['success'] ? ($body['data'] ?? []) : [];
            }

            return view('productos.index', compact('productos', 'categorias', 'marcas'));

        } catch (\Exception $e) {
            Log::error('HTTP Client Error en index: ' . $e->getMessage());
            Session::flash('error', 'Error de red: La API no está disponible.');
            return view('productos.index', ['productos' => [], 'categorias' => [], 'marcas' => []]);
        }
    }

    /**
     * Muestra el formulario para crear un nuevo producto
     */
    public function create()
    {
        try {
            $categorias = $this->obtenerCategorias();
            $marcas = $this->obtenerMarcas();
            
        } catch (\Exception $e) {
            $categorias = [];
            $marcas = [];
            Log::error('Error al obtener categorías o marcas: ' . $e->getMessage());
        }

        return view('productos.create', compact('categorias', 'marcas'));
    }

    /**
     * Almacena un nuevo producto
     */
    public function store(Request $request)
    {
        try {
            $data = $request->except(['_token', 'imagen_1', 'imagen_2', 'imagen_3']);
            
            $httpRequest = Http::timeout(30);
            
            if ($request->hasAny(['imagen_1', 'imagen_2', 'imagen_3'])) {
                $multipartData = [];
                
                foreach ($data as $key => $value) {
                    $multipartData[] = [
                        'name' => $key,
                        'contents' => $value
                    ];
                }
                
                for ($i = 1; $i <= 3; $i++) {
                    $fieldName = "imagen_$i";
                    if ($request->hasFile($fieldName)) {
                        $multipartData[] = [
                            'name' => $fieldName,
                            'contents' => fopen($request->file($fieldName)->getRealPath(), 'r'),
                            'filename' => $request->file($fieldName)->getClientOriginalName()
                        ];
                    }
                }
                
                $response = $httpRequest->asMultipart()->post("{$this->baseApiUrl}/productos", $multipartData);
            } else {
                $response = $httpRequest->asForm()->post("{$this->baseApiUrl}/productos", $data);
            }
            
            if ($response->successful()) {
                $body = $response->json();
                
                if ($body['success'] ?? false) {
                    Session::flash('success', $body['message'] ?? 'Producto creado exitosamente.');
                    return redirect()->route('productos.index');
                }
            }
            
            $body = $response->json();
            
            if ($response->status() == 400 && is_array($body['error'] ?? null)) {
                return redirect()->back()->withErrors($body['error'])->withInput();
            } else {
                $errorMessage = $body['error'] ?? 'Error desconocido al crear producto. Código: ' . $response->status();
                Session::flash('error', $errorMessage);
                return redirect()->back()->withInput();
            }

        } catch (\Exception $e) {
            Log::error('HTTP Client Error en store: ' . $e->getMessage());
            Session::flash('error', 'Error inesperado al crear producto: ' . $e->getMessage());
            return redirect()->back()->withInput();
        }
    }

    /**
     * Muestra el formulario para editar un producto
     */
    public function edit($id)
    {
        try {
            $response = Http::get("{$this->baseApiUrl}/productos/{$id}");

            if ($response->successful()) {
                $body = $response->json();
                if ($body['success'] ?? false) {
                    $producto = $body['data'];
                    
                    $categorias = $this->obtenerCategorias();
                    $marcas = $this->obtenerMarcas();
                    
                    return view('productos.edit', compact('producto', 'categorias', 'marcas'));
                }
            }
            
            $body = $response->json();
            Session::flash('error', $body['error'] ?? 'Producto no encontrado o error en la API.');
            return redirect()->route('productos.index');

        } catch (\Exception $e) {
            Log::error('HTTP Client Error en edit: ' . $e->getMessage());
            Session::flash('error', 'Error de red al intentar editar el producto.');
            return redirect()->route('productos.index');
        }
    }

    /**
     * Actualiza un producto existente
     */
    public function update(Request $request, $id)
    {
        try {
            $data = $request->except(['_token', '_method', 'imagen_1', 'imagen_2', 'imagen_3']);
            
            $httpRequest = Http::timeout(30);
            
            if ($request->hasAny(['imagen_1', 'imagen_2', 'imagen_3'])) {
                $multipartData = [];
                
                foreach ($data as $key => $value) {
                    $multipartData[] = [
                        'name' => $key,
                        'contents' => $value
                    ];
                }
                
                for ($i = 1; $i <= 3; $i++) {
                    $fieldName = "imagen_$i";
                    if ($request->hasFile($fieldName)) {
                        $multipartData[] = [
                            'name' => $fieldName,
                            'contents' => fopen($request->file($fieldName)->getRealPath(), 'r'),
                            'filename' => $request->file($fieldName)->getClientOriginalName()
                        ];
                    }
                }
                
                $response = $httpRequest->asMultipart()->put("{$this->baseApiUrl}/productos/{$id}", $multipartData);
            } else {
                $response = $httpRequest->asForm()->put("{$this->baseApiUrl}/productos/{$id}", $data);
            }
            
            if ($response->successful()) {
                $body = $response->json();
                
                if ($body['success'] ?? false) {
                    Session::flash('success', $body['message'] ?? 'Producto actualizado exitosamente.');
                    return redirect()->route('productos.index');
                }
            }
            
            $body = $response->json();
            
            if ($response->status() == 400 && is_array($body['error'] ?? null)) {
                return redirect()->back()->withErrors($body['error'])->withInput();
            } else {
                $errorMessage = $body['error'] ?? 'Error desconocido al actualizar producto. Código: ' . $response->status();
                Session::flash('error', $errorMessage);
                return redirect()->back()->withInput();
            }

        } catch (\Exception $e) {
            Log::error('HTTP Client Error en update: ' . $e->getMessage());
            Session::flash('error', 'Error inesperado al actualizar producto: ' . $e->getMessage());
            return redirect()->back()->withInput();
        }
    }

    /**
     * Muestra un producto específico
     */
    public function show($id)
    {
        try {
            $response = Http::get("{$this->baseApiUrl}/productos/{$id}");

            if ($response->successful()) {
                $body = $response->json();
                if ($body['success'] ?? false) {
                    $producto = $body['data'];
                    return view('productos.show', compact('producto'));
                }
            }
            
            $body = $response->json();
            Session::flash('error', $body['error'] ?? 'Producto no encontrado o error en la API.');
            return redirect()->route('productos.index');

        } catch (\Exception $e) {
            Log::error('HTTP Client Error en show: ' . $e->getMessage());
            Session::flash('error', 'Error de red al intentar ver el producto.');
            return redirect()->route('productos.index');
        }
    }

    /**
     * Elimina un producto
     */
    public function destroy($id)
    {
        try {
            $response = Http::delete("{$this->baseApiUrl}/productos/{$id}");
            $body = $response->json();

            if ($response->successful() && ($body['success'] ?? false)) {
                Session::flash('success', $body['message'] ?? 'Producto eliminado exitosamente.');
            } else {
                Session::flash('error', $body['error'] ?? 'Error al eliminar el producto.');
            }

        } catch (\Exception $e) {
            Log::error('HTTP Client Error en destroy: ' . $e->getMessage());
            Session::flash('error', 'Error de red al intentar eliminar.');
        }

        return redirect()->route('productos.index');
    }

    /**
     * Métodos privados auxiliares
     */
    private function obtenerCategorias()
    {
        try {
            $response = Http::get("{$this->baseApiUrl}/categorias");
            
            if ($response->successful()) {
                $body = $response->json();
                return $body['success'] ? ($body['data'] ?? []) : [];
            }
        } catch (\Exception $e) {
            Log::error('Error al obtener categorías: ' . $e->getMessage());
        }
        
        return [];
    }

    private function obtenerMarcas()
    {
        try {
            $response = Http::get("{$this->baseApiUrl}/marcas");
            
            if ($response->successful()) {
                $body = $response->json();
                return $body['success'] ? ($body['data'] ?? []) : [];
            }
        } catch (\Exception $e) {
            Log::error('Error al obtener marcas: ' . $e->getMessage());
        }
        
        return [];
    }
}