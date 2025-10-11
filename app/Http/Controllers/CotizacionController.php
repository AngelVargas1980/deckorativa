<?php

namespace App\Http\Controllers;

use App\Models\Cotizacion;
use App\Models\CotizacionDetalle;
use App\Models\Client;
use App\Models\Servicio;
use App\Models\Categoria;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
// use PDF; // TODO: barryvdh/laravel-dompdf

class CotizacionController extends Controller
{
    public function index(Request $request)
    {
        $query = Cotizacion::with(['client', 'user'])->withCount('detalles');

        if ($request->has('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('numero_cotizacion', 'LIKE', "%{$search}%")
                  ->orWhereHas('client', function($clientQuery) use ($search) {
                      $clientQuery->where('first_name', 'LIKE', "%{$search}%")
                                  ->orWhere('last_name', 'LIKE', "%{$search}%")
                                  ->orWhere('email', 'LIKE', "%{$search}%");
                  });
            });
        }

        if ($request->has('estado') && $request->estado !== '') {
            $query->where('estado', $request->estado);
        }

        if ($request->has('fecha_desde') && $request->fecha_desde !== '') {
            $query->whereDate('created_at', '>=', $request->fecha_desde);
        }

        if ($request->has('fecha_hasta') && $request->fecha_hasta !== '') {
            $query->whereDate('created_at', '<=', $request->fecha_hasta);
        }

        $perPage = $request->input('per_page', 5);
        $cotizaciones = $query->orderBy('created_at', 'desc')
                             ->paginate($perPage);

        return view('cotizaciones.index', compact('cotizaciones'));
    }

    public function create()
    {
        $clientes = Client::orderBy('first_name')->get();

        // Cargar categorías activas con sus servicios activos y la relación categoria en cada servicio
        $categorias = Categoria::activo()
            ->with(['servicios' => function($query) {
                $query->where('activo', true)->with('categoria');
            }])
            ->orderBy('nombre')
            ->get();

        // Preparar servicios para JavaScript
        $serviciosJS = [];
        foreach ($categorias as $categoria) {
            foreach ($categoria->servicios as $servicio) {
                $serviciosJS[] = [
                    'id' => $servicio->id,
                    'nombre' => $servicio->nombre,
                    'descripcion' => $servicio->descripcion ?? '',
                    'precio' => $servicio->precio,
                    'tipo' => $servicio->tipo,
                    'categoria_id' => $servicio->categoria_id,
                    'activo' => $servicio->activo,
                    'imagen' => $servicio->imagen ?? '',
                    'categoria' => [
                        'id' => $categoria->id,
                        'nombre' => $categoria->nombre
                    ]
                ];
            }
        }

        return view('cotizaciones.create', compact('clientes', 'categorias', 'serviciosJS'));
    }

    public function store(Request $request)
    {
        // Log de debug
        \Log::info('=== CREAR COTIZACIÓN - DATOS RECIBIDOS ===', [
            'all_data' => $request->all(),
            'client_id' => $request->client_id,
            'servicios_count' => is_array($request->servicios) ? count($request->servicios) : 0,
            'servicios' => $request->servicios
        ]);

        $request->validate([
            'client_id' => 'required|exists:clients,id',
            'observaciones' => 'nullable|string',
            'fecha_vigencia' => 'nullable|date|after_or_equal:today',
            'descuento' => 'nullable|numeric|min:0',
            'servicios' => 'required|array|min:1',
            'servicios.*.servicio_id' => 'required|exists:servicios,id',
            'servicios.*.cantidad' => 'required|integer|min:1',
            'servicios.*.notas' => 'nullable|string'
        ]);

        \Log::info('=== VALIDACIÓN PASADA ===');

        DB::beginTransaction();

        try {
            \Log::info('=== CREANDO COTIZACIÓN ===');
            $cotizacion = Cotizacion::create([
                'client_id' => $request->client_id,
                'user_id' => Auth::id(),
                'observaciones' => $request->observaciones,
                'fecha_vigencia' => $request->fecha_vigencia ?: now()->addDays(30),
                'descuento' => $request->descuento ?: 0
            ]);
            \Log::info('Cotización creada con ID: ' . $cotizacion->id);

            \Log::info('=== AGREGANDO DETALLES ===');
            foreach ($request->servicios as $index => $servicioData) {
                \Log::info("Procesando servicio {$index}", $servicioData);
                $servicio = Servicio::findOrFail($servicioData['servicio_id']);

                $detalle = CotizacionDetalle::create([
                    'cotizacion_id' => $cotizacion->id,
                    'servicio_id' => $servicio->id,
                    'cantidad' => $servicioData['cantidad'],
                    'precio_unitario' => $servicio->precio,
                    'notas' => $servicioData['notas'] ?? null
                ]);
                \Log::info("Detalle creado con ID: {$detalle->id}");
            }

            \Log::info('=== CALCULANDO TOTALES ===');
            $cotizacion->calcularTotales();
            \Log::info('Totales calculados - Subtotal: ' . $cotizacion->subtotal . ', Total: ' . $cotizacion->total);

            \Log::info('=== COMMIT TRANSACCIÓN ===');
            DB::commit();
            \Log::info('=== COTIZACIÓN GUARDADA EXITOSAMENTE ===');

            return redirect()->route('cotizaciones.show', $cotizacion)
                            ->with('success', 'Cotización creada exitosamente.');
        } catch (\Exception $e) {
            \Log::error('=== ERROR AL CREAR COTIZACIÓN ===', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);
            DB::rollback();
            return redirect()->back()
                            ->withInput()
                            ->with('error', 'Error al crear la cotización: ' . $e->getMessage());
        }
    }

    public function show(Cotizacion $cotizacion)
    {
        $cotizacion->load(['client', 'user', 'detalles.servicio.categoria']);
        return view('cotizaciones.show', compact('cotizacion'));
    }

    public function edit(Cotizacion $cotizacion)
    {
        if ($cotizacion->estado !== 'borrador') {
            return redirect()->route('cotizaciones.show', $cotizacion)
                            ->with('error', 'Solo se pueden editar cotizaciones en estado borrador.');
        }

        $clientes = Client::orderBy('first_name')->get();

        // Cargar categorías activas con sus servicios activos y la relación categoria en cada servicio
        $categorias = Categoria::activo()
            ->with(['servicios' => function($query) {
                $query->where('activo', true)->with('categoria');
            }])
            ->orderBy('nombre')
            ->get();

        // Preparar servicios para JavaScript
        $serviciosJS = [];
        foreach ($categorias as $categoria) {
            foreach ($categoria->servicios as $servicio) {
                $serviciosJS[] = [
                    'id' => $servicio->id,
                    'nombre' => $servicio->nombre,
                    'descripcion' => $servicio->descripcion ?? '',
                    'precio' => $servicio->precio,
                    'tipo' => $servicio->tipo,
                    'categoria_id' => $servicio->categoria_id,
                    'activo' => $servicio->activo,
                    'imagen' => $servicio->imagen ?? '',
                    'categoria' => [
                        'id' => $categoria->id,
                        'nombre' => $categoria->nombre
                    ]
                ];
            }
        }

        $cotizacion->load(['client', 'detalles.servicio']);

        return view('cotizaciones.edit', compact('cotizacion', 'clientes', 'categorias', 'serviciosJS'));
    }

    public function update(Request $request, Cotizacion $cotizacion)
    {
        if ($cotizacion->estado !== 'borrador') {
            return redirect()->route('cotizaciones.show', $cotizacion)
                            ->with('error', 'Solo se pueden editar cotizaciones en estado borrador.');
        }

        $request->validate([
            'client_id' => 'required|exists:clients,id',
            'observaciones' => 'nullable|string',
            'fecha_vigencia' => 'nullable|date|after:today',
            'descuento' => 'nullable|numeric|min:0',
            'servicios' => 'required|array|min:1',
            'servicios.*.servicio_id' => 'required|exists:servicios,id',
            'servicios.*.cantidad' => 'required|integer|min:1',
            'servicios.*.notas' => 'nullable|string'
        ]);

        DB::beginTransaction();

        try {
            $cotizacion->update([
                'client_id' => $request->client_id,
                'observaciones' => $request->observaciones,
                'fecha_vigencia' => $request->fecha_vigencia ?: $cotizacion->fecha_vigencia,
                'descuento' => $request->descuento ?: 0
            ]);

            $cotizacion->detalles()->delete();

            foreach ($request->servicios as $servicioData) {
                $servicio = Servicio::findOrFail($servicioData['servicio_id']);

                CotizacionDetalle::create([
                    'cotizacion_id' => $cotizacion->id,
                    'servicio_id' => $servicio->id,
                    'cantidad' => $servicioData['cantidad'],
                    'precio_unitario' => $servicio->precio,
                    'notas' => $servicioData['notas'] ?? null
                ]);
            }

            $cotizacion->calcularTotales();

            DB::commit();

            return redirect()->route('cotizaciones.show', $cotizacion)
                            ->with('success', 'Cotización actualizada exitosamente.');
        } catch (\Exception $e) {
            DB::rollback();
            return redirect()->back()
                            ->withInput()
                            ->with('error', 'Error al actualizar la cotización: ' . $e->getMessage());
        }
    }

    public function destroy(Cotizacion $cotizacion)
    {
        if ($cotizacion->estado !== 'borrador') {
            return redirect()->route('cotizaciones.index')
                            ->with('error', 'Solo se pueden eliminar cotizaciones en estado borrador.');
        }

        $cotizacion->delete();

        return redirect()->route('cotizaciones.index')
                        ->with('success', 'Cotización eliminada exitosamente.');
    }

    public function cambiarEstado(Request $request, Cotizacion $cotizacion)
    {
        $request->validate([
            'estado' => 'required|in:borrador,enviada,aprobada,rechazada'
        ]);

        $cotizacion->update(['estado' => $request->estado]);

        return redirect()->back()
                        ->with('success', 'Estado de cotización actualizado exitosamente.');
    }

    public function generarPDF(Cotizacion $cotizacion)
    {
        $cotizacion->load(['client', 'user', 'detalles.servicio.categoria']);

        return view('cotizaciones.pdf', compact('cotizacion'))->with([
            'printMode' => true,
            'filename' => 'cotizacion-' . $cotizacion->numero_cotizacion . '.pdf'
        ]);
    }

    public function enviarEmail(Cotizacion $cotizacion)
    {
        try {
            $cotizacion->load(['client', 'detalles.servicio.categoria', 'user']);

            // Enviar correo al cliente
            Mail::send('emails.cotizacion-cliente', ['cotizacion' => $cotizacion], function($message) use ($cotizacion) {
                $message->to($cotizacion->client->email, $cotizacion->client->name)
                        ->cc($cotizacion->user->email, $cotizacion->user->name) // Copia al usuario que creó la cotización
                        ->subject('Cotización ' . $cotizacion->numero_cotizacion . ' - DECKORATIVA');
            });

            // Actualizar estado de la cotizacion
            $cotizacion->update([
                'enviada_cliente' => true,
                'fecha_envio' => now(),
                'estado' => 'enviada'
            ]);

            return redirect()->back()
                            ->with('success', 'Cotización enviada por email a ' . $cotizacion->client->email . ' con copia a ' . $cotizacion->user->email);

        } catch (\Exception $e) {
            \Log::error('Error al enviar cotización por email', [
                'cotizacion_id' => $cotizacion->id,
                'error' => $e->getMessage()
            ]);

            return redirect()->back()
                            ->with('error', 'Error al enviar el correo: ' . $e->getMessage());
        }
    }
}
