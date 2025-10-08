<?php

namespace App\Http\Controllers;

use App\Models\Categoria;
use App\Models\Servicio;
use Illuminate\Http\Request;
// use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Mail;
use Carbon\Carbon;

class PublicController extends Controller
{
    public function index()
    {
        $categorias = Categoria::with('servicios')->get();
        $serviciosDestacados = Servicio::take(6)->get();

        return view('public.inicio', compact('categorias', 'serviciosDestacados'));
    }

    public function servicios(Request $request)
    {
        $query = Servicio::with('categoria');

        // Filtrar por tipo
        if ($request->filled('tipo')) {
            $query->where('tipo', $request->tipo);
        }

        // Filtrar por categoría
        if ($request->filled('categoria')) {
            $query->where('categoria_id', $request->categoria);
        }

        // Buscar por nombre
        if ($request->filled('search')) {
            $query->where('nombre', 'like', '%' . $request->search . '%');
        }

        // Filtrar por rango de precio
        if ($request->filled('precio_min')) {
            $query->where('precio', '>=', $request->precio_min);
        }

        if ($request->filled('precio_max')) {
            $query->where('precio', '<=', $request->precio_max);
        }

        $servicios = $query->paginate(12);
        $categorias = Categoria::all();

        return view('public.servicios', compact('servicios', 'categorias'));
    }

    public function servicioDetalle($id)
    {
        $servicio = Servicio::with('categoria')->findOrFail($id);
        $serviciosRelacionados = Servicio::where('categoria_id', $servicio->categoria_id)
                                        ->where('id', '!=', $servicio->id)
                                        ->take(4)
                                        ->get();

        return view('public.servicio-detalle', compact('servicio', 'serviciosRelacionados'));
    }

    public function carrito()
    {
        return view('public.carrito');
    }

    public function cotizar()
    {
        return view('public.cotizar');
    }

    public function generarPDFCotizacion(Request $request)
    {
        $carrito = json_decode($request->carrito, true);
        $subtotal = floatval($request->subtotal);
        $iva = floatval($request->iva);
        $total = floatval($request->total);

        $datos = [
            'carrito' => $carrito,
            'subtotal' => $subtotal,
            'iva' => $iva,
            'total' => $total,
            'fecha' => Carbon::now()->format('d/m/Y'),
            'numero_cotizacion' => 'COT-' . str_pad(rand(1, 999999), 6, '0', STR_PAD_LEFT),
            'empresa' => 'DECKORATIVA',
            'telefono' => '+502 0000-0000',
            'email' => 'info@deckorativa.com',
            'direccion' => 'Guatemala, Guatemala'
        ];

        // Mientras no tenemos DomPDF, devolvemos la vista HTML que se puede imprimir como PDF
        return view('public.pdf.cotizacion', $datos)->with([
            'printMode' => true,
            'filename' => 'cotizacion-deckorativa-' . $datos['numero_cotizacion'] . '.pdf'
        ]);
    }

    public function enviarCotizacion(Request $request)
    {
        $request->validate([
            'nombre' => 'required|string|max:255',
            'email' => 'required|email',
            'telefono' => 'required|string|max:20',
            'mensaje' => 'nullable|string|max:1000',
            'carrito' => 'required|string'
        ]);

        $carrito = json_decode($request->carrito, true);
        $subtotal = floatval($request->subtotal);
        $iva = floatval($request->iva);
        $total = floatval($request->total);

        $datos = [
            'nombre' => $request->nombre,
            'email' => $request->email,
            'telefono' => $request->telefono,
            'mensaje' => $request->mensaje,
            'carrito' => $carrito,
            'subtotal' => $subtotal,
            'iva' => $iva,
            'total' => $total,
            'fecha' => Carbon::now()->format('d/m/Y H:i'),
            'numero_cotizacion' => 'COT-' . str_pad(rand(1, 999999), 6, '0', STR_PAD_LEFT)
        ];

        try {
            // Enviar correo al equipo de ventas
            Mail::send('emails.nueva-cotizacion', $datos, function($message) use ($datos) {
                $message->to('ventas.deckorativa@gmail.com', 'Ventas Deckorativa')
                        ->subject('Nueva Solicitud de Cotización - ' . $datos['numero_cotizacion'])
                        ->replyTo($datos['email'], $datos['nombre']);
            });

            // Enviar confirmación al cliente
            Mail::send('emails.confirmacion-cotizacion', $datos, function($message) use ($datos) {
                $message->to($datos['email'], $datos['nombre'])
                        ->subject('Confirmación de Solicitud de Cotización - DECKORATIVA');
            });

            return response()->json([
                'success' => true,
                'message' => 'Solicitud de cotización enviada exitosamente. Recibirás una respuesta en las próximas 24 horas.'
            ]);

        } catch (\Exception $e) {
            Log::error('Error al enviar cotización por email', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);

            return response()->json([
                'success' => false,
                'message' => 'Error al enviar la solicitud. Por favor intenta nuevamente.',
                'error_detail' => config('app.debug') ? $e->getMessage() : null
            ], 500);
        }
    }
}
