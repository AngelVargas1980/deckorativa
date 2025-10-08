<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $servicio->nombre }} - Deckorativa</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;600;700&display=swap" rel="stylesheet">

    <style>
        body {
            font-family: 'Inter', sans-serif;
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
<body class="antialiased text-gray-800 bg-gray-50">

<header class="glass-effect shadow-sm sticky top-0 z-50">
    <div class="max-w-7xl mx-auto px-6 py-4">
        <div class="flex justify-between items-center">
            <div class="flex items-center space-x-4">
                <a href="{{ route('public.home') }}" class="text-3xl font-bold gradient-text">DECKORATIVA</a>
                <div class="hidden md:block text-sm text-gray-600 font-medium">Cotizador Virtual</div>
            </div>

            <nav class="hidden lg:flex space-x-8 text-lg font-medium">
                <a href="{{ route('public.home') }}" class="hover:text-purple-600 transition duration-300">Inicio</a>
                <a href="{{ route('public.servicios') }}" class="hover:text-purple-600 transition duration-300">Servicios</a>
                <a href="{{ route('public.home') }}#nosotros" class="hover:text-purple-600 transition duration-300">Nosotros</a>
                <a href="{{ route('public.home') }}#contacto" class="hover:text-purple-600 transition duration-300">Contacto</a>
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
            </div>
        </div>
    </div>
</header>

<!-- Breadcrumb -->
<section class="bg-white py-4 border-b">
    <div class="max-w-7xl mx-auto px-6">
        <nav class="text-sm text-gray-600">
            <a href="{{ route('public.home') }}" class="hover:text-purple-600">Inicio</a>
            <span class="mx-2">/</span>
            <a href="{{ route('public.servicios') }}" class="hover:text-purple-600">Servicios</a>
            <span class="mx-2">/</span>
            <span class="text-gray-900">{{ $servicio->nombre }}</span>
        </nav>
    </div>
</section>

<!-- Detalle del Servicio -->
<section class="py-12">
    <div class="max-w-7xl mx-auto px-6">
        <div class="grid lg:grid-cols-2 gap-12 mb-16">
            <!-- Imagen del servicio -->
            <div class="bg-white rounded-2xl shadow-lg overflow-hidden h-96">
                @if($servicio->imagen)
                    <img src="{{ asset('storage/' . $servicio->imagen) }}" alt="{{ $servicio->nombre }}" class="w-full h-full object-cover">
                @else
                    <div class="w-full h-full bg-gray-200 flex items-center justify-center">
                        <span class="text-6xl text-gray-400">🎨</span>
                    </div>
                @endif
            </div>

            <!-- Información del servicio -->
            <div class="flex flex-col justify-center">
                <div class="mb-4 flex gap-2">
                    <span class="inline-block {{ $servicio->tipo == 'producto' ? 'bg-blue-100 text-blue-600' : 'bg-purple-100 text-purple-600' }} px-4 py-2 rounded-full text-sm font-medium">
                        {{ ucfirst($servicio->tipo) }}
                    </span>
                    <span class="inline-block bg-gray-100 text-gray-600 px-4 py-2 rounded-full text-sm font-medium">
                        {{ $servicio->categoria->nombre ?? 'Sin categoría' }}
                    </span>
                </div>

                <h1 class="text-4xl lg:text-5xl font-bold mb-6 text-gray-900">{{ $servicio->nombre }}</h1>

                <p class="text-xl text-gray-600 mb-8 leading-relaxed">{{ $servicio->descripcion }}</p>

                <div class="bg-green-50 border-2 border-green-500 rounded-2xl p-6 mb-8">
                    <div class="text-sm text-green-700 font-medium mb-2">Precio del {{ $servicio->tipo }}</div>
                    <div class="text-5xl font-bold text-green-600">Q{{ number_format($servicio->precio, 2) }}</div>
                    <div class="text-sm text-gray-600 mt-2">
                        @if($servicio->unidad_medida)
                            Precio por {{ $servicio->unidad_medida_formateada }}
                        @else
                            Precio por {{ $servicio->tipo }}
                        @endif
                    </div>
                </div>

                <div class="space-y-4">
                    <button onclick="agregarAlCarrito({{ $servicio->id }})"
                            class="w-full bg-gradient-to-r from-purple-600 to-indigo-600 text-white py-4 rounded-full text-lg font-semibold hover:from-purple-700 hover:to-indigo-700 transition duration-300 transform hover:scale-105">
                        + Agregar al Carrito
                    </button>

                    <a href="{{ route('public.cotizar') }}"
                       class="block w-full text-center border-2 border-purple-600 text-purple-600 py-4 rounded-full text-lg font-semibold hover:bg-purple-50 transition duration-300">
                        Cotizar con más servicios
                    </a>
                </div>

                <!-- Características adicionales -->
                @if($servicio->categoria)
                <div class="mt-8 p-6 bg-gray-50 rounded-xl">
                    <h3 class="font-semibold text-lg mb-3 text-gray-900">Información adicional</h3>
                    <ul class="space-y-2 text-gray-600">
                        <li class="flex items-center">
                            <svg class="w-5 h-5 text-green-500 mr-2" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                            </svg>
                            Categoría: {{ $servicio->categoria->nombre }}
                        </li>
                        <li class="flex items-center">
                            <svg class="w-5 h-5 text-green-500 mr-2" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                            </svg>
                            Cotización inmediata
                        </li>
                        <li class="flex items-center">
                            <svg class="w-5 h-5 text-green-500 mr-2" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                            </svg>
                            Servicio profesional garantizado
                        </li>
                    </ul>
                </div>
                @endif
            </div>
        </div>

        <!-- Servicios relacionados -->
        @if($serviciosRelacionados->count() > 0)
        <div class="mt-20">
            <h2 class="text-3xl font-bold mb-8 text-gray-900">Servicios relacionados</h2>
            <div class="grid md:grid-cols-2 lg:grid-cols-4 gap-6">
                @foreach($serviciosRelacionados as $relacionado)
                    <div class="bg-white rounded-lg shadow-md hover:shadow-lg transition duration-300 overflow-hidden">
                        @if($relacionado->imagen)
                            <img src="{{ asset('storage/' . $relacionado->imagen) }}" alt="{{ $relacionado->nombre }}" class="w-full h-48 object-cover">
                        @else
                            <div class="w-full h-48 bg-gray-200 flex items-center justify-center">
                                <span class="text-4xl text-gray-400">🎨</span>
                            </div>
                        @endif

                        <div class="p-4">
                            <div class="mb-2 flex gap-2">
                                <span class="text-xs {{ $relacionado->tipo == 'producto' ? 'bg-blue-100 text-blue-600' : 'bg-purple-100 text-purple-600' }} px-2 py-1 rounded-full font-medium">
                                    {{ ucfirst($relacionado->tipo) }}
                                </span>
                                <span class="text-xs bg-gray-100 text-gray-600 px-2 py-1 rounded-full font-medium">{{ $relacionado->categoria->nombre ?? 'Sin categoría' }}</span>
                            </div>

                            <h4 class="text-lg font-bold mb-2 text-gray-900">{{ $relacionado->nombre }}</h4>
                            <p class="text-gray-600 mb-4 text-sm">{{ Str::limit($relacionado->descripcion, 80) }}</p>

                            <div class="mb-3">
                                <div class="text-xl font-bold text-green-600">Q{{ number_format($relacionado->precio, 2) }}</div>
                                @if($relacionado->unidad_medida)
                                    <div class="text-xs text-gray-500 mt-1">por {{ $relacionado->unidad_medida_formateada }}</div>
                                @endif
                            </div>

                            <div class="flex gap-2">
                                <a href="{{ route('public.servicio.detalle', $relacionado->id) }}"
                                   class="flex-1 text-center text-purple-600 hover:text-purple-800 font-medium text-sm border border-purple-600 rounded-lg py-2 hover:bg-purple-50 transition">
                                    Ver detalles
                                </a>
                                <button onclick="agregarAlCarrito({{ $relacionado->id }})"
                                        class="flex-1 bg-purple-600 text-white py-2 rounded-lg hover:bg-purple-700 transition text-sm">
                                    + Carrito
                                </button>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
        @endif

        <!-- Botón volver -->
        <div class="mt-12 text-center">
            <a href="{{ route('public.servicios') }}"
               class="inline-flex items-center text-purple-600 hover:text-purple-800 font-medium">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                </svg>
                Volver a todos los servicios
            </a>
        </div>
    </div>
</section>

<!-- Footer -->
<footer class="bg-gray-900 text-white py-12">
    <div class="max-w-7xl mx-auto px-6">
        <div class="grid md:grid-cols-4 gap-8">
            <div class="col-span-2">
                <h3 class="text-3xl font-bold gradient-text mb-4">DECKORATIVA</h3>
                <p class="text-gray-400 mb-6 max-w-md">
                    Tu aliado en decoración profesional. Cotizaciones precisas, diseños únicos y la mejor calidad al mejor precio.
                </p>
            </div>

            <div>
                <h4 class="text-lg font-semibold mb-4">Servicios</h4>
                <ul class="space-y-2 text-gray-400">
                    <li><a href="{{ route('public.servicios') }}" class="hover:text-white transition">Ver todos los servicios</a></li>
                    <li><a href="{{ route('public.cotizar') }}" class="hover:text-white transition">Cotizar ahora</a></li>
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

<!-- JavaScript -->
<script>
// Funcionalidad del carrito
let carrito = JSON.parse(localStorage.getItem('carrito')) || [];

function agregarAlCarrito(servicioId) {
    // Datos del servicio actual y relacionados
    const servicioActual = @json($servicio);
    const serviciosRelacionados = @json($serviciosRelacionados);

    // Buscar el servicio
    let servicio = null;
    if (servicioActual.id == servicioId) {
        servicio = servicioActual;
    } else {
        servicio = serviciosRelacionados.find(s => s.id == servicioId);
    }

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
