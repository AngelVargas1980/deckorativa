<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Carrito de Compras - Deckorativa</title>
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

<section class="bg-gradient-to-r from-purple-600 to-indigo-600 text-white py-16">
    <div class="max-w-7xl mx-auto px-6 text-center">
        <h1 class="text-4xl lg:text-6xl font-bold mb-6">Mi Carrito</h1>
        <p class="text-xl lg:text-2xl opacity-90 max-w-3xl mx-auto">
            Revisa los servicios seleccionados y procede a generar tu cotización personalizada.
        </p>
    </div>
</section>

<!-- Carrito de Compras -->
<section class="py-12">
    <div class="max-w-4xl mx-auto px-6">

        <!-- Carrito vacío -->
        <div id="carrito-vacio" class="text-center py-16 hidden">
            <div class="text-gray-400 text-6xl mb-4">🛒</div>
            <h3 class="text-2xl font-semibold text-gray-600 mb-2">Tu carrito está vacío</h3>
            <p class="text-gray-500 mb-6">Explora nuestros servicios y agrega los que necesitas para tu proyecto.</p>
            <a href="{{ route('public.servicios') }}" class="bg-purple-600 text-white px-6 py-3 rounded-lg hover:bg-purple-700 transition">
                Ver Servicios
            </a>
        </div>

        <!-- Carrito con items -->
        <div id="carrito-contenido" class="hidden">
            <!-- Encabezado -->
            <div class="bg-white rounded-lg shadow-sm p-6 mb-6">
                <div class="flex justify-between items-center">
                    <h2 class="text-2xl font-bold text-gray-900">Servicios Seleccionados</h2>
                    <button onclick="vaciarCarrito()" class="text-red-600 hover:text-red-800 transition">
                        <svg class="w-5 h-5 inline mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                        </svg>
                        Vaciar Carrito
                    </button>
                </div>
            </div>

            <!-- Items del carrito -->
            <div id="items-carrito" class="space-y-4 mb-6">
                <!-- Los items se generarán dinámicamente con JavaScript -->
            </div>

            <!-- Resumen -->
            <div class="bg-white rounded-lg shadow-sm p-6">
                <div class="border-b border-gray-200 pb-4 mb-4">
                    <h3 class="text-xl font-semibold text-gray-900 mb-4">Resumen de la Cotización</h3>

                    <div class="space-y-2">
                        <div class="flex justify-between">
                            <span class="text-gray-600">Subtotal (<span id="total-items">0</span> servicios):</span>
                            <span class="font-medium">Q<span id="subtotal">0.00</span></span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-gray-600">IVA (12%):</span>
                            <span class="font-medium">Q<span id="iva">0.00</span></span>
                        </div>
                    </div>
                </div>

                <div class="flex justify-between items-center mb-6">
                    <span class="text-xl font-bold text-gray-900">Total Estimado:</span>
                    <span class="text-3xl font-bold text-green-600">Q<span id="total-final">0.00</span></span>
                </div>

                <div class="space-y-3">
                    <a href="{{ route('public.servicios') }}" class="w-full bg-gray-500 text-white py-3 rounded-lg hover:bg-gray-600 transition text-center block">
                        ← Seguir Agregando Servicios
                    </a>
                    <button onclick="generarPDFCotizacion()" class="w-full bg-green-600 text-white py-3 rounded-lg hover:bg-green-700 transition font-semibold">
                        📄 Generar PDF de Cotización
                    </button>
                    <button onclick="procederCotizacion()" class="w-full bg-purple-600 text-white py-3 rounded-lg hover:bg-purple-700 transition font-semibold">
                        📧 Enviar Solicitud de Cotización
                    </button>
                </div>

                <div class="mt-4 text-sm text-gray-500 text-center">
                    * Esta es una estimación. La cotización oficial puede variar según los detalles específicos de tu proyecto.
                </div>
            </div>
        </div>

    </div>
</section>

<!-- JavaScript -->
<script>
// Variables globales
let carrito = JSON.parse(localStorage.getItem('carrito')) || [];

// Funciones principales
function inicializarCarrito() {
    actualizarContadorCarrito();
    mostrarCarrito();
}

function mostrarCarrito() {
    const carritoVacio = document.getElementById('carrito-vacio');
    const carritoContenido = document.getElementById('carrito-contenido');
    const itemsContainer = document.getElementById('items-carrito');

    if (carrito.length === 0) {
        carritoVacio.classList.remove('hidden');
        carritoContenido.classList.add('hidden');
    } else {
        carritoVacio.classList.add('hidden');
        carritoContenido.classList.remove('hidden');

        // Generar HTML de los items
        itemsContainer.innerHTML = '';
        carrito.forEach((item, index) => {
            const itemHTML = `
                <div class="bg-white rounded-lg shadow-sm p-6">
                    <div class="flex flex-col md:flex-row md:items-center md:justify-between">
                        <div class="flex-1">
                            <h4 class="text-lg font-semibold text-gray-900">${item.nombre}</h4>
                            <p class="text-sm text-purple-600 mb-2">${item.categoria}</p>
                            <div class="text-xl font-bold text-green-600">Q${parseFloat(item.precio).toFixed(2)} c/u</div>
                        </div>

                        <div class="flex items-center mt-4 md:mt-0 space-x-4">
                            <div class="flex items-center space-x-2">
                                <button onclick="cambiarCantidad(${index}, -1)"
                                        class="w-8 h-8 bg-gray-200 text-gray-600 rounded-full hover:bg-gray-300 transition flex items-center justify-center">
                                    -
                                </button>
                                <span class="w-12 text-center font-medium">${item.cantidad}</span>
                                <button onclick="cambiarCantidad(${index}, 1)"
                                        class="w-8 h-8 bg-gray-200 text-gray-600 rounded-full hover:bg-gray-300 transition flex items-center justify-center">
                                    +
                                </button>
                            </div>

                            <div class="text-lg font-bold text-gray-900">
                                Q${(parseFloat(item.precio) * item.cantidad).toFixed(2)}
                            </div>

                            <button onclick="eliminarItem(${index})"
                                    class="text-red-600 hover:text-red-800 transition p-2">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                </svg>
                            </button>
                        </div>
                    </div>
                </div>
            `;
            itemsContainer.insertAdjacentHTML('beforeend', itemHTML);
        });

        actualizarResumen();
    }
}

function cambiarCantidad(index, cambio) {
    if (carrito[index]) {
        carrito[index].cantidad += cambio;

        if (carrito[index].cantidad <= 0) {
            eliminarItem(index);
        } else {
            guardarCarrito();
            mostrarCarrito();
        }
    }
}

function eliminarItem(index) {
    carrito.splice(index, 1);
    guardarCarrito();
    mostrarCarrito();
    mostrarNotificacion('Servicio eliminado del carrito', 'info');
}

function vaciarCarrito() {
    if (confirm('¿Estás seguro de que deseas vaciar todo el carrito?')) {
        carrito = [];
        guardarCarrito();
        mostrarCarrito();
        mostrarNotificacion('Carrito vaciado', 'info');
    }
}

function actualizarResumen() {
    const totalItems = carrito.reduce((total, item) => total + item.cantidad, 0);
    const subtotal = carrito.reduce((total, item) => total + (parseFloat(item.precio) * item.cantidad), 0);
    const iva = subtotal * 0.12;
    const totalFinal = subtotal + iva;

    document.getElementById('total-items').textContent = totalItems;
    document.getElementById('subtotal').textContent = subtotal.toFixed(2);
    document.getElementById('iva').textContent = iva.toFixed(2);
    document.getElementById('total-final').textContent = totalFinal.toFixed(2);
}

function generarPDFCotizacion() {
    if (carrito.length === 0) {
        mostrarNotificacion('Agrega al menos un servicio al carrito', 'error');
        return;
    }

    // Crear formulario para enviar datos por POST
    const form = document.createElement('form');
    form.method = 'POST';
    form.action = '{{ route("public.cotizar.pdf") }}';
    form.target = '_blank';

    // Agregar token CSRF
    const csrfToken = document.createElement('input');
    csrfToken.type = 'hidden';
    csrfToken.name = '_token';
    csrfToken.value = '{{ csrf_token() }}';
    form.appendChild(csrfToken);

    // Agregar datos del carrito
    const carritoInput = document.createElement('input');
    carritoInput.type = 'hidden';
    carritoInput.name = 'carrito';
    carritoInput.value = JSON.stringify(carrito);
    form.appendChild(carritoInput);

    // Agregar totales
    const subtotalInput = document.createElement('input');
    subtotalInput.type = 'hidden';
    subtotalInput.name = 'subtotal';
    subtotalInput.value = document.getElementById('subtotal').textContent;
    form.appendChild(subtotalInput);

    const ivaInput = document.createElement('input');
    ivaInput.type = 'hidden';
    ivaInput.name = 'iva';
    ivaInput.value = document.getElementById('iva').textContent;
    form.appendChild(ivaInput);

    const totalInput = document.createElement('input');
    totalInput.type = 'hidden';
    totalInput.name = 'total';
    totalInput.value = document.getElementById('total-final').textContent;
    form.appendChild(totalInput);

    // Enviar formulario
    document.body.appendChild(form);
    form.submit();
    document.body.removeChild(form);

    mostrarNotificacion('Generando PDF de cotización...', 'info');
}

function procederCotizacion() {
    if (carrito.length === 0) {
        mostrarNotificacion('Agrega al menos un servicio al carrito', 'error');
        return;
    }

    // Guardar datos para la cotización
    localStorage.setItem('datosParaCotizacion', JSON.stringify({
        servicios: carrito,
        subtotal: parseFloat(document.getElementById('subtotal').textContent),
        iva: parseFloat(document.getElementById('iva').textContent),
        total: parseFloat(document.getElementById('total-final').textContent),
        fecha: new Date().toISOString()
    }));

    // Redirigir a la página de cotización
    window.location.href = '{{ route("public.cotizar") }}';
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

function guardarCarrito() {
    localStorage.setItem('carrito', JSON.stringify(carrito));
    actualizarContadorCarrito();
}

function mostrarNotificacion(mensaje, tipo = 'info') {
    const colores = {
        'success': 'bg-green-500',
        'error': 'bg-red-500',
        'info': 'bg-blue-500'
    };

    const notificacion = document.createElement('div');
    notificacion.className = `fixed top-4 right-4 z-50 p-4 rounded-lg shadow-lg text-white ${colores[tipo]} transform translate-x-full transition-transform duration-300`;
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

// Inicializar cuando se carga la página
document.addEventListener('DOMContentLoaded', function() {
    inicializarCarrito();
});
</script>

</body>
</html>
