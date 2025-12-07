<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Session;

class CheckoutClientController extends Controller
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
     * Mostrar página de checkout
     */
    public function index()
    {
        try {
            // Obtener resumen del carrito desde la API
            $response = Http::withHeaders($this->getHeaders())
                ->timeout(30)
                ->get($this->apiUrl . '/carrito/resumen');
            
            if ($response->successful()) {
                $data = $response->json();
                
                if (isset($data['success']) && $data['success']) {
                    $carrito = $data['data'];
                    
                    if (empty($carrito['items'])) {
                        return redirect()->route('carrito.index')
                            ->with('warning', 'Tu carrito está vacío. Agrega productos para continuar.');
                    }
                    
                    // Preparar las variables que espera la vista
                    $items = $carrito['items'] ?? [];
                    $resumen = [
                        'subtotal' => $carrito['subtotal'] ?? 0,
                        'impuestos' => $carrito['impuestos'] ?? 0,
                        'total' => $carrito['total'] ?? 0,
                        'cantidad_items' => $carrito['cantidad_items'] ?? 0
                    ];
                    
                    // Obtener datos del usuario para la dirección de envío
                    $user = Session::get('client_user', []);
                    
                    return view('checkout.index', compact('items', 'resumen'));
                }
            }
            
            if ($response->status() === 401) {
                Session::forget(['client_token', 'client_user']);
                return redirect()->route('client.login')
                    ->with('error', 'Tu sesión ha expirado. Por favor inicia sesión nuevamente.');
            }
            
            return redirect()->route('carrito.index')
                ->with('error', 'Error al cargar la información del carrito');
            
        } catch (\Exception $e) {
            \Log::error('Error en CheckoutClientController@index: ' . $e->getMessage());
            return redirect()->route('carrito.index')
                ->with('error', 'Error de conexión con el servidor');
        }
    }
    
    /**
     * Procesar checkout y crear pedido
     */
    public function procesar(Request $request)
    {
        $request->validate([
            'direccion_envio' => 'required|string|max:500',
            'metodo_pago' => 'required|in:tarjeta,efectivo,transferencia',
            'notas' => 'nullable|string|max:1000',
            'telefono' => 'required|string|max:20',
            'nombre_completo' => 'required|string|max:200',
        ]);
        
        try {
            $payload = [
                'direccion_envio' => $request->direccion_envio,
                'metodo_pago' => $request->metodo_pago,
                'telefono' => $request->telefono,
                'nombre_completo' => $request->nombre_completo,
            ];
            
            if ($request->filled('notas')) {
                $payload['notas'] = $request->notas;
            }
            
            $response = Http::withHeaders($this->getHeaders())
                ->timeout(30)
                ->post($this->apiUrl . '/pedidos', $payload);
            
            if ($response->successful()) {
                $data = $response->json();
                
                if (isset($data['success']) && $data['success']) {
                    $pedido = $data['data'];
                    
                    // Guardar información del pedido en sesión para confirmación
                    Session::flash('pedido_confirmado', $pedido);
                    
                    return redirect()->route('pedido.show', $pedido['id'])
                        ->with('success', '¡Pedido realizado con éxito! Número de pedido: ' . $pedido['id']);
                }
            }
            
            $errorData = $response->json();
            $errorMessage = $errorData['message'] ?? 'Error al procesar el pedido';
            
            return redirect()->back()
                ->withInput()
                ->with('error', $errorMessage);
            
        } catch (\Exception $e) {
            \Log::error('Error en CheckoutClientController@procesar: ' . $e->getMessage());
            return redirect()->back()
                ->withInput()
                ->with('error', 'Error de conexión con el servidor. Por favor intenta nuevamente.');
        }
    }
}