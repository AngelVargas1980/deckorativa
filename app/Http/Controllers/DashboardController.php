<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Client;
use App\Models\Cotizacion;
use App\Models\Pago;
use App\Models\Pedido;
use App\Models\Servicio;
use Illuminate\Http\Request;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function index()
    {
        // Estadísticas reales
        $totalUsuarios = User::count();
        $totalClientes = Client::count();
        $totalCotizaciones = Cotizacion::count();
        $totalPedidos = Pedido::count();
        $totalPagos = Pago::count();
        $totalProductos = Servicio::where('tipo', 'producto')->where('activo', 1)->count();

        // Generar datos para gráficas
        $datosGraficas = $this->generarDatosGraficas();
        
        // Estadísticas de cotizaciones por estado
        $cotizacionesPorEstado = $this->obtenerCotizacionesPorEstado();

        // Estadistica de pedidos por estdo
        $pedidosPorEstado = $this->obtenerPedidosPorEstado();
        
        // Estadísticas adicionales
        $estadisticasAdicionales = $this->obtenerEstadisticasAdicionales();

        return view('dashboard', array_merge(
            compact('totalUsuarios', 'totalClientes', 'totalCotizaciones', 'totalProductos', 'totalPedidos', 'totalPagos'),
            $datosGraficas,
            $cotizacionesPorEstado,
            $pedidosPorEstado,
            $estadisticasAdicionales
        ));
    }

    /**
     * Genera los datos necesarios para las gráficas
     */
    private function generarDatosGraficas()
    {
        $meses = [];
        $datosCotizaciones = [];
        $valoresCotizaciones = [];

        // Generar datos de los últimos 6 meses
        for ($i = 5; $i >= 0; $i--) {
            $fecha = Carbon::now()->subMonths($i);
            $meses[] = $fecha->format('M Y'); // "Nov 2024"
            
            // Cantidad de cotizaciones del mes
            $cantidadMes = Cotizacion::whereYear('created_at', $fecha->year)
                ->whereMonth('created_at', $fecha->month)
                ->count();
            $datosCotizaciones[] = $cantidadMes;
            
            // Valor total del mes
            $valorMes = Cotizacion::whereYear('created_at', $fecha->year)
                ->whereMonth('created_at', $fecha->month)
                ->sum('total');
            $valoresCotizaciones[] = round($valorMes, 2);
        }

        return [
            'meses' => $meses,
            'datosCotizaciones' => $datosCotizaciones,
            'valoresCotizaciones' => $valoresCotizaciones
        ];
    }

    /**
     * Obtiene las cotizaciones agrupadas por estado
     */
    private function obtenerCotizacionesPorEstado()
    {
        return [
            'cotizacionesPorEstado' => [
                'borrador' => Cotizacion::where('estado', 'borrador')->count(),
                'enviada' => Cotizacion::where('estado', 'enviada')->count(),
                'aprobada' => Cotizacion::where('estado', 'aprobada')->count(),
                'rechazada' => Cotizacion::where('estado', 'rechazada')->count(),
            ]
        ];
    }

    private function obtenerPedidosPorEstado()
    {
        return [
            'pedidosPorEstado' => [
                'pendiente' => Pedido::where('estado', 'pendiente')->count(),
                'procesando' => Pedido::where('estado', 'en_proceso')->count(),
                'completado' => Pedido::where('estado', 'completado')->count(),
                'cancelado' => Pedido::where('estado', 'cancelado')->count(),
            ]
        ];
    }

    /**
     * Obtiene estadísticas adicionales del dashboard
     */
    private function obtenerEstadisticasAdicionales()
    {
        // Valores totales
        $valorTotalCotizaciones = Cotizacion::sum('total');
        $valorCotizacionesAprobadas = Cotizacion::where('estado', 'aprobada')->sum('total');
        
        // Cotizaciones vigentes y vencidas
        $cotizacionesVigentes = Cotizacion::where('fecha_vigencia', '>=', Carbon::now())->count();
        $cotizacionesVencidas = Cotizacion::where('fecha_vigencia', '<', Carbon::now())->count();
        
        // Cotizaciones recientes
        $cotizacionesRecientes = Cotizacion::with(['client', 'user'])
            ->orderBy('created_at', 'desc')
            ->limit(5)
            ->get();

        return [
            'valorTotalCotizaciones' => $valorTotalCotizaciones,
            'valorCotizacionesAprobadas' => $valorCotizacionesAprobadas,
            'cotizacionesVigentes' => $cotizacionesVigentes,
            'cotizacionesVencidas' => $cotizacionesVencidas,
            'cotizacionesRecientes' => $cotizacionesRecientes
        ];
    }
}