<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\ProductoController;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Facades\Permission;
use Spatie\Permission\Middlewares\RoleMiddleware;
use Spatie\Permission\Middlewares\PermissionMiddleware;

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

// Rutas para Roles (Accesibles solo por Admin)
Route::middleware(['auth'])->group(function () {
    // Rutas de Roles (Accesibles solo por Admin)
    Route::middleware(['role:Admin'])->group(function () {
        Route::resource('roles', RoleController::class);


    // Rutas de Usuarios (Accesibles solo para Admin)
        Route::get('/usuarios/{id}', [UserController::class, 'show'])->name('usuarios.show');
        Route::get('/usuarios', [UserController::class, 'index'])->name('usuarios.index');  // Solo Admin puede ver usuarios
        Route::get('/usuarios/crear', [UserController::class, 'create'])->name('usuarios.create');  // Crear usuarios solo Admin
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



});


