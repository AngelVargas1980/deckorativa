<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pago Pendiente - Deckorativa</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;600;700&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Inter', sans-serif; }
        .gradient-text { background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); -webkit-background-clip: text; -webkit-text-fill-color: transparent; background-clip: text; }
        .pulse { animation: pulse 2s cubic-bezier(0.4, 0, 0.6, 1) infinite; }
    </style>
</head>
<body class="bg-gray-50 min-h-screen flex items-center justify-center">
    <div class="max-w-md w-full mx-4">
        <div class="bg-white rounded-2xl shadow-xl p-8 text-center">
            <!-- Ícono de pendiente -->
            <div class="w-16 h-16 mx-auto mb-6 bg-blue-100 rounded-full flex items-center justify-center pulse">
                <svg class="w-8 h-8 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                </svg>
            </div>

            <!-- Título -->
            <h1 class="text-2xl font-bold text-gray-900 mb-2">Pago en Proceso</h1>
            <p class="text-gray-600 mb-6">Tu pago está siendo verificado</p>

            <!-- Estado del pago -->
            <div class="bg-blue-50 border border-blue-200 rounded-lg p-4 mb-6">
                <p class="text-sm text-blue-800 mb-2">
                    <strong>Estado actual:</strong> {{ $pago->estado_texto }}
                </p>
                <p class="text-xs text-blue-700">
                    Estamos verificando tu pago. Este proceso puede tomar unos minutos.
                </p>
            </div>

            <!-- Detalles del pago -->
            <div class="bg-gray-50 rounded-lg p-4 mb-6 text-left">
                <h3 class="font-semibold text-gray-900 mb-3">Detalles de tu compra:</h3>

                <div class="space-y-2 text-sm">
                    <div class="flex justify-between">
                        <span class="text-gray-600">Cliente:</span>
                        <span class="font-medium">{{ $pago->customer_name }}</span>
                    </div>
                    <div class="flex justify-between">
                        <span class="text-gray-600">Email:</span>
                        <span class="font-medium">{{ $pago->customer_email }}</span>
                    </div>
                    <div class="flex justify-between">
                        <span class="text-gray-600">Total:</span>
                        <span class="font-bold text-blue-600">{{ $pago->total_formateado }}</span>
                    </div>
                    <div class="flex justify-between">
                        <span class="text-gray-600">Fecha:</span>
                        <span class="font-medium">{{ $pago->created_at->format('d/m/Y H:i') }}</span>
                    </div>
                    <div class="flex justify-between">
                        <span class="text-gray-600">ID de Transacción:</span>
                        <span class="font-medium text-xs">{{ $pago->checkout_id }}</span>
                    </div>
                </div>
            </div>

            <!-- Servicios comprados -->
            @if($pago->items && count($pago->items) > 0)
                <div class="bg-purple-50 rounded-lg p-4 mb-6 text-left">
                    <h3 class="font-semibold text-gray-900 mb-3">Servicios seleccionados:</h3>
                    <div class="space-y-2">
                        @foreach($pago->items as $item)
                            <div class="flex justify-between items-center text-sm">
                                <div>
                                    <span class="font-medium">{{ $item['nombre'] }}</span>
                                    <span class="text-gray-500">x{{ $item['cantidad'] ?? 1 }}</span>
                                </div>
                                <span class="font-medium">Q{{ number_format($item['precio'] * ($item['cantidad'] ?? 1), 2) }}</span>
                            </div>
                        @endforeach
                    </div>
                </div>
            @endif

            <!-- Instrucciones -->
            <div class="text-left mb-6">
                <h3 class="font-semibold text-gray-900 mb-2">¿Qué hacer mientras esperas?</h3>
                <ul class="text-sm text-gray-600 space-y-1">
                    <li>• Tu pedido ha sido registrado correctamente</li>
                    <li>• Recibirás una confirmación por email cuando se complete</li>
                    <li>• Puedes cerrar esta página sin problema</li>
                    <li>• El equipo te contactará una vez confirmado el pago</li>
                </ul>
            </div>

            <!-- Verificación en tiempo real -->
            <div class="bg-yellow-50 rounded-lg p-4 mb-6">
                <div class="flex items-center justify-center mb-2">
                    <div class="animate-spin rounded-full h-4 w-4 border-b-2 border-yellow-600 mr-2"></div>
                    <span class="text-sm font-medium text-yellow-800">Verificando pago...</span>
                </div>
                <button onclick="verificarEstadoPago()"
                        class="text-xs text-yellow-700 hover:text-yellow-900 underline">
                    Verificar manualmente
                </button>
            </div>

            <!-- Botones de acción -->
            <div class="space-y-3">
                <a href="{{ route('public.home') }}"
                   class="w-full bg-gradient-to-r from-purple-600 to-indigo-600 text-white py-3 px-6 rounded-lg hover:from-purple-700 hover:to-indigo-700 transition duration-300 font-medium inline-block">
                    Ir al Inicio
                </a>
                <a href="{{ route('public.servicios') }}"
                   class="w-full bg-gray-200 text-gray-700 py-3 px-6 rounded-lg hover:bg-gray-300 transition duration-300 font-medium inline-block">
                    Ver Más Servicios
                </a>
            </div>

            <!-- Información de contacto -->
            <div class="mt-6 text-xs text-gray-500">
                <p>¿Tienes preguntas? Contáctanos:</p>
                <p>📧 info@deckorativa.com | 📞 (502) 1234-5678</p>
            </div>

            <!-- Logo y marca -->
            <div class="mt-8 pt-6 border-t border-gray-200">
                <h2 class="text-lg font-bold gradient-text">DECKORATIVA</h2>
                <p class="text-xs text-gray-500 mt-1">Hacemos realidad tus ideas decorativas</p>
            </div>
        </div>
    </div>

    <!-- JavaScript para verificación automática -->
    <script>
        let verificacionInterval;
        const pagoId = {{ $pago->id }};

        function verificarEstadoPago() {
            fetch(`/payment/status/${pagoId}`)
                .then(response => response.json())
                .then(data => {
                    if (data.success && data.estado === 'completed') {
                        clearInterval(verificacionInterval);

                        // Mostrar mensaje de éxito y redirigir
                        document.querySelector('.bg-blue-50').innerHTML = `
                            <p class="text-sm text-green-800 mb-2">
                                <strong>¡Pago confirmado!</strong> Redirigiendo...
                            </p>
                        `;

                        setTimeout(() => {
                            window.location.href = `/payment/success?checkout_id={{ $pago->checkout_id }}`;
                        }, 2000);
                    }
                })
                .catch(error => {
                    // Error verificando estado
                });
        }

        // Verificar cada 10 segundos
        verificacionInterval = setInterval(verificarEstadoPago, 10000);

        // Limpiar interval al salir de la página
        window.addEventListener('beforeunload', () => {
            if (verificacionInterval) {
                clearInterval(verificacionInterval);
            }
        });

        // Verificación inicial después de 5 segundos
        setTimeout(verificarEstadoPago, 5000);
    </script>
</body>
</html>