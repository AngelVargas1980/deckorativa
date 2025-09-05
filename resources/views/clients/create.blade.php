@extends('layouts.app')

@section('content')
    <div class="animate-slideInUp max-w-5xl mx-auto">
        <div class="page-header">
            <div class="flex flex-col lg:flex-row lg:items-center lg:justify-between">
                <div>
                    <h1 class="page-title text-gradient">
                        <i class="fas fa-user-plus mr-3"></i>
                        Nuevo Cliente
                    </h1>
                    <p class="page-subtitle">
                        <i class="fas fa-info-circle mr-2"></i>
                        Registra un nuevo cliente en tu base de datos
                    </p>
                </div>
                <div class="mt-6 lg:mt-0">
                    <a href="{{ route('clients.index') }}" class="btn-outline">
                        <i class="fas fa-arrow-left mr-2"></i>
                        Volver a Clientes
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
                    <div class="w-10 h-10 bg-gradient-to-r from-green-500 to-emerald-600 rounded-lg flex items-center justify-center mr-4">
                        <i class="fas fa-handshake text-white"></i>
                    </div>
                    <div>
                        <h3 class="text-lg font-semibold text-gray-900">Información del Cliente</h3>
                        <p class="text-sm text-gray-600">Los campos marcados con (*) son obligatorios</p>
                    </div>
                </div>
            </div>

            <div class="card-body">
                <form id="client-form" action="{{ route('clients.store') }}" method="POST" class="space-y-8">
                    @csrf

                    <!-- Información Personal -->
                    <div class="border-b border-gray-200 pb-8">
                        <h4 class="text-lg font-semibold text-gray-900 mb-6 flex items-center">
                            <i class="fas fa-id-card text-blue-600 mr-2"></i>
                            Información Personal
                        </h4>
                        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                            <div class="form-group">
                                <label for="first_name" class="form-label">
                                    <i class="fas fa-user mr-2 text-gray-400"></i>
                                    Nombres *
                                </label>
                                <input type="text"
                                       name="first_name"
                                       id="first_name"
                                       class="form-input"
                                       placeholder="Ingresa los nombres"
                                       value="{{ old('first_name') }}"
                                       required>
                            </div>

                            <div class="form-group">
                                <label for="last_name" class="form-label">
                                    <i class="fas fa-user-tag mr-2 text-gray-400"></i>
                                    Apellidos *
                                </label>
                                <input type="text"
                                       name="last_name"
                                       id="last_name"
                                       class="form-input"
                                       placeholder="Ingresa los apellidos"
                                       value="{{ old('last_name') }}"
                                       required>
                            </div>

                            <div class="form-group">
                                <label for="identification_number" class="form-label">
                                    <i class="fas fa-id-card-alt mr-2 text-gray-400"></i>
                                    Número de Identificación
                                </label>
                                <input type="text"
                                       name="identification_number"
                                       id="identification_number"
                                       class="form-input"
                                       placeholder="Cédula, DNI, Pasaporte, etc."
                                       value="{{ old('identification_number') }}">
                                <p class="text-sm text-gray-500 mt-1">Documento de identificación oficial</p>
                            </div>
                        </div>
                    </div>

                    <!-- Información de Contacto -->
                    <div class="border-b border-gray-200 pb-8">
                        <h4 class="text-lg font-semibold text-gray-900 mb-6 flex items-center">
                            <i class="fas fa-address-book text-green-600 mr-2"></i>
                            Información de Contacto
                        </h4>
                        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                            <div class="form-group">
                                <label for="email" class="form-label">
                                    <i class="fas fa-envelope mr-2 text-gray-400"></i>
                                    Correo Electrónico *
                                </label>
                                <input type="email"
                                       name="email"
                                       id="email"
                                       class="form-input"
                                       placeholder="cliente@ejemplo.com"
                                       value="{{ old('email') }}"
                                       required>
                                <p class="text-sm text-gray-500 mt-1">Principal medio de comunicación</p>
                            </div>

                            <div class="form-group">
                                <label for="phone" class="form-label">
                                    <i class="fas fa-phone mr-2 text-gray-400"></i>
                                    Teléfono
                                </label>
                                <input type="tel"
                                       name="phone"
                                       id="phone"
                                       class="form-input"
                                       placeholder="+502 1234 5678"
                                       value="{{ old('phone') }}">
                                <p class="text-sm text-gray-500 mt-1">Incluye código de país si es necesario</p>
                            </div>
                        </div>
                    </div>

                    <!-- Configuración -->
                    <div>
                        <h4 class="text-lg font-semibold text-gray-900 mb-6 flex items-center">
                            <i class="fas fa-cogs text-purple-600 mr-2"></i>
                            Configuración de la Cuenta
                        </h4>
                        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                            <div class="form-group">
                                <label for="email_verified" class="form-label">
                                    <i class="fas fa-shield-check mr-2 text-gray-400"></i>
                                    Estado de Verificación del Email *
                                </label>
                                <select name="email_verified" id="email_verified" class="form-select" required>
                                    <option value="">Selecciona el estado</option>
                                    <option value="1" {{ old('email_verified') == '1' ? 'selected' : '' }}>
                                        ✅ Verificado - Email confirmado
                                    </option>
                                    <option value="0" {{ old('email_verified') == '0' ? 'selected' : 'selected' }}>
                                        ⏳ Sin verificar - Pendiente de confirmación
                                    </option>
                                </select>
                                <p class="text-sm text-gray-500 mt-1">Indica si el cliente ha verificado su correo electrónico</p>
                            </div>

                            <!-- Preview Card -->
                            <div class="form-group">
                                <label class="form-label">
                                    <i class="fas fa-eye mr-2 text-gray-400"></i>
                                    Vista Previa
                                </label>
                                <div class="p-4 bg-gray-50 rounded-lg border border-gray-200">
                                    <div class="flex items-center">
                                        <div class="w-10 h-10 bg-gradient-to-r from-green-500 to-emerald-600 rounded-full flex items-center justify-center">
                                            <span class="text-white font-bold text-sm" id="preview-initials">?</span>
                                        </div>
                                        <div class="ml-3">
                                            <div class="font-semibold text-gray-900" id="preview-name">Nombre del Cliente</div>
                                            <div class="text-sm text-gray-600" id="preview-email">cliente@ejemplo.com</div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Information Box -->
                        <div class="mt-6 p-4 bg-blue-50 rounded-lg border border-blue-200">
                            <h5 class="text-sm font-semibold text-blue-800 mb-2 flex items-center">
                                <i class="fas fa-lightbulb mr-2"></i>
                                Consejos para registrar clientes:
                            </h5>
                            <ul class="text-sm text-blue-700 space-y-1">
                                <li><i class="fas fa-check text-blue-600 mr-2"></i>Verifica la ortografía de nombres y emails</li>
                                <li><i class="fas fa-check text-blue-600 mr-2"></i>Asegúrate de que el email sea válido y activo</li>
                                <li><i class="fas fa-check text-blue-600 mr-2"></i>Incluye el código de país en números internacionales</li>
                                <li><i class="fas fa-check text-blue-600 mr-2"></i>La identificación ayuda a evitar duplicados</li>
                            </ul>
                        </div>
                    </div>
                </form>
            </div>

            <div class="card-footer">
                <div class="flex flex-col sm:flex-row sm:justify-end gap-4">
                    <a href="{{ route('clients.index') }}" class="btn-outline">
                        <i class="fas fa-times mr-2"></i>
                        Cancelar
                    </a>
                    <button type="submit" form="client-form" class="btn-primary">
                        <i class="fas fa-save mr-2"></i>
                        Guardar Cliente
                    </button>
                </div>
            </div>
        </div>
    </div>

    @push('scripts')
        <script>
            // Live preview functionality
            function updatePreview() {
                const firstName = document.getElementById('first_name').value || '';
                const lastName = document.getElementById('last_name').value || '';
                const email = document.getElementById('email').value || 'cliente@ejemplo.com';

                const fullName = `${firstName} ${lastName}`.trim() || 'Nombre del Cliente';
                const initials = (firstName.charAt(0) + lastName.charAt(0)).toUpperCase() || '?';

                document.getElementById('preview-name').textContent = fullName;
                document.getElementById('preview-email').textContent = email;
                document.getElementById('preview-initials').textContent = initials;
            }

            // Form initialization
            document.addEventListener('DOMContentLoaded', function() {
                // Add live preview listeners
                document.getElementById('first_name').addEventListener('input', updatePreview);
                document.getElementById('last_name').addEventListener('input', updatePreview);
                document.getElementById('email').addEventListener('input', updatePreview);
            });
        </script>
    @endpush
@endsection
