<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class DashboardController extends Controller
{
    protected $baseApiUrl;

    public function __construct()
    {
        $this->baseApiUrl = rtrim(env('API_BASE_URL'), '/');
    }

    public function index()
    {
        try {
            // Obtener estadísticas desde las APIs
            $productosResponse = Http::get("{$this->baseApiUrl}/productos");
            $usuariosResponse = Http::get("{$this->baseApiUrl}/usuarios");
            $categoriasResponse = Http::get("{$this->baseApiUrl}/categorias");
            $marcasResponse = Http::get("{$this->baseApiUrl}/marcas");

            $totalProductos = 0;
            $totalUsuarios = 0;
            $totalCategorias = 0;
            $totalMarcas = 0;

            if ($productosResponse->successful()) {
                $body = $productosResponse->json();
                $productos = $body['success'] ? ($body['data'] ?? []) : [];
                $totalProductos = is_array($productos) ? count($productos) : 0;
            }

            if ($usuariosResponse->successful()) {
                $body = $usuariosResponse->json();
                $usuarios = $body['success'] ? ($body['data'] ?? []) : [];
                $totalUsuarios = is_array($usuarios) ? count($usuarios) : 0;
            }

            if ($categoriasResponse->successful()) {
                $body = $categoriasResponse->json();
                $categorias = $body['success'] ? ($body['data'] ?? []) : [];
                $totalCategorias = is_array($categorias) ? count($categorias) : 0;
            }

            if ($marcasResponse->successful()) {
                $body = $marcasResponse->json();
                $marcas = $body['success'] ? ($body['data'] ?? []) : [];
                $totalMarcas = is_array($marcas) ? count($marcas) : 0;
            }

            return view('dashboard', compact(
                'totalProductos',
                'totalUsuarios', 
                'totalCategorias',
                'totalMarcas'
            ));

        } catch (\Exception $e) {
            Log::error('Error al cargar dashboard: ' . $e->getMessage());
            
            // En caso de error, mostrar dashboard con valores en 0
            return view('dashboard', [
                'totalProductos' => 0,
                'totalUsuarios' => 0,
                'totalCategorias' => 0,
                'totalMarcas' => 0
            ]);
        }
    }
}