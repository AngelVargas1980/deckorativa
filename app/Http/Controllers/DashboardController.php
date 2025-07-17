<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    //

    public function index()
    {
        $totalUsuarios = User::count();
        $totalClientes = 0;      // Pendiente de actualizar con modelo real
        $totalCotizaciones = 0;  // Pendiente de actualizar con modelo real
        $totalProductos = 0;    // Pendiente de actualizar con modelo real
        $totalPedidos = 0;       // Pendiente de actualizar con modelo real
        $totalSuscriptores = 0;  // Pendiente de actualizar con modelo real
        $totalMensajes = 0;      // Pendiente de actualizar con modelo real

        // Datos de ejemplo para la gráfica
        $meses = ['Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio'];
        $datosCotizaciones = [5, 8, 4, 6, 7, 9];  // Datos de prueba para cotizaciones

        return view('dashboard', compact(
            'totalUsuarios',
            'totalClientes',
            'totalCotizaciones',
            'totalProductos',
            'totalPedidos',
            'totalSuscriptores',
            'totalMensajes',
            'meses',
            'datosCotizaciones'  // Pasamos estos datos a la vista
        ));

    }
}
