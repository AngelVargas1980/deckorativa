<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Deckorativa — Cotizador Virtual</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css">

    <style>
        .hero-bg {
            background-image: url('/images/VistaPrincipal.png');
            background-size: cover;
            background-position: center top; /* Cambiar de center a center top o center 20% */
            height: 90vh;
            margin-top: 50px; /* Puedes ajustar la cantidad */
        }
    </style>


{{--    Pendiente todo depende de la necesidad del cliente--}}
{{--    <section id="cotizador" class="bg-white py-20 text-center">--}}
{{--        <h2 class="text-3xl font-bold mb-6">¡Solicita tu cotización personalizada!</h2>--}}
{{--        <p class="text-gray-600 mb-8 max-w-2xl mx-auto">Cuéntanos qué necesitas y nuestro equipo te enviará una propuesta decorativa adaptada a tu espacio y estilo.</p>--}}
{{--        <a href="#" class="bg-green-600 text-white px-6 py-3 rounded hover:bg-green-700">Empezar cotización</a>--}}
{{--    </section>--}}




</head>
<body class="antialiased text-gray-800">

<header class="absolute top-0 left-0 w-full flex justify-between items-center p-6 bg-white bg-opacity-80">
    <div class="text-4xl font-bold">COTIZADOR VIRTUAL</div>
{{--    <div class="text-2lg font-bold">DECKORATIVA</div>--}}
    <nav class="space-x-6 text-xl font-medium">  {{--text-lg para mas pequeño--}}
        <a href="#" class="hover:text-red-600">Inicio</a>
        <a href="#" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-red-500 transition">Cotizador</a>
        <a href="#" class="hover:text-red-600">Carrito</a>
        <a href="#" class="hover:text-red-600">Nosotros</a>
        <a href="#" class="hover:text-red-600">Sucursales</a>
        <a href="#" class="hover:text-red-600">Contacto</a>
{{--        <a href="{{ route('login') }}" class="ml-4 bg-red-600 text-white px-4 py-2 rounded hover:bg-red-700">Iniciar sesión</a>--}}
    </nav>
</header>

<section class="hero-bg flex items-center justify-center pt-32">
    {{-- Este espacio es para poner un logo, queda vacío --}}
</section>

</body>

<footer class="mt-10 bg-white shadow">
    <div class="max-w-7xl mx-auto py-4 px-4 text-center text-gray-500">
        &copy; 2025 Deckorativa. Todos los derechos reservados.

        <a href="{{ route('login') }}" class="ml-4 text-gray-400 text-sm hover:text-gray-600">Admin</a>
    </div>
</footer>

</html>
