@extends('layouts.app')

@section('content')
    <div class="max-w-4xl mx-auto p-6 bg-white rounded shadow">
        <h2 class="text-2xl font-semibold mb-4">Detalles del Cliente</h2>

        <div class="mb-4">
            <strong class="font-medium">Nombre:</strong> {{ $client->first_name }}
        </div>

        <div class="mb-4">
            <strong class="font-medium">Apellido:</strong> {{ $client->last_name }}
        </div>

        <div class="mb-4">
            <strong class="font-medium">Correo Electrónico:</strong> {{ $client->email }}
        </div>

        <div class="mb-4">
            <strong class="font-medium">Teléfono:</strong> {{ $client->phone }}
        </div>

        <div class="mb-4">
            <strong class="font-medium">Correo Verificado:</strong>
            {{ $client->email_verified ? 'Sí' : 'No' }}
        </div>

        <div class="flex justify-end">
            <a href="{{ route('clients.index') }}" class="bg-gray-500 text-white px-4 py-2 rounded hover:bg-gray-600">
                Volver a la lista
            </a>
        </div>
    </div>
@endsection
