<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ClienteController;
use App\Http\Controllers\CocineroController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\PedidoController;
use App\Http\Controllers\ProductoController;
use App\Http\Controllers\FacturaController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\UsuarioController;

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

Route::get('/', function () {
    return view('welcome');
});

Route::prefix('cliente')->name('cliente.')->group(function () {
    Route::get('/', [ClienteController::class, 'index'])->name('index');
    Route::get('/menu', [ClienteController::class, 'menu'])->name('menu');
    Route::get('/desayunos', [ClienteController::class, 'desayunos'])->name('desayunos');
    Route::get('/antojos', [ClienteController::class, 'antojos'])->name('antojos');
    Route::get('/bebidas', [ClienteController::class, 'bebidas'])->name('bebidas');
    Route::get('/entradas', [ClienteController::class, 'entradas'])->name('entradas');
    Route::get('/platos', [ClienteController::class, 'platos'])->name('platos');
    Route::get('/postres', [ClienteController::class, 'postres'])->name('postres');
});

Route::prefix('cocinero')->name('cocinero.')->group(function () {
    Route::get('/', [CocineroController::class, 'index'])->name('index');
    Route::get('/pedidos', [CocineroController::class, 'pedidos'])->name('pedidos');
    // Agrega aquí más rutas según las vistas del módulo cocinero
});

// Rutas API para el panel AJAX del cocinero
Route::prefix('cocinero/api')->name('cocinero.api.')->group(function () {
    Route::get('/pedidos', [CocineroController::class, 'apiPedidos'])->name('pedidos');
    Route::post('/pedidos/{id}/listo', [CocineroController::class, 'apiMarcarListo'])->name('pedidos.listo');
});

Route::get('cocinero/panel', function() {
    return view('cocinero.panel');
})->name('cocinero.panel');

// Rutas de autenticación personalizadas
Route::get('login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('login', [AuthController::class, 'login']);
Route::get('register', [AuthController::class, 'register'])->name('register');
Route::post('register', [AuthController::class, 'handleRegister']);
Route::post('logout', [AuthController::class, 'logout'])->name('logout');
Route::get('logout', [AuthController::class, 'logout']);

// Panel cliente
Route::get('cliente/index', function() {
    return view('cliente.index');
})->name('cliente.index');

// Panel cocinero
Route::get('cocinero/index', function() {
    return view('cocinero.index');
})->name('cocinero.index');

Route::get('cliente/pedidos', [ClienteController::class, 'pedidos'])->name('cliente.pedidos');

// Panel cajero
Route::prefix('cajero')->name('cajero.')->middleware(['auth', 'role:admin,cajero'])->group(function () {
    Route::get('/', function() {
        return view('cajero.index');
    })->name('index');
    // Vista de registro de pedidos (compartida con admin)
    Route::get('/registro-pedidos', function() {
        return view('admin.registro_pedidos');
    })->name('registro_pedidos');
});

Route::post('/cliente/enviar-pedido', [PedidoController::class, 'store'])->name('cliente.enviar_pedido')->middleware('auth');

Route::middleware(['auth', 'role:admin,cocinero'])->get('/cocina/pedidos-pendientes', [PedidoController::class, 'pendientes'])->name('cocina.pedidos_pendientes');

// Panel admin
Route::middleware(['auth', 'role:admin'])->get('admin/panel', function() {
    return view('admin.panel');
})->name('admin.panel');

// Ruta principal del panel admin para redirección
Route::middleware(['auth', 'role:admin'])->get('admin', function() {
    return redirect()->route('admin.panel');
})->name('admin.index');

// Gestión de productos (panel admin)
Route::middleware(['auth', 'role:admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/productos', [ProductoController::class, 'gestion'])->name('productos.gestion');
    Route::post('/productos', [ProductoController::class, 'store'])->name('productos.store');
    Route::post('/productos/{id}', [ProductoController::class, 'update'])->name('productos.update');
    Route::delete('/productos/{id}', [ProductoController::class, 'destroy'])->name('productos.destroy');
});

// Vista de facturación (solo para cajero y admin)
Route::middleware(['auth', 'role:admin,cajero'])->get('/facturacion', function() {
    return view('facturacion');
})->name('facturacion');

// API de facturas (debe estar fuera de cualquier prefijo)
Route::middleware(['auth', 'role:admin,cajero'])->group(function () {
    Route::get('/facturas', [FacturaController::class, 'index']);
    Route::get('/facturas/{id}', [FacturaController::class, 'show']);
    Route::post('/facturas', [FacturaController::class, 'store']);
    Route::post('/facturas/{id}/anular', [FacturaController::class, 'anular']);
    Route::get('/facturas/{id}/imprimir', [FacturaController::class, 'imprimir']);
});

// API de productos para facturación
Route::middleware(['auth', 'role:admin,cajero'])->get('/productos', [\App\Http\Controllers\ProductoController::class, 'index']);

// Dashboard admin
Route::middleware(['auth', 'role:admin'])->group(function () {
    Route::get('/admin/dashboard', [\App\Http\Controllers\DashboardController::class, 'index'])->name('admin.dashboard');
    Route::get('/admin/dashboard/api', [\App\Http\Controllers\DashboardController::class, 'api'])->name('admin.dashboard.api');
});

// Gestión de usuarios admin
Route::middleware(['auth', 'role:admin'])->group(function () {
    Route::get('/admin/usuarios', [\App\Http\Controllers\UsuarioController::class, 'index'])->name('admin.usuarios');
    Route::get('/admin/usuarios/api', [\App\Http\Controllers\UsuarioController::class, 'apiList']);
    Route::post('/admin/usuarios/api', [\App\Http\Controllers\UsuarioController::class, 'apiStore']);
    Route::put('/admin/usuarios/api', [\App\Http\Controllers\UsuarioController::class, 'apiUpdate']);
    Route::delete('/admin/usuarios/api/{id}', [\App\Http\Controllers\UsuarioController::class, 'apiDelete']);
    Route::get('/admin/usuarios/api/{id}', [\App\Http\Controllers\UsuarioController::class, 'apiGet']);
});
