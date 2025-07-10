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

    {
        $cantidad = request('cantidad', 5);
        if ($cantidad === 'all') {
            $usuarios = User::get(); // O User::all()
            $paginado = false;
        } else {
            $usuarios = User::paginate($cantidad);
            $paginado = true;
        }

        return view('usuarios.index', compact('usuarios', 'paginado'));

    }


        //paginación manual con DataTable
//        $usuarios = User::paginate(5);  //Aquí cambiamos la paginación
////        $usuarios = User::all();
//        return view('usuarios.index', compact('usuarios'));

    }



    public function create()
    {
        return view('usuarios.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users',
            'password' => 'required|string|min:6|confirmed',
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

    public function destroy($id)
    {
        $usuario = User::findOrFail($id);
        $usuario->delete();

        return redirect()->route('usuarios.index')->with('success', 'Usuario eliminado correctamente.');
    }


//    Para mostrar los usuarios eliminados
    public function showDeleted(Request $request)
    {
        $cantidad = $request->get('cantidad', 5);

        // Mostrar solo los usuarios eliminados
        $usuarios = User::onlyTrashed()->paginate($cantidad); // Filtra para solo mostrar los usuarios eliminados.

        return view('usuarios.eliminados', compact('usuarios'));


    }




}
