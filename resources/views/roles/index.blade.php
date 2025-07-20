@extends('layouts.app')

@section('content')
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <h1 class="text-2xl font-bold mb-4">Administrar Roles</h1>

        <table class="table-auto w-full border-collapse border border-gray-300 bg-white shadow rounded">
            <thead class="bg-gray-100">
            <tr>
                <th class="border border-gray-300 px-4 py-2">ID</th>
                <th class="border border-gray-300 px-4 py-2">Nombre</th>
                <th class="border border-gray-300 px-4 py-2">Rol</th>
                <th class="border border-gray-300 px-4 py-2">Acciones</th>
            </tr>
            </thead>
            <tbody>
            @foreach ($usuarios as $usuario)
                <tr>
                    <td class="border border-gray-300 px-4 py-2">{{ $usuario->id }}</td>
                    <td class="border border-gray-300 px-4 py-2">{{ $usuario->name }}</td>
                    <td class="border border-gray-300 px-4 py-2">{{ $usuario->rol }}</td>
                    <td class="border border-gray-300 px-4 py-2 text-center">
                        <form action="{{ route('roles.update', $usuario->id) }}" method="POST" style="display: inline;">
                            @csrf
                            @method('PATCH')
                            <select name="rol" class="border border-gray-300 rounded p-2">
                                <option value="Admin" {{ $usuario->rol == 'Admin' ? 'selected' : '' }}>Administrador</option>
                                <option value="Asesor" {{ $usuario->rol == 'Asesor' ? 'selected' : '' }}>Asesor</option>
                                <option value="Supervisor" {{ $usuario->rol == 'Supervisor' ? 'selected' : '' }}>Supervisor</option>
                            </select>
                            <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">Cambiar Rol</button>
                        </form>
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>
@endsection
