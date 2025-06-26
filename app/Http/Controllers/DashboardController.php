<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class DashboardController extends Controller
{
    //

    public function index()
    {
        return view('dashboard', [
            'page_id' => 2,
            'page_tag' => 'Dashboard - Cotizador Virtual',
            'page_title' => 'Dashboard - Cotizador Virtual',
            'page_name' => 'dashboard',
        ]);
    }



}
