<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Spatie\Permission\Models\Role;
class RoleController extends Controller

{
    public function index()
    {
        $cantidad = request('cantidad');

        if ($cantidad === 'all') {
            $usuarios = User::with('roles')->get();
            $paginado = false;
        } else {
            $usuarios = User::with('roles')->paginate($cantidad ?? 5);
            $paginado = true;
        }

        $roles = Role::all();

        return view('roles.index', compact('usuarios', 'roles', 'paginado'));
    }

    public function update(Request $request, $id)
    {
        $usuario = User::findOrFail($id);
        $usuario->syncRoles($request->rol); // asigna el nuevo rol con Spatie
        $usuario->rol = $request->rol;
        $usuario->save();
        return redirect()->route('roles.index')->with('success', 'Rol actualizado correctamente.');
    }
}
