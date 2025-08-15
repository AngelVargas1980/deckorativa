@extends('layouts.app')

@section('content')
    <div class="max-w-4xl mx-auto bg-white shadow-md rounded p-6">
        <h2 class="text-2xl font-bold mb-6 text-gray-800">Registrar Nuevo Producto</h2>

        @if ($errors->any())
            <div class="mb-4 p-4 bg-red-100 border border-red-300 rounded">
                <ul class="list-disc list-inside text-red-600">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('productos.store') }}" method="POST">
            @csrf

            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">

                <div class="mb-4">
                    <label for="codigo" class="block font-medium">Código</label>
                    <input type="text" name="codigo" class="w-full border border-gray-300 rounded mt-1 p-2" value="{{ old('codigo') }}" required>
                </div>

                <div class="mb-4">
                    <label for="nombre" class="block font-medium">Nombre</label>
                    <input type="text" name="nombre" class="w-full border border-gray-300 rounded mt-1 p-2" value="{{ old('nombre') }}" required>
                </div>

                <div class="mb-4">
                    <label for="descripcion" class="block font-medium">Descripción</label>
                    <textarea name="descripcion" class="w-full border border-gray-300 rounded mt-1 p-2" required>{{ old('descripcion') }}</textarea>
                </div>

                <div class="mb-4">
                    <label for="precio" class="block font-medium">Precio</label>
                    <input type="number" name="precio" class="w-full border border-gray-300 rounded mt-1 p-2" value="{{ old('precio') }}" required step="0.01">
                </div>

                <div class="mb-4">
                    <label for="existencia" class="block font-medium">Existencia</label>
                    <input type="number" name="existencia" class="w-full border border-gray-300 rounded mt-1 p-2" value="{{ old('existencia') }}" required>
                </div>

                <div class="mb-4">
                    <label for="unidad" class="block font-medium">Unidad</label>
                    <input type="text" name="unidad" class="w-full border border-gray-300 rounded mt-1 p-2" value="{{ old('unidad') }}" required>
                </div>

                <div class="mb-4">
                    <label for="imagen" class="block font-medium">Imagen</label>
                    <input type="text" name="imagen" class="w-full border border-gray-300 rounded mt-1 p-2" value="{{ old('imagen') }}" required>
                </div>

                <div class="mb-4">
                    <label for="status" class="block font-medium">Estado</label>
                    <select name="status" class="w-full border border-gray-300 rounded mt-1 p-2">
                        <option value="1" {{ old('status') == 1 ? 'selected' : '' }}>Activo</option>
                        <option value="0" {{ old('status') == 0 ? 'selected' : '' }}>Inactivo</option>
                    </select>
                </div>

            </div>

            <div class="flex justify-end">
                <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">
                    Guardar Producto
                </button>

                <a href="{{ route('productos.index') }}" class="inline-block bg-gray-500 text-white px-4 py-2 rounded hover:bg-gray-600 ml-2">
                    Cancelar
                </a>
            </div>
        </form>
    </div>
@endsection
