@extends('layouts.app')

@section('content')
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between items-center mb-2">
            <h1 class="text-2xl font-bold">Usuarios Eliminados</h1>
        </div>

        {{-- Botón para volver a la lista de usuarios activos --}}
        <div class="flex justify-start mb-4 mt-4">
            <a href="{{ route('usuarios.index') }}" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">
                Volver a usuarios activos
            </a>
        </div>

        {{-- Tabla de usuarios eliminados --}}
        <table class="table-auto w-full border-collapse border border-gray-300 bg-white shadow rounded">
            <thead class="bg-gray-100">
            <tr>
                <th class="border border-gray-300 px-4 py-2">ID</th>
                <th class="border border-gray-300 px-4 py-2">Nombres</th>
                <th class="border border-gray-300 px-4 py-2">Apellidos</th>
                <th class="border border-gray-300 px-4 py-2">Correo</th>
                <th class="border border-gray-300 px-4 py-2">Fecha de Eliminación</th>
                <th class="border border-gray-300 px-4 py-2">Acciones</th>
            </tr>
            </thead>
            <tbody>
            @foreach ($usuarios as $usuario)
                <tr>
                    <td class="border border-gray-300 px-4 py-2">{{ $usuario->id }}</td>
                    <td class="border border-gray-300 px-4 py-2">{{ $usuario->name }}</td>
                    <td class="border border-gray-300 px-4 py-2">{{ $usuario->apellidos }}</td>
                    <td class="border border-gray-300 px-4 py-2">{{ $usuario->email }}</td>
                    <td class="border border-gray-300 px-4 py-2">{{ $usuario->deleted_at }}</td> <!-- Fecha de eliminación -->
                    <td class="border border-gray-300 px-4 py-2 text-center">

                        {{-- Formulario para restaurar el usuario eliminado --}}
                        @if ($usuario->trashed())  <!-- Solo muestra el botón si el usuario está eliminado -->
                        <form action="{{ route('usuarios.restore', $usuario->id) }}" method="POST" style="display: inline;">
                            @csrf
                            @method('PATCH')
                            <button type="submit" class="bg-green-600 text-white px-2 py-1 rounded hover:bg-green-700" title="Restaurar">🔄 Restaurar</button>
                        </form>
                        @endif

                        {{-- Formulario para eliminar permanentemente el usuario --}}
                        <form action="{{ route('usuarios.destroy', $usuario->id) }}" method="POST" class="inline-block" onsubmit="return confirm('¿Estás seguro de eliminar este usuario permanentemente?');">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="bg-red-600 text-white px-2 py-1 rounded hover:bg-red-700 text-sm" title="Eliminar permanentemente">🗑️ Eliminar permanentemente</button>
                        </form>
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>

        {{-- Paginación de Laravel --}}
        <div class="mt-4">
            {{ $usuarios->links() }}
        </div>
    </div>
@endsection
