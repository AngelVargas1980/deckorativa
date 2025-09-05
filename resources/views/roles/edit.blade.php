@extends('layouts.app')

@section('content')
    <div class="mb-8">
        <div class="flex items-center space-x-4">
            <a href="{{ route('roles.index') }}" class="p-2 hover:bg-gray-100 rounded-lg transition-colors">
                <svg class="w-6 h-6 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                </svg>
            </a>
            <div>
                <h1 class="text-3xl font-bold text-gray-900">Editar Rol: {{ $role->name }}</h1>
                <p class="text-gray-600">Modifica los permisos y configuración del rol</p>
            </div>
        </div>
    </div>

    @if ($errors->any())
        <div class="mb-6 bg-red-50 border border-red-200 rounded-lg p-4">
            <div class="flex items-center mb-2">
                <svg class="w-5 h-5 text-red-600 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                </svg>
                <span class="text-red-800 font-medium">Por favor corrige los siguientes errores:</span>
            </div>
            <ul class="list-disc list-inside text-red-700">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form method="POST" action="{{ route('roles.update', $role) }}" class="space-y-6">
        @csrf
        @method('PUT')

        <div class="bg-white rounded-2xl p-6 shadow-lg border border-gray-100">
            <h3 class="text-xl font-bold text-gray-900 mb-4">Información del Rol</h3>
            <div>
                <label for="name" class="block text-sm font-semibold text-gray-700 mb-2">Nombre del Rol</label>
                <input type="text"
                       name="name"
                       id="name"
                       value="{{ old('name', $role->name) }}"
                       class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-transparent transition-all"
                       placeholder="Ej: Secretaria, Contador, Supervisor..."
                       required>
                <p class="mt-2 text-sm text-gray-500">Ingresa un nombre descriptivo para el rol</p>
            </div>
        </div>

        <div class="bg-white rounded-2xl p-6 shadow-lg border border-gray-100">
            <h3 class="text-xl font-bold text-gray-900 mb-4">Permisos del Rol</h3>
            <p class="text-gray-600 mb-6">Selecciona los permisos que tendrá este rol en cada módulo del sistema</p>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                @foreach($permissions as $module => $modulePermissions)
                    <div class="border border-gray-200 rounded-xl p-4 hover:shadow-md transition-shadow">
                        <div class="flex items-center justify-between mb-4">
                            <h4 class="text-lg font-bold text-gray-800 capitalize flex items-center">
                                @if($module === 'dashboard')
                                    <svg class="w-5 h-5 mr-2 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 7v10a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2H5a2 2 0 00-2-2z"></path>
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 5a2 2 0 012-2h4a2 2 0 012 2v3H8V5z"></path>
                                    </svg>
                                @elseif($module === 'roles')
                                    <svg class="w-5 h-5 mr-2 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.031 9-11.622 0-1.042-.133-2.052-.382-3.016z"></path>
                                    </svg>
                                @elseif($module === 'users')
                                    <svg class="w-5 h-5 mr-2 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197m3 5.197a4 4 0 11-8 0m8 0V9a2 2 0 00-2-2H5a2 2 0 00-2 2v8a2 2 0 002 2h6a2 2 0 002-2V9z"></path>
                                    </svg>
                                @elseif($module === 'clients')
                                    <svg class="w-5 h-5 mr-2 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path>
                                    </svg>
                                @endif
                                {{ ucfirst($module) }}
                            </h4>
                            <button type="button"
                                    onclick="toggleModule('{{ $module }}')"
                                    class="text-sm text-purple-600 hover:text-purple-800 font-medium">
                                Seleccionar todo
                            </button>
                        </div>

                        <div class="space-y-2">
                            @foreach($modulePermissions as $permission)
                                @php
                                    $action = str_replace([' ' . $module, ' readonly'], '', $permission->name);
                                    $colors = [
                                        'view' => 'border-green-200 text-green-700',
                                        'create' => 'border-blue-200 text-blue-700',
                                        'edit' => 'border-yellow-200 text-yellow-700',
                                        'delete' => 'border-red-200 text-red-700',
                                        'manage' => 'border-purple-200 text-purple-700'
                                    ];
                                    $color = $colors[$action] ?? 'border-gray-200 text-gray-700';
                                    $isChecked = $role->hasPermissionTo($permission->name);
                                @endphp
                                <label class="flex items-center p-3 border {{ $color }} rounded-lg hover:bg-gray-50 cursor-pointer transition-colors">
                                    <input type="checkbox"
                                           name="permissions[]"
                                           value="{{ $permission->name }}"
                                           {{ $isChecked ? 'checked' : '' }}
                                           class="w-4 h-4 text-purple-600 border-gray-300 rounded focus:ring-purple-500 mr-3 module-{{ $module }}">
                                    <div class="flex-1">
                                        <span class="font-medium capitalize">{{ $action }}</span>
                                        <p class="text-sm text-gray-500 mt-1">
                                            @if($action === 'view')
                                                Puede ver y consultar registros
                                            @elseif($action === 'create')
                                                Puede crear nuevos registros
                                            @elseif($action === 'edit')
                                                Puede modificar registros existentes
                                            @elseif($action === 'delete')
                                                Puede eliminar registros
                                            @elseif($action === 'manage')
                                                Control total sobre el módulo
                                            @elseif($action === 'view clients readonly')
                                                Solo lectura de clientes (no puede editar)
                                            @endif
                                        </p>
                                    </div>
                                </label>
                            @endforeach
                        </div>
                    </div>
                @endforeach
            </div>

            <div class="mt-6 p-4 bg-blue-50 border border-blue-200 rounded-lg">
                <div class="flex items-center">
                    <svg class="w-5 h-5 text-blue-600 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                    <div>
                        <p class="text-sm text-blue-800 font-medium">Estadísticas del Rol</p>
                        <p class="text-sm text-blue-700">
                            Este rol tiene <strong>{{ $role->permissions->count() }}</strong> permisos asignados y está siendo usado por <strong>{{ $role->users->count() }}</strong> {{ $role->users->count() === 1 ? 'usuario' : 'usuarios' }}.
                        </p>
                    </div>
                </div>
            </div>
        </div>

        <div class="flex justify-end space-x-4">
            <a href="{{ route('roles.index') }}"
               class="px-6 py-3 border border-gray-300 text-gray-700 rounded-lg hover:bg-gray-50 font-medium transition-colors">
                Cancelar
            </a>
            <button type="submit"
                    class="px-6 py-3 bg-gradient-to-r from-purple-600 to-indigo-600 hover:from-purple-700 hover:to-indigo-700 text-white rounded-lg font-medium transition-all duration-200">
                Actualizar Rol
            </button>
        </div>
    </form>

    <script>
        function toggleModule(module) {
            const checkboxes = document.querySelectorAll('.module-' + module);
            const allChecked = Array.from(checkboxes).every(cb => cb.checked);

            checkboxes.forEach(checkbox => {
                checkbox.checked = !allChecked;
            });
        }
    </script>
@endsection
