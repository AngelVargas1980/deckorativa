<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pago Exitoso - Deckorativa</title>
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
            <!-- Ícono de éxito -->
            <div class="w-16 h-16 mx-auto mb-6 bg-green-100 rounded-full flex items-center justify-center">
                <svg class="w-8 h-8 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                </svg>
            </div>

            <!-- Título -->
            <h1 class="text-2xl font-bold text-gray-900 mb-2">¡Pago Exitoso!</h1>
            <p class="text-gray-600 mb-6">Tu pago se ha procesado correctamente</p>

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
                        <span class="font-bold text-green-600">{{ $pago->total_formateado }}</span>
                    </div>
                    <div class="flex justify-between">
                        <span class="text-gray-600">Fecha:</span>
                        <span class="font-medium">{{ $pago->fecha_pago ? $pago->fecha_pago->format('d/m/Y H:i') : 'Ahora' }}</span>
                    </div>
                    <div class="flex justify-between">
                        <span class="text-gray-600">ID de Transacción:</span>
                        <span class="font-medium text-xs">{{ $pago->checkout_id }}</span>
                    </div>
                </div>
            </div>

            <!-- Servicios comprados -->
            @if($pago->items && count($pago->items) > 0)
                <div class="bg-blue-50 rounded-lg p-4 mb-6 text-left">
                    <h3 class="font-semibold text-gray-900 mb-3">Servicios adquiridos:</h3>
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

            <!-- Próximos pasos -->
            <div class="text-left mb-6">
                <h3 class="font-semibold text-gray-900 mb-2">¿Qué sigue?</h3>
                <ul class="text-sm text-gray-600 space-y-1">
                    <li>• Recibirás un email de confirmación en breve</li>
                    <li>• Nuestro equipo se pondrá en contacto contigo</li>
                    <li>• Coordinaremos los detalles de los servicios</li>
                </ul>
            </div>

            <!-- Botones de acción -->
            <div class="space-y-3">
                <a href="{{ route('public.home') }}"
                   class="w-full bg-gradient-to-r from-purple-600 to-indigo-600 text-white py-3 px-6 rounded-lg hover:from-purple-700 hover:to-indigo-700 transition duration-300 font-medium inline-block">
                    Volver al Inicio
                </a>
                <a href="{{ route('public.servicios') }}"
                   class="w-full bg-gray-200 text-gray-700 py-3 px-6 rounded-lg hover:bg-gray-300 transition duration-300 font-medium inline-block">
                    Ver Más Servicios
                </a>
            </div>

            <!-- Logo y marca -->
            <div class="mt-8 pt-6 border-t border-gray-200">
                <h2 class="text-lg font-bold gradient-text">DECKORATIVA</h2>
                <p class="text-xs text-gray-500 mt-1">Hacemos realidad tus ideas decorativas</p>
            </div>
        </div>
    </div>

    <!-- Auto-redirección opcional -->
    <script>
        // IMPORTANTE: Limpiar el carrito cuando el pago es exitoso
        // Solo aquí se debe borrar el carrito, no antes
        localStorage.removeItem('carrito');
        sessionStorage.removeItem('carritoEnProceso');

        console.log('✅ Pago exitoso - Carrito limpiado');

        // Opcional: Auto-redirección después de 30 segundos
        // setTimeout(() => {
        //     window.location.href = "{{ route('public.home') }}";
        // }, 30000);
    </script>
</body>
</html>