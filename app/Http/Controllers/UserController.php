<?php

namespace App\Http\Controllers;


use App\Models\User;
use Illuminate\Http\Request;


class UserController extends Controller
{

    //Este es el metodo crear usuario
    public function index()

    {
        //Paginación de laravel


        $cantidad = request('cantidad', 5);
        if ($cantidad === 'all') {
            $usuarios = User::get(); // O User::all()
            $paginado = false;
        } else {
            $usuarios = User::paginate($cantidad);
            $paginado = true;
        }

        return view('usuarios.index', compact('usuarios', 'paginado'));

        //paginación manual con DataTable
//        $usuarios = User::paginate(5);  //Aquí cambiamos la paginación
////        $usuarios = User::all();
//        return view('usuarios.index', compact('usuarios'));

    }



    public function create()
    {
        return view('usuarios.create');
    }

    //validar y guardar los datos del formulario de creación
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users',
            'password' => 'required|string|min:6|confirmed',
            'rol' => 'required|string|in:Admin,Asesor,Cliente',  // Validación para rol
            'estado' => 'required|boolean',  // Validación para estado
        ]);

        User::create([
            'name' => $request->name,
            'apellidos' => $request->apellidos,
            'telefono' => $request->telefono,
            'email' => $request->email,
            'password' => bcrypt($request->password),
            'rol' => $request->rol,   // Asignamos el rol
            'estado' => $request->estado,  // Asignamos el estado
        ]);

        return redirect()->route('usuarios.index')->with('success', 'Usuario creado correctamente.');
    }


    //Consultar usuarios
    public function show($id)
    {
        $usuario = User::findOrFail($id);
        return view('usuarios.show', compact('usuario'));
    }


    //Este es el metodo editar usuario
    public function edit($id)
    {
        $usuario = User::findOrFail($id);
        return view('usuarios.edit', compact('usuario'));
    }

    public function update(Request $request, $id)
    {
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


    //Este es metodo eliminar usuario

    public function restore($id)
    {
        $usuario = User::onlyTrashed()->findOrFail($id);
        $usuario->restore();

        return redirect()->route('usuarios.eliminados')->with('success', 'Usuario restaurado correctamente.');
    }

    public function destroy($id)
    {
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


