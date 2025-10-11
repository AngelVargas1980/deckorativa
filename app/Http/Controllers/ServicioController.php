<?php

namespace App\Http\Controllers;

use App\Models\Servicio;
use App\Models\Categoria;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ServicioController extends Controller
{
    public function index(Request $request)
    {
        $query = Servicio::with('categoria');

        // Filtro de búsqueda
        if ($request->has('search') && $request->search !== '') {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('nombre', 'LIKE', "%{$search}%")
                  ->orWhere('descripcion', 'LIKE', "%{$search}%");
            });
        }

        // Filtro por tipo (tabs)
        if ($request->has('tipo') && $request->tipo !== '') {
            $query->where('tipo', $request->tipo);
        }

        // Filtro de categoría
        if ($request->has('categoria_id') && $request->categoria_id !== '') {
            $query->where('categoria_id', $request->categoria_id);
        }

        // Filtro de estado
        if ($request->has('activo') && $request->activo !== '') {
            $query->where('activo', $request->activo);
        }

        $perPage = $request->get('per_page', 12);
        $servicios = $query->orderBy('created_at', 'desc')
                          ->paginate($perPage)
                          ->appends($request->except('page'));

        $categorias = Categoria::activo()->orderBy('nombre')->get();

        return view('servicios.index', compact('servicios', 'categorias'));
    }

    public function create()
    {
        $categorias = Categoria::activo()->orderBy('nombre')->get();
        return view('servicios.create', compact('categorias'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nombre' => 'required|string|max:255',
            'descripcion' => 'nullable|string',
            'precio' => 'required|numeric|min:0',
            'imagen' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'tipo' => 'required|in:servicio,producto',
            'categoria_id' => 'required|exists:categorias,id',
            'tiempo_estimado' => 'nullable|integer|min:1',
            'unidad_medida' => 'required|string|max:50',
            'activo' => 'boolean'
        ]);

        $data = $request->all();
        
        // Limpiar tiempo_estimado si está vacío
        if (empty($data['tiempo_estimado'])) {
            $data['tiempo_estimado'] = null;
        }

        if ($request->hasFile('imagen')) {
            $data['imagen'] = $request->file('imagen')->store('servicios', 'public');
        }

        Servicio::create($data);

        return redirect()->route('servicios.index')
                        ->with('success', ucfirst($request->tipo) . ' creado exitosamente.');
    }

    public function show(Servicio $servicio)
    {
        $servicio->load('categoria');
        return view('servicios.show', compact('servicio'));
    }

    public function edit(Servicio $servicio)
    {
        $categorias = Categoria::activo()->orderBy('nombre')->get();
        return view('servicios.edit', compact('servicio', 'categorias'));
    }

    public function update(Request $request, Servicio $servicio)
    {
        $request->validate([
            'nombre' => 'required|string|max:255',
            'descripcion' => 'nullable|string',
            'precio' => 'required|numeric|min:0',
            'imagen' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'tipo' => 'required|in:servicio,producto',
            'categoria_id' => 'required|exists:categorias,id',
            'tiempo_estimado' => 'nullable|integer|min:1',
            'unidad_medida' => 'required|string|max:50',
            'activo' => 'boolean'
        ]);

        $data = $request->all();
        
        // Limpiar tiempo_estimado si está vacío
        if (empty($data['tiempo_estimado'])) {
            $data['tiempo_estimado'] = null;
        }

        if ($request->hasFile('imagen')) {
            if ($servicio->imagen) {
                Storage::disk('public')->delete($servicio->imagen);
            }
            $data['imagen'] = $request->file('imagen')->store('servicios', 'public');
        }

        $servicio->update($data);

        return redirect()->route('servicios.index')
                        ->with('success', ucfirst($request->tipo) . ' actualizado exitosamente.');
    }

    public function destroy(Servicio $servicio)
    {
        if ($servicio->cotizacionDetalles()->count() > 0) {
            return redirect()->route('servicios.index')
                            ->with('error', 'No se puede eliminar porque está asociado a cotizaciones.');
        }

        if ($servicio->imagen) {
            Storage::disk('public')->delete($servicio->imagen);
        }

        $servicio->delete();

        return redirect()->route('servicios.index')
                        ->with('success', 'Servicio/Producto eliminado exitosamente.');
    }

    public function obtenerServicios(Request $request)
    {
        $query = Servicio::activo()->with('categoria');

        if ($request->has('categoria_id') && $request->categoria_id !== '') {
            $query->where('categoria_id', $request->categoria_id);
        }

        if ($request->has('tipo') && $request->tipo !== '') {
            $query->where('tipo', $request->tipo);
        }

        if ($request->has('search') && $request->search !== '') {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('nombre', 'LIKE', "%{$search}%")
                  ->orWhere('descripcion', 'LIKE', "%{$search}%");
            });
        }

        return response()->json($query->orderBy('nombre')->get());
    }
}
