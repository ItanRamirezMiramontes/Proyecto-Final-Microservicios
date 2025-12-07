<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Log;

class PedidoClientController extends Controller
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
     * Mostrar historial de pedidos del usuario
     */
    public function index()
    {
        try {
            $response = Http::withHeaders($this->getHeaders())
                ->timeout(30)
                ->get($this->apiUrl . '/pedidos');
            
            if ($response->successful()) {
                $data = $response->json();
                
                if (isset($data['success']) && $data['success']) {
                    $pedidos = $data['data'];
                    return view('pedidos.index', compact('pedidos'));
                }
            }
            
            if ($response->status() === 401) {
                Session::forget(['client_token', 'client_user']);
                return redirect()->route('client.login')
                    ->with('error', 'Tu sesión ha expirado. Por favor inicia sesión nuevamente.');
            }
            
            // Mostrar vista con pedidos vacíos
            return view('pedidos.index')->with('pedidos', []);
            
        } catch (\Exception $e) {
            Log::error('Error en PedidoClientController@index: ' . $e->getMessage());
            return view('pedidos.index')->with('pedidos', []);
        }
    }
    
    /**
     * Mostrar detalle de un pedido específico
     */
    public function show($id)
    {
        try {
            $response = Http::withHeaders($this->getHeaders())
                ->timeout(30)
                ->get($this->apiUrl . "/pedidos/{$id}");
            
            if ($response->successful()) {
                $data = $response->json();
                
                if (isset($data['success']) && $data['success']) {
                    $pedido = $data['data'];
                    
                    // Verificar que el pedido pertenece al usuario actual
                    $userId = Session::get('client_user.id', null);
                    if ($pedido['usuario_id'] != $userId) {
                        return redirect()->route('pedido.index')
                            ->with('error', 'No tienes permiso para ver este pedido');
                    }
                    
                    return view('pedidos.show', compact('pedido'));
                }
            }
            
            if ($response->status() === 404) {
                return redirect()->route('pedido.index')
                    ->with('error', 'Pedido no encontrado');
            }
            
            if ($response->status() === 401) {
                Session::forget(['client_token', 'client_user']);
                return redirect()->route('client.login')
                    ->with('error', 'Tu sesión ha expirado. Por favor inicia sesión nuevamente.');
            }
            
            return redirect()->route('pedido.index')
                ->with('error', 'Error al cargar el pedido');
            
        } catch (\Exception $e) {
            Log::error('Error en PedidoClientController@show: ' . $e->getMessage());
            return redirect()->route('pedido.index')
                ->with('error', 'Error de conexión con el servidor');
        }
    }
    
    /**
     * Cancelar un pedido pendiente
     */
    public function cancelar(Request $request, $id)
    {
        try {
            // Validar que se esté enviando desde un formulario
            if (!$request->ajax() && $request->method() !== 'POST') {
                return redirect()->route('pedido.show', $id)
                    ->with('error', 'Método no permitido');
            }
            
            // Enviar solicitud de cancelación a la API
            $response = Http::withHeaders($this->getHeaders())
                ->timeout(30)
                ->put($this->apiUrl . "/pedidos/{$id}/cancelar");
            
            if ($response->successful()) {
                $data = $response->json();
                
                if (isset($data['success']) && $data['success']) {
                    // Si es una petición AJAX
                    if ($request->ajax()) {
                        return response()->json([
                            'success' => true,
                            'message' => 'Pedido cancelado exitosamente',
                            'redirect' => route('pedido.show', $id)
                        ]);
                    }
                    
                    return redirect()->route('pedido.show', $id)
                        ->with('success', 'Pedido cancelado exitosamente');
                }
            }
            
            $errorData = $response->json();
            $errorMessage = $errorData['message'] ?? 'Error al cancelar el pedido';
            
            // Si es una petición AJAX
            if ($request->ajax()) {
                return response()->json([
                    'success' => false,
                    'message' => $errorMessage
                ], $response->status());
            }
            
            return redirect()->route('pedido.show', $id)
                ->with('error', $errorMessage);
            
        } catch (\Exception $e) {
            Log::error('Error en PedidoClientController@cancelar: ' . $e->getMessage());
            
            if ($request->ajax()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Error de conexión con el servidor'
                ], 500);
            }
            
            return redirect()->route('pedido.show', $id)
                ->with('error', 'Error de conexión con el servidor');
        }
    }
    
    /**
     * Verificar estado de un pedido 
     */
    public function verificarEstado($id)
    {
        try {
            $response = Http::withHeaders($this->getHeaders())
                ->timeout(30)
                ->get($this->apiUrl . "/pedidos/{$id}");
            
            if ($response->successful()) {
                $data = $response->json();
                
                if (isset($data['success']) && $data['success']) {
                    $pedido = $data['data'];
                    
                    // Verificar que el pedido pertenece al usuario actual
                    $userId = Session::get('client_user.id', null);
                    if ($pedido['usuario_id'] != $userId) {
                        return response()->json([
                            'success' => false,
                            'message' => 'No autorizado'
                        ], 403);
                    }
                    
                    return response()->json([
                        'success' => true,
                        'data' => [
                            'id' => $pedido['id'],
                            'estado' => $pedido['estado'],
                            'fecha_cancelacion' => $pedido['fecha_cancelacion'] ?? null,
                            'updated_at' => $pedido['updated_at']
                        ]
                    ]);
                }
            }
            
            return response()->json([
                'success' => false,
                'message' => 'Error al verificar el estado del pedido'
            ], $response->status());
            
        } catch (\Exception $e) {
            Log::error('Error en PedidoClientController@verificarEstado: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Error de conexión'
            ], 500);
        }
    }
    
    /**
     * Descargar factura o recibo del pedido (PDF)
     */
    public function descargarFactura($id)
    {
        try {
            // Primero verificar que el pedido existe y pertenece al usuario
            $response = Http::withHeaders($this->getHeaders())
                ->timeout(30)
                ->get($this->apiUrl . "/pedidos/{$id}");
            
            if (!$response->successful()) {
                return redirect()->route('pedido.show', $id)
                    ->with('error', 'Pedido no encontrado');
            }
            
            $data = $response->json();
            if (!isset($data['success']) || !$data['success']) {
                return redirect()->route('pedido.show', $id)
                    ->with('error', 'Error al obtener información del pedido');
            }
            
            $pedido = $data['data'];
            
            // Verificar que el pedido pertenece al usuario actual
            $userId = Session::get('client_user.id', null);
            if ($pedido['usuario_id'] != $userId) {
                return redirect()->route('pedido.index')
                    ->with('error', 'No tienes permiso para descargar esta factura');
            }
            
            return redirect()->route('pedido.show', $id)
                ->with('info', 'Funcionalidad de descarga de factura en desarrollo');
            
        } catch (\Exception $e) {
            Log::error('Error en PedidoClientController@descargarFactura: ' . $e->getMessage());
            return redirect()->route('pedido.show', $id)
                ->with('error', 'Error de conexión con el servidor');
        }
    }
    
    /**
     * Obtener estadísticas de pedidos del usuario
     */
    public function estadisticas()
    {
        try {
            $response = Http::withHeaders($this->getHeaders())
                ->timeout(30)
                ->get($this->apiUrl . '/pedidos');
            
            if ($response->successful()) {
                $data = $response->json();
                
                if (isset($data['success']) && $data['success']) {
                    $pedidos = $data['data'];
                    
                    // Calcular estadísticas
                    $totalPedidos = count($pedidos);
                    $pendientes = 0;
                    $completados = 0;
                    $cancelados = 0;
                    $totalGastado = 0;
                    
                    foreach ($pedidos as $pedido) {
                        switch (strtolower($pedido['estado'])) {
                            case 'pendiente':
                                $pendientes++;
                                break;
                            case 'completado':
                            case 'entregado':
                            case 'pagado':
                                $completados++;
                                $totalGastado += $pedido['total'];
                                break;
                            case 'cancelado':
                                $cancelados++;
                                break;
                        }
                    }
                    
                    $estadisticas = [
                        'total_pedidos' => $totalPedidos,
                        'pendientes' => $pendientes,
                        'completados' => $completados,
                        'cancelados' => $cancelados,
                        'total_gastado' => $totalGastado,
                        'promedio_pedido' => $completados > 0 ? $totalGastado / $completados : 0
                    ];
                    
                    return response()->json([
                        'success' => true,
                        'data' => $estadisticas
                    ]);
                }
            }
            
            return response()->json([
                'success' => false,
                'message' => 'Error al obtener estadísticas'
            ], $response->status());
            
        } catch (\Exception $e) {
            Log::error('Error en PedidoClientController@estadisticas: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Error de conexión'
            ], 500);
        }
    }
}