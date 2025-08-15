@extends('layouts.app')

@section('content')
    <div class="max-w-4xl mx-auto bg-white shadow-md rounded p-6">
        <h2 class="text-2xl font-bold mb-6 text-gray-800">Registrar Nuevo Cliente</h2>

        @if ($errors->any())
            <div class="mb-4 p-4 bg-red-100 border border-red-300 rounded">
                <ul class="list-disc list-inside text-red-600">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('clients.store') }}" method="POST">
            @csrf

            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">

                <div class="mb-4">
                    <label for="identification_number" class="block font-medium">Número de Identificación</label>
                    <input type="text" name="identification_number" class="w-full border border-gray-300 rounded mt-1 p-2">
                </div>


                <div>
                    <label for="first_name" class="block font-medium">Nombre</label>
                    <input type="text" name="first_name" class="w-full border border-gray-300 rounded mt-1 p-2" required>
                </div>

                <div>
                    <label for="last_name" class="block font-medium">Apellido</label>
                    <input type="text" name="last_name" class="w-full border border-gray-300 rounded mt-1 p-2" required>
                </div>

                <div>
                    <label for="phone" class="block font-medium">Teléfono</label>
                    <input type="text" name="phone" class="w-full border border-gray-300 rounded mt-1 p-2">
                </div>

                <div>
                    <label for="email" class="block font-medium">Correo electrónico</label>
                    <input type="email" name="email" class="w-full border border-gray-300 rounded mt-1 p-2" required>
                </div>

                <div>
                    <label for="email_verified" class="block font-medium">Correo Verificado</label>
                    <select name="email_verified" class="w-full border border-gray-300 rounded mt-1 p-2">
                        <option value="1">Sí</option>
                        <option value="0">No</option>
                    </select>
                </div>
            </div>

            <div class="flex justify-end">
                <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">
                    Guardar Cliente
                </button>

                <a href="{{ route('clients.index') }}" class="inline-block bg-gray-500 text-white px-4 py-2 rounded hover:bg-gray-600 ml-2">
                    Cancelar
                </a>
            </div>
        </form>
    </div>
@endsection
