@extends('layouts.app')

@section('content')
    <div class="animate-slideInUp">
        <div class="page-header">
            <div class="flex flex-col lg:flex-row lg:items-center lg:justify-between">
                <div>
                    <h1 class="page-title text-gradient">
                        <i class="fas fa-handshake mr-3"></i>
                        Gestión de Clientes
                    </h1>
                    <p class="page-subtitle">
                        <i class="fas fa-users-cog mr-2"></i>
                        Administra y controla la base de datos de clientes
                    </p>
                </div>
                <div class="mt-6 lg:mt-0 flex flex-col sm:flex-row gap-3">
                    <button class="btn-outline btn-sm" onclick="exportClients()">
                        <i class="fas fa-download mr-2"></i>
                        Exportar Datos
                    </button>
                    @can('create clients')
                    <a href="{{ route('clients.create') }}" class="btn-primary">
                        <i class="fas fa-user-plus mr-2"></i>
                        Nuevo Cliente
                    </a>
                    @endcan
                    @cannot('create clients')
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

        <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-8">
            <div class="stat-card">
                <div class="stat-icon bg-gradient-to-r from-blue-500 to-blue-600">
                    <i class="fas fa-users"></i>
                </div>
                <p class="stat-title">Total Clientes</p>
                <p class="stat-value">{{ $clients->count() }}</p>
            </div>
            <div class="stat-card">
                <div class="stat-icon bg-gradient-to-r from-green-500 to-green-600">
                    <i class="fas fa-envelope-open"></i>
                </div>
                <p class="stat-title">Email Verificados</p>
                <p class="stat-value">{{ $clients->where('email_verified', 1)->count() }}</p>
            </div>
            <div class="stat-card">
                <div class="stat-icon bg-gradient-to-r from-purple-500 to-purple-600">
                    <i class="fas fa-phone"></i>
                </div>
                <p class="stat-title">Con Teléfono</p>
                <p class="stat-value">{{ $clients->whereNotNull('phone')->count() }}</p>
            </div>
            <div class="stat-card">
                <div class="stat-icon bg-gradient-to-r from-orange-500 to-orange-600">
                    <i class="fas fa-id-card"></i>
                </div>
                <p class="stat-title">Con Identificación</p>
                <p class="stat-value">{{ $clients->whereNotNull('identification_number')->count() }}</p>
            </div>
        </div>

        <div class="table-container">
            <div class="table-header">
                <div class="flex items-center space-x-4">
                    <i class="fas fa-table text-gray-600"></i>
                    <div>
                        <h3 class="text-lg font-semibold text-gray-900">Base de Clientes</h3>
                        <p class="text-sm text-gray-600">Gestiona la información de todos tus clientes</p>
                    </div>
                </div>
                <div class="flex items-center space-x-3">
                    <form method="GET" class="flex items-center space-x-2">
                        <label class="text-sm text-gray-600 font-medium">Mostrar:</label>
                        <select name="cantidad" onchange="this.form.submit()" class="form-select py-2 text-sm">
                            <option value="5" {{ request('cantidad') == 5 ? 'selected' : '' }}>5</option>
                            <option value="10" {{ request('cantidad') == 10 ? 'selected' : '' }}>10</option>
                            <option value="25" {{ request('cantidad') == 25 ? 'selected' : '' }}>25</option>
                            <option value="50" {{ request('cantidad') == 50 ? 'selected' : '' }}>50</option>
                            <option value="100" {{ request('cantidad') == 100 ? 'selected' : '' }}>100</option>
                            <option value="all" {{ request('cantidad') == 'all' ? 'selected' : '' }}>Todos</option>
                        </select>
                    </form>
                </div>
            </div>

            <div class="overflow-x-auto">
                <table id="tablaClientes" class="custom-table">
                    <thead>
                        <tr>
                            <th>
                                <i class="fas fa-user mr-2"></i>
                                Cliente
                            </th>
                            <th>
                                <i class="fas fa-id-card mr-2"></i>
                                Identificación
                            </th>
                            <th>
                                <i class="fas fa-envelope mr-2"></i>
                                Contacto
                            </th>
                            <th>
                                <i class="fas fa-check-circle mr-2"></i>
                                Estado
                            </th>
                            <th>
                                <i class="fas fa-cogs mr-2"></i>
                                Acciones
                            </th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($clients as $client)
                            <tr>
                                <td>
                                    <div class="flex items-center">
                                        <div class="w-12 h-12 bg-gradient-to-r from-green-500 to-emerald-600 rounded-full flex items-center justify-center shadow-md">
                                            <span class="text-white font-bold text-sm">
                                                {{ strtoupper(substr($client->first_name, 0, 1)) }}{{ $client->last_name ? strtoupper(substr($client->last_name, 0, 1)) : '' }}
                                            </span>
                                        </div>
                                        <div class="ml-4">
                                            <div class="font-semibold text-gray-900">
                                                {{ $client->first_name }} {{ $client->last_name }}
                                            </div>
                                            <div class="text-sm text-gray-600">Cliente ID: #{{ $client->id }}</div>
                                        </div>
                                    </div>
                                </td>
                                <td>
                                    @if($client->identification_number)
                                        <div class="flex items-center">
                                            <i class="fas fa-id-card text-gray-400 mr-2"></i>
                                            <span class="font-mono text-sm">{{ $client->identification_number }}</span>
                                        </div>
                                    @else
                                        <div class="flex items-center text-gray-400">
                                            <i class="fas fa-id-card-alt mr-2"></i>
                                            <span class="text-sm">Sin identificación</span>
                                        </div>
                                    @endif
                                </td>
                                <td>
                                    <div class="space-y-1">
                                        <div class="flex items-center text-gray-900">
                                            <i class="fas fa-at text-gray-400 mr-2 text-xs"></i>
                                            {{ $client->email }}
                                        </div>
                                        @if($client->phone)
                                            <div class="flex items-center text-gray-600">
                                                <i class="fas fa-phone text-gray-400 mr-2 text-xs"></i>
                                                {{ $client->phone }}
                                            </div>
                                        @else
                                            <div class="text-gray-400 text-sm">
                                                <i class="fas fa-phone-slash mr-2 text-xs"></i>
                                                Sin teléfono
                                            </div>
                                        @endif
                                    </div>
                                </td>
                                <td>
                                    <div class="space-y-2">
                                        @if($client->email_verified)
                                            <span class="badge badge-success">
                                                <i class="fas fa-check-circle mr-1"></i>
                                                Email Verificado
                                            </span>
                                        @else
                                            <span class="badge badge-warning">
                                                <i class="fas fa-exclamation-triangle mr-1"></i>
                                                Sin Verificar
                                            </span>
                                        @endif
                                    </div>
                                </td>
                                <td>
                                    <div class="flex items-center space-x-2">
                                        <!-- Ver siempre disponible para todos -->
                                        <a href="{{ route('clients.show', $client->id) }}"
                                           class="inline-flex items-center justify-center w-8 h-8 text-gray-500 hover:text-blue-600 hover:bg-blue-50 rounded-lg transition-all duration-200"
                                           title="Ver detalles">
                                            <i class="fas fa-eye text-sm"></i>
                                        </a>

                                        @can('edit clients')
                                        <a href="{{ route('clients.edit', $client->id) }}"
                                           class="inline-flex items-center justify-center w-8 h-8 text-gray-500 hover:text-orange-600 hover:bg-orange-50 rounded-lg transition-all duration-200"
                                           title="Editar">
                                            <i class="fas fa-edit text-sm"></i>
                                        </a>
                                        @endcan

                                        @can('delete clients')
                                        <form action="{{ route('clients.destroy', $client->id) }}" method="POST" class="inline"
                                              onsubmit="return confirm('¿Estás seguro de que deseas eliminar este cliente?\n\nEsta acción no se puede deshacer.');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit"
                                                    class="inline-flex items-center justify-center w-8 h-8 text-gray-500 hover:text-red-600 hover:bg-red-50 rounded-lg transition-all duration-200"
                                                    title="Eliminar">
                                                <i class="fas fa-trash text-sm"></i>
                                            </button>
                                        </form>
                                        @endcan

                                        @if(!auth()->user()->can('edit clients') && !auth()->user()->can('delete clients'))
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
                                            <i class="fas fa-handshake text-2xl text-gray-400"></i>
                                        </div>
                                        <h3 class="text-lg font-semibold text-gray-900 mb-2">No hay clientes registrados</h3>
                                        <p class="text-gray-600 mb-4">Comienza agregando el primer cliente a tu base de datos</p>
                                        @can('create clients')
                                        <a href="{{ route('clients.create') }}" class="btn-primary btn-sm">
                                            <i class="fas fa-user-plus mr-2"></i>
                                            Agregar Cliente
                                        </a>
                                        @else
                                        <div class="text-sm text-gray-500 italic">
                                            <i class="fas fa-lock mr-2"></i>
                                            No tienes permisos para crear clientes
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
        @if ($paginado)
            <div class="mt-8 flex justify-center">
                <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-4">
                    {{ $clients->appends(['cantidad' => request('cantidad')])->links() }}
                </div>
            </div>
        @else
            <div class="mt-6 text-center">
                <div class="inline-flex items-center px-4 py-2 bg-gray-50 rounded-lg border border-gray-200">
                    <i class="fas fa-info-circle text-gray-600 mr-2"></i>
                    <span class="text-sm text-gray-700 font-medium">
                        Mostrando todos los registros ({{ $clients->count() }} en total)
                    </span>
                </div>
            </div>
        @endif
    </div>

    @push('scripts')
        <script>
            $(document).ready(function() {
                // Verificar si la tabla tiene datos antes de inicializar DataTables
                var hasData = $('#tablaClientes tbody tr').length > 0 &&
                             !$('#tablaClientes tbody tr:first td[colspan]').length;

                if (hasData) {
                    $('#tablaClientes').DataTable({
                        paging: false,
                        lengthChange: false,
                        info: false,
                        searching: true,
                        dom: '<"flex flex-col lg:flex-row lg:justify-between lg:items-center mb-4"<"mb-4 lg:mb-0"B><"flex-1 lg:max-w-xs"f>>rt<"clear">',
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
                            },
                            {
                                extend: 'csv',
                                text: '<i class="fas fa-file-csv mr-1"></i> CSV',
                                className: 'dt-button buttons-csv'
                            }
                        ],
                        language: {
                            search: "",
                            searchPlaceholder: "Buscar clientes...",
                            emptyTable: "No hay clientes disponibles",
                            zeroRecords: "No se encontraron clientes que coincidan con la búsqueda",
                            buttons: {
                                copy: "Copiar",
                                excel: "Excel",
                                pdf: "PDF",
                                csv: "CSV"
                            }
                        },
                        columnDefs: [
                            { orderable: false, targets: [4] } // Deshabilitar orden en columna de acciones
                        ],
                        responsive: true
                    });

                    // Personalizar el input de búsqueda
                    $('.dataTables_filter input').addClass('form-input');
                    $('.dataTables_filter input').attr('placeholder', 'Buscar clientes...');
                } else {
                    // Si no hay datos, solo agregar los botones de exportación manualmente
                    $('.table-header').append('<div class="flex space-x-2"><button class="dt-button buttons-excel" onclick="alert(\'No hay datos para exportar\')"><i class="fas fa-file-excel mr-1"></i> Excel</button></div>');
                }

            });

            function exportClients() {
                // Trigger the Excel export
                $('.buttons-excel').click();
            }
        </script>
    @endpush
@endsection
