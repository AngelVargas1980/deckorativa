@extends('layouts.app')

@section('content')
    <div class="animate-slideInUp">
        <!-- Header -->
        <div class="page-header mb-6">
            <div class="flex flex-col lg:flex-row lg:items-center lg:justify-between">
                <div>
                    <div class="flex items-center mb-2">
                        <a href="{{ route('pedidos.index') }}"
                            class="text-gray-500 hover:text-gray-700 mr-3 transition-colors">
                            <i class="fas fa-arrow-left"></i>
                        </a>
                        <h1 class="page-title text-gradient">
                            <i class="fas fa-file-invoice mr-3"></i>
                            Detalle del Pedido
                        </h1>
                    </div>
                    <p class="page-subtitle">
                        <i class="fas fa-info-circle mr-2"></i>
                        Información completa del pedido {{ $pedido->numero_pedido }}
                    </p>
                </div>
                <div class="mt-4 lg:mt-0 flex flex-col sm:flex-row gap-3">
                    @can('edit pedidos')
                        <a href="{{ route('pedidos.edit', $pedido->id) }}" class="btn-outline btn-sm">
                            <i class="fas fa-edit mr-2"></i>
                            Editar Pedido
                        </a>
                    @endcan

                    @can('generate pdf pedidos')
                        <a href="{{ route('pedidos.pdf', $pedido) }}" class="btn-primary btn-sm" target="_blank">
                            <i class="fas fa-file-pdf mr-2"></i>
                            Descargar PDF
                        </a>
                    @endcan

                    @can('delete pedidos')
                        <button type="button" onclick="abrirModalEliminar()"
                            class="btn-outline btn-sm text-red-600 border-red-300 hover:bg-red-50">
                            <i class="fas fa-trash mr-2"></i>
                            Eliminar
                        </button>
                    @endcan
                </div>
            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            <!-- Columna principal (2/3) -->
            <div class="lg:col-span-2 space-y-6">
                <!-- Información del Pedido -->
                <div class="card">
                    <div class="card-header bg-gradient-to-r from-blue-50 to-indigo-50">
                        <i class="fas fa-clipboard-list text-blue-600 mr-2"></i>
                        <h3 class="card-title text-blue-900">Información del Pedido</h3>
                    </div>
                    <div class="card-body">
                        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                            <!-- Número de Pedido -->
                            <div>
                                <label class="text-sm font-medium text-gray-500 mb-1 block">
                                    <i class="fas fa-hashtag mr-1"></i>
                                    Número de Pedido
                                </label>
                                <p class="text-lg font-bold text-gray-900">{{ $pedido->numero_pedido }}</p>
                            </div>

                            <!-- Estado -->
                            <div>
                                <label class="text-sm font-medium text-gray-500 mb-1 block">
                                    <i class="fas fa-flag mr-1"></i>
                                    Estado
                                </label>
                                @php
                                    $estadoClasses = [
                                        'pendiente' => 'badge-warning',
                                        'en_proceso' => 'badge-info',
                                        'completado' => 'badge-success',
                                        'cancelado' => 'badge-error',
                                    ];
                                    $estadoIcons = [
                                        'pendiente' => 'fa-clock',
                                        'en_proceso' => 'fa-spinner',
                                        'completado' => 'fa-check-circle',
                                        'cancelado' => 'fa-times-circle',
                                    ];
                                @endphp
                                <span class="badge {{ $estadoClasses[$pedido->estado] ?? 'badge-secondary' }}">
                                    <i class="fas {{ $estadoIcons[$pedido->estado] ?? 'fa-circle' }} mr-1"></i>
                                    {{ $pedido->estado_formateado }}
                                </span>
                            </div>

                            <!-- Fecha de Creación -->
                            <div>
                                <label class="text-sm font-medium text-gray-500 mb-1 block">
                                    <i class="fas fa-calendar-plus mr-1"></i>
                                    Fecha de Creación
                                </label>
                                <p class="text-gray-900 font-semibold">
                                    {{ $pedido->created_at->format('d/m/Y') }}
                                </p>
                                <p class="text-sm text-gray-500">{{ $pedido->created_at->format('h:i A') }}</p>
                            </div>

                            <!-- Fecha de Entrega -->
                            <div>
                                <label class="text-sm font-medium text-gray-500 mb-1 block">
                                    <i class="fas fa-calendar-check mr-1"></i>
                                    Fecha de Entrega
                                </label>
                                <p class="text-gray-900 font-semibold">
                                    {{ $pedido->fecha_entrega ? $pedido->fecha_entrega->format('d/m/Y') : 'No especificada' }}
                                </p>
                            </div>

                            <!-- Teléfono -->
                            <div>
                                <label class="text-sm font-medium text-gray-500 mb-1 block">
                                    <i class="fas fa-phone mr-1"></i>
                                    Teléfono de Contacto
                                </label>
                                <p class="text-gray-900 font-semibold">{{ $pedido->telefono_contacto }}</p>
                            </div>

                            <!-- Cotización Relacionada -->
                            <div>
                                <label class="text-sm font-medium text-gray-500 mb-1 block">
                                    <i class="fas fa-file-invoice-dollar mr-1"></i>
                                    Cotización
                                </label>
                                @if ($pedido->cotizacion)
                                    <a href="{{ route('cotizaciones.show', $pedido->cotizacion->id) }}"
                                        class="text-blue-600 hover:text-blue-800 font-semibold">
                                        {{ $pedido->cotizacion->numero_cotizacion }}
                                    </a>
                                @else
                                    <p class="text-gray-400 italic">Sin cotización</p>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Información del Cliente -->
                <div class="card">
                    <div class="card-header bg-gradient-to-r from-green-50 to-emerald-50">
                        <i class="fas fa-user-tie text-green-600 mr-2"></i>
                        <h3 class="card-title text-green-900">Información del Cliente</h3>
                    </div>
                    <div class="card-body">
                        <div class="flex items-start space-x-4">
                            <!-- Avatar -->
                            <div class="flex-shrink-0">
                                <div
                                    class="w-16 h-16 bg-gradient-to-r from-green-500 to-emerald-600 rounded-full flex items-center justify-center shadow-lg">
                                    <span class="text-white font-bold text-xl">
                                        {{ strtoupper(substr($pedido->cliente->first_name, 0, 1)) }}{{ strtoupper(substr($pedido->cliente->last_name ?? '', 0, 1)) }}
                                    </span>
                                </div>
                            </div>

                            <!-- Datos del Cliente -->
                            <div class="flex-1 grid grid-cols-1 md:grid-cols-2 gap-4">
                                <div>
                                    <label class="text-sm font-medium text-gray-500 mb-1 block">
                                        <i class="fas fa-user mr-1"></i>
                                        Nombre Completo
                                    </label>
                                    <p class="text-gray-900 font-semibold">
                                        {{ $pedido->cliente->first_name }} {{ $pedido->cliente->last_name }}
                                    </p>
                                </div>

                                <div>
                                    <label class="text-sm font-medium text-gray-500 mb-1 block">
                                        <i class="fas fa-envelope mr-1"></i>
                                        Email
                                    </label>
                                    <p class="text-gray-900">
                                        <a href="mailto:{{ $pedido->cliente->email }}"
                                            class="text-blue-600 hover:text-blue-800">
                                            {{ $pedido->cliente->email }}
                                        </a>
                                    </p>
                                </div>

                                @if ($pedido->cliente->phone)
                                    <div>
                                        <label class="text-sm font-medium text-gray-500 mb-1 block">
                                            <i class="fas fa-phone mr-1"></i>
                                            Teléfono
                                        </label>
                                        <p class="text-gray-900">
                                            <a href="tel:{{ $pedido->cliente->phone }}"
                                                class="text-blue-600 hover:text-blue-800">
                                                {{ $pedido->cliente->phone }}
                                            </a>
                                        </p>
                                    </div>
                                @endif

                                @if ($pedido->cliente->identification_number)
                                    <div>
                                        <label class="text-sm font-medium text-gray-500 mb-1 block">
                                            <i class="fas fa-id-card mr-1"></i>
                                            Identificación
                                        </label>
                                        <p class="text-gray-900 font-mono">{{ $pedido->cliente->identification_number }}
                                        </p>
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Dirección de Entrega -->
                <div class="card">
                    <div class="card-header bg-gradient-to-r from-orange-50 to-red-50">
                        <i class="fas fa-map-marker-alt text-orange-600 mr-2"></i>
                        <h3 class="card-title text-orange-900">Dirección de Entrega</h3>
                    </div>
                    <div class="card-body">
                        <div class="flex items-start space-x-3">
                            <div class="flex-shrink-0 mt-1">
                                <div class="w-10 h-10 bg-orange-100 rounded-full flex items-center justify-center">
                                    <i class="fas fa-map-marker-alt text-orange-600"></i>
                                </div>
                            </div>
                            <div class="flex-1">
                                <p class="text-gray-900 leading-relaxed">{{ $pedido->direccion_entrega }}</p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Detalles del Pedido -->
                <div class="card">
                    <div class="card-header bg-gradient-to-r from-purple-50 to-pink-50">
                        <i class="fas fa-list-ul text-purple-600 mr-2"></i>
                        <h3 class="card-title text-purple-900">Servicios Incluidos</h3>
                    </div>
                    <div class="card-body p-0">
                        <div class="overflow-x-auto">
                            <table class="min-w-full divide-y divide-gray-200">
                                <thead class="bg-gray-50">
                                    <tr>
                                        <th
                                            class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            Servicio
                                        </th>
                                        <th
                                            class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            Cantidad
                                        </th>
                                        <th
                                            class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            Precio Unit.
                                        </th>
                                        <th
                                            class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            Subtotal
                                        </th>
                                    </tr>
                                </thead>
                                <tbody class="bg-white divide-y divide-gray-200">
                                    @foreach ($pedido->detalles as $detalle)
                                        <tr class="hover:bg-gray-50 transition-colors">
                                            <td class="px-6 py-4">
                                                <div class="flex items-center">
                                                    <div
                                                        class="w-10 h-10 bg-purple-100 rounded-lg flex items-center justify-center mr-3">
                                                        <i class="fas fa-box text-purple-600"></i>
                                                    </div>
                                                    <div>
                                                        <p class="text-sm font-semibold text-gray-900">
                                                            {{ $detalle->servicio->nombre }}
                                                        </p>
                                                        @if ($detalle->servicio->descripcion)
                                                            <p class="text-xs text-gray-500">
                                                                {{ Str::limit($detalle->servicio->descripcion, 50) }}
                                                            </p>
                                                        @endif
                                                    </div>
                                                </div>
                                            </td>
                                            <td class="px-6 py-4 text-center">
                                                <span
                                                    class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-blue-100 text-blue-800">
                                                    {{ $detalle->cantidad }}
                                                </span>
                                            </td>
                                            <td class="px-6 py-4 text-right">
                                                <span class="text-sm font-medium text-gray-900">
                                                    ${{ number_format($detalle->precio_unitario, 2) }}
                                                </span>
                                            </td>
                                            <td class="px-6 py-4 text-right">
                                                <span class="text-sm font-bold text-gray-900">
                                                    ${{ number_format($detalle->subtotal, 2) }}
                                                </span>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                                <tfoot class="bg-gray-50">
                                    <tr>
                                        <td colspan="3" class="px-6 py-4 text-right text-sm font-bold text-gray-900">
                                            Total:
                                        </td>
                                        <td class="px-6 py-4 text-right">
                                            <span class="text-xl font-bold text-blue-600">
                                                ${{ number_format($pedido->total, 2) }}
                                            </span>
                                        </td>
                                    </tr>
                                </tfoot>
                            </table>
                        </div>
                    </div>
                </div>

                <!-- Observaciones -->
                @if ($pedido->observaciones)
                    <div class="card">
                        <div class="card-header bg-gradient-to-r from-yellow-50 to-amber-50">
                            <i class="fas fa-comment-alt text-yellow-600 mr-2"></i>
                            <h3 class="card-title text-yellow-900">Observaciones</h3>
                        </div>
                        <div class="card-body">
                            <div class="flex items-start space-x-3">
                                <div class="flex-shrink-0 mt-1">
                                    <div class="w-10 h-10 bg-yellow-100 rounded-full flex items-center justify-center">
                                        <i class="fas fa-comment-dots text-yellow-600"></i>
                                    </div>
                                </div>
                                <div class="flex-1">
                                    <p class="text-gray-700 leading-relaxed">{{ $pedido->observaciones }}</p>
                                </div>
                            </div>
                        </div>
                    </div>
                @endif
            </div>

            <!-- Columna lateral (1/3) -->
            <div class="space-y-6">
                <!-- Resumen Rápido -->
                <div class="card bg-gradient-to-br from-blue-500 to-indigo-600 text-white">
                    <div class="card-body">
                        <div class="text-center">
                            <div class="w-16 h-16 bg-white/20 rounded-full flex items-center justify-center mx-auto mb-4">
                                <i class="fas fa-dollar-sign text-3xl"></i>
                            </div>
                            <h3 class="text-lg font-semibold mb-2 opacity-90">Total del Pedido</h3>
                            <p class="text-4xl font-bold mb-1">${{ number_format($pedido->total, 2) }}</p>
                            <p class="text-sm opacity-75">{{ count($pedido->detalles) }} servicio(s)</p>
                        </div>
                    </div>
                </div>

                <!-- Estadísticas -->
                <div class="card">
                    <div class="card-header">
                        <i class="fas fa-chart-bar text-indigo-600 mr-2"></i>
                        <h3 class="card-title">Estadísticas</h3>
                    </div>
                    <div class="card-body space-y-4">
                        <div class="flex items-center justify-between p-3 bg-blue-50 rounded-lg">
                            <div class="flex items-center">
                                <div class="w-10 h-10 bg-blue-100 rounded-full flex items-center justify-center mr-3">
                                    <i class="fas fa-boxes text-blue-600"></i>
                                </div>
                                <span class="text-sm font-medium text-gray-700">Servicios</span>
                            </div>
                            <span class="text-lg font-bold text-blue-600">{{ count($pedido->detalles) }}</span>
                        </div>

                        <div class="flex items-center justify-between p-3 bg-green-50 rounded-lg">
                            <div class="flex items-center">
                                <div class="w-10 h-10 bg-green-100 rounded-full flex items-center justify-center mr-3">
                                    <i class="fas fa-layer-group text-green-600"></i>
                                </div>
                                <span class="text-sm font-medium text-gray-700">Cantidad Total</span>
                            </div>
                            <span class="text-lg font-bold text-green-600">
                                {{ $pedido->detalles->sum('cantidad') }}
                            </span>
                        </div>
                    </div>
                </div>

                <!-- Timeline -->
                <div class="card">
                    <div class="card-header">
                        <i class="fas fa-history text-gray-600 mr-2"></i>
                        <h3 class="card-title">Historial</h3>
                    </div>
                    <div class="card-body">
                        <div class="space-y-4">
                            <div class="flex items-start">
                                <div class="flex-shrink-0">
                                    <div class="w-8 h-8 bg-green-100 rounded-full flex items-center justify-center">
                                        <i class="fas fa-plus text-green-600 text-xs"></i>
                                    </div>
                                </div>
                                <div class="ml-3">
                                    <p class="text-sm font-medium text-gray-900">Pedido creado</p>
                                    <p class="text-xs text-gray-500">{{ $pedido->created_at->format('d/m/Y h:i A') }}</p>
                                </div>
                            </div>

                            @if ($pedido->updated_at != $pedido->created_at)
                                <div class="flex items-start">
                                    <div class="flex-shrink-0">
                                        <div class="w-8 h-8 bg-blue-100 rounded-full flex items-center justify-center">
                                            <i class="fas fa-edit text-blue-600 text-xs"></i>
                                        </div>
                                    </div>
                                    <div class="ml-3">
                                        <p class="text-sm font-medium text-gray-900">Última actualización</p>
                                        <p class="text-xs text-gray-500">{{ $pedido->updated_at->format('d/m/Y h:i A') }}
                                        </p>
                                    </div>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>

                <!-- Acciones Rápidas -->
                <div class="card">
                    <div class="card-header">
                        <i class="fas fa-bolt text-yellow-600 mr-2"></i>
                        <h3 class="card-title">Acciones Rápidas</h3>
                    </div>
                    <div class="card-body space-y-2">
                        <a href="mailto:{{ $pedido->cliente->email }}" class="btn-outline btn-sm w-full">
                            <i class="fas fa-envelope mr-2"></i>
                            Enviar Email
                        </a>
                        <a href="tel:{{ $pedido->telefono_contacto }}" class="btn-outline btn-sm w-full">
                            <i class="fas fa-phone mr-2"></i>
                            Llamar Cliente
                        </a>
                        @can('generate pdf pedidos')
                            <a href="{{ route('pedidos.pdf', $pedido) }}" class="btn-outline btn-sm w-full" target="_blank">
                                <i class="fas fa-file-pdf mr-2"></i>
                                Ver/Descargar PDF
                            </a>
                        @endcan
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal de confirmación para eliminar (Estilo mejorado) -->
    @can('delete pedidos')
        <div id="modal-confirmar-eliminar" 
             class="fixed inset-0 bg-black bg-opacity-50 hidden z-50 flex items-center justify-center p-4"
             style="backdrop-filter: blur(4px);">
            <div class="bg-white rounded-2xl shadow-2xl max-w-md w-full transform transition-all">
                <!-- Header del Modal -->
                <div class="bg-gradient-to-r from-red-500 to-red-600 px-6 py-5 rounded-t-2xl">
                    <div class="flex items-center">
                        <div class="flex-shrink-0">
                            <div class="w-12 h-12 bg-white/20 rounded-full flex items-center justify-center">
                                <i class="fas fa-exclamation-triangle text-white text-xl"></i>
                            </div>
                        </div>
                        <div class="ml-4">
                            <h3 class="text-xl font-bold text-white">
                                Confirmar Eliminación
                            </h3>
                            <p class="text-red-100 text-sm mt-1">Esta acción es permanente</p>
                        </div>
                    </div>
                </div>

                <!-- Contenido del Modal -->
                <div class="p-6">
                    <div class="mb-4">
                        <p class="text-gray-700 text-base leading-relaxed">
                            ¿Estás seguro de que deseas eliminar el pedido <strong class="text-gray-900 font-semibold">{{ $pedido->numero_pedido }}</strong>?
                        </p>
                    </div>

                    <div class="bg-amber-50 border-l-4 border-amber-400 p-4 rounded-r-lg">
                        <div class="flex">
                            <div class="flex-shrink-0">
                                <i class="fas fa-info-circle text-amber-400"></i>
                            </div>
                            <div class="ml-3">
                                <p class="text-sm text-amber-800 font-medium">
                                    Esta acción no se puede deshacer
                                </p>
                                <p class="text-xs text-amber-700 mt-1">
                                    Se eliminarán todos los detalles asociados al pedido
                                </p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Footer del Modal -->
                <div class="bg-gray-50 px-6 py-4 rounded-b-2xl flex flex-col-reverse sm:flex-row sm:justify-end gap-3">
                    <button type="button" 
                            onclick="cerrarModalEliminar()"
                            class="w-full sm:w-auto px-5 py-2.5 bg-white border-2 border-gray-300 text-gray-700 font-medium rounded-lg hover:bg-gray-50 hover:border-gray-400 focus:outline-none focus:ring-2 focus:ring-gray-300 transition-all duration-200">
                        <i class="fas fa-times mr-2"></i>
                        Cancelar
                    </button>
                    <form action="{{ route('pedidos.destroy', $pedido->id) }}" method="POST" class="w-full sm:w-auto">
                        @csrf
                        @method('DELETE')
                        <button type="submit"
                                class="w-full px-5 py-2.5 bg-gradient-to-r from-red-500 to-red-600 text-white font-medium rounded-lg hover:from-red-600 hover:to-red-700 focus:outline-none focus:ring-2 focus:ring-red-500 focus:ring-offset-2 shadow-lg hover:shadow-xl transition-all duration-200 transform hover:scale-[1.02]">
                            <i class="fas fa-trash-alt mr-2"></i>
                            Eliminar Pedido
                        </button>
                    </form>
                </div>
            </div>
        </div>
    @endcan

    @push('scripts')
        <script>
            function abrirModalEliminar() {
                const modal = document.getElementById('modal-confirmar-eliminar');
                modal.classList.remove('hidden');
                document.body.style.overflow = 'hidden';
                
                // Animación de entrada
                setTimeout(() => {
                    modal.querySelector('div > div').classList.add('scale-100', 'opacity-100');
                }, 10);
            }

            function cerrarModalEliminar() {
                const modal = document.getElementById('modal-confirmar-eliminar');
                modal.querySelector('div > div').classList.remove('scale-100', 'opacity-100');
                
                setTimeout(() => {
                    modal.classList.add('hidden');
                    document.body.style.overflow = '';
                }, 200);
            }

            // Cerrar modal al hacer clic fuera
            document.getElementById('modal-confirmar-eliminar')?.addEventListener('click', function(e) {
                if (e.target === this) {
                    cerrarModalEliminar();
                }
            });

            // Cerrar modal con tecla ESC
            document.addEventListener('keydown', function(e) {
                if (e.key === 'Escape') {
                    const modal = document.getElementById('modal-confirmar-eliminar');
                    if (!modal.classList.contains('hidden')) {
                        cerrarModalEliminar();
                    }
                }
            });
        </script>
    @endpush
@endsection