@extends('layouts.app')

@section('content')
    <div class="animate-slideInUp">
        <div class="page-header">
            <div class="flex flex-col lg:flex-row lg:items-center lg:justify-between">
                <div>
                    <h1 class="page-title text-gradient">
                        <i class="fas fa-tachometer-alt mr-3"></i>
                        Dashboard Deckorativa
                    </h1>
                    <p class="page-subtitle">
                        <i class="fas fa-user-circle mr-2"></i>
                        Bienvenido/a {{ Auth::user()->name }}, {{ Auth::user()->getRoleNames()->count() > 0 ? 'rol: ' . Auth::user()->getRoleNames()->first() : 'usuario del sistema' }}
                    </p>
                </div>
                <div class="mt-4 lg:mt-0 flex space-x-3">
                    <div class="badge badge-success">
                        <i class="fas fa-circle mr-2 animate-pulse"></i>
                        Sistema Online
                    </div>
                    <div class="badge badge-info">
                        <i class="fas fa-clock mr-2"></i>
                        {{ now()->format('H:i') }}
                    </div>
                </div>
            </div>
        </div>

        <!-- Estadísticas Principales -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
            <!-- Total Usuarios -->
            <div class="stat-card">
                <div class="flex items-center justify-between">
                    <div>
                        <div class="stat-icon bg-gradient-to-r from-blue-500 to-blue-600">
                            <i class="fas fa-users"></i>
                        </div>
                        <p class="stat-title">Total Usuarios</p>
                        <p class="stat-value">{{ $totalUsuarios }}</p>
                        <p class="text-xs text-blue-600 font-medium">
                            <i class="fas fa-arrow-up mr-1"></i>
                            Usuarios activos
                        </p>
                    </div>
                </div>
            </div>

            <!-- Total Clientes -->
            <div class="stat-card">
                <div class="flex items-center justify-between">
                    <div>
                        <div class="stat-icon bg-gradient-to-r from-green-500 to-green-600">
                            <i class="fas fa-handshake"></i>
                        </div>
                        <p class="stat-title">Total Clientes</p>
                        <p class="stat-value">{{ $totalClientes }}</p>
                        <p class="text-xs text-green-600 font-medium">
                            <i class="fas fa-plus mr-1"></i>
                            Base de clientes
                        </p>
                    </div>
                </div>
            </div>

            <!-- Total Productos -->
            <div class="stat-card">
                <div class="flex items-center justify-between">
                    <div>
                        <div class="stat-icon bg-gradient-to-r from-purple-500 to-purple-600">
                            <i class="fas fa-box"></i>
                        </div>
                        <p class="stat-title">Total Productos</p>
                        <p class="stat-value">{{ $totalProductos }}</p>
                        <p class="text-xs text-purple-600 font-medium">
                            <i class="fas fa-inventory mr-1"></i>
                            En catálogo
                        </p>
                    </div>
                </div>
            </div>

            <!-- Total Cotizaciones -->
            <div class="stat-card">
                <div class="flex items-center justify-between">
                    <div>
                        <div class="stat-icon bg-gradient-to-r from-orange-500 to-orange-600">
                            <i class="fas fa-file-invoice-dollar"></i>
                        </div>
                        <p class="stat-title">Cotizaciones</p>
                        <p class="stat-value">{{ $totalCotizaciones }}</p>
                        <p class="text-xs text-orange-600 font-medium">
                            <i class="fas fa-chart-line mr-1"></i>
                            Este mes
                        </p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Gráfica y Acciones Rápidas -->
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8 mb-8">
            <!-- Gráfica de Cotizaciones -->
            <div class="lg:col-span-2 card">
                <div class="card-header">
                    <h3 class="text-lg font-semibold text-gray-900 flex items-center">
                        <i class="fas fa-chart-area mr-2 text-cyan-600"></i>
                        Evolución de Cotizaciones
                    </h3>
                </div>
                <div class="card-body">
                    <div class="h-64 flex items-center justify-center bg-gradient-to-br from-gray-50 to-gray-100 rounded-lg">
                        <div class="text-center">
                            <i class="fas fa-chart-line text-4xl text-gray-400 mb-4"></i>
                            <p class="text-gray-600 font-medium">Gráfica de Cotizaciones</p>
                            <p class="text-sm text-gray-500 mt-2">Los datos se mostrarán aquí cuando haya información disponible</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Acciones Rápidas -->
            <div class="card">
                <div class="card-header">
                    <h3 class="text-lg font-semibold text-gray-900 flex items-center">
                        <i class="fas fa-bolt mr-2 text-yellow-500"></i>
                        Acciones Rápidas
                    </h3>
                </div>
                <div class="card-body space-y-4">
                    @can('create users')
                    <a href="{{ route('usuarios.create') }}" class="btn-primary w-full">
                        <i class="fas fa-user-plus mr-2"></i>
                        Nuevo Usuario
                    </a>
                    @endcan

                    @can('create clients')
                    <a href="{{ route('clients.create') }}" class="btn-success w-full">
                        <i class="fas fa-handshake mr-2"></i>
                        Nuevo Cliente
                    </a>
                    @endcan

                    @can('create productos')
                    <a href="{{ route('productos.create') }}" class="btn-secondary w-full">
                        <i class="fas fa-plus-circle mr-2"></i>
                        Nuevo Producto
                    </a>
                    @endcan

                    @can('create roles')
                    <a href="{{ route('roles.create') }}" class="btn-outline w-full">
                        <i class="fas fa-shield-alt mr-2"></i>
                        Nuevo Rol
                    </a>
                    @endcan

                    @if(!auth()->user()->can('create users') && !auth()->user()->can('create clients') && !auth()->user()->can('create roles'))
                    <div class="text-center py-8">
                        <div class="w-16 h-16 bg-gray-100 rounded-full flex items-center justify-center mx-auto mb-4">
                            <i class="fas fa-lock text-2xl text-gray-400"></i>
                        </div>
                        <p class="text-gray-600 font-medium">Solo tienes permisos de lectura</p>
                        <p class="text-sm text-gray-500 mt-1">Tu rol actual: {{ Auth::user()->getRoleNames()->first() ?? 'Sin rol' }}</p>
                        <div class="mt-4 space-y-2">
                            @can('view clients')
                            <a href="{{ route('clients.index') }}" class="btn-outline w-full">
                                <i class="fas fa-handshake mr-2"></i>
                                Ver Clientes
                            </a>
                            @endcan
                            @can('view users')
                            <a href="{{ route('usuarios.index') }}" class="btn-outline w-full">
                                <i class="fas fa-users mr-2"></i>
                                Ver Usuarios
                            </a>
                            @endcan
                        </div>
                    </div>
                    @endif
                </div>
            </div>
        </div>

        <!-- Estado del Sistema -->
        <div class="card mb-8">
            <div class="card-header">
                <h3 class="text-lg font-semibold text-gray-900 flex items-center">
                    <i class="fas fa-server mr-2 text-green-500"></i>
                    Estado del Sistema
                </h3>
                <div class="badge badge-success">
                    <i class="fas fa-check-circle mr-1"></i>
                    Todos los servicios operativos
                </div>
            </div>
            <div class="card-body">
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
                    <!-- Base de Datos -->
                    <div class="text-center p-4 bg-green-50 rounded-lg border border-green-200">
                        <div class="w-12 h-12 bg-green-500 rounded-xl flex items-center justify-center mx-auto mb-3">
                            <i class="fas fa-database text-white text-xl"></i>
                        </div>
                        <h4 class="font-semibold text-gray-900">Base de Datos</h4>
                        <p class="text-sm text-gray-600">MySQL</p>
                        <div class="mt-2">
                            <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                <i class="fas fa-circle mr-1 text-green-500 animate-pulse"></i>
                                Conectada
                            </span>
                        </div>
                    </div>

                    <!-- Servidor Web -->
                    <div class="text-center p-4 bg-blue-50 rounded-lg border border-blue-200">
                        <div class="w-12 h-12 bg-blue-500 rounded-xl flex items-center justify-center mx-auto mb-3">
                            <i class="fas fa-globe text-white text-xl"></i>
                        </div>
                        <h4 class="font-semibold text-gray-900">Servidor Web</h4>
                        <p class="text-sm text-gray-600">Laravel 10.x</p>
                        <div class="mt-2">
                            <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-blue-100 text-blue-800">
                                <i class="fas fa-circle mr-1 text-blue-500 animate-pulse"></i>
                                Activo
                            </span>
                        </div>
                    </div>

                    <!-- Autenticación -->
                    <div class="text-center p-4 bg-purple-50 rounded-lg border border-purple-200">
                        <div class="w-12 h-12 bg-purple-500 rounded-xl flex items-center justify-center mx-auto mb-3">
                            <i class="fas fa-lock text-white text-xl"></i>
                        </div>
                        <h4 class="font-semibold text-gray-900">Seguridad</h4>
                        <p class="text-sm text-gray-600">Sistema protegido</p>
                        <div class="mt-2">
                            <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-purple-100 text-purple-800">
                                <i class="fas fa-shield-alt mr-1 text-purple-500"></i>
                                Seguro
                            </span>
                        </div>
                    </div>

                    <!-- Almacenamiento -->
                    <div class="text-center p-4 bg-yellow-50 rounded-lg border border-yellow-200">
                        <div class="w-12 h-12 bg-yellow-500 rounded-xl flex items-center justify-center mx-auto mb-3">
                            <i class="fas fa-hdd text-white text-xl"></i>
                        </div>
                        <h4 class="font-semibold text-gray-900">Almacenamiento</h4>
                        <p class="text-sm text-gray-600">Archivos</p>
                        <div class="mt-2">
                            <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-yellow-100 text-yellow-800">
                                <i class="fas fa-check mr-1 text-yellow-500"></i>
                                Disponible
                            </span>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Información del Sistema -->
        <div class="card">
            <div class="card-header">
                <h3 class="text-lg font-semibold text-gray-900 flex items-center">
                    <i class="fas fa-info-circle mr-2 text-blue-500"></i>
                    Información del Sistema
                </h3>
            </div>
            <div class="card-body">
                <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                    <div class="flex items-center space-x-3">
                        <div class="w-10 h-10 bg-red-100 rounded-lg flex items-center justify-center">
                            <i class="fas fa-code text-red-600"></i>
                        </div>
                        <div>
                            <p class="text-sm text-gray-600">Versión Laravel</p>
                            <p class="font-semibold text-gray-900">10.x</p>
                        </div>
                    </div>
                    <div class="flex items-center space-x-3">
                        <div class="w-10 h-10 bg-blue-100 rounded-lg flex items-center justify-center">
                            <i class="fab fa-php text-blue-600"></i>
                        </div>
                        <div>
                            <p class="text-sm text-gray-600">Versión PHP</p>
                            <p class="font-semibold text-gray-900">8.4</p>
                        </div>
                    </div>
                    <div class="flex items-center space-x-3">
                        <div class="w-10 h-10 bg-green-100 rounded-lg flex items-center justify-center">
                            <i class="fas fa-calendar text-green-600"></i>
                        </div>
                        <div>
                            <p class="text-sm text-gray-600">Última actualización</p>
                            <p class="font-semibold text-gray-900">{{ now()->format('d/m/Y') }}</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
