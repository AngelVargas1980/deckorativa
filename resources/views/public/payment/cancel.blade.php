<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pago Cancelado - Deckorativa</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;600;700&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Inter', sans-serif; }
        .gradient-text { background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); -webkit-background-clip: text; -webkit-text-fill-color: transparent; background-clip: text; }
    </style>
</head>
<body class="bg-gray-50 min-h-screen flex items-center justify-center">
    <div class="max-w-md w-full mx-4">
        <div class="bg-white rounded-2xl shadow-xl p-8 text-center">
            <!-- Ícono de cancelación -->
            <div class="w-16 h-16 mx-auto mb-6 bg-yellow-100 rounded-full flex items-center justify-center">
                <svg class="w-8 h-8 text-yellow-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.732-.833-2.464 0L4.732 16.5c-.77.833.192 2.5 1.732 2.5z"></path>
                </svg>
            </div>

            <!-- Título -->
            <h1 class="text-2xl font-bold text-gray-900 mb-2">Pago Cancelado</h1>
            <p class="text-gray-600 mb-6">Has cancelado el proceso de pago</p>

            <!-- Mensaje informativo -->
            <div class="bg-yellow-50 border border-yellow-200 rounded-lg p-4 mb-6">
                <p class="text-sm text-yellow-800">
                    No te preocupes, no se ha realizado ningún cargo. Tu carrito sigue disponible y puedes continuar cuando estés listo.
                </p>
            </div>

            <!-- Opciones disponibles -->
            <div class="text-left mb-6">
                <h3 class="font-semibold text-gray-900 mb-3">¿Qué puedes hacer ahora?</h3>
                <ul class="text-sm text-gray-600 space-y-2">
                    <li class="flex items-start">
                        <svg class="w-4 h-4 text-purple-600 mt-0.5 mr-2 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                        </svg>
                        Regresar al carrito y revisar tu selección
                    </li>
                    <li class="flex items-start">
                        <svg class="w-4 h-4 text-purple-600 mt-0.5 mr-2 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                        </svg>
                        Explorar más servicios decorativos
                    </li>
                    <li class="flex items-start">
                        <svg class="w-4 h-4 text-purple-600 mt-0.5 mr-2 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                        </svg>
                        Contactarnos para una cotización personalizada
                    </li>
                </ul>
            </div>

            <!-- Información de contacto -->
            <div class="bg-purple-50 rounded-lg p-4 mb-6">
                <h3 class="font-semibold text-purple-900 mb-2">¿Necesitas ayuda?</h3>
                <p class="text-sm text-purple-800 mb-2">
                    Si tienes dudas sobre nuestros servicios o el proceso de pago, no dudes en contactarnos.
                </p>
                <p class="text-sm text-purple-800">
                    📞 <strong>Teléfono:</strong> (502) 1234-5678<br>
                    📧 <strong>Email:</strong> info@deckorativa.com
                </p>
            </div>

            <!-- Botones de acción -->
            <div class="space-y-3">
                <a href="{{ route('public.carrito') }}"
                   class="w-full bg-gradient-to-r from-purple-600 to-indigo-600 text-white py-3 px-6 rounded-lg hover:from-purple-700 hover:to-indigo-700 transition duration-300 font-medium inline-block">
                    🛒 Regresar al Carrito
                </a>
                <a href="{{ route('public.servicios') }}"
                   class="w-full bg-gray-200 text-gray-700 py-3 px-6 rounded-lg hover:bg-gray-300 transition duration-300 font-medium inline-block">
                    Ver Más Servicios
                </a>
                <a href="{{ route('public.home') }}"
                   class="w-full text-gray-600 py-2 px-6 rounded-lg hover:text-gray-800 transition duration-300 inline-block">
                    Ir al Inicio
                </a>
            </div>

            <!-- Logo y marca -->
            <div class="mt-8 pt-6 border-t border-gray-200">
                <h2 class="text-lg font-bold gradient-text">DECKORATIVA</h2>
                <p class="text-xs text-gray-500 mt-1">Hacemos realidad tus ideas decorativas</p>
            </div>
        </div>

        <!-- Mensaje de tranquilidad adicional -->
        <div class="mt-4 text-center">
            <p class="text-xs text-gray-500">
                🔒 Proceso seguro - No se ha realizado ningún cargo a tu cuenta
            </p>
        </div>
    </div>

    <script>
        // IMPORTANTE: Limpiar el sessionStorage de respaldo
        // El carrito en localStorage NO se borra, por lo que el usuario
        // puede regresar al carrito y ver sus items intactos
        sessionStorage.removeItem('carritoEnProceso');

        // Verificar que el carrito existe
        const carrito = localStorage.getItem('carrito');
        if (carrito) {
            const items = JSON.parse(carrito);
            console.log('✅ Tu carrito está intacto con', items.length, 'items');
        } else {
            console.log('ℹ️ El carrito está vacío');
        }
    </script>
</body>
</html>