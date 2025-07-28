<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Permission;

class UserController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');  // Protege las rutas
    }

    // Mostrar lista de usuarios
    public function index()
    {
        $this->authorize('view users');  // Verifica permiso para ver usuarios

        // Paginación
        $cantidad = request('cantidad', 5);
        if ($cantidad === 'all') {
            $usuarios = User::get();
            $paginado = false;
        } else {
            $usuarios = User::paginate($cantidad);
            $paginado = true;
        }

        return view('usuarios.index', compact('usuarios', 'paginado'));
    }

    // Crear nuevo usuario
    public function create()
    {
        $this->authorize('create users');  // Verifica permiso para crear usuarios
        return view('usuarios.create');
    }

    // Guardar usuario nuevo
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users',
            'password' => 'required|string|min:6|confirmed',
            'rol' => 'required|string|in:Admin,Asesor,Cliente',
            'estado' => 'required|boolean',
        ]);

        User::create([
            'name' => $request->name,
            'apellidos' => $request->apellidos,
            'telefono' => $request->telefono,
            'email' => $request->email,
            'password' => bcrypt($request->password),
            'rol' => $request->rol,
            'estado' => $request->estado,
        ]);

        return redirect()->route('usuarios.index')->with('success', 'Usuario creado correctamente.');
    }

    // Ver detalles del usuario
    public function show($id)
    {
        $this->authorize('view users');  // Verifica permiso para ver usuarios
        $usuario = User::findOrFail($id);
        return view('usuarios.show', compact('usuario'));
    }

    // Editar usuario
    public function edit($id)
    {
        $this->authorize('edit users');  // Verifica permiso para editar usuarios
        $usuario = User::findOrFail($id);
        return view('usuarios.edit', compact('usuario'));
    }

    // Actualizar usuario
    public function update(Request $request, $id)
    {
        $this->authorize('edit users');  // Verifica permiso para editar usuarios

        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $id,
        ]);

        $usuario = User::findOrFail($id);

        $usuario->name = $request->name;
        $usuario->apellidos = $request->apellidos;
        $usuario->email = $request->email;
        $usuario->telefono = $request->telefono;
        $usuario->rol = $request->rol;
        $usuario->estado = $request->estado;

        if ($request->filled('password')) {
            $request->validate(['password' => 'confirmed|min:6']);
            $usuario->password = bcrypt($request->password);
        }

        $usuario->save();

        return redirect()->route('usuarios.index')->with('success', 'Usuario actualizado correctamente.');
    }

    // Restaurar usuario eliminado
    public function restore($id)
    {
        $this->authorize('restore users');  // Verifica permiso para restaurar usuarios
        $usuario = User::onlyTrashed()->findOrFail($id);
        $usuario->restore();

        return redirect()->route('usuarios.eliminados')->with('success', 'Usuario restaurado correctamente.');
    }

    // Eliminar usuario
    public function destroy($id)
    {
        $this->authorize('delete users');  // Verifica permiso para eliminar usuarios
        $usuario = User::withTrashed()->findOrFail($id);

        if ($usuario->trashed()) {
            $usuario->forceDelete();
            return redirect()->route('usuarios.eliminados')->with('success', 'Usuario eliminado permanentemente.');
        } else {
            $usuario->delete();
            return redirect()->route('usuarios.index')->with('success', 'Usuario eliminado correctamente.');
        }
    }
}
