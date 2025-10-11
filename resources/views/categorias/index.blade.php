@extends('layouts.app')

@section('content')
    <div class="animate-slideInUp">
        <div class="page-header">
            <div class="flex flex-col lg:flex-row lg:items-center lg:justify-between">
                <div>
                    <h1 class="page-title text-gradient">
                        <i class="fas fa-tags mr-3"></i>
                        Gestión de Categorías
                    </h1>
                    <p class="page-subtitle">
                        <i class="fas fa-layer-group mr-2"></i>
                        Organiza servicios y productos por categorías
                    </p>
                </div>
                <div class="mt-6 lg:mt-0 flex flex-col sm:flex-row gap-3">
                    <button class="btn-outline btn-sm" onclick="exportCategorias()">
                        <i class="fas fa-download mr-2"></i>
                        Exportar Datos
                    </button>
                    @can('create categorias')
                    <a href="{{ route('categorias.create') }}" class="btn-primary">
                        <i class="fas fa-plus mr-2"></i>
                        Nueva Categoría
                    </a>
                    @endcan
                    @cannot('create categorias')
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
                <div class="stat-icon bg-gradient-to-r from-amber-500 to-amber-600">
                    <i class="fas fa-tags"></i>
                </div>
                <p class="stat-title">Total Categorías</p>
                <p class="stat-value">{{ $categorias->total() }}</p>
            </div>
            <div class="stat-card">
                <div class="stat-icon bg-gradient-to-r from-green-500 to-green-600">
                    <i class="fas fa-check-circle"></i>
                </div>
                <p class="stat-title">Categorías Activas</p>
                <p class="stat-value">{{ $categorias->where('activo', true)->count() }}</p>
            </div>
            <div class="stat-card">
                <div class="stat-icon bg-gradient-to-r from-blue-500 to-blue-600">
                    <i class="fas fa-layer-group"></i>
                </div>
                <p class="stat-title">Con Servicios</p>
                <p class="stat-value">{{ $categorias->where('servicios_count', '>', 0)->count() }}</p>
            </div>
            <div class="stat-card">
                <div class="stat-icon bg-gradient-to-r from-purple-500 to-purple-600">
                    <i class="fas fa-image"></i>
                </div>
                <p class="stat-title">Con Imagen</p>
                <p class="stat-value">{{ $categorias->whereNotNull('imagen')->count() }}</p>
            </div>
        </div>

        <div class="table-container">
            <div class="table-header">
                <div class="flex items-center space-x-4">
                    <i class="fas fa-table text-gray-600"></i>
                    <div>
                        <h3 class="text-lg font-semibold text-gray-900">Listado de Categorías</h3>
                        <p class="text-sm text-gray-600">Gestiona todas las categorías de servicios y productos</p>
                    </div>
                </div>
                <div class="flex items-center space-x-3">
                    <form method="GET" class="flex items-center space-x-2">
                        @if(request('search'))
                            <input type="hidden" name="search" value="{{ request('search') }}">
                        @endif
                        @if(request('activo') !== null)
                            <input type="hidden" name="activo" value="{{ request('activo') }}">
                        @endif
                        <label class="text-sm text-gray-600 font-medium">Mostrar:</label>
                        <select name="per_page" onchange="this.form.submit()" class="form-select py-2 text-sm">
                            <option value="5" {{ request('per_page', 5) == 5 ? 'selected' : '' }}>5</option>
                            <option value="10" {{ request('per_page', 5) == 10 ? 'selected' : '' }}>10</option>
                            <option value="15" {{ request('per_page', 5) == 15 ? 'selected' : '' }}>15</option>
                            <option value="20" {{ request('per_page', 5) == 20 ? 'selected' : '' }}>20</option>
                            <option value="50" {{ request('per_page', 5) == 50 ? 'selected' : '' }}>50</option>
                            <option value="100" {{ request('per_page', 5) == 100 ? 'selected' : '' }}>100</option>
                        </select>
                    </form>
                </div>
            </div>

            <!-- Filtros -->
            <div class="bg-gray-50 px-6 py-4 border-b border-gray-200">
                <form method="GET" class="flex flex-wrap items-end gap-4">
                    <div class="flex-1 min-w-0">
                        <label class="block text-sm font-medium text-gray-700 mb-1">Buscar</label>
                        <input type="text" name="search" value="{{ request('search') }}" 
                               placeholder="Buscar por nombre o descripción..." 
                               class="form-input w-full">
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
                        <a href="{{ route('categorias.index') }}" class="btn-outline btn-sm">
                            <i class="fas fa-times mr-2"></i>
                            Limpiar
                        </a>
                    </div>
                </form>
            </div>

            <div class="overflow-x-auto">
                <table id="tablaCategorias" class="custom-table">
                    <thead>
                        <tr>
                            <th>
                                <i class="fas fa-tag mr-2"></i>
                                Categoría
                            </th>
                            <th>
                                <i class="fas fa-align-left mr-2"></i>
                                Descripción
                            </th>
                            <th>
                                <i class="fas fa-layer-group mr-2"></i>
                                Servicios
                            </th>
                            <th>
                                <i class="fas fa-toggle-on mr-2"></i>
                                Estado
                            </th>
                            <th>
                                <i class="fas fa-cogs mr-2"></i>
                                Acciones
                            </th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($categorias as $categoria)
                            <tr>
                                <td>
                                    <div class="flex items-center">
                                        @if($categoria->imagen)
                                            <div class="w-32 h-32 bg-gray-100 rounded-lg overflow-hidden shadow-md mr-4">
                                                <img src="{{ asset('storage/' . $categoria->imagen) }}"
                                                     alt="{{ $categoria->nombre }}"
                                                     class="w-full h-full object-cover">
                                            </div>
                                        @else
                                            <div class="w-32 h-32 bg-gradient-to-r from-amber-500 to-amber-600 rounded-lg flex items-center justify-center shadow-md mr-4">
                                                <span class="text-white font-bold text-2xl">
                                                    {{ strtoupper(substr($categoria->nombre, 0, 2)) }}
                                                </span>
                                            </div>
                                        @endif
                                        <div>
                                            <div class="font-semibold text-gray-900">
                                                {{ $categoria->nombre }}
                                            </div>
                                            <div class="text-sm text-gray-600">ID: #{{ $categoria->id }}</div>
                                        </div>
                                    </div>
                                </td>
                                <td>
                                    <div class="max-w-xs">
                                        @if($categoria->descripcion)
                                            <p class="text-sm text-gray-900 line-clamp-2">{{ $categoria->descripcion }}</p>
                                        @else
                                            <span class="text-gray-400 text-sm italic">Sin descripción</span>
                                        @endif
                                    </div>
                                </td>
                                <td>
                                    <div class="flex items-center">
                                        <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-medium bg-blue-100 text-blue-800">
                                            <i class="fas fa-layer-group mr-1"></i>
                                            {{ $categoria->servicios_count ?? 0 }} servicios
                                        </span>
                                    </div>
                                </td>
                                <td>
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
                                </td>
                                <td>
                                    <div class="flex items-center space-x-2">
                                        <!-- Ver siempre disponible -->
                                        <a href="{{ route('categorias.show', $categoria) }}"
                                           class="inline-flex items-center justify-center w-8 h-8 text-gray-500 hover:text-blue-600 hover:bg-blue-50 rounded-lg transition-all duration-200"
                                           title="Ver detalles">
                                            <i class="fas fa-eye text-sm"></i>
                                        </a>

                                        @can('edit categorias')
                                        <a href="{{ route('categorias.edit', $categoria) }}"
                                           class="inline-flex items-center justify-center w-8 h-8 text-gray-500 hover:text-orange-600 hover:bg-orange-50 rounded-lg transition-all duration-200"
                                           title="Editar">
                                            <i class="fas fa-edit text-sm"></i>
                                        </a>
                                        @endcan

                                        @can('delete categorias')
                                        <form action="{{ route('categorias.destroy', $categoria) }}" method="POST" class="inline" id="form-delete-{{ $categoria->id }}">
                                            @csrf
                                            @method('DELETE')
                                            <button type="button" onclick="confirmarEliminacion({{ $categoria->id }}, '{{ $categoria->nombre }}')"
                                                    class="inline-flex items-center justify-center w-8 h-8 text-gray-500 hover:text-red-600 hover:bg-red-50 rounded-lg transition-all duration-200"
                                                    title="Eliminar">
                                                <i class="fas fa-trash text-sm"></i>
                                            </button>
                                        </form>
                                        @endcan

                                        @if(!auth()->user()->can('edit categorias') && !auth()->user()->can('delete categorias'))
                                        <span class="inline-flex items-center justify-center w-8 h-8 text-gray-400 bg-gray-50 rounded-lg"
                                              title="Solo lectura">
                                            <i class="fas fa-lock text-xs"></i>
                                        </span>
                                        @endif
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="px-6 py-16 text-center">
                                    <div class="flex flex-col items-center">
                                        <div class="w-16 h-16 bg-gray-100 rounded-full flex items-center justify-center mb-4">
                                            <i class="fas fa-tags text-2xl text-gray-400"></i>
                                        </div>
                                        <h3 class="text-lg font-semibold text-gray-900 mb-2">No hay categorías registradas</h3>
                                        <p class="text-gray-600 mb-4">Comienza agregando la primera categoría para organizar tus servicios</p>
                                        @can('create categorias')
                                        <a href="{{ route('categorias.create') }}" class="btn-primary btn-sm">
                                            <i class="fas fa-plus mr-2"></i>
                                            Crear Categoría
                                        </a>
                                        @else
                                        <div class="text-sm text-gray-500 italic">
                                            <i class="fas fa-lock mr-2"></i>
                                            No tienes permisos para crear categorías
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
        @if($categorias->hasPages())
        <div class="mt-8 flex justify-center">
            <div class="bg-white rounded-lg shadow-sm border border-gray-200 px-6 py-4 w-full max-w-4xl">
                <div class="flex flex-col sm:flex-row items-center justify-between gap-4">
                    <div class="text-sm text-gray-700 order-2 sm:order-1">
                        Mostrando
                        <span class="font-medium">{{ $categorias->firstItem() ?? 0 }}</span>
                        a
                        <span class="font-medium">{{ $categorias->lastItem() ?? 0 }}</span>
                        de
                        <span class="font-medium">{{ $categorias->total() }}</span>
                        resultados
                    </div>
                    <div class="order-1 sm:order-2">
                        {{ $categorias->appends(request()->query())->links() }}
                    </div>
                </div>
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
                        ¿Estás seguro de que deseas eliminar la categoría <strong id="categoria-nombre"></strong>?
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
            let categoriaIdParaEliminar = null;

            function confirmarEliminacion(id, nombre) {
                categoriaIdParaEliminar = id;
                document.getElementById('categoria-nombre').textContent = nombre;
                document.getElementById('modal-confirmar-eliminar').classList.remove('hidden');
            }

            function cerrarModalEliminar() {
                categoriaIdParaEliminar = null;
                document.getElementById('modal-confirmar-eliminar').classList.add('hidden');
            }

            function confirmarYEliminar() {
                if (categoriaIdParaEliminar) {
                    document.getElementById('form-delete-' + categoriaIdParaEliminar).submit();
                }
            }

            $(document).ready(function() {
                // Verificar si la tabla tiene datos antes de inicializar DataTables
                var hasData = $('#tablaCategorias tbody tr').length > 0 &&
                             !$('#tablaCategorias tbody tr:first td[colspan]').length;

                if (hasData) {
                    $('#tablaCategorias').DataTable({
                        paging: false,
                        lengthChange: false,
                        info: false,
                        searching: false, // Usamos filtros personalizados
                        dom: '<"flex flex-col lg:flex-row lg:justify-between lg:items-center mb-4"<"mb-4 lg:mb-0"B><"flex-1 lg:max-w-xs">>rt<"clear">',
                        buttons: [
                            {
                                extend: 'copy',
                                text: '<i class="fas fa-copy mr-1"></i> Copiar',
                                className: 'dt-button buttons-copy'
                            },
                            {
                                extend: 'excel',
                                text: '<i class="fas fa-file-excel mr-1"></i> Excel',
                                className: 'dt-button buttons-excel'
                            },
                            {
                                extend: 'pdf',
                                text: '<i class="fas fa-file-pdf mr-1"></i> PDF',
                                className: 'dt-button buttons-pdf'
                            }
                        ],
                        language: {
                            emptyTable: "No hay categorías disponibles",
                            zeroRecords: "No se encontraron categorías",
                            buttons: {
                                copy: "Copiar",
                                copyTitle: "Copiado al portapapeles",
                                copySuccess: {
                                    _: "%d filas copiadas",
                                    1: "1 fila copiada"
                                },
                                excel: "Excel",
                                pdf: "PDF"
                            }
                        },
                        columnDefs: [
                            { orderable: false, targets: [4] } // Deshabilitar orden en columna de acciones
                        ],
                        responsive: true
                    });
                }
            });

            function exportCategorias() {
                $('.buttons-excel').click();
            }
        </script>
    @endpush
@endsection