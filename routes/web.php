<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;

use App\Http\Middleware\RoleMiddleware;
use Illuminate\Foundation\Http\Kernel as HttpKernel;
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
    return view('public.inicio');
});

Route::get('/dashboard', [\App\Http\Controllers\DashboardController::class, 'index'])
    ->middleware(['auth'])
    ->name('dashboard');


//Route::middleware('auth')->group(function () {
//    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
//    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
//    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
//
//    });

// Auth routes
    require __DIR__.'/auth.php';

// Nuevo usuario / Crear usuario
Route::middleware(['auth'])->group(function () {
    Route::get('/usuarios', [UserController::class, 'index'])->name('usuarios.index');
    Route::get('/usuarios/crear', [UserController::class, 'create'])->name('usuarios.create');
    Route::post('/usuarios', [UserController::class, 'store'])->name('usuarios.store');




    //Usuarios

//Ver o consultar usuarios
    Route::get('/usuarios/{id}', [UserController::class, 'show'])->name('usuarios.show');

//Editar usuario
    Route::get('/usuarios/{id}/editar', [UserController::class, 'edit'])->name('usuarios.edit');
    Route::put('/usuarios/{id}', [UserController::class, 'update'])->name('usuarios.update');

//Eliminar usuario
    Route::delete('/usuarios/{id}', [UserController::class, 'destroy'])->name('usuarios.destroy');

//Para mostrar los usuarios eliminados
//Route::get('usuarios/eliminados', [UserController::class, 'showDeleted'])->name('usuarios.eliminados');
    Route::get('/usuarios/eliminados', [UserController::class, 'eliminados'])->name('usuarios.eliminados');

//Para mostrar los usuarios restaurados
    Route::patch('/usuarios/{id}/restore', [UserController::class, 'restore'])->name('usuarios.restore');


    // Ruta para Roles, solo accesible para Administradores
    Route::middleware(['auth', 'role:Admin'])->group(function () {
        Route::get('/roles', [RoleController::class, 'index'])->name('roles.index');  // Vista de roles
        Route::patch('/roles/{id}', [RoleController::class, 'update'])->name('roles.update');  // Actualizar rol
    });

    Route::get('/inicio', function () {
        return view('public.inicio');  // Esto mostrará la vista 'public.inicio'
    })->name('inicio');  // Asegúrate de que esta ruta tenga el nombre 'inicio'




});

