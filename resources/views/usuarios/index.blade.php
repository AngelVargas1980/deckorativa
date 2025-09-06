@extends('layouts.app')

@section('content')
    <div class="animate-slideInUp">
        <div class="page-header">
            <div class="flex flex-col lg:flex-row lg:items-center lg:justify-between">
                <div>
                    <h1 class="page-title text-gradient">
                        <i class="fas fa-users mr-3"></i>
                        Gestión de Usuarios
                    </h1>
                    <p class="page-subtitle">
                        <i class="fas fa-user-cog mr-2"></i>
                        Administra y controla todos los usuarios del sistema
                    </p>
                </div>
                <div class="mt-6 lg:mt-0 flex flex-col sm:flex-row gap-3">
                    @can('create users')
                    <a href="{{ route('usuarios.create') }}" class="btn-primary">
                        <i class="fas fa-user-plus mr-2"></i>
                        Nuevo Usuario
                    </a>
                    @endcan
                    @cannot('create users')
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

        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
            <div class="stat-card">
                <div class="stat-icon bg-gradient-to-r from-blue-500 to-blue-600">
                    <i class="fas fa-users"></i>
                </div>
                <p class="stat-title">Total Usuarios</p>
                <p class="stat-value">{{ $usuarios->count() }}</p>
            </div>
            <div class="stat-card">
                <div class="stat-icon bg-gradient-to-r from-green-500 to-green-600">
                    <i class="fas fa-user-check"></i>
                </div>
                <p class="stat-title">Usuarios Activos</p>
                <p class="stat-value">{{ $usuarios->where('estado', 1)->count() }}</p>
            </div>
            <div class="stat-card">
                <div class="stat-icon bg-gradient-to-r from-purple-500 to-purple-600">
                    <i class="fas fa-user-shield"></i>
                </div>
                <p class="stat-title">Administradores</p>
                <p class="stat-value">{{ $usuarios->where('rol', 'Admin')->count() }}</p>
            </div>
        </div>

        <div class="table-container">
            <div class="table-header">
                <div class="flex items-center space-x-4">
                    <i class="fas fa-table text-gray-600"></i>
                    <div>
                        <h3 class="text-lg font-semibold text-gray-900">Lista de Usuarios</h3>
                        <p class="text-sm text-gray-600">Gestiona todos los usuarios del sistema</p>
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
                <table id="tablaUsuarios" class="custom-table">
                    <thead>
                        <tr>
                            <th>
                                <i class="fas fa-user mr-2"></i>
                                Usuario
                            </th>
                            <th>
                                <i class="fas fa-envelope mr-2"></i>
                                Contacto
                            </th>
                            <th>
                                <i class="fas fa-shield-alt mr-2"></i>
                                Rol
                            </th>
                            <th>
                                <i class="fas fa-power-off mr-2"></i>
                                Estado
                            </th>
                            <th>
                                <i class="fas fa-cogs mr-2"></i>
                                Acciones
                            </th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($usuarios as $usuario)
                            <tr>
                                <td>
                                    <div class="flex items-center">
                                        <div class="w-12 h-12 bg-gradient-to-r from-cyan-500 to-blue-600 rounded-full flex items-center justify-center shadow-md">
                                            <span class="text-white font-bold text-sm">
                                                {{ strtoupper(substr($usuario->name, 0, 1)) }}{{ $usuario->apellidos ? strtoupper(substr($usuario->apellidos, 0, 1)) : '' }}
                                            </span>
                                        </div>
                                        <div class="ml-4">
                                            <div class="font-semibold text-gray-900">{{ $usuario->name }}</div>
                                            <div class="text-sm text-gray-600">{{ $usuario->apellidos ?? 'Sin apellidos' }}</div>
                                        </div>
                                    </div>
                                </td>
                                <td>
                                    <div class="space-y-1">
                                        <div class="flex items-center text-gray-900">
                                            <i class="fas fa-at text-gray-400 mr-2 text-xs"></i>
                                            {{ $usuario->email }}
                                        </div>
                                        @if($usuario->telefono)
                                            <div class="flex items-center text-gray-600">
                                                <i class="fas fa-phone text-gray-400 mr-2 text-xs"></i>
                                                {{ $usuario->telefono }}
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
                                    @php
                                        $rolConfig = [
                                            'Admin' => ['class' => 'badge-danger', 'icon' => 'fas fa-crown'],
                                            'Supervisor' => ['class' => 'badge-warning', 'icon' => 'fas fa-user-tie'],
                                            'Asesor' => ['class' => 'badge-info', 'icon' => 'fas fa-user-headset'],
                                        ];
                                        $config = $rolConfig[$usuario->rol] ?? ['class' => 'badge-secondary', 'icon' => 'fas fa-user'];
                                    @endphp
                                    <span class="badge {{ $config['class'] }}">
                                        <i class="{{ $config['icon'] }} mr-1"></i>
                                        {{ $usuario->rol ?? 'Sin rol' }}
                                    </span>
                                </td>
                                <td>
                                    @if($usuario->estado)
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
                                        <a href="{{ route('usuarios.show', $usuario->id) }}"
                                           class="inline-flex items-center justify-center w-8 h-8 text-gray-500 hover:text-blue-600 hover:bg-blue-50 rounded-lg transition-all duration-200"
                                           title="Ver detalles">
                                            <i class="fas fa-eye text-sm"></i>
                                        </a>

                                        @can('edit users')
                                        <a href="{{ route('usuarios.edit', $usuario->id) }}"
                                           class="inline-flex items-center justify-center w-8 h-8 text-gray-500 hover:text-orange-600 hover:bg-orange-50 rounded-lg transition-all duration-200"
                                           title="Editar">
                                            <i class="fas fa-edit text-sm"></i>
                                        </a>
                                        @endcan

                                        @can('delete users')
                                            @if($usuario->email !== 'admin@deckorativa.com')
                                                <form action="{{ route('usuarios.destroy', $usuario->id) }}" method="POST" class="inline"
                                                      onsubmit="return confirm('¿Estás seguro de que deseas eliminar este usuario?\n\nEsta acción no se puede deshacer.');">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit"
                                                            class="inline-flex items-center justify-center w-8 h-8 text-gray-500 hover:text-red-600 hover:bg-red-50 rounded-lg transition-all duration-200"
                                                            title="Eliminar">
                                                        <i class="fas fa-trash text-sm"></i>
                                                    </button>
                                                </form>
                                            @else
                                                <div class="inline-flex items-center justify-center w-8 h-8 text-gray-300 rounded-lg"
                                                     title="Usuario protegido - No se puede eliminar">
                                                    <i class="fas fa-shield-alt text-sm"></i>
                                                </div>
                                            @endif
                                        @endcan

                                        @if(!auth()->user()->can('edit users') && !auth()->user()->can('delete users'))
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
                                            <i class="fas fa-users text-2xl text-gray-400"></i>
                                        </div>
                                        <h3 class="text-lg font-semibold text-gray-900 mb-2">No hay usuarios registrados</h3>
                                        <p class="text-gray-600 mb-4">Comienza agregando el primer usuario al sistema</p>
                                        <a href="{{ route('usuarios.create') }}" class="btn-primary btn-sm">
                                            <i class="fas fa-user-plus mr-2"></i>
                                            Agregar Usuario
                                        </a>
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
                    {{ $usuarios->appends(['cantidad' => request('cantidad')])->links() }}
                </div>
            </div>
        @else
            <div class="mt-6 text-center">
                <div class="inline-flex items-center px-4 py-2 bg-gray-50 rounded-lg border border-gray-200">
                    <i class="fas fa-info-circle text-gray-600 mr-2"></i>
                    <span class="text-sm text-gray-700 font-medium">
                        Mostrando todos los registros ({{ $usuarios->count() }} en total)
                    </span>
                </div>
            </div>
        @endif
    </div>

    @push('scripts')
        <script>
            $(document).ready(function() {
                $('#tablaUsuarios').DataTable({
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
                        searchPlaceholder: "Buscar usuarios...",
                        emptyTable: "No hay usuarios disponibles",
                        zeroRecords: "No se encontraron usuarios que coincidan con la búsqueda",
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
                $('.dataTables_filter input').attr('placeholder', 'Buscar usuarios...');
            });
        </script>
    @endpush
@endsection


