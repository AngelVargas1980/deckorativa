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
                    <button class="btn-outline btn-sm" onclick="exportUsers()">
                        <i class="fas fa-download mr-2"></i>
                        Exportar Datos
                    </button>
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

        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4 lg:gap-6 mb-8">
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
            <div class="table-header flex-col lg:flex-row gap-4">
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

            <!-- Vista de tabla para desktop -->
            <div class="hidden lg:block overflow-x-auto">
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
                                <td data-order="{{ $usuario->name }} {{ $usuario->apellidos }}">
                                    <span style="display:none;">{{ $usuario->name }} {{ $usuario->apellidos }}</span>
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
                                <td data-order="{{ $usuario->email }}">
                                    <span style="display:none;">{{ $usuario->email }}{{ $usuario->telefono ? ' | ' . $usuario->telefono : '' }}</span>
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
                                <td data-export="{{ $usuario->rol ?? 'Sin rol' }}">
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
                                <td data-export="{{ $usuario->estado ? 'Activo' : 'Inactivo' }}">
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
                                                <form id="form-eliminar-{{ $usuario->id }}"
                                                      action="{{ route('usuarios.destroy', $usuario->id) }}" 
                                                      method="POST" 
                                                      class="inline">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="button"
                                                            onclick="abrirModalEliminar('{{ $usuario->id }}', '{{ $usuario->name }}')"
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
                                        @can('create users')
                                            <a href="{{ route('usuarios.create') }}" class="btn-primary btn-sm">
                                                <i class="fas fa-user-plus mr-2"></i>
                                                Agregar Usuario
                                            </a>
                                        @else
                                            <div class="text-sm text-gray-500 italic">
                                                <i class="fas fa-lock mr-2"></i>
                                                No tienes permisos para crear usuarios
                                            </div>
                                        @endcan
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <!-- Vista de tarjetas para móvil/tablet -->
            <div class="lg:hidden">
                <!-- Buscador y botones de exportación solo para móvil -->
                <div class="mb-4 space-y-3 p-8">
                    <div class="flex flex-wrap gap-2" id="botonesExportacionMovil">
                        <!-- Los botones se insertarán aquí via JavaScript -->
                    </div>
                    <input type="text" id="searchInputMobile" class="form-input w-full"
                        placeholder="Buscar usuarios...">
                </div>

                <div class="space-y-4" id="usuariosMobile">
                    @forelse ($usuarios as $usuario)
                        <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-4 hover:shadow-md transition-shadow usuario-card"
                            data-nombre="{{ strtolower($usuario->name . ' ' . ($usuario->apellidos ?? '')) }}"
                            data-email="{{ strtolower($usuario->email) }}"
                            data-telefono="{{ strtolower($usuario->telefono ?? '') }}"
                            data-rol="{{ strtolower($usuario->rol ?? '') }}">
                            <div class="flex items-start justify-between mb-3">
                                <div class="flex items-center flex-1">
                                    <div class="w-12 h-12 bg-gradient-to-r from-cyan-500 to-blue-600 rounded-full flex items-center justify-center shadow-md flex-shrink-0">
                                        <span class="text-white font-bold text-sm">
                                            {{ strtoupper(substr($usuario->name, 0, 1)) }}{{ $usuario->apellidos ? strtoupper(substr($usuario->apellidos, 0, 1)) : '' }}
                                        </span>
                                    </div>
                                    <div class="ml-3 flex-1 min-w-0">
                                        <div class="font-semibold text-gray-900 truncate">
                                            {{ $usuario->name }} {{ $usuario->apellidos }}
                                        </div>
                                        <div class="text-xs text-gray-500">ID: #{{ $usuario->id }}</div>
                                    </div>
                                </div>

                                @if($usuario->estado)
                                    <span class="badge badge-success text-xs ml-2 flex-shrink-0">
                                        <i class="fas fa-check-circle"></i>
                                    </span>
                                @else
                                    <span class="badge badge-danger text-xs ml-2 flex-shrink-0">
                                        <i class="fas fa-times-circle"></i>
                                    </span>
                                @endif
                            </div>

                            <div class="space-y-2 mb-3 text-sm">
                                <div class="flex items-center text-gray-700">
                                    <i class="fas fa-at text-gray-400 mr-2 w-4"></i>
                                    <span class="truncate">{{ $usuario->email }}</span>
                                </div>

                                @if($usuario->telefono)
                                    <div class="flex items-center text-gray-700">
                                        <i class="fas fa-phone text-gray-400 mr-2 w-4"></i>
                                        <span>{{ $usuario->telefono }}</span>
                                    </div>
                                @endif

                                <div class="flex items-center text-gray-700">
                                    @php
                                        $rolConfig = [
                                            'Admin' => ['class' => 'badge-danger', 'icon' => 'fas fa-crown'],
                                            'Supervisor' => ['class' => 'badge-warning', 'icon' => 'fas fa-user-tie'],
                                            'Asesor' => ['class' => 'badge-info', 'icon' => 'fas fa-user-headset'],
                                        ];
                                        $config = $rolConfig[$usuario->rol] ?? ['class' => 'badge-secondary', 'icon' => 'fas fa-user'];
                                    @endphp
                                    <span class="badge {{ $config['class'] }} text-xs">
                                        <i class="{{ $config['icon'] }} mr-1"></i>
                                        {{ $usuario->rol ?? 'Sin rol' }}
                                    </span>
                                </div>
                            </div>

                            <div class="flex items-center justify-end space-x-2 pt-3 border-t border-gray-100">
                                <a href="{{ route('usuarios.show', $usuario->id) }}"
                                    class="inline-flex items-center justify-center px-3 py-2 text-sm text-blue-600 bg-blue-50 rounded-lg hover:bg-blue-100 transition-all duration-200">
                                    <i class="fas fa-eye mr-1"></i>
                                    Ver
                                </a>

                                @can('edit users')
                                    <a href="{{ route('usuarios.edit', $usuario->id) }}"
                                        class="inline-flex items-center justify-center px-3 py-2 text-sm text-orange-600 bg-orange-50 rounded-lg hover:bg-orange-100 transition-all duration-200">
                                        <i class="fas fa-edit mr-1"></i>
                                        Editar
                                    </a>
                                @endcan

                                @can('delete users')
                                    @if($usuario->email !== 'admin@deckorativa.com')
                                        <form id="form-eliminar-mobile-{{ $usuario->id }}"
                                            action="{{ route('usuarios.destroy', $usuario->id) }}" method="POST" class="inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="button"
                                                onclick="abrirModalEliminar('{{ $usuario->id }}', '{{ $usuario->name }}')"
                                                class="inline-flex items-center justify-center px-3 py-2 text-sm text-red-600 bg-red-50 rounded-lg hover:bg-red-100 transition-all duration-200">
                                                <i class="fas fa-trash mr-1"></i>
                                                Eliminar
                                            </button>
                                        </form>
                                    @endif
                                @endcan
                            </div>
                        </div>
                    @empty
                        <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-8 text-center">
                            <div class="w-16 h-16 bg-gray-100 rounded-full flex items-center justify-center mb-4 mx-auto">
                                <i class="fas fa-users text-2xl text-gray-400"></i>
                            </div>
                            <h3 class="text-lg font-semibold text-gray-900 mb-2">No hay usuarios registrados</h3>
                            <p class="text-gray-600 text-sm mb-4">Comienza agregando el primer usuario</p>
                            @can('create users')
                                <a href="{{ route('usuarios.create') }}" class="btn-primary btn-sm inline-flex items-center">
                                    <i class="fas fa-user-plus mr-2"></i>
                                    Agregar Usuario
                                </a>
                            @endcan
                        </div>
                    @endforelse
                </div>
            </div>
        </div>

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

    <!-- Modal de confirmación para eliminar -->
    <div id="modal-confirmar-eliminar" class="fixed inset-0 bg-gray-600 bg-opacity-50 hidden z-50">
        <div class="flex items-center justify-center min-h-screen p-4">
            <div class="bg-white rounded-lg shadow-xl max-w-md w-full mx-4">
                <div class="px-6 py-4 bg-red-600">
                    <h3 class="text-lg font-semibold text-white flex items-center">
                        <i class="fas fa-exclamation-triangle mr-3"></i>
                        Confirmar Eliminación
                    </h3>
                </div>
                <div class="p-6">
                    <p class="text-gray-700 mb-4">
                        ¿Estás seguro de que deseas eliminar al usuario <strong id="usuario-nombre"></strong>?
                    </p>
                    <p class="text-sm text-gray-500 bg-yellow-50 border border-yellow-200 rounded p-3">
                        <i class="fas fa-info-circle mr-1"></i>
                        Esta acción no se puede deshacer.
                    </p>
                </div>
                <div class="px-6 py-4 bg-gray-50 flex flex-col sm:flex-row justify-end space-y-2 sm:space-y-0 sm:space-x-3">
                    <button type="button" onclick="cerrarModalEliminar()"
                            class="px-4 py-2 bg-gray-200 text-gray-700 rounded-lg hover:bg-gray-300 transition w-full sm:w-auto">
                        Cancelar
                    </button>
                    <button type="button" onclick="confirmarYEliminar()"
                            class="px-4 py-2 bg-red-600 text-white rounded-lg hover:bg-red-700 transition w-full sm:w-auto">
                        <i class="fas fa-trash mr-2"></i>
                        Eliminar
                    </button>
                </div>
            </div>
        </div>
    </div>

    @push('scripts')
        <script>
            let usuarioIdParaEliminar = null;
            let tablaDataTable = null;

            $(document).ready(function() {
                var hasData = $('#tablaUsuarios tbody tr').length > 0 &&
                    !$('#tablaUsuarios tbody tr:first td[colspan]').length;

                if (hasData) {
                    tablaDataTable = $('#tablaUsuarios').DataTable({
                        paging: false,
                        lengthChange: false,
                        info: false,
                        searching: true,
                        dom: '<"flex flex-col lg:flex-row lg:justify-between lg:items-center mb-4"<"mb-4 lg:mb-0"B><"flex-1 lg:max-w-xs"f>>rt<"clear">',
                        buttons: [{
                                extend: 'copy',
                                text: '<i class="fas fa-copy mr-1"></i> Copiar',
                                className: 'dt-button buttons-copy',
                                exportOptions: {
                                    columns: [0, 1, 2, 3],
                                    format: {
                                        body: function(data, row, column, node) {
                                            var hidden = $(node).find('span:hidden').first();
                                            if (hidden.length) {
                                                return hidden.text();
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
                                title: 'Listado de Usuarios',
                                exportOptions: {
                                    columns: [0, 1, 2, 3],
                                    format: {
                                        body: function(data, row, column, node) {
                                            var hidden = $(node).find('span:hidden').first();
                                            if (hidden.length) {
                                                return hidden.text();
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
                                title: 'Listado de Usuarios',
                                exportOptions: {
                                    columns: [0, 1, 2, 3],
                                    format: {
                                        body: function(data, row, column, node) {
                                            var hidden = $(node).find('span:hidden').first();
                                            if (hidden.length) {
                                                return hidden.text();
                                            }
                                            return $(node).text().trim();
                                        }
                                    }
                                }
                            },
                            {
                                extend: 'csv',
                                text: '<i class="fas fa-file-csv mr-1"></i> CSV',
                                className: 'dt-button buttons-csv',
                                exportOptions: {
                                    columns: [0, 1, 2, 3],
                                    format: {
                                        body: function(data, row, column, node) {
                                            var hidden = $(node).find('span:hidden').first();
                                            if (hidden.length) {
                                                return hidden.text();
                                            }
                                            return $(node).text().trim();
                                        }
                                    }
                                }
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
                                csv: "CSV",
                                copyTitle: "Copiado al portapapeles",
                                copySuccess: {
                                    _: "Se copiaron %d filas",
                                    1: "Se copió 1 fila"
                                }
                            }
                        },
                        columnDefs: [{
                            orderable: false,
                            targets: [4]
                        }],
                        responsive: true
                    });

                    $('.dataTables_filter input').addClass('form-input');
                    $('.dataTables_filter input').attr('placeholder', 'Buscar usuarios...');

                    // Clonar botones de exportación para móvil
                    var botonesClonados = tablaDataTable.buttons().container().clone();
                    $('#botonesExportacionMovil').html(botonesClonados.html());
                } else {
                    $('.table-header').append(
                        '<div class="flex space-x-2"><button class="dt-button buttons-excel" onclick="alert(\'No hay datos para exportar\')"><i class="fas fa-file-excel mr-1"></i> Excel</button></div>'
                    );
                }

                // Búsqueda para vista móvil
                $('#searchInputMobile').on('keyup', function() {
                    var searchTerm = $(this).val().toLowerCase();
                    $('.usuario-card').each(function() {
                        var nombre = $(this).data('nombre');
                        var email = $(this).data('email');
                        var telefono = $(this).data('telefono');
                        var rol = $(this).data('rol');

                        var textoCompleto = nombre + ' ' + email + ' ' + telefono + ' ' + rol;

                        if (textoCompleto.includes(searchTerm)) {
                            $(this).show();
                        } else {
                            $(this).hide();
                        }
                    });
                });
            });

            function exportUsers() {
                if (tablaDataTable) {
                    $('.buttons-excel').first().click();
                } else {
                    alert('No hay datos para exportar');
                }
            }

            function abrirModalEliminar(usuarioId, usuarioNombre) {
                usuarioIdParaEliminar = usuarioId;
                document.getElementById('usuario-nombre').textContent = usuarioNombre;
                document.getElementById('modal-confirmar-eliminar').classList.remove('hidden');
                document.body.style.overflow = 'hidden';
            }

            function cerrarModalEliminar() {
                document.getElementById('modal-confirmar-eliminar').classList.add('hidden');
                usuarioIdParaEliminar = null;
                document.body.style.overflow = '';
            }

            function confirmarYEliminar() {
                if (usuarioIdParaEliminar) {
                    let form = document.getElementById('form-eliminar-' + usuarioIdParaEliminar) ||
                        document.getElementById('form-eliminar-mobile-' + usuarioIdParaEliminar);
                    if (form) {
                        form.submit();
                    }
                }
            }

            document.getElementById('modal-confirmar-eliminar').addEventListener('click', function(e) {
                if (e.target === this) {
                    cerrarModalEliminar();
                }
            });

            document.addEventListener('keydown', function(e) {
                if (e.key === 'Escape') {
                    cerrarModalEliminar();
                }
            });
        </script>
    @endpush
@endsection