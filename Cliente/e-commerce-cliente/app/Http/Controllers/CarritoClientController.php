<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Log;

class CarritoClientController extends Controller
{
    protected $apiUrl;
    
    public function __construct()
    {
        $this->apiUrl = env('API_URL', 'http://localhost:8000/api');
    }
    
    /**
     * Obtener headers con token de autenticación desde sesión
     */
    private function getHeaders()
    {
        $headers = [
            'Accept' => 'application/json',
            'Content-Type' => 'application/json',
        ];
        
        if (Session::has('client_token')) {
            $headers['Authorization'] = 'Bearer ' . Session::get('client_token');
        }
        
        return $headers;
    }
    
    /**
     * Mostrar carrito de compras
     */
    public function index()
    {
        try {
            $response = Http::withHeaders($this->getHeaders())
                ->timeout(30)
                ->get($this->apiUrl . '/carrito');
            
            if ($response->successful()) {
                $data = $response->json();
                
                if (isset($data['success']) && $data['success']) {
                    $carrito = $data['data'];
                    return view('carrito.index', compact('carrito'));
                }
            }
            
            if ($response->status() === 401) {
                Session::forget(['client_token', 'client_user']);
                return redirect()->route('client.login')
                    ->with('error', 'Tu sesión ha expirado. Por favor inicia sesión nuevamente.');
            }
            
            return view('carrito.index', [
                'carrito' => [
                    'items' => [],
                    'resumen' => [
                        'subtotal' => 0,
                        'impuestos' => 0,
                        'total' => 0,
                        'cantidad_items' => 0
                    ]
                ]
            ]);
            
        } catch (\Exception $e) {
            Log::error('Error en CarritoClientController@index: ' . $e->getMessage());
            return view('carrito.index', [
                'carrito' => [
                    'items' => [],
                    'resumen' => [
                        'subtotal' => 0,
                        'impuestos' => 0,
                        'total' => 0,
                        'cantidad_items' => 0
                    ]
                ]
            ]);
        }
    }
    
    /**
     * Agregar producto al carrito
     */
    public function store(Request $request)
    {
        $request->validate([
            'producto_id' => 'required|integer',
            'cantidad' => 'required|integer|min:1'
        ]);
        
        try {
            // Hacer petición a la API para agregar al carrito
            $response = Http::withHeaders($this->getHeaders())
                ->timeout(30)
                ->post($this->apiUrl . '/carrito', [
                    'producto_id' => $request->producto_id,
                    'cantidad' => $request->cantidad
                ]);
            
            if ($response->successful()) {
                $data = $response->json();
                
                // Obtener la cantidad total actual del carrito DESPUÉS de agregar
                $carritoResponse = Http::withHeaders($this->getHeaders())
                    ->timeout(30)
                    ->get($this->apiUrl . '/carrito');
                
                $cantidadTotal = 0;
                $subtotal = 0;
                $total = 0;
                
                if ($carritoResponse->successful()) {
                    $carritoData = $carritoResponse->json();
                    if (isset($carritoData['success']) && $carritoData['success']) {
                        $cantidadTotal = $carritoData['data']['resumen']['cantidad_items'] ?? 0;
                        $subtotal = $carritoData['data']['resumen']['subtotal'] ?? 0;
                        $total = $carritoData['data']['resumen']['total'] ?? 0;
                    }
                }
                
                if ($request->ajax()) {
                    return response()->json([
                        'success' => true,
                        'message' => 'Producto agregado al carrito',
                        'data' => [
                            'item' => $data['data'] ?? null,
                            'cantidad_total' => $cantidadTotal,
                            'resumen' => [
                                'subtotal' => $subtotal,
                                'total' => $total,
                                'cantidad_items' => $cantidadTotal
                            ]
                        ]
                    ]);
                }
                
                return redirect()->back()->with('success', 'Producto agregado al carrito');
            }
            
            $errorData = $response->json();
            $errorMessage = $errorData['message'] ?? 'Error al agregar al carrito';
            
            // Verificar si es error de stock
            if (str_contains(strtolower($errorMessage), 'stock') || str_contains(strtolower($errorMessage), 'insuficiente')) {
                $errorMessage = "Stock insuficiente. " . $errorMessage;
            }
            
            if ($request->ajax()) {
                return response()->json([
                    'success' => false,
                    'message' => $errorMessage,
                    'status' => $response->status()
                ], $response->status());
            }
            
            return redirect()->back()->with('error', $errorMessage);
            
        } catch (\Exception $e) {
            Log::error('Error en CarritoClientController@store: ' . $e->getMessage());
            
            if ($request->ajax()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Error de conexión con el servidor. Por favor intenta nuevamente.',
                    'error' => env('APP_DEBUG') ? $e->getMessage() : null
                ], 500);
            }
            
            return redirect()->back()->with('error', 'Error de conexión con el servidor. Por favor intenta nuevamente.');
        }
    }
    
    /**
     * Actualizar cantidad en carrito
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'cantidad' => 'required|integer|min:1'
        ]);
        
        try {
            $response = Http::withHeaders($this->getHeaders())
                ->timeout(30)
                ->put($this->apiUrl . "/carrito/{$id}", [
                    'cantidad' => $request->cantidad
                ]);
            
            if ($response->successful()) {
                $data = $response->json();
                
                // Obtener carrito actualizado
                $carritoResponse = Http::withHeaders($this->getHeaders())
                    ->timeout(30)
                    ->get($this->apiUrl . '/carrito');
                
                $cantidadTotal = 0;
                $subtotal = 0;
                $total = 0;
                
                if ($carritoResponse->successful()) {
                    $carritoData = $carritoResponse->json();
                    if (isset($carritoData['success']) && $carritoData['success']) {
                        $cantidadTotal = $carritoData['data']['resumen']['cantidad_items'] ?? 0;
                        $subtotal = $carritoData['data']['resumen']['subtotal'] ?? 0;
                        $total = $carritoData['data']['resumen']['total'] ?? 0;
                    }
                }
                
                if ($request->ajax()) {
                    return response()->json([
                        'success' => true,
                        'message' => 'Cantidad actualizada',
                        'data' => [
                            'cantidad_total' => $cantidadTotal,
                            'resumen' => [
                                'subtotal' => $subtotal,
                                'total' => $total,
                                'cantidad_items' => $cantidadTotal
                            ]
                        ]
                    ]);
                }
                
                return redirect()->back()->with('success', 'Cantidad actualizada');
            }
            
            $errorData = $response->json();
            $errorMessage = $errorData['message'] ?? 'Error al actualizar';
            
            if ($request->ajax()) {
                return response()->json([
                    'success' => false,
                    'message' => $errorMessage,
                    'status' => $response->status()
                ], $response->status());
            }
            
            return redirect()->back()->with('error', $errorMessage);
            
        } catch (\Exception $e) {
            Log::error('Error en CarritoClientController@update: ' . $e->getMessage());
            
            if ($request->ajax()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Error de conexión con el servidor'
                ], 500);
            }
            
            return redirect()->back()->with('error', 'Error de conexión con el servidor');
        }
    }
    
    /**
     * Eliminar producto del carrito
     */
    public function destroy($id)
    {
        try {
            $response = Http::withHeaders($this->getHeaders())
                ->timeout(30)
                ->delete($this->apiUrl . "/carrito/{$id}");
            
            if ($response->successful()) {
                $data = $response->json();
                
                // Obtener carrito actualizado
                $carritoResponse = Http::withHeaders($this->getHeaders())
                    ->timeout(30)
                    ->get($this->apiUrl . '/carrito');
                
                $cantidadTotal = 0;
                $subtotal = 0;
                $total = 0;
                
                if ($carritoResponse->successful()) {
                    $carritoData = $carritoResponse->json();
                    if (isset($carritoData['success']) && $carritoData['success']) {
                        $cantidadTotal = $carritoData['data']['resumen']['cantidad_items'] ?? 0;
                        $subtotal = $carritoData['data']['resumen']['subtotal'] ?? 0;
                        $total = $carritoData['data']['resumen']['total'] ?? 0;
                    }
                }
                
                if (request()->ajax()) {
                    return response()->json([
                        'success' => true,
                        'message' => 'Producto eliminado del carrito',
                        'data' => [
                            'cantidad_total' => $cantidadTotal,
                            'resumen' => [
                                'subtotal' => $subtotal,
                                'total' => $total,
                                'cantidad_items' => $cantidadTotal
                            ]
                        ]
                    ]);
                }
                
                return redirect()->back()->with('success', 'Producto eliminado del carrito');
            }
            
            $errorData = $response->json();
            $errorMessage = $errorData['message'] ?? 'Error al eliminar del carrito';
            
            if (request()->ajax()) {
                return response()->json([
                    'success' => false,
                    'message' => $errorMessage,
                    'status' => $response->status()
                ], $response->status());
            }
            
            return redirect()->back()->with('error', $errorMessage);
            
        } catch (\Exception $e) {
            Log::error('Error en CarritoClientController@destroy: ' . $e->getMessage());
            
            if (request()->ajax()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Error de conexión con el servidor'
                ], 500);
            }
            
            return redirect()->back()->with('error', 'Error de conexión con el servidor');
        }
    }
    
    /**
     * Obtener solo el contador del carrito (para AJAX)
     */
    public function getCount()
    {
        try {
            $response = Http::withHeaders($this->getHeaders())
                ->timeout(30)
                ->get($this->apiUrl . '/carrito');
            
            if ($response->successful()) {
                $data = $response->json();
                
                if (isset($data['success']) && $data['success']) {
                    $count = $data['data']['resumen']['cantidad_items'] ?? 0;
                    return response()->json([
                        'success' => true,
                        'count' => $count,
                        'timestamp' => now()->toISOString()
                    ]);
                }
            }
            
            if ($response->status() === 401) {
                // Usuario no autenticado
                return response()->json([
                    'success' => false,
                    'count' => 0,
                    'message' => 'No autenticado',
                    'redirect' => route('client.login')
                ], 401);
            }
            
            return response()->json([
                'success' => false,
                'count' => 0,
                'message' => 'No se pudo obtener el carrito'
            ]);
            
        } catch (\Exception $e) {
            Log::error('Error en CarritoClientController@getCount: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'count' => 0,
                'message' => 'Error de conexión'
            ]);
        }
    }
    
    /**
     * Vaciar todo el carrito
     */
    public function vaciarTodo()
    {
        try {
            // Obtener todos los items del carrito
            $response = Http::withHeaders($this->getHeaders())
                ->timeout(30)
                ->get($this->apiUrl . '/carrito');
            
            if ($response->successful()) {
                $data = $response->json();
                if (isset($data['success']) && $data['success']) {
                    $items = $data['data']['items'] ?? [];
                    
                    // Eliminar cada item individualmente
                    foreach ($items as $item) {
                        $deleteResponse = Http::withHeaders($this->getHeaders())
                            ->timeout(30)
                            ->delete($this->apiUrl . "/carrito/{$item['id']}");
                    }
                    
                    return redirect()->back()->with('success', 'Carrito vaciado correctamente');
                }
            }
            
            return redirect()->back()->with('error', 'Error al vaciar el carrito');
            
        } catch (\Exception $e) {
            Log::error('Error en CarritoClientController@vaciarTodo: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Error de conexión al vaciar el carrito');
        }
    }
    
    /**
     * Obtener resumen del carrito (para checkout)
     */
    public function getResumen()
    {
        try {
            $response = Http::withHeaders($this->getHeaders())
                ->timeout(30)
                ->get($this->apiUrl . '/carrito/resumen');
            
            if ($response->successful()) {
                $data = $response->json();
                
                if (isset($data['success']) && $data['success']) {
                    return response()->json([
                        'success' => true,
                        'data' => $data['data']
                    ]);
                }
            }
            
            return response()->json([
                'success' => false,
                'message' => 'No se pudo obtener el resumen del carrito'
            ]);
            
        } catch (\Exception $e) {
            Log::error('Error en CarritoClientController@getResumen: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Error de conexión'
            ]);
        }
    }
}