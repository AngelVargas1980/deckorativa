<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Client;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        // Estadísticas reales
        $totalUsuarios = User::count();
        $totalClientes = Client::count();
        $totalCotizaciones = 0;  // Pendiente de modelo Cotizacion
        $totalProductos = 0;     // Pendiente de modelo Producto

        // Datos de ejemplo para la gráfica (se actualizarán cuando haya modelo de cotizaciones)
        $meses = ['Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio'];
        $datosCotizaciones = [5, 8, 4, 6, 7, 9];

        return view('dashboard', compact(
            'totalUsuarios',
            'totalClientes',
            'totalCotizaciones',
            'totalProductos',
            'meses',
            'datosCotizaciones'
        ));
    }
}
