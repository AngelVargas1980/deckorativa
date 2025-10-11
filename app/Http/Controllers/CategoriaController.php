<?php

namespace App\Http\Controllers;

use App\Models\Categoria;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class CategoriaController extends Controller
{
    public function index(Request $request)
    {
        $query = Categoria::query();

        // Filtro de búsqueda
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('nombre', 'LIKE', "%{$search}%")
                  ->orWhere('descripcion', 'LIKE', "%{$search}%");
            });
        }

        // Filtro de estado (activo/inactivo)
        if ($request->has('activo') && $request->activo !== '') {
            $query->where('activo', $request->activo);
        }

        $perPage = $request->input('per_page', 5);
        $categorias = $query->withCount('servicios')
                           ->orderBy('created_at', 'desc')
                           ->paginate($perPage)
                           ->appends($request->except('page'));

        return view('categorias.index', compact('categorias'));
    }

    public function create()
    {
        return view('categorias.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nombre' => 'required|string|max:255|unique:categorias',
            'descripcion' => 'nullable|string',
            'imagen' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'activo' => 'boolean'
        ]);

        $data = $request->all();

        if ($request->hasFile('imagen')) {
            $data['imagen'] = $request->file('imagen')->store('categorias', 'public');
        }

        Categoria::create($data);

        return redirect()->route('categorias.index')
                        ->with('success', 'Categoría creada exitosamente.');
    }

    public function show(Categoria $categoria)
    {
        $categoria->load(['servicios' => function($query) {
            $query->where('activo', true);
        }]);
        
        return view('categorias.show', compact('categoria'));
    }

    public function edit(Categoria $categoria)
    {
        return view('categorias.edit', compact('categoria'));
    }

    public function update(Request $request, Categoria $categoria)
    {
        $request->validate([
            'nombre' => 'required|string|max:255|unique:categorias,nombre,' . $categoria->id,
            'descripcion' => 'nullable|string',
            'imagen' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'activo' => 'boolean'
        ]);

        $data = $request->all();
        $data['activo'] = $request->input('activo', 0);

        if ($request->hasFile('imagen')) {
            // Eliminar imagen anterior
            if ($categoria->imagen) {
                Storage::disk('public')->delete($categoria->imagen);
            }
            $data['imagen'] = $request->file('imagen')->store('categorias', 'public');
        }

        $categoria->update($data);

        return redirect()->route('categorias.index')
                        ->with('success', 'Categoría actualizada exitosamente.');
    }

    public function destroy(Categoria $categoria)
    {
        // Verificar si tiene servicios asociados
        if ($categoria->servicios()->count() > 0) {
            return redirect()->route('categorias.index')
                            ->with('error', 'No se puede eliminar la categoría porque tiene servicios asociados.');
        }

        // Eliminar imagen si existe
        if ($categoria->imagen) {
            Storage::disk('public')->delete($categoria->imagen);
        }

        $categoria->delete();

        return redirect()->route('categorias.index')
                        ->with('success', 'Categoría eliminada exitosamente.');
    }

    public function obtenerCategorias()
    {
        return response()->json(Categoria::activo()->orderBy('nombre')->get());
    }

    public function desactivarServicios(Request $request, Categoria $categoria)
    {
        // Desactivar todos los servicios de esta categoría
        $count = $categoria->servicios()->update(['activo' => false]);

        // Si es una petición AJAX, retornar JSON
        if ($request->expectsJson()) {
            return response()->json([
                'success' => true,
                'message' => "Se han desactivado {$count} servicios/productos.",
                'count' => $count
            ]);
        }

        // Si no es AJAX, redirigir
        return redirect()->route('categorias.edit', $categoria)
                        ->with('success', "Se han desactivado {$count} servicios/productos. Ahora puedes desactivar la categoría.");
    }
}
