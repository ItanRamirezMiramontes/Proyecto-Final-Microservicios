<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Exception;

class TiendaController extends Controller
{
    private $apiBaseUrl;

    public function __construct()
    {
        // URL base de la API del backend
        $this->apiBaseUrl = 'http://localhost:8000/api';
    }

    // GET: /tienda - MOSTRAR VISTA DE TIENDA CON FILTROS
    public function index(Request $request)
    {
        try {
            // Inicializar variables con arrays vacíos por defecto
            $productos = [];
            $categorias = [];
            $marcas = [];

            // Obtener productos
            $productosResponse = $this->makeApiRequest('GET', '/productos');
            if ($productosResponse && isset($productosResponse['success']) && $productosResponse['success']) {
                $productos = is_array($productosResponse['data']) ? $productosResponse['data'] : [];
            }

            // Obtener categorías - CON MÁS VALIDACIONES
            $categoriasResponse = $this->makeApiRequest('GET', '/categorias');
            if ($categoriasResponse && isset($categoriasResponse['success']) && $categoriasResponse['success']) {
                $categorias = is_array($categoriasResponse['data']) ? $categoriasResponse['data'] : [];
            } else {
                // Si falla, asegurarnos que sea un array vacío
                $categorias = [];
            }

            // Obtener marcas - CON MÁS VALIDACIONES
            $marcasResponse = $this->makeApiRequest('GET', '/marcas');
            if ($marcasResponse && isset($marcasResponse['success']) && $marcasResponse['success']) {
                $marcas = is_array($marcasResponse['data']) ? $marcasResponse['data'] : [];
            } else {
                // Si falla, asegurarnos que sea un array vacío
                $marcas = [];
            }

            // Aplicar filtros localmente si es necesario
            if ($request->has('categoria_id') && $request->categoria_id) {
                $productos = array_filter($productos, function($producto) use ($request) {
                    return isset($producto['categoria_id']) && $producto['categoria_id'] == $request->categoria_id;
                });
            }

            if ($request->has('marca_id') && $request->marca_id) {
                $productos = array_filter($productos, function($producto) use ($request) {
                    return isset($producto['marca_id']) && $producto['marca_id'] == $request->marca_id;
                });
            }

            // Asegurarse de que todos sean arrays antes de pasar a la vista
            return view('tienda', [
                'productos' => is_array($productos) ? $productos : [],
                'categorias' => is_array($categorias) ? $categorias : [],
                'marcas' => is_array($marcas) ? $marcas : []
            ]);

        } catch (Exception $e) {
            // En caso de error, devolver arrays vacíos garantizados
            return view('tienda', [
                'productos' => [],
                'categorias' => [],
                'marcas' => [],
                'error' => 'Error de conexión: ' . $e->getMessage()
            ]);
        }
    }

    // GET: /tienda/{id} - MOSTRAR DETALLE DE PRODUCTO EN TIENDA
    public function show($id)
    {
        try {
            $response = $this->makeApiRequest('GET', "/productos/{$id}");
            
            if ($response && isset($response['success']) && $response['success']) {
                return view('productos.show', [
                    'producto' => $response['data'] ?? []
                ]);
            } else {
                return redirect()->route('tienda')
                    ->with('error', $response['error'] ?? 'Producto no encontrado');
            }
        } catch (Exception $e) {
            return redirect()->route('tienda')
                ->with('error', 'Error de conexión: ' . $e->getMessage());
        }
    }

    // MÉTODO PRIVADO PARA HACER PETICIONES A LA API
    private function makeApiRequest($method, $endpoint, $data = [])
    {
        $url = $this->apiBaseUrl . $endpoint;
        
        // Configurar opciones para context de stream
        $options = [
            'http' => [
                'method' => $method,
                'header' => "Content-Type: application/json\r\n",
                'timeout' => 30,
                'ignore_errors' => true
            ]
        ];

        if (!empty($data)) {
            $options['http']['content'] = json_encode($data);
        }

        $context = stream_context_create($options);
        
        try {
            $response = file_get_contents($url, false, $context);
            
            if ($response === false) {
                throw new Exception('Error en la petición HTTP');
            }

            $decodedResponse = json_decode($response, true);
            
            // Validar que la respuesta sea un array
            return is_array($decodedResponse) ? $decodedResponse : ['success' => false, 'error' => 'Respuesta inválida'];

        } catch (Exception $e) {
            // Fallback a cURL si file_get_contents falla
            return $this->makeApiRequestWithCurl($method, $url, $data);
        }
    }

    // MÉTODO ALTERNATIVO CON cURL
    private function makeApiRequestWithCurl($method, $url, $data = [])
    {
        if (!function_exists('curl_init')) {
            return ['success' => false, 'error' => 'cURL no disponible'];
        }

        $ch = curl_init();
        
        $options = [
            CURLOPT_URL => $url,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_CUSTOMREQUEST => $method,
            CURLOPT_TIMEOUT => 30,
            CURLOPT_HTTPHEADER => [
                'Content-Type: application/json',
            ]
        ];

        if (!empty($data)) {
            $options[CURLOPT_POSTFIELDS] = json_encode($data);
        }

        curl_setopt_array($ch, $options);

        $response = curl_exec($ch);
        $error = curl_error($ch);
        $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        
        curl_close($ch);

        if ($response === false) {
            return ['success' => false, 'error' => 'cURL Error: ' . $error];
        }

        $decodedResponse = json_decode($response, true);
        
        // Validar que la respuesta sea un array
        return is_array($decodedResponse) ? $decodedResponse : ['success' => false, 'error' => 'Respuesta inválida de la API'];
    }
}