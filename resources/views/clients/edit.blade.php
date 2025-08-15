@extends('layouts.app')

@section('content')
    <div class="max-w-xl mx-auto p-6 bg-white rounded shadow">
        <h2 class="text-2xl font-semibold mb-4">Editar Cliente</h2>

        @if ($errors->any())
            <div class="mb-4">
                <ul class="list-disc list-inside text-red-600">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('clients.update', $client->id) }}" method="POST">
            @csrf
            @method('PUT')

            <div class="mb-4">
                <label for="identification_number" class="block font-medium">Número de Identificación</label>
                <input type="text" name="identification_number" value="{{ old('identification_number', $client->identification_number) }}" class="w-full border border-gray-300 rounded mt-1 p-2">
            </div>


            <div class="mb-4">
                <label class="block font-medium">Nombre</label>
                <input type="text" name="first_name" value="{{ old('first_name', $client->first_name) }}" class="w-full border-gray-300 rounded mt-1" required>
            </div>

            <div class="mb-4">
                <label class="block font-medium">Apellido</label>
                <input type="text" name="last_name" value="{{ old('last_name', $client->last_name) }}" class="w-full border-gray-300 rounded mt-1">
            </div>

            <div class="mb-4">
                <label class="block font-medium">Correo electrónico</label>
                <input type="email" name="email" value="{{ old('email', $client->email) }}" class="w-full border-gray-300 rounded mt-1" required>
            </div>

            <div class="mb-4">
                <label class="block font-medium">Teléfono</label>
                <input type="text" name="phone" value="{{ old('phone', $client->phone) }}" class="w-full border-gray-300 rounded mt-1">
            </div>

            <div class="mb-4">
                <label class="block font-medium">Correo Verificado</label>
                <select name="email_verified" class="w-full border-gray-300 rounded mt-1">
                    <option value="1" {{ $client->email_verified ? 'selected' : '' }}>Sí</option>
                    <option value="0" {{ !$client->email_verified ? 'selected' : '' }}>No</option>
                </select>
            </div>

            <div class="flex justify-end">
                <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">
                    Actualizar Cliente
                </button>

                <a href="{{ route('clients.index') }}" class="inline-block bg-gray-500 text-white px-4 py-2 rounded hover:bg-gray-600 ml-2">
                    Cancelar
                </a>
            </div>
        </form>
    </div>
@endsection
