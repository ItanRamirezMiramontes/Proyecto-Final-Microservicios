<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Session;

// Importación de Controladores
use App\Http\Controllers\ClientAuthController;
use App\Http\Controllers\ProductoController;
use App\Http\Controllers\CategoriaController;
use App\Http\Controllers\MarcaController;
use App\Http\Controllers\CarritoClientController;
use App\Http\Controllers\CheckoutClientController;
use App\Http\Controllers\PedidoClientController;

// Middleware
use App\Http\Middleware\ClientAuth;

/*
|--------------------------------------------------------------------------
| Web Routes 
|--------------------------------------------------------------------------
*/

// =============================================
// 1. RUTAS PÚBLICAS
// =============================================

// Estáticas
Route::get('/', function () { return view('welcome'); })->name('welcome');
Route::get('/sobre-nosotros', function () { return view('sobre_nosotros'); })->name('sobre.nosotros');
Route::get('/contacto', function () { return view('contacto'); })->name('contacto');
Route::get('/terminos-condiciones', function () { return view('terminos'); })->name('terminos');
Route::get('/politica-privacidad', function () { return view('privacidad'); })->name('privacidad');

// --- CATÁLOGO DE PRODUCTOS ---
Route::get('/tienda', [ProductoController::class, 'tienda'])->name('tienda');
Route::get('/producto/{id}', [ProductoController::class, 'productoDetalle'])->name('producto.detalle');

// Rutas de búsqueda y filtrado 
Route::get('/buscar', [ProductoController::class, 'buscar'])->name('producto.buscar');
Route::get('/filtrar', [ProductoController::class, 'filtrar'])->name('producto.filtrar');

// Categorías y Marcas (Vistas individuales)
Route::get('/categorias', [CategoriaController::class, 'indexPublic'])->name('categorias.index');
Route::get('/categoria/{id}', [CategoriaController::class, 'showPublic'])->name('categoria.show');
Route::get('/marcas', [MarcaController::class, 'indexPublic'])->name('marcas.index');
Route::get('/marca/{id}', [MarcaController::class, 'showPublic'])->name('marca.show');

// =============================================
// 2. AUTENTICACIÓN (Guest - No Logueados)
// =============================================
Route::middleware('guest:web')->group(function () {
    Route::get('/login', [ClientAuthController::class, 'showLogin'])->name('client.login');
    Route::post('/login', [ClientAuthController::class, 'login'])->name('client.login.post');
    Route::get('/register', [ClientAuthController::class, 'showRegister'])->name('client.register');
    Route::post('/register', [ClientAuthController::class, 'register'])->name('client.register.post');
    
    // Recuperación de contraseña
    Route::get('/forgot-password', function () {
        return redirect()->route('client.login')->with('info', 'Contacta con soporte para recuperar tu contraseña.');
    })->name('client.password.request');
    
    Route::get('/reset-password/{token}', function ($token) {
        return redirect()->route('client.login')->with('info', 'Contacta con soporte para recuperar tu contraseña.');
    })->name('client.password.reset');
});

// =============================================
// 3. RUTAS PROTEGIDAS (Cliente Logueado)
// =============================================
Route::middleware([ClientAuth::class])->group(function () {
    
    // --- Dashboard y Perfil ---
    Route::post('/logout', [ClientAuthController::class, 'logout'])->name('client.logout');
    Route::get('/dashboard', [ClientAuthController::class, 'dashboard'])->name('client.dashboard');
    Route::get('/perfil', [ClientAuthController::class, 'profile'])->name('client.profile');
    Route::put('/perfil/actualizar', [ClientAuthController::class, 'updateProfile'])->name('client.profile.update');
    Route::put('/perfil/cambiar-password', [ClientAuthController::class, 'changePassword'])->name('client.password.change');
    
    // --- CARRITO DE COMPRAS (Conectado a API) ---
    // Rutas principales
    Route::get('/carrito', [CarritoClientController::class, 'index'])->name('carrito.index');
    Route::post('/carrito', [CarritoClientController::class, 'store'])->name('carrito.add');
    Route::put('/carrito/{id}', [CarritoClientController::class, 'update'])->name('carrito.update');
    Route::delete('/carrito/{id}', [CarritoClientController::class, 'destroy'])->name('carrito.delete');
    
    // Rutas adicionales para carrito
    Route::delete('/carrito/vaciar/todo', [CarritoClientController::class, 'vaciarTodo'])->name('carrito.vaciar.todo');
    Route::get('/carrito-count', [CarritoClientController::class, 'getCount'])->name('carrito.count');
    Route::get('/carrito/resumen', [CarritoClientController::class, 'getResumen'])->name('carrito.resumen');

    // --- CHECKOUT (Proceso de Pago) ---
    Route::get('/checkout', [CheckoutClientController::class, 'index'])->name('checkout.index');
    Route::post('/checkout', [CheckoutClientController::class, 'procesar'])->name('checkout.procesar');

    // --- PEDIDOS (Historial) ---
    Route::get('/mis-pedidos', [PedidoClientController::class, 'index'])->name('pedido.index');
    Route::get('/pedido/{id}', [PedidoClientController::class, 'show'])->name('pedido.show');
    Route::post('/pedido/{id}/cancelar', [PedidoClientController::class, 'cancelar'])->name('pedido.cancelar');
    
    // Rutas adicionales para pedidos
    Route::get('/pedido/{id}/verificar-estado', [PedidoClientController::class, 'verificarEstado'])->name('pedido.verificar.estado');
    Route::get('/pedido/{id}/descargar-factura', [PedidoClientController::class, 'descargarFactura'])->name('pedido.descargar.factura');
    Route::get('/mis-pedidos/estadisticas', [PedidoClientController::class, 'estadisticas'])->name('pedido.estadisticas');
    
    // --- Wishlist y Reseñas (ProductoController) ---
    Route::get('/wishlist', [ProductoController::class, 'wishlist'])->name('wishlist.index');
    Route::post('/wishlist/agregar/{productoId}', [ProductoController::class, 'agregarWishlist'])->name('wishlist.agregar');
    Route::delete('/wishlist/eliminar/{productoId}', [ProductoController::class, 'eliminarWishlist'])->name('wishlist.eliminar');
    Route::post('/producto/{id}/reseña', [ProductoController::class, 'agregarResena'])->name('producto.resena.agregar');
});

// =============================================
// 4. RUTAS AUXILIARES 
// =============================================
Route::get('/carrito/estado', function() {
    return response()->json([
        'autenticado' => Session::has('client_token'),
        'tiene_carrito' => Session::has('client_token') 
    ]);
})->name('carrito.estado');

Route::get('/auth/status', function() {
    return response()->json([
        'authenticated' => Session::has('client_token'),
        'user' => Session::get('client_user', null)
    ]);
})->name('auth.status');

// =============================================
// 5. REDIRECCIONES 
// =============================================

// Redirecciones útiles para UX/SEO
Route::redirect('/inicio', '/');
Route::redirect('/home', '/');
Route::redirect('/registro', '/register');
Route::redirect('/iniciar-sesion', '/login');
Route::redirect('/mi-cuenta', '/dashboard');
Route::redirect('/carro', '/carrito');
Route::redirect('/mi-carrito', '/carrito');
Route::redirect('/comprar', '/tienda');
Route::redirect('/checkout/pago', '/checkout');
Route::redirect('/ordenes', '/mis-pedidos');
Route::redirect('/pedidos', '/mis-pedidos');
Route::redirect('/historial', '/mis-pedidos');

Route::fallback(function () {
    return response()->view('errors.404', [], 404);
})->name('fallback.404');