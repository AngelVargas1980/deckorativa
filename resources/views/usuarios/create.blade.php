@extends('layouts.app')

@section('content')
    <div class="max-w-4xl mx-auto bg-white shadow-md rounded p-6">
        <h2 class="text-2xl font-bold mb-6 text-gray-800">Registrar Nuevo Usuario</h2>

        @if ($errors->any())
            <div class="mb-4 p-4 bg-red-100 border border-red-300 rounded">
                <ul class="list-disc list-inside text-red-600">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('usuarios.store') }}" method="POST">
            @csrf

            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">


                <div>
                    <label for="name" class="block font-medium">Nombres</label>
                    <input type="text" name="name" class="w-full border border-gray-300 rounded mt-1 p-2" required>
                </div>

                <div>
                    <label for="apellidos" class="block font-medium">Apellidos</label>
                    <input type="text" name="apellidos" class="w-full border border-gray-300 rounded mt-1 p-2" required>
                </div>

                <div>
                    <label for="telefono" class="block font-medium">Teléfono</label>
                    <input type="text" name="telefono" class="w-full border border-gray-300 rounded mt-1 p-2">
                </div>

                <div>
                    <label for="email" class="block font-medium">Correo electrónico</label>
                    <input type="email" name="email" class="w-full border border-gray-300 rounded mt-1 p-2" required>
                </div>

                <div>
                    <label for="rol" class="block font-medium">Rol</label>
                    <select name="rol" class="w-full border border-gray-300 rounded mt-1 p-2">
                        <option value="Admin">Administrador</option>
                        <option value="Asesor">Supervisor</option>
                        <option value="Cliente">Asesor</option>
                    </select>
                </div>

                <div>
                    <label for="estado" class="block font-medium">Estado</label>
                    <select name="estado" class="w-full border border-gray-300 rounded mt-1 p-2">
                        <option value="1">Activo</option>
                        <option value="0">Inactivo</option>
                    </select>
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-6">
                <div>
                    <label for="password" class="block font-medium">Contraseña</label>
                    <input type="password" name="password" class="w-full border border-gray-300 rounded mt-1 p-2" required>
                </div>

                <div>
                    <label for="password_confirmation" class="block font-medium">Confirmar Contraseña</label>
                    <input type="password" name="password_confirmation" class="w-full border border-gray-300 rounded mt-1 p-2" required>
                </div>
            </div>

            <div class="flex justify-end">
                <button type="submit" class="bg-blue-600 text-black px-4 py-2 rounded hover:bg-blue-700">
                    Guardar Usuario
                </button>
            </div>
        </form>
    </div>
@endsection
