@extends('layouts.app')

@section('content')
    <div class="animate-slideInUp">
        <div class="page-header">
            <div class="flex flex-col lg:flex-row lg:items-center lg:justify-between">
                <div>
                    <h1 class="page-title text-gradient">
                        <i class="fas fa-file-invoice-dollar mr-3"></i>
                        {{ $cotizacion->numero_cotizacion }}
                    </h1>
                    <p class="page-subtitle">
                        <i class="fas fa-user mr-2"></i>
                        Cliente: {{ $cotizacion->client->name }} - Creada: {{ $cotizacion->created_at->format('d/m/Y') }}
                    </p>
                </div>
                <div class="mt-6 lg:mt-0 flex gap-3">
                    @can('generate pdf cotizaciones')
                    <a href="{{ route('cotizaciones.pdf', $cotizacion) }}" class="btn-primary" target="_blank">
                        <i class="fas fa-file-pdf mr-2"></i>
                        Descargar PDF
                    </a>
                    @endcan
                    
                    @can('edit cotizaciones')
                    @if($cotizacion->estado == 'borrador')
                    <a href="{{ route('cotizaciones.edit', $cotizacion) }}" class="btn-outline">
                        <i class="fas fa-edit mr-2"></i>
                        Editar
                    </a>
                    @endif
                    @endcan
                    
                    <a href="{{ route('cotizaciones.index') }}" class="btn-outline">
                        <i class="fas fa-arrow-left mr-2"></i>
                        Volver al Listado
                    </a>
                </div>
            </div>
        </div>

        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            <!-- Información de la Cotización -->
            <div class="lg:col-span-2">
                <!-- Información del Cliente -->
                <div class="card mb-6">
                    <h3 class="text-lg font-semibold text-gray-900 mb-4">
                        <i class="fas fa-user mr-2 text-blue-600"></i>
                        Información del Cliente
                    </h3>
                    
                    <div class="flex items-center mb-4">
                        <div class="w-16 h-16 bg-gradient-to-r from-green-500 to-green-600 rounded-full flex items-center justify-center mr-4">
                            <span class="text-white font-bold text-xl">
                                {{ strtoupper(substr($cotizacion->client->name, 0, 2)) }}
                            </span>
                        </div>
                        <div>
                            <h4 class="text-xl font-semibold text-gray-900">{{ $cotizacion->client->name }}</h4>
                            <p class="text-gray-600">{{ $cotizacion->client->email }}</p>
                            @if($cotizacion->client->phone)
                                <p class="text-gray-600">
                                    <i class="fas fa-phone mr-1"></i>
                                    {{ $cotizacion->client->phone }}
                                </p>
                            @endif
                        </div>
                    </div>
                </div>

                <!-- Servicios de la Cotización -->
                <div class="card">
                    <h3 class="text-lg font-semibold text-gray-900 mb-4">
                        <i class="fas fa-layer-group mr-2 text-green-600"></i>
                        Servicios y Productos ({{ $cotizacion->detalles->count() }})
                    </h3>

                    <div class="space-y-4">
                        @foreach($cotizacion->detalles as $detalle)
                            <div class="border border-gray-200 rounded-lg p-4">
                                <div class="flex items-start justify-between">
                                    <div class="flex-1">
                                        <div class="flex items-center mb-2">
                                            @if($detalle->servicio->imagen)
                                                <div class="w-12 h-12 bg-gray-100 rounded-lg overflow-hidden mr-3">
                                                    <img src="{{ asset('storage/' . $detalle->servicio->imagen) }}" 
                                                         alt="{{ $detalle->servicio->nombre }}" 
                                                         class="w-full h-full object-cover">
                                                </div>
                                            @else
                                                <div class="w-12 h-12 bg-gradient-to-r from-cyan-500 to-cyan-600 rounded-lg flex items-center justify-center mr-3">
                                                    <i class="fas fa-{{ $detalle->servicio->tipo == 'servicio' ? 'handshake' : 'box' }} text-white"></i>
                                                </div>
                                            @endif
                                            <div>
                                                <h4 class="font-semibold text-gray-900">{{ $detalle->servicio->nombre }}</h4>
                                                <div class="flex items-center space-x-2 text-sm text-gray-600">
                                                    <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium 
                                                           {{ $detalle->servicio->tipo == 'servicio' ? 'bg-blue-100 text-blue-800' : 'bg-green-100 text-green-800' }}">
                                                        {{ ucfirst($detalle->servicio->tipo) }}
                                                    </span>
                                                    <span>{{ $detalle->servicio->categoria->nombre }}</span>
                                                </div>
                                            </div>
                                        </div>

                                        @if($detalle->notas)
                                            <p class="text-sm text-gray-600 mt-2">
                                                <i class="fas fa-sticky-note mr-1"></i>
                                                {{ $detalle->notas }}
                                            </p>
                                        @endif
                                    </div>

                                    <div class="text-right ml-4">
                                        <div class="text-sm text-gray-600">Cantidad: {{ $detalle->cantidad }}</div>
                                        <div class="text-sm text-gray-600">Precio unit: {{ $detalle->precio_unitario_formateado }}</div>
                                        <div class="text-lg font-bold text-green-600">{{ $detalle->subtotal_formateado }}</div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>

                    @if($cotizacion->observaciones)
                        <div class="mt-6 p-4 bg-gray-50 rounded-lg">
                            <h4 class="font-medium text-gray-900 mb-2">
                                <i class="fas fa-comment-alt mr-2 text-gray-600"></i>
                                Observaciones
                            </h4>
                            <p class="text-gray-700">{{ $cotizacion->observaciones }}</p>
                        </div>
                    @endif
                </div>
            </div>

            <!-- Resumen y Acciones -->
            <div class="lg:col-span-1">
                <!-- Estado y Fechas -->
                <div class="card mb-6">
                    <h3 class="text-lg font-semibold text-gray-900 mb-4">
                        <i class="fas fa-info-circle mr-2 text-purple-600"></i>
                        Estado de la Cotización
                    </h3>

                    <div class="space-y-4">
                        <div class="flex justify-between items-center">
                            <span class="text-gray-600">Estado:</span>
                            <span class="badge badge-{{ $cotizacion->estado_color }}">
                                {{ ucfirst($cotizacion->estado) }}
                            </span>
                        </div>

                        <div class="flex justify-between items-center">
                            <span class="text-gray-600">Número:</span>
                            <span class="font-mono font-semibold">{{ $cotizacion->numero_cotizacion }}</span>
                        </div>

                        <div class="flex justify-between items-center">
                            <span class="text-gray-600">Creado:</span>
                            <span>{{ $cotizacion->created_at->format('d/m/Y H:i') }}</span>
                        </div>

                        <div class="flex justify-between items-center">
                            <span class="text-gray-600">Vigencia:</span>
                            <div class="text-right">
                                <div>{{ $cotizacion->fecha_vigencia->format('d/m/Y') }}</div>
                                @if($cotizacion->isVencida())
                                    <span class="text-red-600 text-sm font-medium">Vencida</span>
                                @else
                                    <span class="text-green-600 text-sm">{{ $cotizacion->fecha_vigencia->diffInDays(now()) }} días restantes</span>
                                @endif
                            </div>
                        </div>

                        <div class="flex justify-between items-center">
                            <span class="text-gray-600">Creado por:</span>
                            <span>{{ $cotizacion->user->name ?? 'Sistema' }}</span>
                        </div>

                        @if($cotizacion->enviada_cliente)
                            <div class="flex justify-between items-center">
                                <span class="text-gray-600">Enviada:</span>
                                <span class="text-green-600">
                                    <i class="fas fa-check mr-1"></i>
                                    {{ $cotizacion->fecha_envio->format('d/m/Y H:i') }}
                                </span>
                            </div>
                        @endif
                    </div>

                    <!-- Cambiar Estado -->
                    @can('change state cotizaciones')
                    <div class="mt-6 pt-4 border-t">
                        <form action="{{ route('cotizaciones.cambiarEstado', $cotizacion) }}" method="POST">
                            @csrf
                            @method('PATCH')
                            <label class="form-label">Cambiar Estado</label>
                            <div class="flex gap-2">
                                <select name="estado" class="form-select flex-1">
                                    <option value="borrador" {{ $cotizacion->estado == 'borrador' ? 'selected' : '' }}>Borrador</option>
                                    <option value="enviada" {{ $cotizacion->estado == 'enviada' ? 'selected' : '' }}>Enviada</option>
                                    <option value="aprobada" {{ $cotizacion->estado == 'aprobada' ? 'selected' : '' }}>Aprobada</option>
                                    <option value="rechazada" {{ $cotizacion->estado == 'rechazada' ? 'selected' : '' }}>Rechazada</option>
                                </select>
                                <button type="submit" class="btn-primary btn-sm">
                                    <i class="fas fa-save"></i>
                                </button>
                            </div>
                        </form>
                    </div>
                    @endcan
                </div>

                <!-- Resumen Financiero -->
                <div class="card">
                    <h3 class="text-lg font-semibold text-gray-900 mb-4">
                        <i class="fas fa-calculator mr-2 text-green-600"></i>
                        Resumen Financiero
                    </h3>

                    <div class="space-y-4">
                        <div class="flex justify-between items-center">
                            <span class="text-gray-600">Subtotal:</span>
                            <span class="font-semibold">Q{{ number_format($cotizacion->subtotal, 2) }}</span>
                        </div>

                        @if($cotizacion->descuento > 0)
                        <div class="flex justify-between items-center">
                            <span class="text-gray-600">Descuento:</span>
                            <span class="font-semibold text-red-600">-Q{{ number_format($cotizacion->descuento, 2) }}</span>
                        </div>
                        @endif

                        <div class="flex justify-between items-center">
                            <span class="text-gray-600">IVA ({{ $cotizacion->impuesto }}%):</span>
                            <span class="font-semibold">Q{{ number_format($cotizacion->total_impuesto, 2) }}</span>
                        </div>

                        <div class="border-t pt-4">
                            <div class="flex justify-between items-center">
                                <span class="text-xl font-bold text-gray-900">Total:</span>
                                <span class="text-3xl font-bold text-green-600">{{ $cotizacion->total_formateado }}</span>
                            </div>
                        </div>
                    </div>

                    <!-- Acciones Rápidas -->
                    <div class="mt-6 pt-4 border-t space-y-2">
                        @can('send email cotizaciones')
                        {{-- @if(!$cotizacion->enviada_cliente) --}}
                        <form action="{{ route('cotizaciones.enviar', $cotizacion) }}" method="POST">
                            @csrf
                            <button type="submit" class="w-full btn-primary btn-sm">
                                <i class="fas fa-envelope mr-2"></i>
                                Enviar por Email
                            </button>
                        </form>
                        {{-- @endif --}}
                        @endcan

                        @can('generate pdf cotizaciones')
                        <a href="{{ route('cotizaciones.pdf', $cotizacion) }}" class="w-full btn-outline btn-sm" target="_blank">
                            <i class="fas fa-file-pdf mr-2"></i>
                            Ver/Descargar PDF
                        </a>
                        @endcan
                    </div>
                </div>
            </div>
        </div>
        </div>
    </div>
@endsection