<?php

namespace App\Http\Controllers;

use App\Models\Pedido;
use App\Models\PedidoDetalle;
use App\Models\Client;
use App\Models\Servicio;
use App\Models\Cotizacion;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Barryvdh\DomPDF\Facade\Pdf as PDF;

class PedidoController extends Controller
{
    public function index(Request $request)
    {
        $query = Pedido::with(['cliente', 'cotizacion'])
            ->withCount('detalles'); // Para mostrar el conteo de items

        // Filtro por estado
        if ($request->filled('estado')) {
            $query->where('estado', $request->estado);
        }

        // Filtro por búsqueda (número de pedido, cliente o email)
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('numero_pedido', 'like', "%{$search}%")
                    ->orWhereHas('cliente', function ($clientQuery) use ($search) {
                        $clientQuery->where('first_name', 'like', "%{$search}%")
                            ->orWhere('last_name', 'like', "%{$search}%")
                            ->orWhere('email', 'like', "%{$search}%");
                    });
            });
        }

        // Filtro por fecha
        if ($request->filled('fecha')) {
            switch ($request->fecha) {
                case 'hoy':
                    $query->whereDate('created_at', today());
                    break;

                case 'semana':
                    $query->whereBetween('created_at', [
                        now()->startOfWeek(),
                        now()->endOfWeek()
                    ]);
                    break;

                case 'mes':
                    $query->whereMonth('created_at', now()->month)
                        ->whereYear('created_at', now()->year);
                    break;

                case 'personalizado':
                    if ($request->filled('fecha_inicio')) {
                        $query->whereDate('created_at', '>=', $request->fecha_inicio);
                    }
                    if ($request->filled('fecha_fin')) {
                        $query->whereDate('created_at', '<=', $request->fecha_fin);
                    }
                    break;
            }
        }

        // Ordenar por fecha de creación descendente (más recientes primero)
        $pedidos = $query->orderBy('created_at', 'desc')->paginate(10);

        return view('admin.pedidos.index', compact('pedidos'));
    }

    public function create()
    {
        $clientes = Client::all();
        $servicios = Servicio::all();
        $cotizaciones = Cotizacion::where('estado', 'aprobada')
            ->with(['detalles.servicio']) // Eager loading
            ->get();
        // dd($cotizaciones);

        return view('admin.pedidos.create', compact('clientes', 'servicios', 'cotizaciones'));
    }

    public function store(Request $request)
    {
        // dd($request);

        $request->validate([
            'client_id' => 'required|exists:clients,id',
            'cotizacion_id' => 'exists:cotizaciones,id',
            'direccion_entrega' => 'required|string',
            'telefono_contacto' => 'required|string',
            'fecha_entrega' => 'nullable|date',
            'observaciones' => 'nullable|string',
            'detalles' => 'required|array|min:1',
            'detalles.*.servicio_id' => 'nullable|exists:servicios,id',
            'detalles.*.nombre_item' => 'required|string',
            'detalles.*.cantidad' => 'required|integer|min:1',
            'detalles.*.precio_unitario' => 'required|numeric|min:0',
        ]);

        try {
            DB::beginTransaction();

            $pedido = Pedido::create([
                'numero_pedido' => Pedido::generarNumeroPedido(),
                'client_id' => $request->client_id,
                'cotizacion_id' => $request->cotizacion_id,
                'direccion_entrega' => $request->direccion_entrega,
                'telefono_contacto' => $request->telefono_contacto,
                'fecha_entrega' => $request->fecha_entrega,
                'observaciones' => $request->observaciones,
                'estado' => 'pendiente',
                'total' => 0
            ]);

            $total = 0;
            foreach ($request->detalles as $detalle) {
                $subtotal = $detalle['cantidad'] * $detalle['precio_unitario'];

                PedidoDetalle::create([
                    'pedido_id' => $pedido->id,
                    'servicio_id' => $detalle['servicio_id'],
                    'nombre_item' => $detalle['nombre_item'],
                    'descripcion' => $detalle['descripcion'] ?? null,
                    'cantidad' => $detalle['cantidad'],
                    'precio_unitario' => $detalle['precio_unitario'],
                    'subtotal' => $subtotal
                ]);

                $total += $subtotal;
            }

            $pedido->update(['total' => $total]);

            DB::commit();

            return redirect()->route('pedidos.index')->with('success', 'Pedido creado exitosamente.');
        } catch (\Exception $e) {
            dd($e);
            DB::rollback();
            Log::error('Error al crear pedido: ' . $e->getMessage());
            return back()->withInput()->with('error', 'Error al crear el pedido. Inténtalo nuevamente.');
        }
    }

    public function show(Pedido $pedido)
    {
        $pedido->load(['cliente', 'cotizacion', 'detalles.servicio']);
        return view('admin.pedidos.show', compact('pedido'));
    }

    public function edit(Pedido $pedido)
    {
        $clientes = Client::all();
        $servicios = Servicio::all();
        $cotizaciones = Cotizacion::where('estado', 'aprobada')->get();
        $pedido->load('detalles');

        return view('admin.pedidos.edit', compact('pedido', 'clientes', 'servicios', 'cotizaciones'));
    }

    public function update(Request $request, Pedido $pedido)
    {
        $request->validate([
            'client_id' => 'required|exists:clients,id',
            'cotizacion_id' => 'nullable|exists:cotizaciones,id',
            'direccion_entrega' => 'required|string',
            'telefono_contacto' => 'required|string',
            'fecha_entrega' => 'nullable|date',
            'observaciones' => 'nullable|string',
            'estado' => 'required|in:pendiente,en_proceso,completado,cancelado',
            'detalles' => 'required|array|min:1',
            'detalles.*.servicio_id' => 'required|exists:servicios,id',
            'detalles.*.cantidad' => 'required|integer|min:1',
            'detalles.*.precio_unitario' => 'required|numeric|min:0',
            'detalles.*.subtotal' => 'required|numeric|min:0',
            'total' => 'required|numeric|min:0'
        ]);

        try {
            DB::beginTransaction();

            // Actualizar datos del pedido
            $pedido->update([
                'client_id' => $request->client_id,
                'cotizacion_id' => 1, //$request->cotizacion_id,
                'direccion_entrega' => $request->direccion_entrega,
                'telefono_contacto' => $request->telefono_contacto,
                'fecha_entrega' => $request->fecha_entrega,
                'observaciones' => $request->observaciones,
                'estado' => $request->estado,
                'total' => $request->total
            ]);

            // Eliminar detalles existentes
            $pedido->detalles()->delete();


            // Crear nuevos detalles
            foreach ($request->detalles as $detalle) {

                $servicio = Servicio::find($detalle['servicio_id']);
                PedidoDetalle::create([
                    'pedido_id' => $pedido->id,
                    'servicio_id' => $detalle['servicio_id'],
                    'nombre_item' => $servicio->nombre,
                    'cantidad' => $detalle['cantidad'],
                    'precio_unitario' => $detalle['precio_unitario'],
                    'subtotal' => $detalle['subtotal']
                ]);
            }

            DB::commit();

            return redirect()->route('pedidos.index')
                ->with('success', 'Pedido actualizado exitosamente.');
        } catch (\Exception $e) {
            dd($e);
            DB::rollback();
            Log::error('Error al actualizar pedido: ' . $e->getMessage());
            return back()->withInput()
                ->with('error', 'Error al actualizar el pedido. Inténtalo nuevamente.');
        }
    }

    public function destroy(Pedido $pedido)
    {
        try {
            $pedido->delete();
            return redirect()->route('pedidos.index')->with('success', 'Pedido eliminado exitosamente.');
        } catch (\Exception $e) {
            Log::error('Error al eliminar pedido: ' . $e->getMessage());
            return back()->with('error', 'Error al eliminar el pedido.');
        }
    }

    public function cambiarEstado(Request $request, Pedido $pedido)
    {
        $request->validate([
            'estado' => 'required|in:pendiente,en_proceso,completado,cancelado'
        ]);

        try {
            $pedido->update(['estado' => $request->estado]);
            return response()->json(['success' => true, 'message' => 'Estado actualizado correctamente.']);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => 'Error al cambiar el estado.']);
        }
    }

    public function generarPDF(Pedido $pedido)
    {
        $pedido->load(['cliente', 'detalles.servicio']);

        // $pdf = Pdf::loadView('admin.pedidos.pdf', compact('pedido'));
        return view('admin.pedidos.pdf', compact('pedido'))->with([
            'printMode' => true,
            'fileName' => 'pedido-' . $pedido->numero_pedido . '.pdf'
        ]);
        // return $pdf->download('pedido-' . $pedido->numero_pedido . '.pdf');
    }
}
