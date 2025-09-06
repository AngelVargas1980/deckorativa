@extends('layouts.app')

@section('content')
    <div class="max-w-xl mx-auto p-6 bg-white rounded shadow">
        <h2 class="text-2xl font-semibold mb-4">Editar Usuario</h2>

        @if ($errors->any())
            <div class="mb-4">
                <ul class="list-disc list-inside text-red-600">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('usuarios.update', $usuario->id) }}" method="POST">
            @csrf
            @method('PUT')

            <div class="mb-4">
                <label class="block font-medium">Nombre</label>
                <input type="text" name="name" value="{{ old('name', $usuario->name) }}" class="w-full border-gray-300 rounded mt-1" required>
            </div>

            <div class="mb-4">
                <label class="block font-medium">Apellidos</label>
                <input type="text" name="apellidos" value="{{ old('apellidos', $usuario->apellidos) }}" class="w-full border-gray-300 rounded mt-1">
            </div>

            <div class="mb-4">
                <label class="block font-medium">Correo electrónico</label>
                <input type="email" name="email" value="{{ old('email', $usuario->email) }}" class="w-full border-gray-300 rounded mt-1" required>
            </div>

            <div class="mb-4">
                <label class="block font-medium">Teléfono</label>
                <input type="text" name="telefono" value="{{ old('telefono', $usuario->telefono) }}" class="w-full border-gray-300 rounded mt-1">
            </div>

            <div class="mb-4">
                <label class="block font-medium">Rol</label>
                @if($usuario->email === 'admin@deckorativa.com')
                    <div class="p-3 bg-amber-50 border border-amber-200 rounded-lg">
                        <div class="flex items-center">
                            <i class="fas fa-lock text-amber-600 mr-2"></i>
                            <span class="font-semibold text-amber-800">Administrador</span>
                            <span class="ml-2 text-amber-700">(Protegido)</span>
                        </div>
                        <p class="text-sm text-amber-600 mt-1">El rol del usuario administrador principal no puede ser modificado</p>
                    </div>
                    <input type="hidden" name="rol" value="Admin">
                @else
                    <select name="rol" class="w-full border-gray-300 rounded mt-1">
                        @foreach($roles as $role)
                            <option value="{{ $role->name }}" {{ $usuario->rol == $role->name ? 'selected' : '' }}>
                                {{ ucfirst($role->name) }}
                            </option>
                        @endforeach
                    </select>
                @endif
            </div>

            <div class="mb-4">
                <label class="block font-medium">Estado</label>
                @if($usuario->email === 'admin@deckorativa.com')
                    <div class="p-3 bg-green-50 border border-green-200 rounded-lg">
                        <div class="flex items-center">
                            <i class="fas fa-check-circle text-green-600 mr-2"></i>
                            <span class="font-semibold text-green-800">Activo</span>
                            <span class="ml-2 text-green-700">(Protegido)</span>
                        </div>
                        <p class="text-sm text-green-600 mt-1">El usuario administrador principal siempre debe estar activo</p>
                    </div>
                    <input type="hidden" name="estado" value="1">
                @else
                    <select name="estado" class="w-full border-gray-300 rounded mt-1">
                        <option value="1" {{ $usuario->estado ? 'selected' : '' }}>Activo</option>
                        <option value="0" {{ !$usuario->estado ? 'selected' : '' }}>Inactivo</option>
                    </select>
                @endif
            </div>

            <div class="mb-4">
                <label class="block font-medium">Nueva Contraseña (opcional)</label>
                <input type="password" name="password" class="w-full border-gray-300 rounded mt-1">
            </div>

            <div class="mb-4">
                <label class="block font-medium">Confirmar Contraseña</label>
                <input type="password" name="password_confirmation" class="w-full border-gray-300 rounded mt-1">
            </div>

            <div class="flex justify-end">
                <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">
                    Actualizar Usuario
                </button>

                <a href="{{ route('usuarios.index') }}"
                   class="inline-block bg-gray-500 text-white px-4 py-2 rounded hover:bg-gray-600 ml-2">
                    Cancelar
                </a>
            </div>
        </form>
    </div>
@endsection

