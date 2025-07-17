@extends('layouts.app')

@section('content')
    <h2 class="text-2xl font-bold mb-6">Bienvenido al Panel de Administración</h2>

    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">

        <div class="bg-white p-6 rounded shadow text-center">
            <h3 class="text-lg font-bold mb-2">👤 Usuarios</h3>
            <p class="text-3xl font-extrabold text-blue-600">{{ $totalUsuarios }}</p>
        </div>

        <div class="bg-white p-6 rounded shadow text-center">
            <h3 class="text-lg font-bold mb-2">🧑‍🤝‍🧑 Clientes</h3>
            <p class="text-3xl font-extrabold text-green-600">{{ $totalClientes }}</p>
        </div>

        <div class="bg-white p-6 rounded shadow text-center">
            <h3 class="text-lg font-bold mb-2">📝 Cotizaciones</h3>
            <p class="text-3xl font-extrabold text-yellow-600">{{ $totalCotizaciones }}</p>
        </div>

        <div class="bg-white p-6 rounded shadow text-center">
            <h3 class="text-lg font-bold mb-2">🎨 Productos</h3>
            <p class="text-3xl font-extrabold text-purple-600">{{ $totalProductos }}</p>
        </div>

        <div class="bg-white p-6 rounded shadow text-center">
            <h3 class="text-lg font-bold mb-2">📦 Pedidos</h3>
            <p class="text-3xl font-extrabold text-pink-600">{{ $totalPedidos }}</p>
        </div>

        <div class="bg-white p-6 rounded shadow text-center">
            <h3 class="text-lg font-bold mb-2">💌 Suscriptores</h3>
            <p class="text-3xl font-extrabold text-indigo-600">{{ $totalSuscriptores }}</p>
        </div>

        <div class="bg-white p-6 rounded shadow text-center">
            <h3 class="text-lg font-bold mb-2">✉️ Mensajes</h3>
            <p class="text-3xl font-extrabold text-red-600">{{ $totalMensajes }}</p>
        </div>

    </div>

    <canvas id="graficaBarras" class="mt-10 bg-white p-4 rounded shadow"></canvas>

    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <script>
        const ctx = document.getElementById('graficaBarras').getContext('2d');

        const data = {
            labels: @json($meses),
            datasets: [{
                label: 'Cotizaciones',
                data: @json($datosCotizaciones),
                backgroundColor: 'rgba(59, 130, 246, 0.7)',
                borderColor: 'rgba(59, 130, 246, 1)',
                borderWidth: 1
            }]
        };

        const config = {
            type: 'bar',
            data: data,
            options: {
                responsive: true,
                scales: {
                    y: {
                        beginAtZero: true
                    }
                }
            }
        };

        const graficaBarras = new Chart(ctx, config);
    </script>







@endsection
