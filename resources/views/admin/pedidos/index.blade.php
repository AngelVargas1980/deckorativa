@extends('layouts.app')

@section('content')
    <div class="animate-slideInUp">
        <div class="page-header">
            <div class="flex flex-col lg:flex-row lg:items-center lg:justify-between">
                <div>
                    <h1 class="page-title text-gradient">
                        <i class="fas fa-shopping-cart mr-3"></i>
                        Gestión de Pedidos
                    </h1>
                    <p class="page-subtitle">
                        <i class="fas fa-box mr-2"></i>
                        Administra y controla todos los pedidos del sistema
                    </p>
                </div>
                <div class="mt-6 lg:mt-0 flex flex-col sm:flex-row gap-3">
                    <button class="btn-outline btn-sm" onclick="exportPedidos()">
                        <i class="fas fa-download mr-2"></i>
                        Exportar Datos
                    </button>
                    @can('create pedidos')
                    <a href="{{ route('pedidos.create') }}" class="btn-primary">
                        <i class="fas fa-plus mr-2"></i>
                        Nuevo Pedido
                    </a>
                    @endcan
                    @cannot('create pedidos')
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
                    <div class="stat-icon bg-gradient-to-r from-blue-500 to-blue-600">
                        <i class="fas fa-shopping-cart"></i>
                    </div>
                    <p class="stat-title">Total Pedidos</p>
                    <p class="stat-value">{{ $pedidos->total() }}</p>
                </div>
                <div class="stat-card">
                    <div class="stat-icon bg-gradient-to-r from-yellow-500 to-yellow-600">
                        <i class="fas fa-clock"></i>
                    </div>
                    <p class="stat-title">Pendientes</p>
                    <p class="stat-value">{{ $pedidos->where('estado', 'pendiente')->count() }}</p>
                </div>
                <div class="stat-card">
                    <div class="stat-icon bg-gradient-to-r from-orange-500 to-orange-600">
                        <i class="fas fa-cog"></i>
                    </div>
                    <p class="stat-title">En Proceso</p>
                    <p class="stat-value">{{ $pedidos->where('estado', 'en_proceso')->count() }}</p>
                </div>
                <div class="stat-card">
                    <div class="stat-icon bg-gradient-to-r from-green-500 to-green-600">
                        <i class="fas fa-check-circle"></i>
                    </div>
                    <p class="stat-title">Completados</p>
                    <p class="stat-value">{{ $pedidos->where('estado', 'completado')->count() }}</p>
                </div>
            </div>

            <div class="table-container">
                <div class="table-header">
                    <div class="flex items-center space-x-4">
                        <i class="fas fa-table text-gray-600"></i>
                        <div>
                            <h3 class="text-lg font-semibold text-gray-900">Listado de Pedidos</h3>
                            <p class="text-sm text-gray-600">Gestiona todos los pedidos del sistema</p>
                        </div>
                    </div>
                </div>

                <!-- Filtros -->
                <div class="bg-white border-b border-gray-200 shadow-sm">
                    <div class="px-6 py-4">
                        <form method="GET" id="filterForm" class="space-y-4">
                            <!-- Fila principal de filtros -->
                            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4">
                                <!-- Búsqueda -->
                                <div class="lg:col-span-2">
                                    <label for="search" class="block text-sm font-medium text-gray-700 mb-2">
                                        <i class="fas fa-search text-gray-400 mr-1"></i>
                                        Buscar
                                    </label>
                                    <div class="relative">
                                        <input type="text" 
                                               id="search"
                                               name="search" 
                                               value="{{ request('search') }}"
                                               placeholder="Número de pedido, cliente, correo..."
                                               class="form-input w-full pl-10 pr-10 rounded-lg border-gray-300 focus:border-blue-500 focus:ring focus:ring-blue-200 transition">
                                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                            <i class="fas fa-search text-gray-400"></i>
                                        </div>
                                        @if(request('search'))
                                            <button type="button" 
                                                    onclick="document.getElementById('search').value=''; document.getElementById('filterForm').submit();"
                                                    class="absolute inset-y-0 right-0 pr-3 flex items-center text-gray-400 hover:text-gray-600">
                                                <i class="fas fa-times"></i>
                                            </button>
                                        @endif
                                    </div>
                                </div>
                
                                <!-- Estado -->
                                <div>
                                    <label for="estado" class="block text-sm font-medium text-gray-700 mb-2">
                                        <i class="fas fa-flag text-gray-400 mr-1"></i>
                                        Estado
                                    </label>
                                    <select name="estado" 
                                            id="estado"
                                            class="form-select w-full rounded-lg border-gray-300 focus:border-blue-500 focus:ring focus:ring-blue-200 transition">
                                        <option value="">Todos los estados</option>
                                        <option value="pendiente" {{ request('estado') === 'pendiente' ? 'selected' : '' }}>
                                            Pendiente
                                        </option>
                                        <option value="en_proceso" {{ request('estado') === 'en_proceso' ? 'selected' : '' }}>
                                            En Proceso
                                        </option>
                                        <option value="completado" {{ request('estado') === 'completado' ? 'selected' : '' }}>
                                            Completado
                                        </option>
                                        <option value="cancelado" {{ request('estado') === 'cancelado' ? 'selected' : '' }}>
                                            Cancelado
                                        </option>
                                    </select>
                                </div>
                
                                <!-- Fecha (nuevo filtro opcional) -->
                                <div>
                                    <label for="fecha" class="block text-sm font-medium text-gray-700 mb-2">
                                        <i class="fas fa-calendar text-gray-400 mr-1"></i>
                                        Fecha
                                    </label>
                                    <select name="fecha" 
                                            id="fecha"
                                            class="form-select w-full rounded-lg border-gray-300 focus:border-blue-500 focus:ring focus:ring-blue-200 transition">
                                        <option value="">Todas las fechas</option>
                                        <option value="hoy" {{ request('fecha') === 'hoy' ? 'selected' : '' }}>Hoy</option>
                                        <option value="semana" {{ request('fecha') === 'semana' ? 'selected' : '' }}>Esta semana</option>
                                        <option value="mes" {{ request('fecha') === 'mes' ? 'selected' : '' }}>Este mes</option>
                                        <option value="personalizado" {{ request('fecha') === 'personalizado' ? 'selected' : '' }}>Personalizado</option>
                                    </select>
                                </div>
                            </div>
                
                            <!-- Botones de acción -->
                            <div class="flex flex-wrap items-center justify-between gap-3 pt-2">
                                <div class="flex flex-wrap gap-2">
                                    <button type="submit" 
                                            class="inline-flex items-center px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white font-medium rounded-lg shadow-sm transition duration-150 ease-in-out focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                                        <i class="fas fa-filter mr-2"></i>
                                        Aplicar Filtros
                                    </button>
                                    
                                    @if(request()->hasAny(['search', 'estado', 'fecha']))
                                        <a href="{{ route('pedidos.index') }}" 
                                           class="inline-flex items-center px-4 py-2 bg-white hover:bg-gray-50 text-gray-700 font-medium rounded-lg border border-gray-300 shadow-sm transition duration-150 ease-in-out focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-500">
                                            <i class="fas fa-times mr-2"></i>
                                            Limpiar Filtros
                                        </a>
                                    @endif
                                </div>
                
                                <!-- Contador de resultados -->
                                @if(isset($pedidos))
                                    <div class="text-sm text-gray-600">
                                        <i class="fas fa-list mr-1"></i>
                                        <span class="font-medium">{{ $pedidos->total() }}</span> pedido(s) encontrado(s)
                                    </div>
                                @endif
                            </div>
                
                            <!-- Filtros activos (chips) -->
                            @if(request()->hasAny(['search', 'estado', 'fecha']))
                                <div class="flex flex-wrap gap-2 pt-2 border-t border-gray-200">
                                    <span class="text-xs font-medium text-gray-600">Filtros activos:</span>
                                    
                                    @if(request('search'))
                                        <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium bg-blue-100 text-blue-800">
                                            <i class="fas fa-search mr-1"></i>
                                            "{{ request('search') }}"
                                            <button type="button" 
                                                    onclick="document.getElementById('search').value=''; document.getElementById('filterForm').submit();"
                                                    class="ml-1.5 hover:text-blue-900">
                                                <i class="fas fa-times"></i>
                                            </button>
                                        </span>
                                    @endif
                
                                    @if(request('estado'))
                                        <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium bg-purple-100 text-purple-800">
                                            <i class="fas fa-flag mr-1"></i>
                                            Estado: {{ ucfirst(str_replace('_', ' ', request('estado'))) }}
                                            <button type="button" 
                                                    onclick="document.getElementById('estado').value=''; document.getElementById('filterForm').submit();"
                                                    class="ml-1.5 hover:text-purple-900">
                                                <i class="fas fa-times"></i>
                                            </button>
                                        </span>
                                    @endif
                
                                    @if(request('fecha'))
                                        <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                            <i class="fas fa-calendar mr-1"></i>
                                            Fecha: {{ ucfirst(request('fecha')) }}
                                            <button type="button" 
                                                    onclick="document.getElementById('fecha').value=''; document.getElementById('filterForm').submit();"
                                                    class="ml-1.5 hover:text-green-900">
                                                <i class="fas fa-times"></i>
                                            </button>
                                        </span>
                                    @endif
                                </div>
                            @endif
                        </form>
                    </div>
                </div>

                <div class="overflow-x-auto">
                    <table id="tablaPedidos" class="custom-table">
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
                                    <i class="fas fa-truck mr-2"></i>
                                    Entrega
                                </th>
                                <th>
                                    <i class="fas fa-cogs mr-2"></i>
                                    Acciones
                                </th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($pedidos as $pedido)
                                <tr>
                                    <td data-order="{{ $pedido->numero_pedido }}" data-export="{{ $pedido->numero_pedido }}">
                                        <span style="display:none;">{{ $pedido->numero_pedido }}</span>
                                        <div class="font-semibold text-gray-900">{{ $pedido->numero_pedido }}</div>
                                        <div class="text-sm text-gray-600">ID: #{{ $pedido->id }}</div>
                                    </td>
                                    <td data-order="{{ $pedido->cliente->nombre ?? 'Cliente' }}" data-export="{{ $pedido->cliente->nombre ?? 'Cliente' }} | {{ $pedido->cliente->email ?? '' }}">
                                        <span style="display:none;">{{ $pedido->cliente->nombre ?? 'Cliente' }} {{ $pedido->cliente->email ?? '' }}</span>
                                        <div class="flex items-center">
                                            <div class="w-10 h-10 bg-gradient-to-r from-blue-500 to-blue-600 rounded-full flex items-center justify-center mr-3">
                                                <span class="text-white font-bold text-sm">
                                                    {{ strtoupper(substr($pedido->cliente->nombre ?? 'C', 0, 2)) }}
                                                </span>
                                            </div>
                                            <div>
                                                <div class="font-medium text-gray-900">{{ $pedido->cliente->nombre ?? 'Cliente' }}</div>
                                                <div class="text-sm text-gray-600">{{ $pedido->cliente->email ?? '' }}</div>
                                            </div>
                                        </div>
                                    </td>
                                    <td data-order="{{ $pedido->created_at->format('Y-m-d') }}" data-export="{{ $pedido->created_at->format('d/m/Y H:i') }}">
                                        <span style="display:none;">{{ $pedido->created_at->format('d/m/Y H:i') }}</span>
                                        <div class="text-gray-900">{{ $pedido->created_at->format('d/m/Y') }}</div>
                                        <div class="text-sm text-gray-600">{{ $pedido->created_at->format('H:i') }}</div>
                                    </td>
                                    <td data-order="{{ $pedido->total }}" data-export="Q{{ number_format($pedido->total, 2) }} | {{ $pedido->detalles_count ?? 0 }} items">
                                        <span style="display:none;">Q{{ number_format($pedido->total, 2) }} - {{ $pedido->detalles_count ?? 0 }} items</span>
                                        <div class="text-xl font-bold text-green-600">Q{{ number_format($pedido->total, 2) }}</div>
                                        @if($pedido->detalles_count ?? 0 > 0)
                                            <div class="text-sm text-gray-600">{{ $pedido->detalles_count ?? 0 }} items</div>
                                        @endif
                                    </td>
                                    <td data-export="{{ $pedido->estado_formateado }}">
                                        @php
                                            $estadoColors = [
                                                'pendiente' => 'yellow',
                                                'en_proceso' => 'blue',
                                                'completado' => 'green',
                                                'cancelado' => 'red'
                                            ];
                                            $estadoIcons = [
                                                'pendiente' => 'clock',
                                                'en_proceso' => 'cog',
                                                'completado' => 'check',
                                                'cancelado' => 'times'
                                            ];
                                        @endphp
                                        <span class="badge badge-{{ $estadoColors[$pedido->estado] ?? 'gray' }}">
                                            <i class="fas fa-{{ $estadoIcons[$pedido->estado] ?? 'question' }} mr-1"></i>
                                            {{ $pedido->estado_formateado }}
                                        </span>
                                    </td>
                                    <td data-order="{{ $pedido->fecha_entrega ? $pedido->fecha_entrega->format('Y-m-d') : '' }}" data-export="{{ $pedido->fecha_entrega ? $pedido->fecha_entrega->format('d/m/Y') : 'No definida' }}">
                                        <span style="display:none;">{{ $pedido->fecha_entrega ? $pedido->fecha_entrega->format('d/m/Y') : 'No definida' }}</span>
                                        @if($pedido->fecha_entrega)
                                            <div class="text-gray-900">{{ $pedido->fecha_entrega->format('d/m/Y') }}</div>
                                            @if($pedido->fecha_entrega->isPast() && $pedido->estado !== 'completado')
                                                <span class="text-red-600 text-sm font-medium">
                                                    <i class="fas fa-exclamation-triangle mr-1"></i>
                                                    Atrasado
                                                </span>
                                            @else
                                                <div class="text-sm text-gray-600">
                                                    {{ $pedido->fecha_entrega->diffForHumans() }}
                                                </div>
                                            @endif
                                        @else
                                            <span class="text-gray-400 text-sm">No definida</span>
                                        @endif
                                    </td>
                                    <td>
                                        <div class="flex items-center space-x-2">
                                            <a href="{{ route('pedidos.show', $pedido) }}"
                                               class="inline-flex items-center justify-center w-8 h-8 text-gray-500 hover:text-blue-600 hover:bg-blue-50 rounded-lg transition-all duration-200"
                                               title="Ver pedido">
                                                <i class="fas fa-eye text-sm"></i>
                                            </a>

                                            @can('generate pdf pedidos')
                                            <a href="{{ route('pedidos.pdf', $pedido) }}"
                                               class="inline-flex items-center justify-center w-8 h-8 text-gray-500 hover:text-red-600 hover:bg-red-50 rounded-lg transition-all duration-200"
                                               title="Descargar PDF" target="_blank">
                                                <i class="fas fa-file-pdf text-sm"></i>
                                            </a>
                                            @endcan

                                            @can('edit pedidos')
                                            <a href="{{ route('pedidos.edit', $pedido) }}"
                                               class="inline-flex items-center justify-center w-8 h-8 text-gray-500 hover:text-orange-600 hover:bg-orange-50 rounded-lg transition-all duration-200"
                                               title="Editar">
                                                <i class="fas fa-edit text-sm"></i>
                                            </a>
                                            @endcan

                                            @can('delete pedidos')
                                            <button type="button"
                                                    onclick="abrirModalEliminar({{ $pedido->id }}, '{{ $pedido->numero_pedido }}')"
                                                    class="inline-flex items-center justify-center w-8 h-8 text-gray-500 hover:text-red-600 hover:bg-red-50 rounded-lg transition-all duration-200"
                                                    title="Eliminar">
                                                <i class="fas fa-trash text-sm"></i>
                                            </button>
                                            @endcan
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="7" class="px-6 py-16 text-center">
                                        <div class="flex flex-col items-center">
                                            <div class="w-16 h-16 bg-gray-100 rounded-full flex items-center justify-center mb-4">
                                                <i class="fas fa-shopping-cart text-2xl text-gray-400"></i>
                                            </div>
                                            <h3 class="text-lg font-semibold text-gray-900 mb-2">No hay pedidos registrados</h3>
                                            <p class="text-gray-600 mb-4">Comienza creando el primer pedido para tus clientes</p>
                                            @can('create pedidos')
                                            <a href="{{ route('pedidos.create') }}" class="btn-primary btn-sm">
                                                <i class="fas fa-plus mr-2"></i>
                                                Crear Primer Pedido
                                            </a>
                                            @else
                                            <div class="text-sm text-gray-500 italic">
                                                <i class="fas fa-lock mr-2"></i>
                                                No tienes permisos para crear pedidos
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
            @if($pedidos->hasPages())
            <div class="mt-8 flex justify-center">
                <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-4">
                    {{ $pedidos->appends(request()->query())->links() }}
                </div>
            </div>
            @endif
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
                            ¿Estás seguro de que deseas eliminar el pedido <strong class="text-gray-900 font-semibold" id="modal-pedido-numero"></strong>?
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
                    <form id="form-eliminar-pedido" method="POST" class="w-full sm:w-auto">
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
            let tablaDataTable = null;
            let pedidoAEliminar = null;

            $(document).ready(function() {
                var hasData = $('#tablaPedidos tbody tr').length > 0 &&
                    !$('#tablaPedidos tbody tr:first td[colspan]').length;

                if (hasData) {
                    tablaDataTable = $('#tablaPedidos').DataTable({
                        paging: false,
                        lengthChange: false,
                        info: false,
                        searching: true,
                        dom: '<"flex flex-col lg:flex-row lg:justify-between lg:items-center mb-4"<"mb-4 lg:mb-0"B><"flex-1 lg:max-w-xs"f>>rt<"clear">',
                        buttons: [
                            {
                                extend: 'copy',
                                text: '<i class="fas fa-copy mr-1"></i> Copiar',
                                className: 'dt-button buttons-copy',
                                exportOptions: {
                                    columns: [0, 1, 3, 4, 5], // Número, Cliente, Total, Estado, Entrega
                                    format: {
                                        body: function(data, row, column, node) {
                                            // Buscar span oculto primero
                                            var hidden = $(node).find('span:hidden').first();
                                            if (hidden.length) {
                                                return hidden.text();
                                            }
                                            // Si tiene data-export, usarlo
                                            var exportData = $(node).attr('data-export');
                                            if (exportData) {
                                                return exportData;
                                            }
                                            return $(node).text().trim();
                                        }
                                    }
                                }
                            },
                            {
                                extend: 'excel',
                                text: '<i class="fas fa-file-excel mr-1"></i> Excel',
                                className: 'dt-button buttons-excel',
                                title: 'Listado de Pedidos',
                                exportOptions: {
                                    columns: [0, 1, 3, 4, 5], // Número, Cliente, Total, Estado, Entrega
                                    format: {
                                        body: function(data, row, column, node) {
                                            var hidden = $(node).find('span:hidden').first();
                                            if (hidden.length) {
                                                return hidden.text();
                                            }
                                            var exportData = $(node).attr('data-export');
                                            if (exportData) {
                                                return exportData;
                                            }
                                            return $(node).text().trim();
                                        }
                                    }
                                }
                            },
                            {
                                extend: 'pdf',
                                text: '<i class="fas fa-file-pdf mr-1"></i> PDF',
                                className: 'dt-button buttons-pdf',
                                title: 'Listado de Pedidos',
                                exportOptions: {
                                    columns: [0, 1, 3, 4, 5], // Número, Cliente, Total, Estado, Entrega
                                    format: {
                                        body: function(data, row, column, node) {
                                            var hidden = $(node).find('span:hidden').first();
                                            if (hidden.length) {
                                                return hidden.text();
                                            }
                                            var exportData = $(node).attr('data-export');
                                            if (exportData) {
                                                return exportData;
                                            }
                                            return $(node).text().trim();
                                        }
                                    }
                                },
                                customize: function(doc) {
                                    doc.content[1].table.widths = ['15%', '25%', '15%', '15%', '30%'];
                                }
                            },
                            {
                                extend: 'csv',
                                text: '<i class="fas fa-file-csv mr-1"></i> CSV',
                                className: 'dt-button buttons-csv',
                                exportOptions: {
                                    columns: [0, 1, 3, 4, 5], // Número, Cliente, Total, Estado, Entrega
                                    format: {
                                        body: function(data, row, column, node) {
                                            var hidden = $(node).find('span:hidden').first();
                                            if (hidden.length) {
                                                return hidden.text();
                                            }
                                            var exportData = $(node).attr('data-export');
                                            if (exportData) {
                                                return exportData;
                                            }
                                            return $(node).text().trim();
                                        }
                                    }
                                }
                            }
                        ],
                        language: {
                            search: "",
                            searchPlaceholder: "Buscar pedidos...",
                            emptyTable: "No hay pedidos disponibles",
                            zeroRecords: "No se encontraron pedidos que coincidan con la búsqueda",
                            buttons: {
                                copy: "Copiar",
                                excel: "Excel",
                                pdf: "PDF",
                                csv: "CSV",
                                copyTitle: "Copiado al portapapeles",
                                copySuccess: {
                                    _: "Se copiaron %d filas",
                                    1: "Se copió 1 fila"
                                }
                            }
                        },
                        columnDefs: [
                            {
                                orderable: false,
                                targets: [6] // Columna de acciones
                            }
                        ],
                        order: [[0, 'desc']], // Ordenar por número de pedido descendente
                        responsive: true
                    });

                    $('.dataTables_filter input').addClass('form-input');
                    $('.dataTables_filter input').attr('placeholder', 'Buscar pedidos...');
                } else {
                    $('.table-header').append(
                        '<div class="flex space-x-2"><button class="dt-button buttons-excel" onclick="alert(\'No hay datos para exportar\')"><i class="fas fa-file-excel mr-1"></i> Excel</button></div>'
                    );
                }
            });

            function exportPedidos() {
                if (tablaDataTable) {
                    $('.buttons-excel').first().click();
                } else {
                    alert('No hay datos para exportar');
                }
            }

            // Mostrar/ocultar campos de fecha personalizada
            document.getElementById('fecha').addEventListener('change', function() {
                const fechasPersonalizadas = document.getElementById('fechasPersonalizadas');
                if (fechasPersonalizadas && this.value === 'personalizado') {
                    fechasPersonalizadas.classList.remove('hidden');
                } else if (fechasPersonalizadas) {
                    fechasPersonalizadas.classList.add('hidden');
                }
            });

            // Funciones del modal mejorado
            function abrirModalEliminar(pedidoId, numeroPedido) {
                pedidoAEliminar = pedidoId;
                document.getElementById('modal-pedido-numero').textContent = numeroPedido;
                
                const form = document.getElementById('form-eliminar-pedido');
                form.action = '{{ route("pedidos.index") }}/' + pedidoId;
                
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
                    pedidoAEliminar = null;
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