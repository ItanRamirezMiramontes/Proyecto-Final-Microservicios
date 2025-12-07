<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UsuarioController;
use App\Http\Controllers\ProductoController;
use App\Http\Controllers\CategoriaController;
use App\Http\Controllers\MarcaController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\AuthController;
use App\Http\Middleware\AdminAuth;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

// Ruta pública principal
Route::get('/', function () {
    return view('welcome');
});

// RUTAS PÚBLICAS 
Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login'])->name('login.post');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// RUTAS ADMINISTRATIVAS PROTEGIDAS
Route::group(['prefix' => 'admin', 'middleware' => [AdminAuth::class]], function () {

    // DASHBOARD
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // RUTAS DE USUARIOS
    Route::get('usuarios', [UsuarioController::class, 'index'])->name('usuarios.index');
    Route::get('usuarios/create', [UsuarioController::class, 'create'])->name('usuarios.create');
    Route::post('usuarios', [UsuarioController::class, 'store'])->name('usuarios.store');
    Route::get('usuarios/{id}/edit', [UsuarioController::class, 'edit'])->name('usuarios.edit');
    Route::put('usuarios/{id}', [UsuarioController::class, 'update'])->name('usuarios.update');
    Route::get('usuarios/{id}', [UsuarioController::class, 'show'])->name('usuarios.show');
    Route::delete('usuarios/{id}', [UsuarioController::class, 'destroy'])->name('usuarios.destroy');

    // RUTAS DE PRODUCTOS
    Route::get('productos', [ProductoController::class, 'index'])->name('productos.index');
    Route::get('productos/create', [ProductoController::class, 'create'])->name('productos.create');
    Route::post('productos', [ProductoController::class, 'store'])->name('productos.store');
    Route::get('productos/{id}/edit', [ProductoController::class, 'edit'])->name('productos.edit');
    Route::put('productos/{id}', [ProductoController::class, 'update'])->name('productos.update');
    Route::get('productos/{id}', [ProductoController::class, 'show'])->name('productos.show');
    Route::delete('productos/{id}', [ProductoController::class, 'destroy'])->name('productos.destroy');

    // RUTAS DE CATEGORÍAS
    Route::get('categorias', [CategoriaController::class, 'index'])->name('categorias.index');
    Route::get('categorias/create', [CategoriaController::class, 'create'])->name('categorias.create');
    Route::post('categorias', [CategoriaController::class, 'store'])->name('categorias.store');
    Route::get('categorias/{id}/edit', [CategoriaController::class, 'edit'])->name('categorias.edit');
    Route::put('categorias/{id}', [CategoriaController::class, 'update'])->name('categorias.update');
    Route::get('categorias/{id}', [CategoriaController::class, 'show'])->name('categorias.show');
    Route::delete('categorias/{id}', [CategoriaController::class, 'destroy'])->name('categorias.destroy');

    // RUTAS DE MARCAS
    Route::get('marcas', [MarcaController::class, 'index'])->name('marcas.index');
    Route::get('marcas/create', [MarcaController::class, 'create'])->name('marcas.create');
    Route::post('marcas', [MarcaController::class, 'store'])->name('marcas.store');
    Route::get('marcas/{id}/edit', [MarcaController::class, 'edit'])->name('marcas.edit');
    Route::put('marcas/{id}', [MarcaController::class, 'update'])->name('marcas.update');
    Route::get('marcas/{id}', [MarcaController::class, 'show'])->name('marcas.show');
    Route::delete('marcas/{id}', [MarcaController::class, 'destroy'])->name('marcas.destroy');

});