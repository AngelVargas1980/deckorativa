<?php

namespace App\Http\Controllers;

use App\Models\Producto;
use Illuminate\Http\Request;

class ProductoController extends Controller
{
    public function index()
    {
        // Paginación
        $cantidad = request('cantidad', 5); // Cantidad a mostrar
        if ($cantidad === 'all') {
            $productos = Producto::get();
            $paginado = false;
        } else {
            $productos = Producto::paginate($cantidad);
            $paginado = true;
        }

        return view('productos.index', compact('productos', 'paginado'));
    }

    // Mostrar formulario para crear un nuevo producto
    public function create()
    {
        return view('productos.create');
    }

    // Almacenar un nuevo producto
    public function store(Request $request)
    {
        $request->validate([
            'codigo' => 'required|string|max:30',
            'nombre' => 'required|string|max:100',
            'descripcion' => 'required|string',
            'precio' => 'required|numeric',
            'existencia' => 'required|integer',
            'unidad' => 'required|string|max:50',
            'imagen' => 'required|string|max:100',
            'status' => 'required|integer',
        ]);

        Producto::create([
            'codigo' => $request->codigo,
            'nombre' => $request->nombre,
            'descripcion' => $request->descripcion,
            'precio' => $request->precio,
            'existencia' => $request->existencia,
            'unidad' => $request->unidad,
            'imagen' => $request->imagen,
            'status' => $request->status,
        ]);

        return redirect()->route('productos.index')->with('success', 'Producto creado exitosamente.');
    }

    // Mostrar los detalles de un producto
    public function show(Producto $producto)
    {
        return view('productos.show', compact('producto'));
    }

    // Mostrar formulario para editar un producto
    public function edit(Producto $producto)
    {
        return view('productos.edit', compact('producto'));
    }

    // Actualizar los datos de un producto
    public function update(Request $request, Producto $producto)
    {
        $request->validate([
            'codigo' => 'required|string|max:30',
            'nombre' => 'required|string|max:100',
            'descripcion' => 'required|string',
            'precio' => 'required|numeric',
            'existencia' => 'required|integer',
            'unidad' => 'required|string|max:50',
            'imagen' => 'required|string|max:100',
            'status' => 'required|integer',
        ]);

        // Actualización del producto
        $producto->update([
            'codigo' => $request->codigo,
            'nombre' => $request->nombre,
            'descripcion' => $request->descripcion,
            'precio' => $request->precio,
            'existencia' => $request->existencia,
            'unidad' => $request->unidad,
            'imagen' => $request->imagen,
            'status' => $request->status,
        ]);

        return redirect()->route('productos.index')->with('success', 'Producto actualizado exitosamente.');
    }

    // Eliminar un producto
    public function destroy(Producto $producto)
    {
        $producto->delete();

        return redirect()->route('productos.index')->with('success', 'Producto eliminado exitosamente.');
    }
}
