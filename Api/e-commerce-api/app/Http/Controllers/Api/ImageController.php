<?php
namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Response;
use Symfony\Component\HttpFoundation\StreamedResponse;

class ImageController extends Controller
{
    /**
     * Servir imágenes desde el storage público
     */
    public function show(Request $request, $folder, $filename)
    {
        try {
            $path = "{$folder}/{$filename}";
            
            // Verificar que el archivo existe
            if (!Storage::disk('public')->exists($path)) {
                return response()->json([
                    'success' => false,
                    'error' => 'Imagen no encontrada'
                ], 404);
            }

            // Obtener el archivo y su tipo MIME
            $file = Storage::disk('public')->get($path);
            $mimeType = Storage::disk('public')->mimeType($path);
            $fileSize = Storage::disk('public')->size($path);

            // Configurar headers para cache y CORS
            $headers = [
                'Content-Type' => $mimeType,
                'Content-Length' => $fileSize,
                'Cache-Control' => 'public, max-age=31536000', // Cache de 1 año
                'Expires' => now()->addYear()->toRfc7231String(),
                'Access-Control-Allow-Origin' => '*', // Permitir acceso desde el frontend
            ];

            return response($file, 200, $headers);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'error' => 'Error al cargar la imagen: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Servir imagen específica de producto
     */
    public function productoImage($productoId, $imageNumber)
    {
        try {
            $filename = "producto_{$productoId}_{$imageNumber}";
            $possibleExtensions = ['jpg', 'jpeg', 'png', 'webp'];
            
            // Buscar el archivo con cualquier extensión
            foreach ($possibleExtensions as $ext) {
                $path = "imagenes_productos/{$filename}.{$ext}";
                if (Storage::disk('public')->exists($path)) {
                    $file = Storage::disk('public')->get($path);
                    $mimeType = Storage::disk('public')->mimeType($path);
                    
                    return response($file, 200, [
                        'Content-Type' => $mimeType,
                        'Cache-Control' => 'public, max-age=31536000',
                        'Access-Control-Allow-Origin' => '*',
                    ]);
                }
            }

            // Si no encuentra la imagen, devolver placeholder
            return $this->getPlaceholderImage();

        } catch (\Exception $e) {
            return $this->getPlaceholderImage();
        }
    }

    /**
     * Generar imagen placeholder
     */
    private function getPlaceholderImage()
    {
        $placeholder = '
        <svg width="400" height="300" xmlns="http://www.w3.org/2000/svg">
            <rect width="100%" height="100%" fill="#f3f4f6"/>
            <text x="50%" y="50%" font-family="Arial" font-size="16" text-anchor="middle" fill="#9ca3af">
                Imagen no disponible
            </text>
        </svg>';

        return response($placeholder, 200, [
            'Content-Type' => 'image/svg+xml',
            'Cache-Control' => 'public, max-age=3600', // 1 hora para placeholders
        ]);
    }
}