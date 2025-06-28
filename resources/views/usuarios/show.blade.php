@extends('layouts.app')

@section('content')
    <div class="max-w-3xl mx-auto bg-white shadow p-6 rounded">
        <h2 class="text-2xl font-bold mb-4">Detalles del Usuario</h2>

        <div class="mb-4">
            <strong>Nombre:</strong> {{ $usuario->name }}
        </div>

        <div class="mb-4">
            <strong>Apellidos:</strong> {{ $usuario->apellidos }}
        </div>

        <div class="mb-4">
            <strong>Correo:</strong> {{ $usuario->email }}
        </div>

        <div class="mb-4">
            <strong>Teléfono:</strong> {{ $usuario->telefono }}
        </div>

        <div class="mb-4">
            <strong>Rol:</strong> {{ $usuario->rol }}
        </div>

        <div class="mb-4">
            <strong>Estado:</strong> {{ $usuario->estado ? 'Activo' : 'Inactivo' }}
        </div>

        <a href="{{ route('usuarios.index') }}" class="bg-gray-500 text-white px-4 py-2 rounded hover:bg-gray-600">
            ← Volver
        </a>
    </div>
@endsection
