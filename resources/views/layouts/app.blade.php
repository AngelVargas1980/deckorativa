<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Deckorativa</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-gray-100">

{{-- Barra superior --}}
<header class="bg-[#0097A7] text-white flex justify-between items-center px-6 py-3 shadow">

    <h1 class="text-xl font-bold tracking-wider uppercase">Cotizador Virtual</h1>
    <div class="flex items-center space-x-2">
        <span class="text-sm">{{ Auth::user()->name }}</span>
        <svg class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="2"
             viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
            <path stroke-linecap="round" stroke-linejoin="round"
                  d="M5.121 17.804A12.072 12.072 0 0112 15c2.21 0 4.268.634 6 1.804M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
        </svg>
    </div>
</header>



<div class="flex min-h-screen">
    {{-- Sidebar --}}
    <aside class="w-64 bg-black shadow-md">
        <div class="p-4 text-center font-bold text-lg border-b text-white">
            DECKORATIVA layouts.app
        </div>


        <nav class="p-4 space-y-2 text-sm">
            <a href="/admin" class="block px-4 py-2 bg-black text-white rounded">⚙️ Administrador</a>
            <a href="/" class="block px-4 py-2 bg-black text-white rounded">🌐 Ver Sitio Web</a>
            <a href="/dashboard" class="block px-4 py-2 bg-black text-white rounded">📊 Dashboard</a>


            <a href="{{ route('usuarios.index') }}" class="block px-4 py-2 bg-black text-white rounded">👤 Usuarios</a>
            <a href="{{ route('roles.index') }}" class="block px-4 py-2 bg-black text-white rounded">🛠️ Roles</a>


{{--            <a href="/usuarios" class="block px-4 py-2 bg-black text-white rounded">👤 Usuarios</a>--}}


            <a href="/clients" class="block px-4 py-2 bg-black text-white rounded">🧑‍🤝‍🧑 Clientes</a>
            <a href="/cotizaciones" class="block px-4 py-2 bg-black text-white rounded">📝 Cotizador</a>
            <a href="/productos" class="block px-4 py-2 bg-black text-white rounded">🎨 Productos</a>
            <a href="/pedidos" class="block px-4 py-2 bg-black text-white rounded">📦 Pedidos</a>
            <a href="/suscriptores" class="block px-4 py-2 bg-black text-white rounded">📦 Suscriptores</a>
            <a href="/mensajes" class="block px-4 py-2 bg-black text-white rounded">📦 Mensajes</a>
            <a href="/paginas" class="block px-4 py-2 bg-black text-white rounded">📦 Paginas</a>

            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" class="w-full text-left px-4 py-2 bg-red-600 text-white rounded hover:bg-red-700">🚪 Cerrar sesión</button>
            </form>
        </nav>

    </aside>

    {{-- Contenido principal --}}
    <main class="flex-1 p-6">
        @yield('content')
    </main>
</div>

{{-- DataTables CSS --}}
<link rel="stylesheet" href="https://cdn.datatables.net/1.13.4/css/jquery.dataTables.min.css">
<link rel="stylesheet" href="https://cdn.datatables.net/buttons/2.3.6/css/buttons.dataTables.min.css">

{{-- Este es el jQuery y DataTables --}}
<script src="https://code.jquery.com/jquery-3.7.0.min.js"></script>
<script src="https://cdn.datatables.net/1.13.4/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.3.6/js/dataTables.buttons.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.3.6/js/buttons.flash.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.10.1/jszip.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.2.7/pdfmake.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.2.7/vfs_fonts.js"></script>
<script src="https://cdn.datatables.net/buttons/2.3.6/js/buttons.html5.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.3.6/js/buttons.print.min.js"></script>




@stack('scripts')


</body>
</html>
