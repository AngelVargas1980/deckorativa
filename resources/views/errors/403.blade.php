@extends('layouts.app')

@section('content')
    <div class="animate-slideInUp max-w-3xl mx-auto text-center">
        <div class="mb-8">
            <div class="w-24 h-24 bg-gradient-to-r from-red-500 to-red-600 rounded-full flex items-center justify-center mx-auto shadow-lg">
                <i class="fas fa-ban text-white text-4xl"></i>
            </div>
        </div>

        <div class="card">
            <div class="card-body text-center py-12">
                <h1 class="text-3xl font-bold text-gray-900 mb-4">
                    <i class="fas fa-exclamation-triangle text-red-500 mr-3"></i>
                    Acceso Denegado
                </h1>

                <p class="text-lg text-gray-700 mb-6">
                    Lo sentimos, no tienes permisos para acceder a esta sección del sistema.
                </p>

                <div class="bg-gray-50 rounded-lg p-6 mb-8 inline-block">
                    <div class="flex items-center justify-center space-x-4">
                        <div class="w-12 h-12 bg-gradient-to-r from-blue-500 to-blue-600 rounded-full flex items-center justify-center">
                            <span class="text-white font-bold">
                                {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}
                            </span>
                        </div>
                        <div class="text-left">
                            <p class="font-semibold text-gray-900">{{ Auth::user()->name }}</p>
                            <p class="text-sm text-gray-600">
                                Rol: {{ Auth::user()->getRoleNames()->first() ?? 'Sin rol asignado' }}
                            </p>
                        </div>
                    </div>
                </div>

                <div class="space-y-4">
                    <h3 class="text-lg font-semibold text-gray-900 mb-4">
                        <i class="fas fa-lightbulb text-yellow-500 mr-2"></i>
                        ¿Qué puedes hacer?
                    </h3>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        @can('view clients')
                        <a href="{{ route('clients.index') }}" class="btn-outline">
                            <i class="fas fa-handshake mr-2"></i>
                            Ver Clientes
                        </a>
                        @endcan

                        @can('view users')
                        <a href="{{ route('usuarios.index') }}" class="btn-outline">
                            <i class="fas fa-users mr-2"></i>
                            Ver Usuarios
                        </a>
                        @endcan

                        @can('view roles')
                        <a href="{{ route('roles.index') }}" class="btn-outline">
                            <i class="fas fa-shield-alt mr-2"></i>
                            Ver Roles
                        </a>
                        @endcan
                    </div>

                    <div class="mt-6 pt-6 border-t border-gray-200">
                        <a href="{{ route('dashboard') }}" class="btn-primary">
                            <i class="fas fa-home mr-2"></i>
                            Volver al Dashboard
                        </a>
                    </div>
                </div>

                <div class="mt-8 p-4 bg-blue-50 rounded-lg border border-blue-200">
                    <h4 class="font-semibold text-blue-800 mb-2">
                        <i class="fas fa-question-circle mr-2"></i>
                        ¿Necesitas más permisos?
                    </h4>
                    <p class="text-sm text-blue-700">
                        Contacta a tu administrador del sistema para solicitar los permisos necesarios.
                        El administrador puede modificar tu rol o asignarte permisos adicionales.
                    </p>
                </div>
            </div>
        </div>
    </div>
@endsection
