<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\Api\AuthController; 
use App\Http\Controllers\Api\UsuarioController; 
use App\Http\Controllers\Api\MarcaController;
use App\Http\Controllers\Api\CategoriaController;
use App\Http\Controllers\Api\ProductoController;
use App\Http\Controllers\Api\ImageController;
use App\Http\Controllers\Api\PedidoController; 
use App\Http\Controllers\Api\CarritoController;

/*
|--------------------------------------------------------------------------
| RUTAS PÚBLICAS (NO REQUIEREN TOKEN)
|--------------------------------------------------------------------------
*/

// Autenticación pública
Route::post('/login', [AuthController::class, 'login'])->name('api.login');
Route::post('/register', [UsuarioController::class, 'register']);

// ==================== USUARIOS ====================
Route::get('/usuarios', [UsuarioController::class, 'index']);
Route::get('/usuarios/{id}', [UsuarioController::class, 'show']);
Route::post('/usuarios', [UsuarioController::class, 'store']);
Route::put('/usuarios/{id}', [UsuarioController::class, 'update']);
Route::delete('/usuarios/{id}', [UsuarioController::class, 'destroy']);
Route::get('/roles', [UsuarioController::class, 'getRoles']);

// ==================== CATEGORÍAS ====================
Route::get('/categorias', [CategoriaController::class, 'index']);
Route::get('/categorias/{id}', [CategoriaController::class, 'show']);
Route::post('/categorias', [CategoriaController::class, 'store']);
Route::put('/categorias/{id}', [CategoriaController::class, 'update']);
Route::delete('/categorias/{id}', [CategoriaController::class, 'destroy']);

// ==================== MARCAS ====================
Route::get('/marcas', [MarcaController::class, 'index']);
Route::get('/marcas/{id}', [MarcaController::class, 'show']);
Route::post('/marcas', [MarcaController::class, 'store']);      
Route::put('/marcas/{id}', [MarcaController::class, 'update']); 
Route::delete('/marcas/{id}', [MarcaController::class, 'destroy']); 

// ==================== PRODUCTOS ====================
Route::get('/productos', [ProductoController::class, 'index']);
Route::get('/productos/{id}', [ProductoController::class, 'show']);
Route::post('/productos', [ProductoController::class, 'store']);
Route::put('/productos/{id}', [ProductoController::class, 'update']);
Route::delete('/productos/{id}', [ProductoController::class, 'destroy']);

// Rutas de imágenes
Route::get('/storage/{folder}/{filename}', [ImageController::class, 'show'])
    ->where('folder', '[a-zA-Z0-9_-]+')
    ->where('filename', '[a-zA-Z0-9._-]+')
    ->name('api.images.show');

/*
|--------------------------------------------------------------------------
| RUTAS PROTEGIDAS (REQUIEREN TOKEN SANCTUM) 
|--------------------------------------------------------------------------
*/

Route::middleware('auth:sanctum')->group(function () {
    
    // --- Autenticación y Perfil ---
    Route::post('/logout', [AuthController::class, 'logout']);
    Route::get('/user', [AuthController::class, 'user']);
    Route::put('/usuarios/{usuario}/password', [UsuarioController::class, 'changePassword']);
    Route::put('/usuarios/{usuario}/profile', [UsuarioController::class, 'updateProfile']);
    
    // --- CARRITO DE COMPRAS (para clientes) ---
    Route::prefix('carrito')->group(function () {
        Route::get('/', [CarritoController::class, 'index']);
        Route::post('/', [CarritoController::class, 'agregar']);
        Route::get('/resumen', [CarritoController::class, 'index']);
        Route::put('/{id}', [CarritoController::class, 'actualizar']);
        Route::delete('/{id}', [CarritoController::class, 'eliminar']);
        Route::delete('/', [CarritoController::class, 'vaciar']);
    });
    
    // --- PEDIDOS (para clientes) ---
    Route::prefix('pedidos')->group(function () {
        Route::post('/', [PedidoController::class, 'store']);
        Route::get('/', [PedidoController::class, 'index']);
        Route::get('/{id}', [PedidoController::class, 'show']);
        Route::put('/{id}/cancelar', [PedidoController::class, 'cancelar']);
    });

    // --- RUTAS ESPECIALES DE ADMIN (si las necesitas) ---
    Route::middleware('admin')->group(function () {
        Route::get('/dashboard/estadisticas', function() {
            return response()->json(['message' => 'Estadísticas admin']);
        });
    });
});