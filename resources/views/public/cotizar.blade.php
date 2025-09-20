<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Generar Cotización - Deckorativa</title>
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
            </div>
        </div>
    </div>
</header>

<section class="bg-gradient-to-r from-purple-600 to-indigo-600 text-white py-16">
    <div class="max-w-7xl mx-auto px-6 text-center">
        <h1 class="text-4xl lg:text-6xl font-bold mb-6">Generar Cotización</h1>
        <p class="text-xl lg:text-2xl opacity-90 max-w-3xl mx-auto">
            Completa tus datos para recibir una cotización oficial personalizada de tus servicios seleccionados.
        </p>
    </div>
</section>

<!-- Formulario de Cotización -->
<section class="py-12">
    <div class="max-w-4xl mx-auto px-6">

        <!-- Sin datos del carrito -->
        <div id="sin-datos" class="text-center py-16 hidden">
            <div class="text-gray-400 text-6xl mb-4">📋</div>
            <h3 class="text-2xl font-semibold text-gray-600 mb-2">No hay servicios seleccionados</h3>
            <p class="text-gray-500 mb-6">Primero agrega servicios a tu carrito para poder generar una cotización.</p>
            <a href="{{ route('public.servicios') }}" class="bg-purple-600 text-white px-6 py-3 rounded-lg hover:bg-purple-700 transition">
                Ver Servicios
            </a>
        </div>

        <!-- Formulario de cotización -->
        <div id="formulario-cotizacion" class="hidden">
            <form id="form-cotizacion" class="space-y-8">
                <!-- Información del Cliente -->
                <div class="bg-white rounded-lg shadow-sm p-6">
                    <h3 class="text-2xl font-bold text-gray-900 mb-6">Información del Cliente</h3>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Nombre Completo *</label>
                            <input type="text" name="nombre" required
                                   class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-transparent">
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Correo Electrónico *</label>
                            <input type="email" name="email" required
                                   class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-transparent">
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Teléfono *</label>
                            <input type="tel" name="telefono" required
                                   class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-transparent">
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Empresa (Opcional)</label>
                            <input type="text" name="empresa"
                                   class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-transparent">
                        </div>

                        <div class="md:col-span-2">
                            <label class="block text-sm font-medium text-gray-700 mb-2">Dirección del Proyecto *</label>
                            <textarea name="direccion" rows="3" required
                                      class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-transparent"
                                      placeholder="Dirección completa donde se realizará el proyecto..."></textarea>
                        </div>
                    </div>
                </div>

                <!-- Detalles del Proyecto -->
                <div class="bg-white rounded-lg shadow-sm p-6">
                    <h3 class="text-2xl font-bold text-gray-900 mb-6">Detalles del Proyecto</h3>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Tipo de Proyecto</label>
                            <select name="tipo_proyecto"
                                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-transparent">
                                <option value="">Seleccionar...</option>
                                <option value="residencial">Residencial</option>
                                <option value="comercial">Comercial</option>
                                <option value="oficina">Oficina</option>
                                <option value="restaurante">Restaurante/Bar</option>
                                <option value="otro">Otro</option>
                            </select>
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Tiempo Estimado de Entrega</label>
                            <select name="tiempo_entrega"
                                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-transparent">
                                <option value="">Seleccionar...</option>
                                <option value="1-2-semanas">1-2 semanas</option>
                                <option value="3-4-semanas">3-4 semanas</option>
                                <option value="1-2-meses">1-2 meses</option>
                                <option value="mas-2-meses">Más de 2 meses</option>
                                <option value="sin-prisa">Sin prisa</option>
                            </select>
                        </div>

                        <div class="md:col-span-2">
                            <label class="block text-sm font-medium text-gray-700 mb-2">Descripción del Proyecto</label>
                            <textarea name="descripcion" rows="4"
                                      class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-transparent"
                                      placeholder="Describe tu proyecto, estilo preferido, dimensiones aproximadas, y cualquier requerimiento especial..."></textarea>
                        </div>

                        <div class="md:col-span-2">
                            <label class="block text-sm font-medium text-gray-700 mb-2">Presupuesto Aproximado (Opcional)</label>
                            <select name="presupuesto"
                                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-transparent">
                                <option value="">Prefiero no especificar</option>
                                <option value="5000-10000">Q5,000 - Q10,000</option>
                                <option value="10000-20000">Q10,000 - Q20,000</option>
                                <option value="20000-50000">Q20,000 - Q50,000</option>
                                <option value="50000-100000">Q50,000 - Q100,000</option>
                                <option value="mas-100000">Más de Q100,000</option>
                            </select>
                        </div>
                    </div>
                </div>

                <!-- Resumen de Servicios -->
                <div class="bg-white rounded-lg shadow-sm p-6">
                    <h3 class="text-2xl font-bold text-gray-900 mb-6">Servicios Seleccionados</h3>

                    <div id="resumen-servicios" class="space-y-4 mb-6">
                        <!-- Se llena dinámicamente -->
                    </div>

                    <div class="border-t border-gray-200 pt-4">
                        <div class="flex justify-between items-center mb-2">
                            <span class="text-gray-600">Subtotal:</span>
                            <span class="font-medium">Q<span id="resumen-subtotal">0.00</span></span>
                        </div>
                        <div class="flex justify-between items-center mb-2">
                            <span class="text-gray-600">IVA (12%):</span>
                            <span class="font-medium">Q<span id="resumen-iva">0.00</span></span>
                        </div>
                        <div class="flex justify-between items-center text-xl font-bold">
                            <span>Total Estimado:</span>
                            <span class="text-green-600">Q<span id="resumen-total">0.00</span></span>
                        </div>
                    </div>
                </div>

                <!-- Botones de Acción -->
                <div class="flex flex-col sm:flex-row gap-4">
                    <a href="{{ route('public.carrito') }}"
                       class="flex-1 bg-gray-500 text-white py-3 rounded-lg hover:bg-gray-600 transition text-center">
                        ← Modificar Carrito
                    </a>
                    <button type="submit"
                            class="flex-1 bg-purple-600 text-white py-3 rounded-lg hover:bg-purple-700 transition font-semibold">
                        Enviar Solicitud de Cotización
                    </button>
                </div>

                <div class="text-sm text-gray-500 text-center">
                    * Al enviar esta solicitud, un especialista de Deckorativa se pondrá en contacto contigo en las próximas 24 horas para coordinar una cotización oficial y visita técnica si es necesaria.
                </div>
            </form>
        </div>

    </div>
</section>

<!-- Modal de Confirmación -->
<div id="modal-confirmacion" class="fixed inset-0 bg-black bg-opacity-50 hidden items-center justify-center z-50">
    <div class="bg-white rounded-lg p-8 max-w-md mx-4 text-center">
        <div class="text-green-500 text-6xl mb-4">✅</div>
        <h3 class="text-2xl font-bold text-gray-900 mb-4">¡Solicitud Enviada!</h3>
        <p class="text-gray-600 mb-6">
            Hemos recibido tu solicitud de cotización. Un especialista se pondrá en contacto contigo en las próximas 24 horas.
        </p>
        <div class="space-y-3">
            <button onclick="cerrarModal()" class="w-full bg-purple-600 text-white py-2 rounded-lg hover:bg-purple-700 transition">
                Continuar
            </button>
            <button onclick="nuevaCotizacion()" class="w-full bg-gray-500 text-white py-2 rounded-lg hover:bg-gray-600 transition">
                Nueva Cotización
            </button>
        </div>
    </div>
</div>

<!-- JavaScript -->
<script>
// Variables globales
let carrito = JSON.parse(localStorage.getItem('carrito')) || [];
let datosCotizacion = JSON.parse(localStorage.getItem('datosParaCotizacion'));

function inicializarPagina() {
    actualizarContadorCarrito();

    if (!datosCotizacion || carrito.length === 0) {
        document.getElementById('sin-datos').classList.remove('hidden');
        document.getElementById('formulario-cotizacion').classList.add('hidden');
    } else {
        document.getElementById('sin-datos').classList.add('hidden');
        document.getElementById('formulario-cotizacion').classList.remove('hidden');
        mostrarResumenServicios();
    }
}

function mostrarResumenServicios() {
    const container = document.getElementById('resumen-servicios');
    container.innerHTML = '';

    carrito.forEach(item => {
        const itemHTML = `
            <div class="flex justify-between items-center p-4 bg-gray-50 rounded-lg">
                <div>
                    <h5 class="font-medium text-gray-900">${item.nombre}</h5>
                    <p class="text-sm text-purple-600">${item.categoria}</p>
                </div>
                <div class="text-right">
                    <div class="font-medium">Q${parseFloat(item.precio).toFixed(2)} x ${item.cantidad}</div>
                    <div class="text-lg font-bold text-green-600">Q${(parseFloat(item.precio) * item.cantidad).toFixed(2)}</div>
                </div>
            </div>
        `;
        container.insertAdjacentHTML('beforeend', itemHTML);
    });

    // Actualizar totales
    document.getElementById('resumen-subtotal').textContent = datosCotizacion.subtotal.toFixed(2);
    document.getElementById('resumen-iva').textContent = datosCotizacion.iva.toFixed(2);
    document.getElementById('resumen-total').textContent = datosCotizacion.total.toFixed(2);
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

async function enviarCotizacion(datos) {
    try {
        mostrarNotificacion('Enviando solicitud...', 'info');

        const formData = new FormData();
        formData.append('_token', '{{ csrf_token() }}');
        formData.append('nombre', datos.cliente.nombre);
        formData.append('email', datos.cliente.email);
        formData.append('telefono', datos.cliente.telefono);
        formData.append('mensaje', datos.proyecto.descripcion || '');
        formData.append('carrito', JSON.stringify(carrito));
        formData.append('subtotal', datosCotizacion.subtotal);
        formData.append('iva', datosCotizacion.iva);
        formData.append('total', datosCotizacion.total);

        const response = await fetch('{{ route("public.cotizar.enviar") }}', {
            method: 'POST',
            body: formData
        });

        const result = await response.json();

        if (result.success) {
            mostrarNotificacion(result.message, 'success');
            mostrarModalConfirmacion();
        } else {
            mostrarNotificacion(result.message || 'Error al enviar la solicitud', 'error');
        }

    } catch (error) {
        console.error('Error:', error);
        mostrarNotificacion('Error de conexión. Por favor intenta nuevamente.', 'error');
    }
}

function mostrarModalConfirmacion() {
    document.getElementById('modal-confirmacion').classList.remove('hidden');
    document.getElementById('modal-confirmacion').classList.add('flex');
}

function cerrarModal() {
    document.getElementById('modal-confirmacion').classList.add('hidden');
    document.getElementById('modal-confirmacion').classList.remove('flex');
}

function nuevaCotizacion() {
    // Limpiar carrito y datos
    localStorage.removeItem('carrito');
    localStorage.removeItem('datosParaCotizacion');

    // Redirigir a servicios
    window.location.href = '{{ route("public.servicios") }}';
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

// Event Listeners
document.addEventListener('DOMContentLoaded', function() {
    inicializarPagina();

    // Manejar envío del formulario
    document.getElementById('form-cotizacion').addEventListener('submit', function(e) {
        e.preventDefault();

        const formData = new FormData(this);
        const datos = {
            cliente: {
                nombre: formData.get('nombre'),
                email: formData.get('email'),
                telefono: formData.get('telefono'),
                empresa: formData.get('empresa'),
                direccion: formData.get('direccion')
            },
            proyecto: {
                tipo: formData.get('tipo_proyecto'),
                tiempoEntrega: formData.get('tiempo_entrega'),
                descripcion: formData.get('descripcion'),
                presupuesto: formData.get('presupuesto')
            },
            servicios: carrito,
            totales: datosCotizacion,
            fecha: new Date().toISOString()
        };

        // Validar campos requeridos
        if (!datos.cliente.nombre || !datos.cliente.email || !datos.cliente.telefono || !datos.cliente.direccion) {
            mostrarNotificacion('Por favor completa todos los campos obligatorios', 'error');
            return;
        }

        // Enviar cotización
        enviarCotizacion(datos);
    });
});
</script>

</body>
</html>
