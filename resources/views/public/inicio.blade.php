<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Deckorativa — Cotizador Virtual de Decoración</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;600;700&display=swap" rel="stylesheet">

    <style>
        body {
            font-family: 'Inter', sans-serif;
        }
        .hero-bg {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            position: relative;
            overflow: hidden;
        }
        .hero-bg::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: url('/images/VistaPrincipal.png') center/cover;
            opacity: 0.3;
        }
        .floating-element {
            animation: float 6s ease-in-out infinite;
        }
        @keyframes float {
            0%, 100% { transform: translateY(0px); }
            50% { transform: translateY(-20px); }
        }
        .glass-effect {
            backdrop-filter: blur(10px);
            background: rgba(255, 255, 255, 0.9);
            border: 1px solid rgba(255, 255, 255, 0.3);
        }
        .gradient-text {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }
    </style>
</head>
<body class="antialiased text-gray-800">

<header class="fixed top-0 left-0 w-full z-50 glass-effect shadow-sm transition-all duration-300">
    <div class="max-w-7xl mx-auto px-6 py-4">
        <div class="flex justify-between items-center">
            <div class="flex items-center space-x-4">
                <div class="text-3xl font-bold gradient-text">DECKORATIVA</div>
                <div class="hidden md:block text-sm text-gray-600 font-medium">Cotizador Virtual</div>
            </div>

            <nav class="hidden lg:flex space-x-8 text-lg font-medium">
                <a href="#inicio" class="hover:text-purple-600 transition duration-300">Inicio</a>
                <a href="{{ route('public.servicios') }}" class="hover:text-purple-600 transition duration-300">Servicios</a>
                <a href="#nosotros" class="hover:text-purple-600 transition duration-300">Nosotros</a>
                <a href="#contacto" class="hover:text-purple-600 transition duration-300">Contacto</a>
            </nav>

            <div class="flex items-center space-x-4">
                <a href="{{ route('public.carrito') }}" class="text-purple-600 hover:text-purple-800 relative mr-2">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4m0 0L7 13m0 0l-1.5 1.5M7 13l-1.5-1.5M17 21a2 2 0 100-4 2 2 0 000 4zM9 21a2 2 0 100-4 2 2 0 000 4z"></path>
                    </svg>
                    <span id="carrito-count" class="absolute -top-2 -right-2 bg-red-500 text-white text-xs rounded-full w-5 h-5 flex items-center justify-center hidden">0</span>
                </a>
                <a href="{{ route('public.cotizar') }}" class="bg-gradient-to-r from-purple-600 to-indigo-600 text-white px-6 py-2 rounded-full hover:from-purple-700 hover:to-indigo-700 transition duration-300 font-medium">
                    Cotizar Ahora
                </a>
                <!-- Botón de menú móvil -->
                <button class="lg:hidden text-gray-600 hover:text-purple-600">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path>
                    </svg>
                </button>
            </div>
        </div>
    </div>
</header>

<section id="inicio" class="hero-bg min-h-screen flex items-center justify-center relative">
    <div class="text-center text-white px-6 relative z-10">
        <div class="floating-element mb-8">
            <h1 class="text-5xl lg:text-7xl font-bold mb-6 leading-tight">
                Transforma tu
                <span class="block text-yellow-300">Espacio Ideal</span>
            </h1>
            <p class="text-xl lg:text-2xl mb-8 max-w-3xl mx-auto opacity-90 font-light">
                Cotizaciones instantáneas para decoración profesional.
                Diseño, calidad y precios transparentes al alcance de un click.
            </p>
        </div>

        <div class="flex flex-col sm:flex-row gap-6 justify-center items-center">
            <a href="#cotizador" class="bg-yellow-400 text-gray-900 px-8 py-4 rounded-full text-lg font-semibold hover:bg-yellow-300 transition duration-300 transform hover:scale-105">
                🎨 Empezar Cotización
            </a>
            <a href="#servicios" class="border-2 border-white text-white px-8 py-4 rounded-full text-lg font-semibold hover:bg-white hover:text-gray-900 transition duration-300">
                Ver Servicios
            </a>
        </div>
    </div>

    <!-- Elementos decorativos -->
    <div class="absolute top-20 right-20 w-32 h-32 bg-yellow-400 rounded-full opacity-20 floating-element"></div>
    <div class="absolute bottom-20 left-20 w-24 h-24 bg-white rounded-full opacity-10 floating-element" style="animation-delay: -2s;"></div>
</section>

<!-- Sección de Servicios -->
<section id="servicios" class="py-20 bg-gray-50">
    <div class="max-w-7xl mx-auto px-6">
        <div class="text-center mb-16">
            <h2 class="text-4xl font-bold gradient-text mb-6">Nuestros Servicios</h2>
            <p class="text-xl text-gray-600 max-w-3xl mx-auto">
                Ofrecemos soluciones completas de decoración con cotizaciones precisas y transparentes
            </p>
        </div>

        <!-- Categorías dinámicas desde admin -->
        <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-8 mb-12">
            @forelse($categorias as $categoria)
                <div class="bg-white rounded-2xl p-8 shadow-lg hover:shadow-xl transition duration-300 transform hover:scale-105">
                    <div class="w-16 h-16 bg-purple-100 rounded-full flex items-center justify-center mb-6">
                        <span class="text-2xl">🎨</span>
                    </div>
                    <h3 class="text-2xl font-bold mb-4">{{ $categoria->nombre }}</h3>
                    <p class="text-gray-600 mb-6">{{ Str::limit($categoria->descripcion, 100) }}</p>
                    <div class="flex justify-between items-center">
                        <div class="text-purple-600 font-semibold">{{ $categoria->servicios->count() }} servicios</div>
                        <a href="{{ route('public.servicios', ['categoria' => $categoria->id]) }}"
                           class="bg-purple-600 text-white px-4 py-2 rounded-full text-sm hover:bg-purple-700 transition">
                            Ver servicios
                        </a>
                    </div>
                </div>
            @empty
                <div class="col-span-full text-center py-12">
                    <div class="text-gray-400 text-6xl mb-4">🎨</div>
                    <h3 class="text-xl font-semibold text-gray-600 mb-2">No hay categorías disponibles</h3>
                    <p class="text-gray-500">Las categorías aparecerán aquí cuando se creen desde el panel administrativo.</p>
                </div>
            @endforelse
        </div>

        <!-- Servicios destacados -->
        @if($serviciosDestacados->count() > 0)
        <div class="mt-16">
            <h3 class="text-3xl font-bold text-center mb-12">Servicios Destacados</h3>
            <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-8">
                @foreach($serviciosDestacados as $servicio)
                    <div class="bg-white rounded-2xl p-6 shadow-lg hover:shadow-xl transition duration-300">
                        @if($servicio->imagen)
                            <img src="{{ asset('storage/' . $servicio->imagen) }}" alt="{{ $servicio->nombre }}" class="w-full h-48 object-cover rounded-lg mb-4">
                        @else
                            <div class="w-full h-48 bg-gray-200 rounded-lg mb-4 flex items-center justify-center">
                                <span class="text-4xl text-gray-400">🎨</span>
                            </div>
                        @endif

                        <div class="mb-2">
                            <span class="text-sm text-purple-600 font-medium">{{ $servicio->categoria->nombre ?? 'Sin categoría' }}</span>
                        </div>

                        <h4 class="text-xl font-bold mb-2">{{ $servicio->nombre }}</h4>
                        <p class="text-gray-600 mb-4">{{ Str::limit($servicio->descripcion, 80) }}</p>

                        <div class="flex justify-between items-center">
                            <div class="text-2xl font-bold text-green-600">Q{{ number_format($servicio->precio, 2) }}</div>
                            <div class="space-x-2">
                                <a href="{{ route('public.servicio.detalle', $servicio->id) }}"
                                   class="text-purple-600 hover:text-purple-800 font-medium">Ver detalles</a>
                                <button onclick="agregarAlCarrito({{ $servicio->id }})"
                                        class="bg-purple-600 text-white px-4 py-2 rounded-full text-sm hover:bg-purple-700 transition">
                                    + Carrito
                                </button>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>

            <div class="text-center mt-8">
                <a href="{{ route('public.servicios') }}"
                   class="bg-gradient-to-r from-purple-600 to-indigo-600 text-white px-8 py-3 rounded-full text-lg font-semibold hover:from-purple-700 hover:to-indigo-700 transition duration-300">
                    Ver Todos los Servicios
                </a>
            </div>
        </div>
        @endif
    </div>
</section>

<!-- Sección de Cotización -->
<section id="cotizador" class="py-20 bg-gradient-to-r from-purple-600 to-indigo-600 text-white">
    <div class="max-w-4xl mx-auto px-6 text-center">
        <h2 class="text-4xl font-bold mb-6">¡Solicita tu Cotización Personalizada!</h2>
        <p class="text-xl mb-8 opacity-90">
            Cuéntanos qué necesitas y nuestro sistema te proporcionará una cotización detallada y precisa
        </p>
        <div class="bg-white bg-opacity-10 backdrop-filter backdrop-blur-lg rounded-2xl p-8 max-w-2xl mx-auto">
            <div class="text-left space-y-4">
                <div class="flex items-center space-x-3">
                    <div class="w-8 h-8 bg-yellow-400 rounded-full flex items-center justify-center">
                        <span class="text-gray-900 font-bold">1</span>
                    </div>
                    <span class="text-lg">Selecciona el tipo de espacio</span>
                </div>
                <div class="flex items-center space-x-3">
                    <div class="w-8 h-8 bg-yellow-400 rounded-full flex items-center justify-center">
                        <span class="text-gray-900 font-bold">2</span>
                    </div>
                    <span class="text-lg">Elige los servicios que necesitas</span>
                </div>
                <div class="flex items-center space-x-3">
                    <div class="w-8 h-8 bg-yellow-400 rounded-full flex items-center justify-center">
                        <span class="text-gray-900 font-bold">3</span>
                    </div>
                    <span class="text-lg">Recibe tu cotización instantánea</span>
                </div>
            </div>
            <a href="#" class="inline-block mt-8 bg-yellow-400 text-gray-900 px-8 py-4 rounded-full text-lg font-semibold hover:bg-yellow-300 transition duration-300 transform hover:scale-105">
                Comenzar Ahora
            </a>
        </div>
    </div>
</section>

<!-- Footer mejorado -->
<footer class="bg-gray-900 text-white py-12">
    <div class="max-w-7xl mx-auto px-6">
        <div class="grid md:grid-cols-4 gap-8">
            <div class="col-span-2">
                <h3 class="text-3xl font-bold gradient-text mb-4">DECKORATIVA</h3>
                <p class="text-gray-400 mb-6 max-w-md">
                    Tu aliado en decoración profesional. Cotizaciones precisas, diseños únicos y la mejor calidad al mejor precio.
                </p>
                <div class="flex space-x-4">
                    <div class="w-10 h-10 bg-purple-600 rounded-full flex items-center justify-center hover:bg-purple-700 transition">
                        <span class="text-sm">📧</span>
                    </div>
                    <div class="w-10 h-10 bg-blue-600 rounded-full flex items-center justify-center hover:bg-blue-700 transition">
                        <span class="text-sm">📱</span>
                    </div>
                    <div class="w-10 h-10 bg-pink-600 rounded-full flex items-center justify-center hover:bg-pink-700 transition">
                        <span class="text-sm">📷</span>
                    </div>
                </div>
            </div>

            <div>
                <h4 class="text-lg font-semibold mb-4">Servicios</h4>
                <ul class="space-y-2 text-gray-400">
                    <li><a href="#" class="hover:text-white transition">Decoración Interior</a></li>
                    <li><a href="#" class="hover:text-white transition">Diseño Personalizado</a></li>
                    <li><a href="#" class="hover:text-white transition">Consultoría</a></li>
                </ul>
            </div>

            <div>
                <h4 class="text-lg font-semibold mb-4">Contacto</h4>
                <ul class="space-y-2 text-gray-400">
                    <li>📧 info@deckorativa.com</li>
                    <li>📱 +502 1234-5678</li>
                    <li>📍 Guatemala, Guatemala</li>
                </ul>
            </div>
        </div>

        <div class="border-t border-gray-800 mt-8 pt-8 text-center text-gray-400">
            <div class="flex flex-col md:flex-row justify-between items-center">
                <p>&copy; 2025 Deckorativa. Todos los derechos reservados.</p>
                <a href="{{ route('login') }}" class="mt-4 md:mt-0 text-gray-500 text-sm hover:text-gray-300 transition">
                    Acceso Administrativo
                </a>
            </div>
        </div>
    </div>
</footer>

<!-- JavaScript para scroll suave y carrito -->
<script>
document.querySelectorAll('a[href^="#"]').forEach(anchor => {
    anchor.addEventListener('click', function (e) {
        e.preventDefault();
        const target = document.querySelector(this.getAttribute('href'));
        if (target) {
            target.scrollIntoView({
                behavior: 'smooth',
                block: 'start'
            });
        }
    });
});

// Funcionalidad del carrito
let carrito = JSON.parse(localStorage.getItem('carrito')) || [];

function agregarAlCarrito(servicioId) {
    // Buscar el servicio en los datos de la página
    const servicioData = @json($serviciosDestacados ?? []);
    const servicio = servicioData.find(s => s.id == servicioId);

    if (servicio) {
        const existeEnCarrito = carrito.find(item => item.id == servicioId);

        if (existeEnCarrito) {
            existeEnCarrito.cantidad += 1;
        } else {
            carrito.push({
                id: servicio.id,
                nombre: servicio.nombre,
                precio: servicio.precio,
                categoria: servicio.categoria?.nombre || 'Sin categoría',
                cantidad: 1
            });
        }

        localStorage.setItem('carrito', JSON.stringify(carrito));
        actualizarContadorCarrito();

        // Mostrar notificación
        mostrarNotificacion('Servicio agregado al carrito', 'success');
    }
}

function actualizarContadorCarrito() {
    const contador = document.getElementById('carrito-count');
    const totalItems = carrito.reduce((total, item) => total + item.cantidad, 0);

    if (totalItems > 0) {
        contador.textContent = totalItems;
        contador.classList.remove('hidden');
    } else {
        contador.classList.add('hidden');
    }
}

function mostrarNotificacion(mensaje, tipo = 'info') {
    const notificacion = document.createElement('div');
    notificacion.className = `fixed top-4 right-4 z-50 p-4 rounded-lg shadow-lg text-white ${tipo === 'success' ? 'bg-green-500' : 'bg-blue-500'} transform translate-x-full transition-transform duration-300`;
    notificacion.textContent = mensaje;

    document.body.appendChild(notificacion);

    // Animar entrada
    setTimeout(() => {
        notificacion.classList.remove('translate-x-full');
    }, 100);

    // Remover después de 3 segundos
    setTimeout(() => {
        notificacion.classList.add('translate-x-full');
        setTimeout(() => {
            document.body.removeChild(notificacion);
        }, 300);
    }, 3000);
}

// Inicializar contador al cargar la página
document.addEventListener('DOMContentLoaded', function() {
    actualizarContadorCarrito();
});
</script>

</body>
</html>
