@extends('layouts.app')

@section('content')
    <div class="animate-slideInUp max-w-5xl mx-auto">
        <div class="page-header">
            <div class="flex flex-col lg:flex-row lg:items-center lg:justify-between">
                <div>
                    <h1 class="page-title text-gradient">
                        <i class="fas fa-user-plus mr-3"></i>
                        Nuevo Usuario
                    </h1>
                    <p class="page-subtitle">
                        <i class="fas fa-info-circle mr-2"></i>
                        Completa los datos para registrar un nuevo usuario en el sistema
                    </p>
                </div>
                <div class="mt-6 lg:mt-0">
                    <a href="{{ route('usuarios.index') }}" class="btn-outline">
                        <i class="fas fa-arrow-left mr-2"></i>
                        Volver a Usuarios
                    </a>
                </div>
            </div>
        </div>
        @if ($errors->any())
            <div class="alert alert-error mb-8">
                <i class="fas fa-exclamation-triangle text-xl"></i>
                <div>
                    <h4 class="font-semibold mb-2">¡Atención! Corrige los siguientes errores:</h4>
                    <ul class="list-disc list-inside space-y-1">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            </div>
        @endif

        <div class="card">
            <div class="card-header">
                <div class="flex items-center">
                    <div class="w-10 h-10 bg-gradient-to-r from-blue-500 to-blue-600 rounded-lg flex items-center justify-center mr-4">
                        <i class="fas fa-user-plus text-white"></i>
                    </div>
                    <div>
                        <h3 class="text-lg font-semibold text-gray-900">Información del Usuario</h3>
                        <p class="text-sm text-gray-600">Los campos marcados con (*) son obligatorios</p>
                    </div>
                </div>
            </div>

            <div class="card-body">
                <form id="usuario-form" action="{{ route('usuarios.store') }}" method="POST" class="space-y-8">
                    @csrf
                    <div class="border-b border-gray-200 pb-8">
                        <h4 class="text-lg font-semibold text-gray-900 mb-6 flex items-center">
                            <i class="fas fa-id-card text-blue-600 mr-2"></i>
                            Información Personal
                        </h4>
                        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                            <div class="form-group">
                                <label for="name" class="form-label">
                                    <i class="fas fa-user mr-2 text-gray-400"></i>
                                    Nombres *
                                </label>
                                <input type="text"
                                       name="name"
                                       id="name"
                                       class="form-input"
                                       placeholder="Ingresa los nombres"
                                       value="{{ old('name') }}"
                                       required>
                            </div>

                            <div class="form-group">
                                <label for="apellidos" class="form-label">
                                    <i class="fas fa-user-tag mr-2 text-gray-400"></i>
                                    Apellidos *
                                </label>
                                <input type="text"
                                       name="apellidos"
                                       id="apellidos"
                                       class="form-input"
                                       placeholder="Ingresa los apellidos"
                                       value="{{ old('apellidos') }}"
                                       required>
                            </div>

                            <div class="form-group">
                                <label for="email" class="form-label">
                                    <i class="fas fa-envelope mr-2 text-gray-400"></i>
                                    Correo Electrónico *
                                </label>
                                <input type="email"
                                       name="email"
                                       id="email"
                                       class="form-input"
                                       placeholder="ejemplo@deckorativa.com"
                                       value="{{ old('email') }}"
                                       required>
                                <p class="text-sm text-gray-500 mt-1">Este será el email para iniciar sesión</p>
                            </div>

                            <div class="form-group">
                                <label for="telefono" class="form-label">
                                    <i class="fas fa-phone mr-2 text-gray-400"></i>
                                    Teléfono
                                </label>
                                <input type="tel"
                                       name="telefono"
                                       id="telefono"
                                       class="form-input"
                                       placeholder="+502 1234 5678"
                                       value="{{ old('telefono') }}">
                            </div>
                        </div>
                    </div>

                    <!-- Configuración de Cuenta -->
                    <div class="border-b border-gray-200 pb-8">
                        <h4 class="text-lg font-semibold text-gray-900 mb-6 flex items-center">
                            <i class="fas fa-cogs text-purple-600 mr-2"></i>
                            Configuración de Cuenta
                        </h4>
                        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                            <div class="form-group">
                                <label for="rol" class="form-label">
                                    <i class="fas fa-shield-alt mr-2 text-gray-400"></i>
                                    Rol del Usuario *
                                </label>
                                <select name="rol" id="rol" class="form-select" required>
                                    <option value="">Selecciona un rol</option>
                                    @foreach($roles as $role)
                                        @php
                                            $roleDescription = [
                                                'Admin' => 'Acceso completo al sistema',
                                                'Supervisor' => 'Gestión de equipos y supervisión',
                                                'Asesor' => 'Atención al cliente y ventas',
                                            ][$role->name] ?? 'Rol personalizado';
                                        @endphp
                                        <option value="{{ $role->name }}" {{ old('rol') == $role->name ? 'selected' : '' }}>
                                            {{ $role->name }} - {{ $roleDescription }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="form-group">
                                <label for="estado" class="form-label">
                                    <i class="fas fa-power-off mr-2 text-gray-400"></i>
                                    Estado de la Cuenta *
                                </label>
                                <select name="estado" id="estado" class="form-select" required>
                                    <option value="1" {{ old('estado') == '1' ? 'selected' : 'selected' }}>
                                        ✅ Activo - Puede acceder al sistema
                                    </option>
                                    <option value="0" {{ old('estado') == '0' ? 'selected' : '' }}>
                                        ❌ Inactivo - Sin acceso al sistema
                                    </option>
                                </select>
                            </div>
                        </div>
                    </div>

                    <!-- Seguridad -->
                    <div>
                        <h4 class="text-lg font-semibold text-gray-900 mb-6 flex items-center">
                            <i class="fas fa-lock text-green-600 mr-2"></i>
                            Seguridad y Contraseña
                        </h4>
                        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                            <div class="form-group">
                                <label for="password" class="form-label">
                                    <i class="fas fa-key mr-2 text-gray-400"></i>
                                    Contraseña *
                                </label>
                                <div class="relative">
                                    <input type="password"
                                           name="password"
                                           id="password"
                                           class="form-input pr-12"
                                           placeholder="Mínimo 6 caracteres"
                                           required>
                                    <button type="button"
                                            class="absolute inset-y-0 right-0 pr-3 flex items-center"
                                            onclick="togglePassword('password')">
                                        <i class="fas fa-eye text-gray-400" id="password-icon"></i>
                                    </button>
                                </div>
                                <p class="text-sm text-gray-500 mt-1">La contraseña debe tener al menos 6 caracteres</p>
                            </div>

                            <div class="form-group">
                                <label for="password_confirmation" class="form-label">
                                    <i class="fas fa-check-double mr-2 text-gray-400"></i>
                                    Confirmar Contraseña *
                                </label>
                                <div class="relative">
                                    <input type="password"
                                           name="password_confirmation"
                                           id="password_confirmation"
                                           class="form-input pr-12"
                                           placeholder="Repite la contraseña"
                                           required>
                                    <button type="button"
                                            class="absolute inset-y-0 right-0 pr-3 flex items-center"
                                            onclick="togglePassword('password_confirmation')">
                                        <i class="fas fa-eye text-gray-400" id="password_confirmation-icon"></i>
                                    </button>
                                </div>
                            </div>
                        </div>

                        <!-- Password Strength Indicator -->
                        <div class="mt-4 p-4 bg-gray-50 rounded-lg">
                            <h5 class="text-sm font-semibold text-gray-700 mb-2">
                                <i class="fas fa-info-circle mr-1"></i>
                                Recomendaciones de seguridad:
                            </h5>
                            <ul class="text-sm text-gray-600 space-y-1">
                                <li><i class="fas fa-check text-green-500 mr-2"></i>Usa al menos 6 caracteres</li>
                                <li><i class="fas fa-check text-green-500 mr-2"></i>Combina letras y números</li>
                                <li><i class="fas fa-check text-green-500 mr-2"></i>Incluye caracteres especiales (@, #, $, etc.)</li>
                            </ul>
                        </div>
                    </div>
                </form>
            </div>

            <div class="card-footer">
                <div class="flex flex-col sm:flex-row sm:justify-end gap-4">
                    <a href="{{ route('usuarios.index') }}" class="btn-outline">
                        <i class="fas fa-times mr-2"></i>
                        Cancelar
                    </a>
                    <button type="submit" form="usuario-form" class="btn-primary">
                        <i class="fas fa-save mr-2"></i>
                        Guardar Usuario
                    </button>
                </div>
            </div>
        </div>
    </div>

    @push('scripts')
        <script>
            function togglePassword(fieldId) {
                const field = document.getElementById(fieldId);
                const icon = document.getElementById(fieldId + '-icon');

                if (field.type === 'password') {
                    field.type = 'text';
                    icon.classList.remove('fa-eye');
                    icon.classList.add('fa-eye-slash');
                } else {
                    field.type = 'password';
                    icon.classList.remove('fa-eye-slash');
                    icon.classList.add('fa-eye');
                }
            }

            document.addEventListener('DOMContentLoaded', function() {});
        </script>
    @endpush
@endsection
