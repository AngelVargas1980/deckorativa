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
        // Verifica permiso para ver usuarios
        if (!auth()->user()->can('view users')) {
            abort(403, 'Unauthorized action.');
        }

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
        // Verifica permiso para crear usuarios
        if (!auth()->user()->can('create users')) {
            abort(403, 'Unauthorized action.');
        }
        return view('usuarios.create');
    }

    // Guardar usuario nuevo
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users',
            'password' => 'required|string|min:6|confirmed',
            'rol' => 'required|string|in:Admin,Asesor,Supervisor',  //Roles permitidos
            'estado' => 'required|boolean',
        ]);

        //Crear el usuario en la base de datos
        // Crear el usuario y asignarlo a la variable $usuario
        $usuario = User::create([
            'name' => $request->name,
            'apellidos' => $request->apellidos,
            'telefono' => $request->telefono,
            'email' => $request->email,
            'password' => bcrypt($request->password),
            'estado' => $request->estado,
            'rol' => $request->rol, // Guardar el rol en la base de datos
        ]);

// Asignar el rol al usuario
        $usuario->assignRole($request->rol);  // Asigna el rol al usuario

// Redirigir con mensaje de éxito
        return redirect()->route('usuarios.index')->with('success', 'Usuario creado correctamente.');
        }


    // Ver detalles del usuario
    public function show($id)
    {
        // Verifica permiso para ver usuarios
        if (!auth()->user()->can('view users')) {
            abort(403, 'Unauthorized action.');
        }
        $usuario = User::findOrFail($id);
        return view('usuarios.show', compact('usuario'));
    }

    // Editar usuario
    public function edit($id)
    {
        // Verifica permiso para ver usuarios
        if (!auth()->user()->can('edit users')) {
            abort(403, 'Unauthorized action.');
        }

        $usuario = User::findOrFail($id);
        return view('usuarios.edit', compact('usuario'));
    }

    // Actualizar usuario
    public function update(Request $request, $id)
    {

        // Verifica permiso para ver usuarios
        if (!auth()->user()->can('edit users')) {
            abort(403, 'Unauthorized action.');
        }

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

        // Verifica permiso para ver usuarios
        if (!auth()->user()->can('restore users')) {
            abort(403, 'Unauthorized action.');
        }

        $usuario = User::onlyTrashed()->findOrFail($id);
        $usuario->restore();

        return redirect()->route('usuarios.eliminados')->with('success', 'Usuario restaurado correctamente.');
    }

    // Eliminar usuario
    public function destroy($id)
    {
        // Verifica permiso para ver usuarios
        if (!auth()->user()->can('delete users')) {
            abort(403, 'Unauthorized action.');
        }

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
