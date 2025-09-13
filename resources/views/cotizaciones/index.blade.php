@extends('layouts.app')

@section('content')
    <div class="animate-slideInUp">
        <div class="page-header">
            <div class="flex flex-col lg:flex-row lg:items-center lg:justify-between">
                <div>
                    <h1 class="page-title text-gradient">
                        <i class="fas fa-file-invoice-dollar mr-3"></i>
                        Gestión de Cotizaciones
                    </h1>
                    <p class="page-subtitle">
                        <i class="fas fa-calculator mr-2"></i>
                        Administra y controla todas las cotizaciones de servicios
                    </p>
                </div>
                <div class="mt-6 lg:mt-0 flex flex-col sm:flex-row gap-3">
                    <button class="btn-outline btn-sm" onclick="exportCotizaciones()">
                        <i class="fas fa-download mr-2"></i>
                        Exportar Datos
                    </button>
                    @can('create cotizaciones')
                    <a href="{{ route('cotizaciones.create') }}" class="btn-primary">
                        <i class="fas fa-plus mr-2"></i>
                        Nueva Cotización
                    </a>
                    @endcan
                    @cannot('create cotizaciones')
                    <div class="text-sm text-gray-500 italic bg-gray-50 px-3 py-2 rounded-lg border">
                        <i class="fas fa-lock mr-2"></i>
                        Solo tienes permisos de lectura
                    </div>
                    @endcannot
                </div>
            </div>
        </div>

        @if(session('success'))
            <div class="alert alert-success mb-6">
                <i class="fas fa-check-circle text-xl"></i>
                <div>
                    <h4 class="font-semibold">¡Éxito!</h4>
                    <p>{{ session('success') }}</p>
                </div>
            </div>
        @endif

        @if(session('error'))
            <div class="alert alert-error mb-6">
                <i class="fas fa-exclamation-triangle text-xl"></i>
                <div>
                    <h4 class="font-semibold">Error</h4>
                    <p>{{ session('error') }}</p>
                </div>
            </div>
        @endif

        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-8">
            <div class="stat-card">
                <div class="stat-icon bg-gradient-to-r from-orange-500 to-orange-600">
                    <i class="fas fa-file-invoice"></i>
                </div>
                <p class="stat-title">Total Cotizaciones</p>
                <p class="stat-value">{{ $cotizaciones->total() }}</p>
            </div>
            <div class="stat-card">
                <div class="stat-icon bg-gradient-to-r from-blue-500 to-blue-600">
                    <i class="fas fa-clock"></i>
                </div>
                <p class="stat-title">Borradores</p>
                <p class="stat-value">{{ $cotizaciones->where('estado', 'borrador')->count() }}</p>
            </div>
            <div class="stat-card">
                <div class="stat-icon bg-gradient-to-r from-green-500 to-green-600">
                    <i class="fas fa-check-circle"></i>
                </div>
                <p class="stat-title">Aprobadas</p>
                <p class="stat-value">{{ $cotizaciones->where('estado', 'aprobada')->count() }}</p>
            </div>
            <div class="stat-card">
                <div class="stat-icon bg-gradient-to-r from-purple-500 to-purple-600">
                    <i class="fas fa-dollar-sign"></i>
                </div>
                <p class="stat-title">Valor Total</p>
                <p class="stat-value">Q{{ number_format($cotizaciones->sum('total'), 0) }}</p>
            </div>
        </div>

        <div class="table-container">
            <div class="table-header">
                <div class="flex items-center space-x-4">
                    <i class="fas fa-table text-gray-600"></i>
                    <div>
                        <h3 class="text-lg font-semibold text-gray-900">Listado de Cotizaciones</h3>
                        <p class="text-sm text-gray-600">Gestiona todas las cotizaciones del sistema</p>
                    </div>
                </div>
            </div>

            <!-- Filtros -->
            <div class="bg-gray-50 px-6 py-4 border-b border-gray-200">
                <form method="GET" class="flex flex-wrap items-end gap-4">
                    <div class="flex-1 min-w-0">
                        <label class="block text-sm font-medium text-gray-700 mb-1">Buscar</label>
                        <input type="text" name="search" value="{{ request('search') }}" 
                               placeholder="Buscar por número o cliente..." 
                               class="form-input w-full">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Estado</label>
                        <select name="estado" class="form-select">
                            <option value="">Todos los estados</option>
                            <option value="borrador" {{ request('estado') === 'borrador' ? 'selected' : '' }}>Borrador</option>
                            <option value="enviada" {{ request('estado') === 'enviada' ? 'selected' : '' }}>Enviada</option>
                            <option value="aprobada" {{ request('estado') === 'aprobada' ? 'selected' : '' }}>Aprobada</option>
                            <option value="rechazada" {{ request('estado') === 'rechazada' ? 'selected' : '' }}>Rechazada</option>
                        </select>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Desde</label>
                        <input type="date" name="fecha_desde" value="{{ request('fecha_desde') }}" class="form-input">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Hasta</label>
                        <input type="date" name="fecha_hasta" value="{{ request('fecha_hasta') }}" class="form-input">
                    </div>
                    <div class="flex gap-2">
                        <button type="submit" class="btn-primary btn-sm">
                            <i class="fas fa-search mr-2"></i>
                            Filtrar
                        </button>
                        <a href="{{ route('cotizaciones.index') }}" class="btn-outline btn-sm">
                            <i class="fas fa-times mr-2"></i>
                            Limpiar
                        </a>
                    </div>
                </form>
            </div>

            <div class="overflow-x-auto">
                <table class="custom-table">
                    <thead>
                        <tr>
                            <th>
                                <i class="fas fa-hashtag mr-2"></i>
                                Número
                            </th>
                            <th>
                                <i class="fas fa-user mr-2"></i>
                                Cliente
                            </th>
                            <th>
                                <i class="fas fa-calendar mr-2"></i>
                                Fecha
                            </th>
                            <th>
                                <i class="fas fa-dollar-sign mr-2"></i>
                                Total
                            </th>
                            <th>
                                <i class="fas fa-info-circle mr-2"></i>
                                Estado
                            </th>
                            <th>
                                <i class="fas fa-clock mr-2"></i>
                                Vigencia
                            </th>
                            <th>
                                <i class="fas fa-cogs mr-2"></i>
                                Acciones
                            </th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($cotizaciones as $cotizacion)
                            <tr>
                                <td>
                                    <div class="font-semibold text-gray-900">{{ $cotizacion->numero_cotizacion }}</div>
                                    <div class="text-sm text-gray-600">ID: #{{ $cotizacion->id }}</div>
                                </td>
                                <td>
                                    <div class="flex items-center">
                                        <div class="w-10 h-10 bg-gradient-to-r from-green-500 to-green-600 rounded-full flex items-center justify-center mr-3">
                                            <span class="text-white font-bold text-sm">
                                                {{ strtoupper(substr($cotizacion->client->name ?? 'C', 0, 2)) }}
                                            </span>
                                        </div>
                                        <div>
                                            <div class="font-medium text-gray-900">{{ $cotizacion->client->name ?? 'Cliente' }}</div>
                                            <div class="text-sm text-gray-600">{{ $cotizacion->client->email ?? '' }}</div>
                                        </div>
                                    </div>
                                </td>
                                <td>
                                    <div class="text-gray-900">{{ $cotizacion->created_at->format('d/m/Y') }}</div>
                                    <div class="text-sm text-gray-600">{{ $cotizacion->created_at->format('H:i') }}</div>
                                </td>
                                <td>
                                    <div class="text-xl font-bold text-green-600">Q{{ number_format($cotizacion->total, 2) }}</div>
                                    @if($cotizacion->detalles_count ?? 0 > 0)
                                        <div class="text-sm text-gray-600">{{ $cotizacion->detalles_count ?? 0 }} items</div>
                                    @endif
                                </td>
                                <td>
                                    <span class="badge badge-{{ $cotizacion->estado_color }}">
                                        <i class="fas fa-{{ $cotizacion->estado == 'borrador' ? 'clock' : ($cotizacion->estado == 'aprobada' ? 'check' : ($cotizacion->estado == 'rechazada' ? 'times' : 'paper-plane')) }} mr-1"></i>
                                        {{ ucfirst($cotizacion->estado) }}
                                    </span>
                                </td>
                                <td>
                                    <div class="text-gray-900">{{ $cotizacion->fecha_vigencia->format('d/m/Y') }}</div>
                                    @if($cotizacion->isVencida())
                                        <span class="text-red-600 text-sm font-medium">
                                            <i class="fas fa-exclamation-triangle mr-1"></i>
                                            Vencida
                                        </span>
                                    @else
                                        <div class="text-sm text-gray-600">
                                            {{ $cotizacion->fecha_vigencia->diffInDays(now()) }} días restantes
                                        </div>
                                    @endif
                                </td>
                                <td>
                                    <div class="flex items-center space-x-2">
                                        <!-- Ver siempre disponible -->
                                        <a href="{{ route('cotizaciones.show', $cotizacion) }}"
                                           class="inline-flex items-center justify-center w-8 h-8 text-gray-500 hover:text-blue-600 hover:bg-blue-50 rounded-lg transition-all duration-200"
                                           title="Ver cotización">
                                            <i class="fas fa-eye text-sm"></i>
                                        </a>

                                        @can('generate pdf cotizaciones')
                                        <a href="{{ route('cotizaciones.pdf', $cotizacion) }}"
                                           class="inline-flex items-center justify-center w-8 h-8 text-gray-500 hover:text-red-600 hover:bg-red-50 rounded-lg transition-all duration-200"
                                           title="Descargar PDF" target="_blank">
                                            <i class="fas fa-file-pdf text-sm"></i>
                                        </a>
                                        @endcan

                                        @can('edit cotizaciones')
                                        @if($cotizacion->estado == 'borrador')
                                        <a href="{{ route('cotizaciones.edit', $cotizacion) }}"
                                           class="inline-flex items-center justify-center w-8 h-8 text-gray-500 hover:text-orange-600 hover:bg-orange-50 rounded-lg transition-all duration-200"
                                           title="Editar">
                                            <i class="fas fa-edit text-sm"></i>
                                        </a>
                                        @endif
                                        @endcan

                                        @can('delete cotizaciones')
                                        @if($cotizacion->estado == 'borrador')
                                        <form action="{{ route('cotizaciones.destroy', $cotizacion) }}" method="POST" class="inline"
                                              onsubmit="return confirm('¿Estás seguro de eliminar esta cotización?');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit"
                                                    class="inline-flex items-center justify-center w-8 h-8 text-gray-500 hover:text-red-600 hover:bg-red-50 rounded-lg transition-all duration-200"
                                                    title="Eliminar">
                                                <i class="fas fa-trash text-sm"></i>
                                            </button>
                                        </form>
                                        @endif
                                        @endcan
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="px-6 py-16 text-center">
                                    <div class="flex flex-col items-center">
                                        <div class="w-16 h-16 bg-gray-100 rounded-full flex items-center justify-center mb-4">
                                            <i class="fas fa-file-invoice-dollar text-2xl text-gray-400"></i>
                                        </div>
                                        <h3 class="text-lg font-semibold text-gray-900 mb-2">No hay cotizaciones registradas</h3>
                                        <p class="text-gray-600 mb-4">Comienza creando la primera cotización para tus clientes</p>
                                        @can('create cotizaciones')
                                        <a href="{{ route('cotizaciones.create') }}" class="btn-primary btn-sm">
                                            <i class="fas fa-plus mr-2"></i>
                                            Crear Primera Cotización
                                        </a>
                                        @else
                                        <div class="text-sm text-gray-500 italic">
                                            <i class="fas fa-lock mr-2"></i>
                                            No tienes permisos para crear cotizaciones
                                        </div>
                                        @endcan
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Pagination -->
        @if($cotizaciones->hasPages())
        <div class="mt-8 flex justify-center">
            <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-4">
                {{ $cotizaciones->appends(request()->query())->links() }}
            </div>
        </div>
        @endif
        </div>
    </div>

    @push('scripts')
        <script>
            function exportCotizaciones() {
                alert('Función de exportación en desarrollo');
            }
        </script>
    @endpush
@endsection