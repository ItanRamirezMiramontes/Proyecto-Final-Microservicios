<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Session;

class MarcaController extends Controller
{
    protected $baseApiUrl;

    public function __construct()
    {
        $this->baseApiUrl = rtrim(env('API_BASE_URL'), '/');
    }

    /**
     * Muestra la lista de marcas
     */
    public function index()
    {
        try {
            $response = Http::get("{$this->baseApiUrl}/marcas");

            if ($response->successful()) {
                $body = $response->json();
                if ($body['success'] ?? false) {
                    $marcas = $body['data'];
                    return view('marcas.index', compact('marcas'));
                } else {
                    Session::flash('error', $body['error'] ?? 'Error desconocido al obtener marcas.');
                }
            } else {
                Session::flash('error', 'Error ' . $response->status() . ': No se pudo conectar a la API.');
            }

        } catch (\Exception $e) {
            Log::error('HTTP Client Error en index: ' . $e->getMessage());
            Session::flash('error', 'Error de red: La API no está disponible.');
        }

        return view('marcas.index', ['marcas' => []]);
    }

    /**
     * Muestra el formulario para crear una nueva marca
     */
    public function create()
    {
        return view('marcas.create');
    }

    /**
     * Almacena una nueva marca
     */
    public function store(Request $request)
    {
        try {
            $data = $request->except(['_token']);
            
            $httpRequest = Http::timeout(30);
            
            if ($request->hasFile('imagen')) {
                $multipartData = [];
                
                foreach ($data as $key => $value) {
                    if ($key !== 'imagen') {
                        $multipartData[] = [
                            'name' => $key,
                            'contents' => $value
                        ];
                    }
                }
                
                $multipartData[] = [
                    'name' => 'imagen',
                    'contents' => fopen($request->file('imagen')->getRealPath(), 'r'),
                    'filename' => $request->file('imagen')->getClientOriginalName()
                ];
                
                $response = $httpRequest->asMultipart()->post("{$this->baseApiUrl}/marcas", $multipartData);
            } else {
                $response = $httpRequest->asForm()->post("{$this->baseApiUrl}/marcas", $data);
            }
            
            if ($response->successful()) {
                $body = $response->json();
                
                if ($body['success'] ?? false) {
                    Session::flash('success', $body['message'] ?? 'Marca creada exitosamente.');
                    return redirect()->route('marcas.index');
                }
            }
            
            $body = $response->json();
            
            if ($response->status() == 400 && is_array($body['error'] ?? null)) {
                return redirect()->back()->withErrors($body['error'])->withInput();
            } else {
                $errorMessage = $body['error'] ?? 'Error desconocido al crear marca. Código: ' . $response->status();
                Session::flash('error', $errorMessage);
                return redirect()->back()->withInput();
            }

        } catch (\Exception $e) {
            Log::error('HTTP Client Error en store: ' . $e->getMessage());
            Session::flash('error', 'Error inesperado al crear marca: ' . $e->getMessage());
            return redirect()->back()->withInput();
        }
    }

    /**
     * Muestra el formulario para editar una marca
     */
    public function edit($id)
{
    try {
        $response = Http::get("{$this->baseApiUrl}/marcas/{$id}");

        if ($response->successful()) {
            $body = $response->json();
            if ($body['success'] ?? false) {
                $marca = $body['data'];
                return view('marcas.edit', compact('marca'));
            }
        }
        
        $body = $response->json();
        Session::flash('error', $body['error'] ?? 'Marca no encontrada o error en la API.');
        return redirect()->route('marcas.index');

    } catch (\Exception $e) {
        Log::error('HTTP Client Error en edit: ' . $e->getMessage());
        Session::flash('error', 'Error de red al intentar editar la marca.');
        return redirect()->route('marcas.index');
    }
}

    /**
     * Actualiza una marca existente
     */
    public function update(Request $request, $id)
    {
        try {
            $data = $request->except(['_token', '_method']);
            
            $httpRequest = Http::timeout(30);
            
            if ($request->hasFile('imagen')) {
                $multipartData = [];
                
                foreach ($data as $key => $value) {
                    if ($key !== 'imagen') {
                        $multipartData[] = [
                            'name' => $key,
                            'contents' => $value
                        ];
                    }
                }
                
                $multipartData[] = [
                    'name' => 'imagen',
                    'contents' => fopen($request->file('imagen')->getRealPath(), 'r'),
                    'filename' => $request->file('imagen')->getClientOriginalName()
                ];
                
                $response = $httpRequest->asMultipart()->put("{$this->baseApiUrl}/marcas/{$id}", $multipartData);
            } else {
                $response = $httpRequest->asForm()->put("{$this->baseApiUrl}/marcas/{$id}", $data);
            }
            
            if ($response->successful()) {
                $body = $response->json();
                
                if ($body['success'] ?? false) {
                    Session::flash('success', $body['message'] ?? 'Marca actualizada exitosamente.');
                    return redirect()->route('marcas.index');
                }
            }
            
            $body = $response->json();
            
            if ($response->status() == 400 && is_array($body['error'] ?? null)) {
                return redirect()->back()->withErrors($body['error'])->withInput();
            } else {
                $errorMessage = $body['error'] ?? 'Error desconocido al actualizar marca. Código: ' . $response->status();
                Session::flash('error', $errorMessage);
                return redirect()->back()->withInput();
            }

        } catch (\Exception $e) {
            Log::error('HTTP Client Error en update: ' . $e->getMessage());
            Session::flash('error', 'Error inesperado al actualizar marca: ' . $e->getMessage());
            return redirect()->back()->withInput();
        }
    }

    /**
     * Muestra una marca específica
     */
    public function show($id)
    {
        try {
            $response = Http::get("{$this->baseApiUrl}/marcas/{$id}");

            if ($response->successful()) {
                $body = $response->json();
                if ($body['success'] ?? false) {
                    $marca = $body['data'];
                    return view('marcas.show', compact('marca'));
                }
            }
            
            $body = $response->json();
            Session::flash('error', $body['error'] ?? 'Marca no encontrada o error en la API.');
            return redirect()->route('marcas.index');

        } catch (\Exception $e) {
            Log::error('HTTP Client Error en show: ' . $e->getMessage());
            Session::flash('error', 'Error de red al intentar ver la marca.');
            return redirect()->route('marcas.index');
        }
    }

    /**
     * Elimina una marca
     */
    public function destroy($id)
    {
        try {
            $response = Http::delete("{$this->baseApiUrl}/marcas/{$id}");
            $body = $response->json();

            if ($response->successful() && ($body['success'] ?? false)) {
                Session::flash('success', $body['message'] ?? 'Marca eliminada exitosamente.');
            } else {
                Session::flash('error', $body['error'] ?? 'Error al eliminar la marca.');
            }

        } catch (\Exception $e) {
            Log::error('HTTP Client Error en destroy: ' . $e->getMessage());
            Session::flash('error', 'Error de red al intentar eliminar.');
        }

        return redirect()->route('marcas.index');
    }
}