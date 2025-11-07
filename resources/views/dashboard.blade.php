@extends('layouts.app')

@section('content')
    <div class="min-h-screen bg-gray-50 py-6">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <!-- Header del Dashboard -->
            <div class="mb-8">
                <div class="bg-white rounded-xl shadow-sm p-6 border border-gray-100">
                    <div class="flex flex-col lg:flex-row lg:items-center lg:justify-between">
                        <div class="mb-4 lg:mb-0">
                            <h1 class="text-3xl font-bold text-gray-900 mb-2">
                                <i class="fas fa-tachometer-alt mr-3 text-indigo-600"></i>
                                Dashboard Deckorativa
                            </h1>
                            <p class="text-lg text-gray-600">
                                <i class="fas fa-user-circle mr-2 text-gray-400"></i>
                                Bienvenido/a <span class="font-semibold">{{ Auth::user()->name }}</span>
                                @if(Auth::user()->getRoleNames()->count() > 0)
                                    <span class="ml-2 px-3 py-1 bg-indigo-100 text-indigo-800 rounded-full text-sm font-medium">
                                        {{ Auth::user()->getRoleNames()->first() }}
                                    </span>
                                @endif
                            </p>
                        </div>
                        <div class="flex flex-wrap gap-3">
                            <div class="flex items-center px-4 py-2 bg-green-50 border border-green-200 rounded-lg">
                                <i class="fas fa-circle mr-2 text-green-500 animate-pulse"></i>
                                <span class="text-green-700 font-medium">Sistema Online</span>
                            </div>
                            <div class="flex items-center px-4 py-2 bg-blue-50 border border-blue-200 rounded-lg">
                                <i class="fas fa-clock mr-2 text-blue-500"></i>
                                <span class="text-blue-700 font-medium">{{ now()->format('H:i') }}</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Estadísticas Principales -->
            <div class="mb-8">
                <h2 class="text-xl font-semibold text-gray-900 mb-4">Estadísticas Generales</h2>
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
                    <!-- Total Usuarios -->
                    <div class="bg-white rounded-xl shadow-sm hover:shadow-md transition-shadow duration-300 border border-gray-100">
                        <div class="p-6">
                            <div class="flex items-center">
                                <div class="flex-shrink-0">
                                    <div class="w-12 h-12 bg-gradient-to-r from-blue-500 to-blue-600 rounded-xl flex items-center justify-center">
                                        <i class="fas fa-users text-white text-xl"></i>
                                    </div>
                                </div>
                                <div class="ml-4 flex-1">
                                    <p class="text-sm font-medium text-gray-600">Total Usuarios</p>
                                    <p class="text-3xl font-bold text-gray-900">{{ $totalUsuarios ?? 0 }}</p>
                                    <p class="text-sm text-blue-600 font-medium mt-1">
                                        <i class="fas fa-arrow-up mr-1"></i>
                                        Usuarios activos
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Total Clientes -->
                    <div class="bg-white rounded-xl shadow-sm hover:shadow-md transition-shadow duration-300 border border-gray-100">
                        <div class="p-6">
                            <div class="flex items-center">
                                <div class="flex-shrink-0">
                                    <div class="w-12 h-12 bg-gradient-to-r from-green-500 to-green-600 rounded-xl flex items-center justify-center">
                                        <i class="fas fa-handshake text-white text-xl"></i>
                                    </div>
                                </div>
                                <div class="ml-4 flex-1">
                                    <p class="text-sm font-medium text-gray-600">Total Clientes</p>
                                    <p class="text-3xl font-bold text-gray-900">{{ $totalClientes ?? 0 }}</p>
                                    <p class="text-sm text-green-600 font-medium mt-1">
                                        <i class="fas fa-plus mr-1"></i>
                                        Base de clientes
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Total Productos -->
                    <div class="bg-white rounded-xl shadow-sm hover:shadow-md transition-shadow duration-300 border border-gray-100">
                        <div class="p-6">
                            <div class="flex items-center">
                                <div class="flex-shrink-0">
                                    <div class="w-12 h-12 bg-gradient-to-r from-purple-500 to-purple-600 rounded-xl flex items-center justify-center">
                                        <i class="fas fa-box text-white text-xl"></i>
                                    </div>
                                </div>
                                <div class="ml-4 flex-1">
                                    <p class="text-sm font-medium text-gray-600">Total Productos</p>
                                    <p class="text-3xl font-bold text-gray-900">{{ $totalProductos ?? 0 }}</p>
                                    <p class="text-sm text-purple-600 font-medium mt-1">
                                        <i class="fas fa-list mr-1"></i>
                                        En catálogo
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Total Cotizaciones -->
                    <div class="bg-white rounded-xl shadow-sm hover:shadow-md transition-shadow duration-300 border border-gray-100">
                        <div class="p-6">
                            <div class="flex items-center">
                                <div class="flex-shrink-0">
                                    <div class="w-12 h-12 bg-gradient-to-r from-orange-500 to-orange-600 rounded-xl flex items-center justify-center">
                                        <i class="fas fa-file-invoice-dollar text-white text-xl"></i>
                                    </div>
                                </div>
                                <div class="ml-4 flex-1">
                                    <p class="text-sm font-medium text-gray-600">Cotizaciones</p>
                                    <p class="text-3xl font-bold text-gray-900">{{ $totalCotizaciones ?? 0 }}</p>
                                    <p class="text-sm text-orange-600 font-medium mt-1">
                                        <i class="fas fa-chart-line mr-1"></i>
                                        Este mes
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- NUEVAS TARJETAS: Cotizaciones por Estado, Pedidos por Estado, Resumen General -->
            <div class="mb-8">
                <h2 class="text-xl font-semibold text-gray-900 mb-4">Análisis Detallado</h2>
                <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                    
                    <!-- Cotizaciones por Estado -->
                    <div class="bg-white rounded-xl shadow-sm border border-gray-100">
                        <div class="p-6 border-b border-gray-100">
                            <h3 class="text-lg font-semibold text-gray-900 flex items-center">
                                <i class="fas fa-file-invoice mr-2 text-indigo-600"></i>
                                Cotizaciones por Estado
                            </h3>
                        </div>
                        <div class="p-6">
                            <div class="space-y-4"> 
                                <!-- Enviada -->
                                <div class="flex items-center justify-between p-3 bg-blue-50 rounded-lg border border-blue-200">
                                    <div class="flex items-center">
                                        <div class="w-10 h-10 bg-blue-500 rounded-lg flex items-center justify-center">
                                            <i class="fas fa-paper-plane text-white"></i>
                                        </div>
                                        <div class="ml-3">
                                            <p class="text-sm font-medium text-gray-700">Pendiente</p>
                                        </div>
                                    </div>
                                    <span class="text-2xl font-bold text-blue-700">{{ $cotizacionesPorEstado['enviada'] ?? 0 }}</span>
                                </div>

                                <!-- Aprobada -->
                                <div class="flex items-center justify-between p-3 bg-green-50 rounded-lg border border-green-200">
                                    <div class="flex items-center">
                                        <div class="w-10 h-10 bg-green-500 rounded-lg flex items-center justify-center">
                                            <i class="fas fa-check-circle text-white"></i>
                                        </div>
                                        <div class="ml-3">
                                            <p class="text-sm font-medium text-gray-700">Aprobada</p>
                                        </div>
                                    </div>
                                    <span class="text-2xl font-bold text-green-700">{{ $cotizacionesPorEstado['aprobada'] ?? 0 }}</span>
                                </div>

                                <!-- Rechazada -->
                                <div class="flex items-center justify-between p-3 bg-red-50 rounded-lg border border-red-200">
                                    <div class="flex items-center">
                                        <div class="w-10 h-10 bg-red-500 rounded-lg flex items-center justify-center">
                                            <i class="fas fa-times-circle text-white"></i>
                                        </div>
                                        <div class="ml-3">
                                            <p class="text-sm font-medium text-gray-700">Rechazada</p>
                                            <p class="text-xs text-gray-500">No aprobada</p>
                                        </div>
                                    </div>
                                    <span class="text-2xl font-bold text-red-700">{{ $cotizacionesPorEstado['rechazada'] ?? 0 }}</span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Pedidos por Estado -->
                    <div class="bg-white rounded-xl shadow-sm border border-gray-100">
                        <div class="p-6 border-b border-gray-100">
                            <h3 class="text-lg font-semibold text-gray-900 flex items-center">
                                <i class="fas fa-shopping-cart mr-2 text-purple-600"></i>
                                Pedidos por Estado
                            </h3>
                        </div>
                        <div class="p-6">
                            <div class="space-y-4">
                                <!-- Pendiente -->
                                <div class="flex items-center justify-between p-3 bg-orange-50 rounded-lg border border-orange-200">
                                    <div class="flex items-center">
                                        <div class="w-10 h-10 bg-orange-500 rounded-lg flex items-center justify-center">
                                            <i class="fas fa-clock text-white"></i>
                                        </div>
                                        <div class="ml-3">
                                            <p class="text-sm font-medium text-gray-700">Pendiente</p>
                                        </div>
                                    </div>
                                    <span class="text-2xl font-bold text-orange-700">{{ $pedidosPorEstado['pendiente'] ?? 0  }}</span>
                                </div>

                                <!-- En Proceso -->
                                <div class="flex items-center justify-between p-3 bg-cyan-50 rounded-lg border border-cyan-200">
                                    <div class="flex items-center">
                                        <div class="w-10 h-10 bg-cyan-500 rounded-lg flex items-center justify-center">
                                            <i class="fas fa-cog text-white"></i>
                                        </div>
                                        <div class="ml-3">
                                            <p class="text-sm font-medium text-gray-700">En Proceso</p>
                                        </div>
                                    </div>
                                    <span class="text-2xl font-bold text-cyan-700">{{ $pedidosPorEstado['procesando'] ?? 0 }}</span>
                                </div>

                                <!-- Completado -->
                                <div class="flex items-center justify-between p-3 bg-emerald-50 rounded-lg border border-emerald-200">
                                    <div class="flex items-center">
                                        <div class="w-10 h-10 bg-green-500 rounded-lg flex items-center justify-center">
                                            <i class="fas fa-check-circle text-white"></i>
                                        </div>
                                        <div class="ml-3">
                                            <p class="text-sm font-medium text-gray-700">Completado</p>
                                        </div>
                                    </div>
                                    <span class="text-2xl font-bold text-emerald-700">{{ $pedidosPorEstado['completado'] ?? 0 }}</span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Resumen General -->
                    <div class="bg-white rounded-xl shadow-sm border border-gray-100">
                        <div class="p-6 border-b border-gray-100">
                            <h3 class="text-lg font-semibold text-gray-900 flex items-center">
                                <i class="fas fa-chart-pie mr-2 text-teal-600"></i>
                                Resumen General
                            </h3>
                        </div>
                        <div class="p-6">
                            <div class="space-y-4">
                                <!-- Usuarios -->
                                <div class="flex items-center justify-between p-3 bg-gradient-to-r from-blue-50 to-blue-100 rounded-lg border border-blue-200">
                                    <div class="flex items-center">
                                        <div class="w-10 h-10 bg-blue-600 rounded-lg flex items-center justify-center shadow-md">
                                            <i class="fas fa-users text-white"></i>
                                        </div>
                                        <span class="ml-3 text-sm font-semibold text-gray-700">Usuarios</span>
                                    </div>
                                    <span class="text-2xl font-bold text-blue-700">{{ $totalUsuarios ?? 0 }}</span>
                                </div>

                                <!-- Productos -->
                                <div class="flex items-center justify-between p-3 bg-gradient-to-r from-purple-50 to-purple-100 rounded-lg border border-purple-200">
                                    <div class="flex items-center">
                                        <div class="w-10 h-10 bg-purple-600 rounded-lg flex items-center justify-center shadow-md">
                                            <i class="fas fa-box text-white"></i>
                                        </div>
                                        <span class="ml-3 text-sm font-semibold text-gray-700">Pedidos</span>
                                    </div>
                                    <span class="text-2xl font-bold text-purple-700">{{ $totalPedidos ?? 0 }}</span>
                                </div>

                                <div class="flex items-center justify-between p-3 bg-gradient-to-r from-green-50 to-green-100 rounded-lg border border-green-200">
                                    <div class="flex items-center">
                                        <div class="w-10 h-10 bg-green-600 rounded-lg flex items-center justify-center shadow-md">
                                            <i class="fas fa-box text-white"></i>
                                        </div>
                                        <span class="ml-3 text-sm font-semibold text-gray-700">Pagos</span>
                                    </div>
                                    <span class="text-2xl font-bold text-green-700">{{ $totalPagos ?? 0 }}</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Gráfica y Acciones Rápidas -->
            <div class="grid grid-cols-1 xl:grid-cols-3 gap-8 mb-8">
                <!-- Gráfica de Cotizaciones -->
                <div class="xl:col-span-2">
                    <div class="bg-white rounded-xl shadow-sm border border-gray-100">
                        <div class="p-6 border-b border-gray-100">
                            <h3 class="text-lg font-semibold text-gray-900 flex items-center">
                                <i class="fas fa-chart-area mr-2 text-cyan-600"></i>
                                Evolución de Cotizaciones
                            </h3>
                            <div class="flex items-center space-x-4 mt-2">
                                <button id="btnCantidad" class="px-3 py-1 text-sm bg-cyan-100 text-cyan-700 rounded-md font-medium chart-toggle active">
                                    Cantidad
                                </button>
                            </div>
                        </div>
                        <div class="p-6">
                            <div style="height: 320px; min-height: 320px; position: relative;">
                                <canvas id="cotizacionesChart"></canvas>
                            </div>
                        </div>
                    </div>
                </div>
                
                <!-- Acciones Rápidas -->
                <div class="xl:col-span-1">
                    <div class="bg-white rounded-xl shadow-sm border border-gray-100">
                        <div class="p-6 border-b border-gray-100">
                            <h3 class="text-lg font-semibold text-gray-900 flex items-center">
                                <i class="fas fa-bolt mr-2 text-yellow-500"></i>
                                Acciones Rápidas
                            </h3>
                        </div>
                        <div class="p-6 space-y-4">
                            @can('create users')
                            <a href="{{ route('usuarios.create') }}" class="flex items-center justify-center w-full px-4 py-3 bg-blue-600 hover:bg-blue-700 text-white font-medium rounded-lg transition-colors duration-200">
                                <i class="fas fa-user-plus mr-2"></i>
                                Nuevo Usuario
                            </a>
                            @endcan

                            @can('create clients')
                            <a href="{{ route('clients.create') }}" class="flex items-center justify-center w-full px-4 py-3 bg-green-600 hover:bg-green-700 text-white font-medium rounded-lg transition-colors duration-200">
                                <i class="fas fa-handshake mr-2"></i>
                                Nuevo Cliente
                            </a>
                            @endcan

                            @can('create productos')
                            <a href="{{ route('productos.create') }}" class="flex items-center justify-center w-full px-4 py-3 bg-purple-600 hover:bg-purple-700 text-white font-medium rounded-lg transition-colors duration-200">
                                <i class="fas fa-plus-circle mr-2"></i>
                                Nuevo Producto
                            </a>
                            @endcan

                            @can('create roles')
                            <a href="{{ route('roles.create') }}" class="flex items-center justify-center w-full px-4 py-3 bg-gray-600 hover:bg-gray-700 text-white font-medium rounded-lg transition-colors duration-200">
                                <i class="fas fa-shield-alt mr-2"></i>
                                Nuevo Rol
                            </a>
                            @endcan

                            @if(!auth()->user()->can('create users') && !auth()->user()->can('create clients') && !auth()->user()->can('create roles'))
                            <div class="text-center py-8">
                                <div class="w-16 h-16 bg-gray-100 rounded-full flex items-center justify-center mx-auto mb-4">
                                    <i class="fas fa-eye text-2xl text-gray-400"></i>
                                </div>
                                <p class="text-gray-600 font-medium mb-1">Permisos de Lectura</p>
                                <p class="text-sm text-gray-500 mb-4">{{ Auth::user()->getRoleNames()->first() ?? 'Sin rol' }}</p>
                                <div class="space-y-2">
                                    @can('view clients')
                                    <a href="{{ route('clients.index') }}" class="flex items-center justify-center w-full px-4 py-2 border border-gray-300 text-gray-700 font-medium rounded-lg hover:bg-gray-50 transition-colors duration-200">
                                        <i class="fas fa-handshake mr-2"></i>
                                        Ver Clientes
                                    </a>
                                    @endcan
                                    @can('view users')
                                    <a href="{{ route('usuarios.index') }}" class="flex items-center justify-center w-full px-4 py-2 border border-gray-300 text-gray-700 font-medium rounded-lg hover:bg-gray-50 transition-colors duration-200">
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
            </div>

            <!-- Estado del Sistema -->
            <div class="mb-8">
                <div class="bg-white rounded-xl shadow-sm border border-gray-100">
                    <div class="p-6 border-b border-gray-100">
                        <div class="flex items-center justify-between">
                            <h3 class="text-lg font-semibold text-gray-900 flex items-center">
                                <i class="fas fa-server mr-2 text-green-500"></i>
                                Estado del Sistema
                            </h3>
                            <div class="flex items-center px-3 py-1 bg-green-100 text-green-800 rounded-full text-sm font-medium">
                                <i class="fas fa-check-circle mr-1"></i>
                                Todos los servicios operativos
                            </div>
                        </div>
                    </div>
                    <div class="p-6">
                        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
                            <!-- Base de Datos -->
                            <div class="text-center p-6 bg-green-50 rounded-xl border border-green-200">
                                <div class="w-14 h-14 bg-green-500 rounded-xl flex items-center justify-center mx-auto mb-4">
                                    <i class="fas fa-database text-white text-xl"></i>
                                </div>
                                <h4 class="font-semibold text-gray-900 text-lg mb-1">Base de Datos</h4>
                                <p class="text-sm text-gray-600 mb-3">MySQL</p>
                                <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                    <i class="fas fa-circle mr-1 text-green-500 animate-pulse"></i>
                                    Conectada
                                </span>
                            </div>

                            <!-- Servidor Web -->
                            <div class="text-center p-6 bg-blue-50 rounded-xl border border-blue-200">
                                <div class="w-14 h-14 bg-blue-500 rounded-xl flex items-center justify-center mx-auto mb-4">
                                    <i class="fas fa-globe text-white text-xl"></i>
                                </div>
                                <h4 class="font-semibold text-gray-900 text-lg mb-1">Servidor Web</h4>
                                <p class="text-sm text-gray-600 mb-3">Laravel 10.x</p>
                                <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium bg-blue-100 text-blue-800">
                                    <i class="fas fa-circle mr-1 text-blue-500 animate-pulse"></i>
                                    Activo
                                </span>
                            </div>

                            <!-- Autenticación -->
                            <div class="text-center p-6 bg-purple-50 rounded-xl border border-purple-200">
                                <div class="w-14 h-14 bg-purple-500 rounded-xl flex items-center justify-center mx-auto mb-4">
                                    <i class="fas fa-lock text-white text-xl"></i>
                                </div>
                                <h4 class="font-semibold text-gray-900 text-lg mb-1">Seguridad</h4>
                                <p class="text-sm text-gray-600 mb-3">Sistema protegido</p>
                                <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium bg-purple-100 text-purple-800">
                                    <i class="fas fa-shield-alt mr-1 text-purple-500"></i>
                                    Seguro
                                </span>
                            </div>

                            <!-- Almacenamiento -->
                            <div class="text-center p-6 bg-yellow-50 rounded-xl border border-yellow-200">
                                <div class="w-14 h-14 bg-yellow-500 rounded-xl flex items-center justify-center mx-auto mb-4">
                                    <i class="fas fa-hdd text-white text-xl"></i>
                                </div>
                                <h4 class="font-semibold text-gray-900 text-lg mb-1">Almacenamiento</h4>
                                <p class="text-sm text-gray-600 mb-3">Archivos</p>
                                <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium bg-yellow-100 text-yellow-800">
                                    <i class="fas fa-check mr-1 text-yellow-500"></i>
                                    Disponible
                                </span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Información del Sistema -->
            <div class="bg-white rounded-xl shadow-sm border border-gray-100">
                <div class="p-6 border-b border-gray-100">
                    <h3 class="text-lg font-semibold text-gray-900 flex items-center">
                        <i class="fas fa-info-circle mr-2 text-blue-500"></i>
                        Información del Sistema
                    </h3>
                </div>
                <div class="p-6">
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                        <div class="flex items-center space-x-4 p-4 bg-gray-50 rounded-lg">
                            <div class="w-12 h-12 bg-red-100 rounded-xl flex items-center justify-center flex-shrink-0">
                                <i class="fas fa-code text-red-600 text-xl"></i>
                            </div>
                            <div>
                                <p class="text-sm text-gray-600">Versión Laravel</p>
                                <p class="font-semibold text-gray-900 text-lg">10.x</p>
                            </div>
                        </div>
                        <div class="flex items-center space-x-4 p-4 bg-gray-50 rounded-lg">
                            <div class="w-12 h-12 bg-blue-100 rounded-xl flex items-center justify-center flex-shrink-0">
                                <i class="fab fa-php text-blue-600 text-xl"></i>
                            </div>
                            <div>
                                <p class="text-sm text-gray-600">Versión PHP</p>
                                <p class="font-semibold text-gray-900 text-lg">8.4</p>
                            </div>
                        </div>
                        <div class="flex items-center space-x-4 p-4 bg-gray-50 rounded-lg">
                            <div class="w-12 h-12 bg-green-100 rounded-xl flex items-center justify-center flex-shrink-0">
                                <i class="fas fa-calendar text-green-600 text-xl"></i>
                            </div>
                            <div>
                                <p class="text-sm text-gray-600">Última actualización</p>
                                <p class="font-semibold text-gray-900 text-lg">{{ now()->format('d/m/Y') }}</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('styles')
<style>
/* Variables CSS */
:root {
    --primary-color: #6366f1;
    --primary-dark: #4f46e5;
    --secondary-color: #8b5cf6;
    --success-color: #10b981;
    --warning-color: #f59e0b;
    --danger-color: #ef4444;
    --info-color: #06b6d4;
}

/* Animaciones suaves */
.hover\:shadow-md:hover {
    box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1), 0 4px 6px -2px rgba(0, 0, 0, 0.05);
}

button, a {
    transition: all 0.2s ease-in-out;
}

.chart-toggle {
    transition: all 0.2s ease;
}

.chart-toggle:hover {
    transform: translateY(-1px);
}

/* Responsive adjustments */
@media (max-width: 640px) {
    .grid {
        gap: 1rem;
    }
    
    .p-6 {
        padding: 1rem;
    }
    
    .text-3xl {
        font-size: 1.875rem;
    }
}

@media (max-width: 480px) {
    .text-3xl {
        font-size: 1.5rem;
    }
    
    .w-12.h-12 {
        width: 2.5rem;
        height: 2.5rem;
    }
    
    .text-xl {
        font-size: 1rem;
    }
}

/* FIX IMPORTANTE: Canvas de la gráfica */
#cotizacionesChart {
    width: 100% !important;
    height: 100% !important;
}

/* Estilos para las nuevas tarjetas */
.space-y-4 > * + * {
    margin-top: 1rem;
}

/* Animación de pulse para indicadores */
@keyframes pulse {
    0%, 100% {
        opacity: 1;
    }
    50% {
        opacity: .5;
    }
}

.animate-pulse {
    animation: pulse 2s cubic-bezier(0.4, 0, 0.6, 1) infinite;
}
</style>
@endpush

@push('scripts')
<!-- Chart.js Script -->
<script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.0/dist/chart.umd.min.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Datos del controlador
    const meses = @json($meses ?? []);
    const datosCantidad = @json($datosCotizaciones ?? []);
    const datosValores = @json($valoresCotizaciones ?? []);
    const datosEstados = @json(array_values($cotizacionesPorEstado ?? []));

    // Gráfica principal
    const ctx = document.getElementById('cotizacionesChart');
    
    if (ctx) {
        let cotizacionesChart = new Chart(ctx.getContext('2d'), {
            type: 'line',
            data: {
                labels: meses,
                datasets: [{
                    label: 'Cotizaciones',
                    data: datosCantidad,
                    borderColor: '#06B6D4',
                    backgroundColor: 'rgba(6, 182, 212, 0.1)',
                    borderWidth: 3,
                    fill: true,
                    tension: 0.4,
                    pointBackgroundColor: '#06B6D4',
                    pointBorderColor: '#fff',
                    pointBorderWidth: 2,
                    pointRadius: 6
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: { 
                        display: false 
                    },
                    tooltip: {
                        enabled: true,
                        backgroundColor: 'rgba(0, 0, 0, 0.8)',
                        titleColor: '#fff',
                        bodyColor: '#fff',
                        borderColor: '#06B6D4',
                        borderWidth: 1
                    }
                },
                scales: {
                    x: {
                        grid: { 
                            display: false 
                        },
                        ticks: { 
                            color: '#6B7280',
                            font: {
                                size: 12
                            }
                        }
                    },
                    y: {
                        beginAtZero: true,
                        grid: { 
                            color: 'rgba(0,0,0,0.1)' 
                        },
                        ticks: { 
                            color: '#6B7280',
                            font: {
                                size: 12
                            }
                        }
                    }
                }
            }
        });

        // Alternar entre cantidad y valores
        function toggleChart(tipo) {
            const buttons = document.querySelectorAll('.chart-toggle');
            buttons.forEach(btn => {
                btn.classList.remove('active', 'bg-cyan-100', 'text-cyan-700');
                btn.classList.add('bg-gray-100', 'text-gray-600');
            });

            if (tipo === 'cantidad') {
                const btnCantidad = document.getElementById('btnCantidad');
                if (btnCantidad) {
                    btnCantidad.classList.add('active', 'bg-cyan-100', 'text-cyan-700');
                    btnCantidad.classList.remove('bg-gray-100', 'text-gray-600');
                }
                
                cotizacionesChart.data.datasets[0].data = datosCantidad;
                cotizacionesChart.data.datasets[0].label = 'Cantidad de Cotizaciones';
                cotizacionesChart.options.scales.y.ticks.callback = function(value) {
                    return value;
                };
            } else {
                const btnValores = document.getElementById('btnValores');
                if (btnValores) {
                    btnValores.classList.add('active', 'bg-cyan-100', 'text-cyan-700');
                    btnValores.classList.remove('bg-gray-100', 'text-gray-600');
                }
                
                cotizacionesChart.data.datasets[0].data = datosValores;
                cotizacionesChart.data.datasets[0].label = 'Valores en Quetzales';
                cotizacionesChart.options.scales.y.ticks.callback = function(value) {
                    return 'Q' + value.toLocaleString();
                };
            }
            cotizacionesChart.update();
        }

        // Event listeners
        const btnCantidad = document.getElementById('btnCantidad');
        const btnValores = document.getElementById('btnValores');
        
        if (btnCantidad) {
            btnCantidad.addEventListener('click', () => toggleChart('cantidad'));
        }
        
        if (btnValores) {
            btnValores.addEventListener('click', () => toggleChart('valores'));
        }
    }
});
</script>
@endpush