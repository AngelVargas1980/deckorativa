@extends('layouts.app')

@section('content')
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between items-center mb-4">
            <h1 class="text-2xl font-bold">Listado de Usuarios</h1>
            <a href="{{ route('usuarios.create') }}" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">
                ➕ Nuevo Usuario
            </a>
        </div>

        <table class="table-auto w-full border-collapse border border-gray-300 bg-white shadow rounded">
            <thead class="bg-gray-100">
            <tr>
                <th class="border border-gray-300 px-4 py-2">ID</th>
                <th class="border border-gray-300 px-4 py-2">Nombres</th>
                <th class="border border-gray-300 px-4 py-2">Apellidos</th>
                <th class="border border-gray-300 px-4 py-2">Correo</th>
                <th class="border border-gray-300 px-4 py-2">Teléfono</th>
                <th class="border border-gray-300 px-4 py-2">Rol</th>
                <th class="border border-gray-300 px-4 py-2">Estado</th>
                <th class="border border-gray-300 px-4 py-2">Acciones</th>
            </tr>
            </thead>
            <tbody>
            @foreach ($usuarios as $usuario)
                <tr>
                    <td class="border border-gray-300 px-4 py-2">{{ $usuario->id }}</td>
                    <td class="border border-gray-300 px-4 py-2">{{ $usuario->name }}</td>
                    <td class="border border-gray-300 px-4 py-2">Apellidos (pendiente)</td>
                    <td class="border border-gray-300 px-4 py-2">{{ $usuario->email }}</td>
                    <td class="border border-gray-300 px-4 py-2">Teléfono (pendiente)</td>
                    <td class="border border-gray-300 px-4 py-2">Rol (pendiente)</td>
                    <td class="border border-gray-300 px-4 py-2">Activo</td>
                    <td class="border border-gray-300 px-4 py-2 space-x-2 text-center">
                        <a href="{{ route('usuarios.edit', $usuario->id) }}"
                           class="bg-yellow-500 text-white px-2 py-1 rounded hover:bg-yellow-600 text-sm">
                            ✏️ Editar
                        </a>

                        <form action="{{ route('usuarios.destroy', $usuario->id) }}" method="POST" class="inline-block">
                            @csrf
                            @method('DELETE')
                            <button type="submit"
                                    class="bg-red-600 text-white px-2 py-1 rounded hover:bg-red-700 text-sm"
                                    onclick="return confirm('¿Estás seguro de eliminar este usuario?')">
                                🗑️ Eliminar
                            </button>
                        </form>
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>
@endsection
