<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\ProductoController;
use Spatie\Permission\Models\Role;

/*
|--------------------------------------------------------------------------|
| Web Routes
|--------------------------------------------------------------------------|
*/

Route::get('/', function () {
    return view('public.inicio');
});

Route::get('/dashboard', [\App\Http\Controllers\DashboardController::class, 'index'])
    ->middleware(['auth'])
    ->name('dashboard');

// Auth routes
require __DIR__.'/auth.php';

Route::middleware(['auth'])->group(function () {

    // Rutas de Usuarios (Accesibles solo para Admin)
    Route::middleware(['role:Admin'])->group(function () {
        Route::get('/usuarios', [UserController::class, 'index'])->name('usuarios.index');  // Solo Admin puede ver usuarios
        Route::get('/usuarios/crear', [UserController::class, 'create'])->name('usuarios.create');  // Crear usuarios solo Admin
        Route::post('/usuarios', [UserController::class, 'store'])->name('usuarios.store');  // Crear usuarios solo Admin
        Route::get('/usuarios/{id}/editar', [UserController::class, 'edit'])->name('usuarios.edit');  // Editar usuarios solo Admin
        Route::put('/usuarios/{id}', [UserController::class, 'update'])->name('usuarios.update');  // Editar usuarios solo Admin
        Route::delete('/usuarios/{id}', [UserController::class, 'destroy'])->name('usuarios.destroy');  // Eliminar usuarios solo Admin
    });

    // Rutas para Supervisores y Asesores solo ver usuarios
    Route::middleware(['role:Supervisor|Asesor'])->group(function () {
        Route::get('/usuarios/{id}', [UserController::class, 'show'])->name('usuarios.show');  // Ver usuarios
    });

    // Rutas para Restaurar y Eliminar usuarios (solo accesibles por Admin)
    Route::middleware(['role:Admin'])->group(function () {
        Route::get('/usuarios/eliminados', [UserController::class, 'eliminados'])->name('usuarios.eliminados');
        Route::patch('/usuarios/{id}/restore', [UserController::class, 'restore'])->name('usuarios.restore');
    });

    // Rutas para Roles (Accesibles solo por Admin)
    Route::middleware(['role:Admin'])->group(function () {
        Route::resource('roles', RoleController::class);
    });

    // Productos (Accesible solo por Admin y Supervisor con permisos específicos)
    Route::middleware(['role:Admin', 'permission:create productos'])->group(function () {
        Route::get('/productos/create', [ProductoController::class, 'create']);
        Route::post('/productos', [ProductoController::class, 'store']);
    });

    Route::middleware(['role:Supervisor', 'permission:edit productos'])->group(function () {
        Route::get('/productos/{id}/edit', [ProductoController::class, 'edit']);
        Route::put('/productos/{id}', [ProductoController::class, 'update']);
    });

});
