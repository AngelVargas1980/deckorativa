<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;

class RoleController extends Controller

{
    public function index()
    {
        $usuarios = User::all();  // Traemos todos los usuarios
        return view('roles.index', compact('usuarios'));  // Vista para administrar roles
    }

    public function update(Request $request, $id)
    {
        $usuario = User::findOrFail($id);
        $usuario->rol = $request->rol;  // Actualizamos el rol del usuario
        $usuario->save();

        return redirect()->route('roles.index')->with('success', 'Rol actualizado correctamente.');
    }
}
