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

        if ($request->has('search')) {
            $search = $request->search;
            $query->where('nombre', 'LIKE', "%{$search}%")
                  ->orWhere('descripcion', 'LIKE', "%{$search}%");
        }

        if ($request->has('activo') && $request->activo !== '') {
            $query->where('activo', $request->activo);
        }

        $perPage = $request->input('per_page', 5);
        $categorias = $query->withCount('servicios')
                           ->orderBy('created_at', 'desc')
                           ->paginate($perPage);

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

        // Verificar si se está intentando desactivar una categoría con servicios asociados
        $activo = $request->input('activo', 0);
        if (!$activo && $categoria->servicios()->count() > 0) {
            return redirect()->back()
                            ->withInput()
                            ->with('error', 'No se puede desactivar la categoría porque tiene ' . $categoria->servicios()->count() . ' servicio(s) asociado(s).');
        }

        $data = $request->all();
        $data['activo'] = $activo;

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
}
