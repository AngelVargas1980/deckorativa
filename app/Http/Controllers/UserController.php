<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
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
        
        // Obtener roles dinámicos
        $roles = \Spatie\Permission\Models\Role::all();
        
        return view('usuarios.create', compact('roles'));
    }

    // Guardar usuario nuevo
    public function store(Request $request)
    {
        // Obtener roles disponibles dinámicamente
        $availableRoles = \Spatie\Permission\Models\Role::pluck('name')->toArray();
        
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => [
                'required',
                'email',
                \Illuminate\Validation\Rule::unique('users')->whereNull('deleted_at')
            ],
            'password' => 'required|string|min:6|confirmed',
            'rol' => 'required|string|in:' . implode(',', $availableRoles),  //Roles dinámicos
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
        
        // Obtener roles dinámicos
        $roles = \Spatie\Permission\Models\Role::all();
        
        return view('usuarios.edit', compact('usuario', 'roles'));
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
            'email' => [
                'required',
                'email',
                Rule::unique('users')->ignore($id)->whereNull('deleted_at')
            ],
        ]);

        $usuario = User::findOrFail($id);

        $usuario->name = $request->name;
        $usuario->apellidos = $request->apellidos;
        $usuario->email = $request->email;
        $usuario->telefono = $request->telefono;
        
        // Proteger al usuario admin principal
        if ($usuario->email === 'admin@deckorativa.com') {
            // El admin principal mantiene su rol y estado
            $usuario->rol = 'Admin';
            $usuario->estado = 1;
        } else {
            $usuario->rol = $request->rol;
            $usuario->estado = $request->estado;
        }

        if ($request->filled('password')) {
            $request->validate(['password' => 'confirmed|min:6']);
            $usuario->password = bcrypt($request->password);
        }

        $usuario->save();

        // Sincronizar el rol de Spatie Permission
        if ($request->has('rol')) {
            $usuario->syncRoles($request->rol);
        }

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
        
        // Proteger al usuario admin principal
        if ($usuario->email === 'admin@deckorativa.com') {
            return redirect()->route('usuarios.index')->with('error', 'El usuario administrador principal no puede ser eliminado por seguridad del sistema.');
        }

        if ($usuario->trashed()) {
            $usuario->forceDelete();
            return redirect()->route('usuarios.eliminados')->with('success', 'Usuario eliminado permanentemente.');
        } else {
            $usuario->delete();
            return redirect()->route('usuarios.index')->with('success', 'Usuario eliminado correctamente.');
        }
    }
}
