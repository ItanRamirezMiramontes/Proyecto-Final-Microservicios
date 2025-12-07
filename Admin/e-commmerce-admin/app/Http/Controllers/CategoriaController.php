<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Session;

class CategoriaController extends Controller
{
    protected $baseApiUrl;

    public function __construct()
    {
        $this->baseApiUrl = rtrim(env('API_BASE_URL'), '/');
    }

    /**
     * Muestra la lista de categorías
     */
    public function index()
    {
        try {
            $response = Http::get("{$this->baseApiUrl}/categorias");

            if ($response->successful()) {
                $body = $response->json();
                if ($body['success'] ?? false) {
                    $categorias = $body['data'];
                    return view('categorias.index', compact('categorias'));
                } else {
                    Session::flash('error', $body['error'] ?? 'Error desconocido al obtener categorías.');
                }
            } else {
                Session::flash('error', 'Error ' . $response->status() . ': No se pudo conectar a la API.');
            }

        } catch (\Exception $e) {
            Log::error('HTTP Client Error en index: ' . $e->getMessage());
            Session::flash('error', 'Error de red: La API no está disponible.');
        }

        return view('categorias.index', ['categorias' => []]);
    }

    /**
     * Muestra el formulario para crear una nueva categoría
     */
    public function create()
    {
        return view('categorias.create');
    }

    /**
     * Almacena una nueva categoría
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
                
                $response = $httpRequest->asMultipart()->post("{$this->baseApiUrl}/categorias", $multipartData);
            } else {
                $response = $httpRequest->asForm()->post("{$this->baseApiUrl}/categorias", $data);
            }
            
            if ($response->successful()) {
                $body = $response->json();
                
                if ($body['success'] ?? false) {
                    Session::flash('success', $body['message'] ?? 'Categoría creada exitosamente.');
                    return redirect()->route('categorias.index');
                }
            }
            
            $body = $response->json();
            
            if ($response->status() == 400 && is_array($body['error'] ?? null)) {
                return redirect()->back()->withErrors($body['error'])->withInput();
            } else {
                $errorMessage = $body['error'] ?? 'Error desconocido al crear categoría. Código: ' . $response->status();
                Session::flash('error', $errorMessage);
                return redirect()->back()->withInput();
            }

        } catch (\Exception $e) {
            Log::error('HTTP Client Error en store: ' . $e->getMessage());
            Session::flash('error', 'Error inesperado al crear categoría: ' . $e->getMessage());
            return redirect()->back()->withInput();
        }
    }

    /**
     * Muestra el formulario para editar una categoría
     */
    public function edit($id)
    {
        try {
            $response = Http::get("{$this->baseApiUrl}/categorias/{$id}");

            if ($response->successful()) {
                $body = $response->json();
                if ($body['success'] ?? false) {
                    $categoria = $body['data'];
                    return view('categorias.edit', compact('categoria'));
                }
            }
            
            $body = $response->json();
            Session::flash('error', $body['error'] ?? 'Categoría no encontrada o error en la API.');
            return redirect()->route('categorias.index');

        } catch (\Exception $e) {
            Log::error('HTTP Client Error en edit: ' . $e->getMessage());
            Session::flash('error', 'Error de red al intentar editar la categoría.');
            return redirect()->route('categorias.index');
        }
    }

    /**
     * Actualiza una categoría existente
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
                
                $response = $httpRequest->asMultipart()->put("{$this->baseApiUrl}/categorias/{$id}", $multipartData);
            } else {
                $response = $httpRequest->asForm()->put("{$this->baseApiUrl}/categorias/{$id}", $data);
            }
            
            if ($response->successful()) {
                $body = $response->json();
                
                if ($body['success'] ?? false) {
                    Session::flash('success', $body['message'] ?? 'Categoría actualizada exitosamente.');
                    return redirect()->route('categorias.index');
                }
            }
            
            $body = $response->json();
            
            if ($response->status() == 400 && is_array($body['error'] ?? null)) {
                return redirect()->back()->withErrors($body['error'])->withInput();
            } else {
                $errorMessage = $body['error'] ?? 'Error desconocido al actualizar categoría. Código: ' . $response->status();
                Session::flash('error', $errorMessage);
                return redirect()->back()->withInput();
            }

        } catch (\Exception $e) {
            Log::error('HTTP Client Error en update: ' . $e->getMessage());
            Session::flash('error', 'Error inesperado al actualizar categoría: ' . $e->getMessage());
            return redirect()->back()->withInput();
        }
    }

    /**
     * Muestra una categoría específica
     */
    public function show($id)
    {
        try {
            $response = Http::get("{$this->baseApiUrl}/categorias/{$id}");

            if ($response->successful()) {
                $body = $response->json();
                if ($body['success'] ?? false) {
                    $categoria = $body['data'];
                    return view('categorias.show', compact('categoria'));
                }
            }
            
            $body = $response->json();
            Session::flash('error', $body['error'] ?? 'Categoría no encontrada o error en la API.');
            return redirect()->route('categorias.index');

        } catch (\Exception $e) {
            Log::error('HTTP Client Error en show: ' . $e->getMessage());
            Session::flash('error', 'Error de red al intentar ver la categoría.');
            return redirect()->route('categorias.index');
        }
    }

    /**
     * Elimina una categoría
     */
    public function destroy($id)
    {
        try {
            $response = Http::delete("{$this->baseApiUrl}/categorias/{$id}");
            $body = $response->json();

            if ($response->successful() && ($body['success'] ?? false)) {
                Session::flash('success', $body['message'] ?? 'Categoría eliminada exitosamente.');
            } else {
                Session::flash('error', $body['error'] ?? 'Error al eliminar la categoría.');
            }

        } catch (\Exception $e) {
            Log::error('HTTP Client Error en destroy: ' . $e->getMessage());
            Session::flash('error', 'Error de red al intentar eliminar.');
        }

        return redirect()->route('categorias.index');
    }
}