@extends('layouts.app')

@section('content')
    <div class="animate-slideInUp">
        <div class="page-header">
            <div class="flex flex-col lg:flex-row lg:items-center lg:justify-between">
                <div>
                    <h1 class="page-title text-gradient">
                        <i class="fas fa-concierge-bell mr-3"></i>
                        Gestión de Servicios y Productos
                    </h1>
                    <p class="page-subtitle">
                        <i class="fas fa-layer-group mr-2"></i>
                        Administra tu catálogo de servicios y productos de decoración
                    </p>
                </div>
                <div class="mt-6 lg:mt-0 flex flex-col sm:flex-row gap-3">
                    <button class="btn-outline btn-sm" onclick="exportServicios()">
                        <i class="fas fa-download mr-2"></i>
                        Exportar Catálogo
                    </button>
                    @can('create servicios')
                    <a href="{{ route('servicios.create') }}" class="btn-primary">
                        <i class="fas fa-plus mr-2"></i>
                        Nuevo Servicio/Producto
                    </a>
                    @endcan
                    @cannot('create servicios')
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
                <div class="stat-icon bg-gradient-to-r from-cyan-500 to-cyan-600">
                    <i class="fas fa-layer-group"></i>
                </div>
                <p class="stat-title">Total Items</p>
                <p class="stat-value">{{ $servicios->total() }}</p>
            </div>
            <div class="stat-card">
                <div class="stat-icon bg-gradient-to-r from-blue-500 to-blue-600">
                    <i class="fas fa-handshake"></i>
                </div>
                <p class="stat-title">Servicios</p>
                <p class="stat-value">{{ $servicios->where('tipo', 'servicio')->count() }}</p>
            </div>
            <div class="stat-card">
                <div class="stat-icon bg-gradient-to-r from-green-500 to-green-600">
                    <i class="fas fa-box"></i>
                </div>
                <p class="stat-title">Productos</p>
                <p class="stat-value">{{ $servicios->where('tipo', 'producto')->count() }}</p>
            </div>
            <div class="stat-card">
                <div class="stat-icon bg-gradient-to-r from-emerald-500 to-emerald-600">
                    <i class="fas fa-check-circle"></i>
                </div>
                <p class="stat-title">Activos</p>
                <p class="stat-value">{{ $servicios->where('activo', true)->count() }}</p>
            </div>
        </div>

        <div class="table-container">
            <div class="table-header">
                <div class="flex items-center space-x-4">
                    <i class="fas fa-table text-gray-600"></i>
                    <div>
                        <h3 class="text-lg font-semibold text-gray-900">Catálogo de Servicios y Productos</h3>
                        <p class="text-sm text-gray-600">Gestiona todos los servicios y productos disponibles</p>
                    </div>
                </div>
                <div class="flex items-center space-x-3">
                    <form method="GET" class="flex items-center space-x-2">
                        <label class="text-sm text-gray-600 font-medium">Mostrar:</label>
                        <select name="per_page" onchange="this.form.submit()" class="form-select py-2 text-sm">
                            <option value="12" {{ request('per_page') == 12 ? 'selected' : '' }}>12</option>
                            <option value="24" {{ request('per_page') == 24 ? 'selected' : '' }}>24</option>
                            <option value="48" {{ request('per_page') == 48 ? 'selected' : '' }}>48</option>
                        </select>
                    </form>
                </div>
            </div>

            <!-- Filtros Avanzados -->
            <div class="bg-gray-50 px-6 py-4 border-b border-gray-200">
                <form method="GET" class="flex flex-wrap items-end gap-4">
                    <div class="flex-1 min-w-0">
                        <label class="block text-sm font-medium text-gray-700 mb-1">Buscar</label>
                        <input type="text" name="search" value="{{ request('search') }}"
                               placeholder="Buscar por nombre o descripción..."
                               class="form-input w-full">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Categoría</label>
                        <select name="categoria_id" class="form-select">
                            <option value="">Todas las categorías</option>
                            @foreach($categorias as $categoria)
                                <option value="{{ $categoria->id }}" {{ request('categoria_id') == $categoria->id ? 'selected' : '' }}>
                                    {{ $categoria->nombre }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Tipo</label>
                        <select name="tipo" class="form-select">
                            <option value="">Todos</option>
                            <option value="servicio" {{ request('tipo') === 'servicio' ? 'selected' : '' }}>Servicios</option>
                            <option value="producto" {{ request('tipo') === 'producto' ? 'selected' : '' }}>Productos</option>
                        </select>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Estado</label>
                        <select name="activo" class="form-select">
                            <option value="">Todos</option>
                            <option value="1" {{ request('activo') === '1' ? 'selected' : '' }}>Activos</option>
                            <option value="0" {{ request('activo') === '0' ? 'selected' : '' }}>Inactivos</option>
                        </select>
                    </div>
                    <div class="flex gap-2">
                        <button type="submit" class="btn-primary btn-sm">
                            <i class="fas fa-search mr-2"></i>
                            Filtrar
                        </button>
                        <a href="{{ route('servicios.index') }}" class="btn-outline btn-sm">
                            <i class="fas fa-times mr-2"></i>
                            Limpiar
                        </a>
                    </div>
                </form>
            </div>

            <!-- Vista de Tarjetas (Grid) -->
            @if($servicios->count() > 0)
                <div class="p-6">
                    <div class="grid grid-cols-1 md:grid-cols-3 lg:grid-cols-5 gap-4">
                        @foreach($servicios as $servicio)
                            <div class="bg-white rounded-lg border border-gray-200 shadow-sm hover:shadow-md transition-shadow duration-200 overflow-hidden">
                                <!-- Imagen del servicio/producto -->
                                <div class="relative">
                                    @if($servicio->imagen)
                                        <div class="h-48 bg-gray-100 overflow-hidden">
                                            <img src="{{ asset('storage/' . $servicio->imagen) }}"
                                                 alt="{{ $servicio->nombre }}"
                                                 class="w-full h-full object-cover">
                                        </div>
                                    @else
                                        <div class="h-48 bg-gradient-to-br from-cyan-500 to-blue-600 flex items-center justify-center">
                                            <i class="fas fa-{{ $servicio->tipo == 'servicio' ? 'handshake' : 'box' }} text-white text-4xl"></i>
                                        </div>
                                    @endif

                                    <!-- Badge de tipo -->
                                    <div class="absolute top-3 left-3">
                                        <span class="inline-flex items-center px-2.5 py-1.5 rounded-lg text-xs font-medium shadow-lg
                                                   {{ $servicio->tipo == 'servicio' ? 'bg-blue-600 text-white' : 'bg-green-600 text-white' }}">
                                            <i class="fas fa-{{ $servicio->tipo == 'servicio' ? 'handshake' : 'box' }} mr-1.5"></i>
                                            {{ ucfirst($servicio->tipo) }}
                                        </span>
                                    </div>

                                    <!-- Badge de estado -->
                                    @if(!$servicio->activo)
                                        <div class="absolute top-3 right-3">
                                            <span class="badge badge-danger badge-sm">Inactivo</span>
                                        </div>
                                    @endif
                                </div>

                                <!-- Contenido de la tarjeta -->
                                <div class="p-4">
                                    <div class="mb-3">
                                        <h3 class="font-semibold text-gray-900 text-lg mb-1">{{ $servicio->nombre }}</h3>
                                        <p class="text-sm text-gray-600">
                                            <i class="fas fa-tag mr-1"></i>
                                            {{ $servicio->categoria->nombre }}
                                        </p>
                                    </div>

                                    @if($servicio->descripcion)
                                        <p class="text-gray-700 text-sm mb-3 line-clamp-2">{{ $servicio->descripcion }}</p>
                                    @endif

                                    <!-- Precio -->
                                    <div class="flex items-center justify-between mb-4">
                                        <div>
                                            <span class="text-2xl font-bold text-green-600">Q{{ number_format($servicio->precio, 2) }}</span>
                                            <span class="text-sm text-gray-600">/ {{ $servicio->unidad_medida }}</span>
                                        </div>
                                        @if($servicio->tiempo_estimado)
                                            <div class="text-right">
                                                <span class="text-xs text-gray-600">Tiempo est.</span>
                                                <div class="text-sm font-medium text-gray-900">
                                                    <i class="fas fa-clock mr-1"></i>
                                                    {{ $servicio->tiempo_estimado }} min
                                                </div>
                                            </div>
                                        @endif
                                    </div>

                                    <!-- Acciones -->
                                    <div class="flex items-center space-x-2 pt-3 border-t border-gray-200">
                                        <a href="{{ route('servicios.show', $servicio) }}"
                                           class="flex-1 inline-flex items-center justify-center px-3 py-2 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-md hover:bg-gray-50 transition-colors">
                                            <i class="fas fa-eye mr-2"></i>
                                            Ver
                                        </a>

                                        @can('edit servicios')
                                        <a href="{{ route('servicios.edit', $servicio) }}"
                                           class="flex-1 inline-flex items-center justify-center px-3 py-2 text-sm font-medium text-white bg-orange-600 border border-transparent rounded-md hover:bg-orange-700 transition-colors">
                                            <i class="fas fa-edit mr-2"></i>
                                            Editar
                                        </a>
                                        @endcan

                                        @can('delete servicios')
                                        <form action="{{ route('servicios.destroy', $servicio) }}" method="POST" class="inline" id="form-delete-{{ $servicio->id }}">
                                            @csrf
                                            @method('DELETE')
                                            <button type="button"
                                                    onclick="confirmarEliminacion({{ $servicio->id }}, '{{ $servicio->nombre }}', '{{ $servicio->tipo }}')"
                                                    class="inline-flex items-center justify-center w-10 h-10 text-red-600 hover:text-red-800 hover:bg-red-50 rounded-md transition-colors">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </form>
                                        @endcan
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            @else
                <div class="px-6 py-16 text-center">
                    <div class="flex flex-col items-center">
                        <div class="w-16 h-16 bg-gray-100 rounded-full flex items-center justify-center mb-4">
                            <i class="fas fa-layer-group text-2xl text-gray-400"></i>
                        </div>
                        <h3 class="text-lg font-semibold text-gray-900 mb-2">No hay servicios o productos registrados</h3>
                        <p class="text-gray-600 mb-4">Comienza agregando tu primer servicio o producto al catálogo</p>
                        @can('create servicios')
                        <a href="{{ route('servicios.create') }}" class="btn-primary btn-sm">
                            <i class="fas fa-plus mr-2"></i>
                            Agregar Primer Item
                        </a>
                        @else
                        <div class="text-sm text-gray-500 italic">
                            <i class="fas fa-lock mr-2"></i>
                            No tienes permisos para crear servicios
                        </div>
                        @endcan
                    </div>
                </div>
            @endif
        </div>

        <!-- Pagination -->
        @if($servicios->hasPages())
        <div class="mt-8 flex justify-center">
            <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-4">
                {{ $servicios->appends(request()->query())->links() }}
            </div>
        </div>
        @endif
        </div>
    </div>

    <!-- Modal de confirmación para eliminar -->
    <div id="modal-confirmar-eliminar" class="fixed inset-0 bg-gray-600 bg-opacity-50 hidden z-50">
        <div class="flex items-center justify-center min-h-screen p-4">
            <div class="bg-white rounded-lg shadow-xl max-w-md w-full">
                <div class="px-6 py-4 bg-red-600">
                    <h3 class="text-lg font-semibold text-white flex items-center">
                        <i class="fas fa-exclamation-triangle mr-3"></i>
                        Confirmar Eliminación
                    </h3>
                </div>
                <div class="p-6">
                    <p class="text-gray-700 mb-4">
                        ¿Estás seguro de que deseas eliminar <span id="servicio-tipo">el servicio</span> <strong id="servicio-nombre"></strong>?
                    </p>
                    <p class="text-sm text-gray-500 bg-yellow-50 border border-yellow-200 rounded p-3">
                        <i class="fas fa-info-circle mr-1"></i>
                        Esta acción no se puede deshacer.
                    </p>
                </div>
                <div class="px-6 py-4 bg-gray-50 flex justify-end space-x-3">
                    <button type="button" onclick="cerrarModalEliminar()"
                            class="px-4 py-2 bg-gray-200 text-gray-700 rounded-lg hover:bg-gray-300 transition">
                        Cancelar
                    </button>
                    <button type="button" onclick="confirmarYEliminar()"
                            class="px-4 py-2 bg-red-600 text-white rounded-lg hover:bg-red-700 transition">
                        <i class="fas fa-trash mr-2"></i>
                        Eliminar
                    </button>
                </div>
            </div>
        </div>
    </div>

    @push('scripts')
        <script>
            let servicioIdParaEliminar = null;

            function confirmarEliminacion(id, nombre, tipo) {
                servicioIdParaEliminar = id;
                document.getElementById('servicio-nombre').textContent = nombre;
                document.getElementById('servicio-tipo').textContent = tipo === 'servicio' ? 'el servicio' : 'el producto';
                document.getElementById('modal-confirmar-eliminar').classList.remove('hidden');
            }

            function cerrarModalEliminar() {
                servicioIdParaEliminar = null;
                document.getElementById('modal-confirmar-eliminar').classList.add('hidden');
            }

            function confirmarYEliminar() {
                if (servicioIdParaEliminar) {
                    document.getElementById('form-delete-' + servicioIdParaEliminar).submit();
                }
            }

            function exportServicios() {
                // Crear el contenido CSV
                let csv = 'ID,Nombre,Tipo,Categoría,Precio,Unidad Medida,Tiempo Estimado,Estado,Fecha Creación\n';

                // Obtener todos los servicios de la página actual
                const servicios = @json($servicios->items());

                servicios.forEach(servicio => {
                    const row = [
                        servicio.id,
                        `"${servicio.nombre}"`,
                        servicio.tipo,
                        `"${servicio.categoria?.nombre || 'Sin categoría'}"`,
                        servicio.precio,
                        servicio.unidad_medida,
                        servicio.tiempo_estimado || 'N/A',
                        servicio.activo ? 'Activo' : 'Inactivo',
                        new Date(servicio.created_at).toLocaleDateString('es-GT')
                    ];
                    csv += row.join(',') + '\n';
                });

                // Crear el archivo y descargarlo
                const blob = new Blob([csv], { type: 'text/csv;charset=utf-8;' });
                const link = document.createElement('a');
                const url = URL.createObjectURL(blob);
                const fecha = new Date().toISOString().split('T')[0];

                link.setAttribute('href', url);
                link.setAttribute('download', `catalogo_servicios_${fecha}.csv`);
                link.style.visibility = 'hidden';
                document.body.appendChild(link);
                link.click();
                document.body.removeChild(link);
            }
        </script>
    @endpush
@endsection
