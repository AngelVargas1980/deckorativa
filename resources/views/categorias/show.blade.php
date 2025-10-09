@extends('layouts.app')

@section('content')
    <div class="animate-slideInUp">
        <div class="page-header">
            <div class="flex flex-col lg:flex-row lg:items-center lg:justify-between">
                <div>
                    <h1 class="page-title text-gradient">
                        <i class="fas fa-tag mr-3"></i>
                        {{ $categoria->nombre }}
                    </h1>
                    <p class="page-subtitle">
                        <i class="fas fa-info-circle mr-2"></i>
                        Detalles de la categoría y servicios asociados
                    </p>
                </div>
                <div class="mt-6 lg:mt-0 flex flex-col sm:flex-row gap-3">
                    <button onclick="window.print()" class="btn-outline">
                        <i class="fas fa-print mr-2"></i>
                        Imprimir
                    </button>
                    @can('edit categorias')
                    <a href="{{ route('categorias.edit', $categoria) }}" class="btn-primary">
                        <i class="fas fa-edit mr-2"></i>
                        Editar Categoría
                    </a>
                    @endcan
                    <a href="{{ route('categorias.index') }}" class="btn-outline">
                        <i class="fas fa-arrow-left mr-2"></i>
                        Volver al Listado
                    </a>
                </div>
            </div>
        </div>

        <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            <!-- Información de la Categoría -->
            <div class="lg:col-span-1">
                <div class="card">
                    <div class="text-center mb-6">
                        @if($categoria->imagen)
                            <div class="w-32 h-32 mx-auto bg-gray-100 rounded-lg overflow-hidden shadow-lg mb-4">
                                <img src="{{ asset('storage/' . $categoria->imagen) }}" 
                                     alt="{{ $categoria->nombre }}" 
                                     class="w-full h-full object-cover">
                            </div>
                        @else
                            <div class="w-32 h-32 mx-auto bg-gradient-to-r from-amber-500 to-amber-600 rounded-lg flex items-center justify-center shadow-lg mb-4">
                                <span class="text-white font-bold text-2xl">
                                    {{ strtoupper(substr($categoria->nombre, 0, 2)) }}
                                </span>
                            </div>
                        @endif
                        <h2 class="text-2xl font-bold text-gray-900">{{ $categoria->nombre }}</h2>
                        <div class="mt-2">
                            @if($categoria->activo)
                                <span class="badge badge-success">
                                    <i class="fas fa-check-circle mr-1"></i>
                                    Activo
                                </span>
                            @else
                                <span class="badge badge-danger">
                                    <i class="fas fa-times-circle mr-1"></i>
                                    Inactivo
                                </span>
                            @endif
                        </div>
                    </div>

                    <div class="space-y-4">
                        <div>
                            <label class="text-sm font-medium text-gray-700">ID de Categoría</label>
                            <p class="text-gray-900 font-mono">#{{ $categoria->id }}</p>
                        </div>

                        @if($categoria->descripcion)
                        <div>
                            <label class="text-sm font-medium text-gray-700">Descripción</label>
                            <p class="text-gray-900">{{ $categoria->descripcion }}</p>
                        </div>
                        @endif

                        <div>
                            <label class="text-sm font-medium text-gray-700">Fecha de Creación</label>
                            <p class="text-gray-900">{{ $categoria->created_at->format('d/m/Y H:i') }}</p>
                        </div>

                        <div>
                            <label class="text-sm font-medium text-gray-700">Última Actualización</label>
                            <p class="text-gray-900">{{ $categoria->updated_at->format('d/m/Y H:i') }}</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Servicios de la Categoría -->
            <div class="lg:col-span-2">
                <div class="card">
                    <div class="flex items-center justify-between mb-6">
                        <div>
                            <h3 class="text-lg font-semibold text-gray-900">
                                <i class="fas fa-layer-group mr-2 text-blue-600"></i>
                                Servicios y Productos
                            </h3>
                            <p class="text-sm text-gray-600">{{ $categoria->servicios->count() }} elementos en esta categoría</p>
                        </div>
                        @can('create servicios')
                        <a href="{{ route('servicios.create', ['categoria_id' => $categoria->id]) }}" class="btn-primary btn-sm">
                            <i class="fas fa-plus mr-2"></i>
                            Agregar Servicio
                        </a>
                        @endcan
                    </div>

                    @if($categoria->servicios->count() > 0)
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            @foreach($categoria->servicios as $servicio)
                                <div class="border border-gray-200 rounded-lg p-4 hover:shadow-md transition-shadow">
                                    <div class="flex items-start justify-between">
                                        <div class="flex-1">
                                            <div class="flex items-center">
                                                @if($servicio->imagen)
                                                    <div class="w-10 h-10 bg-gray-100 rounded-lg overflow-hidden mr-3">
                                                        <img src="{{ asset('storage/' . $servicio->imagen) }}" 
                                                             alt="{{ $servicio->nombre }}" 
                                                             class="w-full h-full object-cover">
                                                    </div>
                                                @else
                                                    <div class="w-10 h-10 bg-gradient-to-r from-cyan-500 to-cyan-600 rounded-lg flex items-center justify-center mr-3">
                                                        <i class="fas fa-{{ $servicio->tipo == 'servicio' ? 'handshake' : 'box' }} text-white text-sm"></i>
                                                    </div>
                                                @endif
                                                <div>
                                                    <h4 class="font-semibold text-gray-900">{{ $servicio->nombre }}</h4>
                                                    <div class="flex items-center space-x-2 text-sm text-gray-600">
                                                        <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium 
                                                                   {{ $servicio->tipo == 'servicio' ? 'bg-blue-100 text-blue-800' : 'bg-green-100 text-green-800' }}">
                                                            <i class="fas fa-{{ $servicio->tipo == 'servicio' ? 'handshake' : 'box' }} mr-1"></i>
                                                            {{ ucfirst($servicio->tipo) }}
                                                        </span>
                                                        @if(!$servicio->activo)
                                                            <span class="badge badge-danger badge-sm">Inactivo</span>
                                                        @endif
                                                    </div>
                                                </div>
                                            </div>
                                            <p class="text-lg font-bold text-green-600 mt-2">Q{{ number_format($servicio->precio, 2) }}</p>
                                        </div>
                                        <div class="flex items-center space-x-1">
                                            <a href="{{ route('servicios.show', $servicio) }}" 
                                               class="inline-flex items-center justify-center w-8 h-8 text-gray-500 hover:text-blue-600 hover:bg-blue-50 rounded-lg transition-all duration-200"
                                               title="Ver servicio">
                                                <i class="fas fa-eye text-sm"></i>
                                            </a>
                                            @can('edit servicios')
                                            <a href="{{ route('servicios.edit', $servicio) }}" 
                                               class="inline-flex items-center justify-center w-8 h-8 text-gray-500 hover:text-orange-600 hover:bg-orange-50 rounded-lg transition-all duration-200"
                                               title="Editar servicio">
                                                <i class="fas fa-edit text-sm"></i>
                                            </a>
                                            @endcan
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <div class="text-center py-12">
                            <div class="w-16 h-16 bg-gray-100 rounded-full flex items-center justify-center mx-auto mb-4">
                                <i class="fas fa-layer-group text-2xl text-gray-400"></i>
                            </div>
                            <h3 class="text-lg font-semibold text-gray-900 mb-2">No hay servicios en esta categoría</h3>
                            <p class="text-gray-600 mb-4">Agrega servicios o productos para organizarlos en esta categoría</p>
                            @can('create servicios')
                            <a href="{{ route('servicios.create', ['categoria_id' => $categoria->id]) }}" class="btn-primary btn-sm">
                                <i class="fas fa-plus mr-2"></i>
                                Agregar Primer Servicio
                            </a>
                            @endcan
                        </div>
                    @endif
                </div>
            </div>
        </div>
        </div>
    </div>

    @push('styles')
    <style>
        @media print {
            .page-header .flex {
                flex-direction: column;
            }
            .btn-primary, .btn-outline {
                display: none !important;
            }
        }
    </style>
    @endpush
@endsection