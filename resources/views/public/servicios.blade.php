<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Servicios - Deckorativa</title>
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
                <a href="{{ route('public.servicios') }}" class="text-purple-600 font-semibold">Servicios</a>
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

<section class="bg-gradient-to-r from-purple-600 to-indigo-600 text-white py-16">
    <div class="max-w-7xl mx-auto px-6 text-center">
        <h1 class="text-4xl lg:text-6xl font-bold mb-6">
            @if(request('tipo') == 'producto')
                Nuestros Productos
            @elseif(request('tipo') == 'servicio')
                Nuestros Servicios
            @else
                Servicios y Productos
            @endif
        </h1>
        <p class="text-xl lg:text-2xl opacity-90 max-w-3xl mx-auto">
            Descubre todos nuestros servicios y productos de decoración y agrega los que necesitas a tu carrito para obtener una cotización personalizada.
        </p>
    </div>
</section>

<!-- Filtros y Servicios -->
<section class="py-12">
    <div class="max-w-7xl mx-auto px-6">
        <!-- Filtros -->
        <div class="bg-white rounded-lg shadow-sm p-6 mb-8">
            <form method="GET" class="flex flex-wrap items-end gap-4">
                <div class="flex-1 min-w-0">
                    <label class="block text-sm font-medium text-gray-700 mb-2">Buscar servicios</label>
                    <input type="text" name="search" value="{{ request('search') }}"
                           placeholder="Buscar por nombre..."
                           class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-transparent">
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Tipo</label>
                    <select name="tipo" class="px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-transparent">
                        <option value="">Todos</option>
                        <option value="servicio" {{ request('tipo') == 'servicio' ? 'selected' : '' }}>Servicios</option>
                        <option value="producto" {{ request('tipo') == 'producto' ? 'selected' : '' }}>Productos</option>
                    </select>
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Categoría</label>
                    <select name="categoria" class="px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-transparent">
                        <option value="">Todas las categorías</option>
                        @foreach($categorias as $categoria)
                            <option value="{{ $categoria->id }}" {{ request('categoria') == $categoria->id ? 'selected' : '' }}>
                                {{ $categoria->nombre }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Precio mínimo</label>
                    <input type="number" name="precio_min" value="{{ request('precio_min') }}"
                           placeholder="Q0" step="0.01" min="0"
                           class="px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-transparent">
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Precio máximo</label>
                    <input type="number" name="precio_max" value="{{ request('precio_max') }}"
                           placeholder="Q1000" step="0.01" min="0"
                           class="px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-transparent">
                </div>

                <div class="flex gap-2">
                    <button type="submit" class="bg-purple-600 text-white px-6 py-2 rounded-lg hover:bg-purple-700 transition">
                        Filtrar
                    </button>
                    <a href="{{ route('public.servicios') }}" class="bg-gray-500 text-white px-6 py-2 rounded-lg hover:bg-gray-600 transition">
                        Limpiar
                    </a>
                </div>
            </form>
        </div>

        <!-- Resultados -->
        @if($servicios->count() > 0)
            <div class="mb-6">
                <h3 class="text-2xl font-bold text-gray-900">
                    {{ $servicios->total() }}
                    @if(request('tipo') == 'producto')
                        productos encontrados
                    @elseif(request('tipo') == 'servicio')
                        servicios encontrados
                    @else
                        resultados encontrados
                    @endif
                </h3>
                @if(request()->hasAny(['search', 'categoria', 'tipo', 'precio_min', 'precio_max']))
                    <p class="text-gray-600 mt-1">
                        Resultados filtrados
                        @if(request('search'))
                            por "<strong>{{ request('search') }}</strong>"
                        @endif
                        @if(request('tipo'))
                            - Tipo: <strong>{{ ucfirst(request('tipo')) }}</strong>
                        @endif
                        @if(request('categoria'))
                            - Categoría: <strong>{{ $categorias->find(request('categoria'))->nombre ?? 'Categoría' }}</strong>
                        @endif
                    </p>
                @endif
            </div>

            <!-- Grid de Servicios -->
            <div class="grid md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">
                @foreach($servicios as $servicio)
                    <div class="bg-white rounded-lg shadow-md hover:shadow-lg transition duration-300 overflow-hidden">
                        @if($servicio->imagen)
                            <img src="{{ asset('storage/' . $servicio->imagen) }}" alt="{{ $servicio->nombre }}" class="w-full h-48 object-cover">
                        @else
                            <div class="w-full h-48 bg-gray-200 flex items-center justify-center">
                                <span class="text-4xl text-gray-400">🎨</span>
                            </div>
                        @endif

                        <div class="p-6">
                            <div class="mb-2 flex gap-2">
                                <span class="text-xs {{ $servicio->tipo == 'producto' ? 'bg-blue-100 text-blue-600' : 'bg-purple-100 text-purple-600' }} px-3 py-1 rounded-full font-medium">
                                    {{ ucfirst($servicio->tipo) }}
                                </span>
                                <span class="text-xs bg-gray-100 text-gray-600 px-3 py-1 rounded-full font-medium">{{ $servicio->categoria->nombre ?? 'Sin categoría' }}</span>
                            </div>

                            <h4 class="text-xl font-bold mb-2 text-gray-900">{{ $servicio->nombre }}</h4>
                            <p class="text-gray-600 mb-4 text-sm">{{ Str::limit($servicio->descripcion, 100) }}</p>

                            <div class="flex justify-between items-center">
                                <div>
                                    <div class="text-2xl font-bold text-green-600">Q{{ number_format($servicio->precio, 2) }}</div>
                                    @if($servicio->unidad_medida)
                                        <div class="text-xs text-gray-500 mt-1">por {{ $servicio->unidad_medida_formateada }}</div>
                                    @endif
                                </div>
                                <div class="space-x-2">
                                    <a href="{{ route('public.servicio.detalle', $servicio->id) }}"
                                       class="text-purple-600 hover:text-purple-800 font-medium text-sm">Ver detalles</a>
                                </div>
                            </div>

                            <button onclick="agregarAlCarrito({{ $servicio->id }})"
                                    class="w-full mt-4 bg-purple-600 text-white py-2 rounded-lg hover:bg-purple-700 transition">
                                + Agregar al Carrito
                            </button>
                        </div>
                    </div>
                @endforeach
            </div>

            <!-- Paginación -->
            @if($servicios->hasPages())
                <div class="mt-12 flex justify-center">
                    <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-4">
                        {{ $servicios->appends(request()->query())->links() }}
                    </div>
                </div>
            @endif

        @else
            <div class="text-center py-16">
                <div class="text-gray-400 text-6xl mb-4">🔍</div>
                <h3 class="text-2xl font-semibold text-gray-600 mb-2">No se encontraron servicios</h3>
                <p class="text-gray-500 mb-6">Intenta ajustar los filtros o buscar con otros términos.</p>
                <a href="{{ route('public.servicios') }}" class="bg-purple-600 text-white px-6 py-3 rounded-lg hover:bg-purple-700 transition">
                    Ver todos los servicios
                </a>
            </div>
        @endif
    </div>
</section>

<!-- JavaScript -->
<script>
// Funcionalidad del carrito
let carrito = JSON.parse(localStorage.getItem('carrito')) || [];

function agregarAlCarrito(servicioId) {
    // Buscar el servicio en los datos de la página
    const servicioData = @json($servicios->items());
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
