<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\RoleController;

use Spatie\Permission\Models\Role;
use Spatie\Permission\Facades\Permission;
use Spatie\Permission\Middlewares\RoleMiddleware;
use Spatie\Permission\Middlewares\PermissionMiddleware;

use App\Http\Controllers\ClientController;
use App\Http\Controllers\ProductoController;
use App\Http\Controllers\CategoriaController;
use App\Http\Controllers\ServicioController;
use App\Http\Controllers\CotizacionController;
use App\Http\Controllers\PedidoController;
use App\Http\Controllers\PublicController;

/*
|--------------------------------------------------------------------------|
| Web Routes
|--------------------------------------------------------------------------|
*/

// Rutas públicas
Route::get('/', [PublicController::class, 'index'])->name('public.home');
Route::get('/servicios-publicos', [PublicController::class, 'servicios'])->name('public.servicios');
Route::get('/servicio-detalle/{id}', [PublicController::class, 'servicioDetalle'])->name('public.servicio.detalle');
Route::get('/carrito', [PublicController::class, 'carrito'])->name('public.carrito');
Route::get('/cotizar', [PublicController::class, 'cotizar'])->name('public.cotizar');
Route::post('/cotizar/pdf', [PublicController::class, 'generarPDFCotizacion'])->name('public.cotizar.pdf');
Route::post('/cotizar/enviar', [PublicController::class, 'enviarCotizacion'])->name('public.cotizar.enviar');

// Rutas de pagos públicos
Route::post('/payment/process-cart', [App\Http\Controllers\PaymentController::class, 'procesarCarrito'])->name('public.payment.process');
Route::get('/payment/success', [App\Http\Controllers\PaymentController::class, 'success'])->name('public.payment.success');
Route::get('/payment/cancel', [App\Http\Controllers\PaymentController::class, 'cancel'])->name('public.payment.cancel');
Route::post('/payment/webhook', [App\Http\Controllers\PaymentController::class, 'webhook'])->name('public.payment.webhook');
Route::get('/payment/status/{pago}', [App\Http\Controllers\PaymentController::class, 'verificarEstado'])->name('public.payment.status');

// Ruta de prueba para conexión con Recurrente
Route::get('/payment/test-connection', [App\Http\Controllers\PaymentController::class, 'probarConexion'])->name('public.payment.test');

Route::get('/dashboard', [\App\Http\Controllers\DashboardController::class, 'index'])
    ->middleware(['auth'])
    ->name('dashboard');

// Auth routes
require __DIR__.'/auth.php';

// Rutas para Roles (Accesibles solo por Admin)
Route::middleware(['auth'])->group(function () {
    // Rutas de Roles (Accesibles solo por Admin)
    Route::middleware(['role:Admin'])->group(function () {
        Route::resource('roles', RoleController::class);
        Route::get('roles-users', [RoleController::class, 'users'])->name('roles.users');
        Route::post('users/{user}/role', [RoleController::class, 'updateUserRole'])->name('roles.updateUserRole');


    // Rutas de Usuarios (Accesibles solo para Admin)
        Route::get('/usuarios', [UserController::class, 'index'])->name('usuarios.index');  // Solo Admin puede ver usuarios
        Route::get('/usuarios/crear', [UserController::class, 'create'])->name('usuarios.create');  // Crear usuarios solo Admin
        Route::get('/usuarios/{id}', [UserController::class, 'show'])->name('usuarios.show');
        Route::post('/usuarios', [UserController::class, 'store'])->name('usuarios.store');  // Crear usuarios solo Admin
        Route::get('/usuarios/{id}/editar', [UserController::class, 'edit'])->name('usuarios.edit');  // Editar usuarios solo Admin
        Route::put('/usuarios/{id}', [UserController::class, 'update'])->name('usuarios.update');  // Editar usuarios solo Admin
        Route::delete('/usuarios/{id}', [UserController::class, 'destroy'])->name('usuarios.destroy');  // Eliminar usuarios solo Admin

});

    // Rutas de usuarios eliminados (Accesibles solo por Admin)
    Route::middleware(['auth', 'role:Admin'])->group(function () {
        Route::get('/usuarios/eliminados', [UserController::class, 'eliminados'])->name('usuarios.eliminados');
    });


// //Rutas para Supervisores (Accesibles solo para Supervisor)
//Route::middleware(['role:Supervisor'])->group(function () {
//    Route::get('/usuarios/{id}', [UserController::class, 'show'])->name('usuarios.show');  // Supervisor solo puede ver usuarios
//    Route::get('/usuarios', [UserController::class, 'index'])->name('usuarios.index');  // Supervisor solo puede ver usuarios
//});
//
//
//// Rutas para Asesores (Accesibles solo para Asesor)
//Route::middleware(['role:Asesor'])->group(function () {
//    Route::get('/usuarios/{id}', [UserController::class, 'show'])->name('usuarios.show');  // Asesor solo puede ver usuarios
//    Route::get('/usuarios', [UserController::class, 'index'])->name('usuarios.index');  // Asesor solo puede ver usuarios
//});

    Route::resource('clients', ClientController::class);

    // Rutas para HU8: Gestión de Servicios, Productos y Categorías
    Route::resource('categorias', CategoriaController::class)->middleware('permission:view categorias');
    Route::resource('servicios', ServicioController::class)->middleware('permission:view servicios');
    
    // Rutas API para obtener datos dinámicamente
    Route::get('/api/categorias', [CategoriaController::class, 'obtenerCategorias'])->name('api.categorias')->middleware('permission:view categorias');
    Route::get('/api/servicios', [ServicioController::class, 'obtenerServicios'])->name('api.servicios')->middleware('permission:view servicios');
    
    // Rutas para HU7: Módulo de Cotización  
    Route::resource('cotizaciones', CotizacionController::class)->parameters(['cotizaciones' => 'cotizacion'])->middleware('permission:view cotizaciones');
    Route::patch('/cotizaciones/{cotizacion}/estado', [CotizacionController::class, 'cambiarEstado'])->name('cotizaciones.cambiarEstado')->middleware('permission:change state cotizaciones');
    Route::get('/cotizaciones/{cotizacion}/pdf', [CotizacionController::class, 'generarPDF'])->name('cotizaciones.pdf')->middleware('permission:generate pdf cotizaciones');
    Route::post('/cotizaciones/{cotizacion}/enviar', [CotizacionController::class, 'enviarEmail'])->name('cotizaciones.enviar')->middleware('permission:send email cotizaciones');

// Rutas para el controlador Producto
    Route::resource('productos', ProductoController::class);

    // Rutas para HU9: Módulo de Pedidos
    Route::resource('pedidos', PedidoController::class)->middleware('permission:view pedidos');
    Route::patch('/pedidos/{pedido}/estado', [PedidoController::class, 'cambiarEstado'])->name('pedidos.cambiarEstado')->middleware('permission:change state pedidos');
    Route::get('/pedidos/{pedido}/pdf', [PedidoController::class, 'generarPDF'])->name('pedidos.pdf')->middleware('permission:generate pdf pedidos');

});


