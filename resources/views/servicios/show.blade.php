@extends('layouts.app')

@section('content')
    <div class="animate-slideInUp">
        <div class="page-header">
            <div class="flex flex-col lg:flex-row lg:items-center lg:justify-between">
                <div>
                    <h1 class="page-title text-gradient">
                        <i class="fas fa-{{ $servicio->tipo == 'servicio' ? 'handshake' : 'box' }} mr-3"></i>
                        {{ $servicio->nombre }}
                    </h1>
                    <p class="page-subtitle">
                        <i class="fas fa-tag mr-2"></i>
                        {{ ucfirst($servicio->tipo) }} - {{ $servicio->categoria->nombre }}
                    </p>
                </div>
                <div class="mt-6 lg:mt-0 flex gap-3">
                    @can('edit servicios')
                    <a href="{{ route('servicios.edit', $servicio) }}" class="btn-primary">
                        <i class="fas fa-edit mr-2"></i>
                        Editar
                    </a>
                    @endcan
                    <a href="{{ route('servicios.index') }}" class="btn-outline">
                        <i class="fas fa-arrow-left mr-2"></i>
                        Volver al Catálogo
                    </a>
                </div>
            </div>
        </div>

        <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
            <!-- Imagen y detalles -->
            <div class="card">
                <div class="text-center mb-6">
                    @if($servicio->imagen)
                        <div class="w-full h-64 bg-gray-100 rounded-lg overflow-hidden shadow-lg mb-4">
                            <img src="{{ asset('storage/' . $servicio->imagen) }}" 
                                 alt="{{ $servicio->nombre }}" 
                                 class="w-full h-full object-cover">
                        </div>
                    @else
                        <div class="w-full h-64 bg-gradient-to-br from-cyan-500 to-blue-600 rounded-lg flex items-center justify-center shadow-lg mb-4">
                            <i class="fas fa-{{ $servicio->tipo == 'servicio' ? 'handshake' : 'box' }} text-white text-6xl"></i>
                        </div>
                    @endif
                    
                    <div class="flex justify-center space-x-2 mb-4">
                        <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium 
                               {{ $servicio->tipo == 'servicio' ? 'bg-blue-100 text-blue-800' : 'bg-green-100 text-green-800' }}">
                            <i class="fas fa-{{ $servicio->tipo == 'servicio' ? 'handshake' : 'box' }} mr-2"></i>
                            {{ ucfirst($servicio->tipo) }}
                        </span>
                        
                        @if($servicio->activo)
                            <span class="badge badge-success">Activo</span>
                        @else
                            <span class="badge badge-danger">Inactivo</span>
                        @endif
                    </div>
                    
                    <div class="text-center">
                        <div class="text-4xl font-bold text-green-600 mb-2">
                            Q{{ number_format($servicio->precio, 2) }}
                        </div>
                        <div class="text-gray-600">por {{ $servicio->unidad_medida }}</div>
                    </div>
                </div>
            </div>

            <!-- Información detallada -->
            <div class="card">
                <h3 class="text-lg font-semibold text-gray-900 mb-4">
                    <i class="fas fa-info-circle mr-2 text-blue-600"></i>
                    Información Detallada
                </h3>

                <div class="space-y-6">
                    @if($servicio->descripcion)
                    <div>
                        <label class="text-sm font-medium text-gray-700">Descripción</label>
                        <p class="text-gray-900 mt-1">{{ $servicio->descripcion }}</p>
                    </div>
                    @endif

                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <label class="text-sm font-medium text-gray-700">ID</label>
                            <p class="text-gray-900 font-mono">#{{ $servicio->id }}</p>
                        </div>
                        <div>
                            <label class="text-sm font-medium text-gray-700">Categoría</label>
                            <p class="text-gray-900">{{ $servicio->categoria->nombre }}</p>
                        </div>
                    </div>

                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <label class="text-sm font-medium text-gray-700">Precio Unitario</label>
                            <p class="text-2xl font-bold text-green-600">Q{{ number_format($servicio->precio, 2) }}</p>
                        </div>
                        <div>
                            <label class="text-sm font-medium text-gray-700">Unidad de Medida</label>
                            <p class="text-gray-900">{{ ucfirst($servicio->unidad_medida) }}</p>
                        </div>
                    </div>

                    @if($servicio->tiempo_estimado)
                    <div>
                        <label class="text-sm font-medium text-gray-700">Tiempo Estimado</label>
                        <p class="text-gray-900">
                            <i class="fas fa-clock mr-2 text-blue-600"></i>
                            {{ $servicio->tiempo_estimado }} minutos
                            <span class="text-gray-600">({{ round($servicio->tiempo_estimado / 60, 1) }} horas)</span>
                        </p>
                    </div>
                    @endif

                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <label class="text-sm font-medium text-gray-700">Fecha de Creación</label>
                            <p class="text-gray-900">{{ $servicio->created_at->format('d/m/Y H:i') }}</p>
                        </div>
                        <div>
                            <label class="text-sm font-medium text-gray-700">Última Actualización</label>
                            <p class="text-gray-900">{{ $servicio->updated_at->format('d/m/Y H:i') }}</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection