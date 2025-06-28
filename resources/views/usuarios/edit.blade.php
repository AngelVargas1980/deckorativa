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
                <select name="rol" class="w-full border-gray-300 rounded mt-1">
                    <option value="Administrador" {{ $usuario->rol == 'Administrador' ? 'selected' : '' }}>Administrador</option>
                    <option value="Asesor" {{ $usuario->rol == 'Asesor' ? 'selected' : '' }}>Asesor</option>
                    <option value="Cliente" {{ $usuario->rol == 'Cliente' ? 'selected' : '' }}>Cliente</option>
                </select>
            </div>

            <div class="mb-4">
                <label class="block font-medium">Estado</label>
                <select name="estado" class="w-full border-gray-300 rounded mt-1">
                    <option value="1" {{ $usuario->estado ? 'selected' : '' }}>Activo</option>
                    <option value="0" {{ !$usuario->estado ? 'selected' : '' }}>Inactivo</option>
                </select>
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
                <button type="submit" class="bg-blue-600 text-black px-4 py-2 rounded hover:bg-blue-700">
                    Actualizar Usuario
                </button>
            </div>
        </form>
    </div>
@endsection

