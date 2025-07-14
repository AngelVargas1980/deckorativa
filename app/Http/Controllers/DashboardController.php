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

        return view('dashboard', compact(
                'totalUsuarios',
                'totalClientes',
                'totalCotizaciones',
                'totalProductos',
                'totalPedidos',
                'totalSuscriptores',
                'totalMensajes'
    ));

    }
}
