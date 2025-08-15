@extends('layouts.app')

@section('content')
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        {{-- Fila principal --}}
        <div class="flex justify-between items-center mb-2">
            <h1 class="text-2xl font-bold">Productos – Cotizador Virtual</h1>
            <div class="flex items-center text-sm text-gray-600">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                     stroke-width="1.5" stroke="currentColor" class="w-5 h-5 mr-1">
                    <path stroke-linecap="round" stroke-linejoin="round"
                          d="M3 12l9-9 9 9M4.5 10.5V21h15V10.5" />
                </svg>
                <span class="mr-2">/ Productos</span>
            </div>
        </div>

        {{-- Combo de cantidad de registros --}}
        <div class="flex justify-between items-center mb-4">
            <div>
                <form method="GET" class="inline">
                    Mostrar
                    <select name="cantidad" onchange="this.form.submit()" class="border border-gray-300 rounded px-2 py-1">
                        <option value="5" {{ request('cantidad') == 5 ? 'selected' : '' }}>5</option>
                        <option value="10" {{ request('cantidad') == 10 ? 'selected' : '' }}>10</option>
                        <option value="25" {{ request('cantidad') == 25 ? 'selected' : '' }}>25</option>
                        <option value="50" {{ request('cantidad') == 50 ? 'selected' : '' }}>50</option>
                        <option value="100" {{ request('cantidad') == 100 ? 'selected' : '' }}>100</option>
                        <option value="all" {{ request('cantidad') == 'all' ? 'selected' : '' }}>Todos</option>
                    </select> registros
                </form>
            </div>
            <div>
                {{-- El buscador de DataTables se coloca aquí automáticamente --}}
            </div>
        </div>

        {{-- Botón Nuevo Producto --}}
        <div class="flex justify-end mb-4 mt-14">
            <a href="{{ route('productos.create') }}" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">
                ➕ Nuevo Producto
            </a>
        </div>

        {{-- Tabla --}}
        <table id="tablaProductos" class="table-auto w-full text-center border-collapse border-gray-300 bg-white shadow rounded">
            <thead class="bg-gray-100">
            <tr>
                <th class="border border-gray-300 px-4 py-2">Código</th>
                <th class="border border-gray-300 px-4 py-2">Nombre</th>
                <th class="border border-gray-300 px-4 py-2">Descripción</th>
                <th class="border border-gray-300 px-4 py-2">Precio</th>
                <th class="border border-gray-300 px-4 py-2">Existencia</th>
                <th class="border border-gray-300 px-4 py-2">Unidad</th>
                <th class="border border-gray-300 px-4 py-2">Estado</th>
                <th class="border border-gray-300 px-4 py-2">Acciones</th>
            </tr>
            </thead>
            <tbody>
            @foreach ($productos as $producto)
                <tr>
                    <td class="border border-gray-300 px-4 py-2">{{ $producto->codigo }}</td>
                    <td class="border border-gray-300 px-4 py-2">{{ $producto->nombre }}</td>
                    <td class="border border-gray-300 px-4 py-2">{{ Str::limit($producto->descripcion, 50) }}</td>
                    <td class="border border-gray-300 px-4 py-2">${{ number_format($producto->precio, 2) }}</td>
                    <td class="border border-gray-300 px-4 py-2">{{ $producto->existencia }}</td>
                    <td class="border border-gray-300 px-4 py-2">{{ $producto->unidad }}</td>
                    <td class="border border-gray-300 px-4 py-2">{{ $producto->status == 1 ? 'Activo' : 'Inactivo' }}</td>
                    <td class="border border-gray-300 px-4 py-2 text-center">
                        <a href="{{ route('productos.show', $producto->idproducto) }}" class="bg-blue-500 text-white px-2 py-1 rounded hover:bg-blue-600 text-sm" title="Consultar">👁️</a>
                        <a href="{{ route('productos.edit', $producto->idproducto) }}" class="bg-yellow-500 text-white px-2 py-1 rounded hover:bg-yellow-600 text-sm" title="Editar">✏️</a>

                        <!-- Formulario para eliminar el producto -->
                        <form action="{{ route('productos.destroy', $producto->idproducto) }}" method="POST" class="inline-block" onsubmit="return confirm('¿Estás seguro de eliminar este producto?');">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="bg-red-600 text-white px-2 py-1 rounded hover:bg-red-700 text-sm" title="Eliminar">🗑️</button>
                        </form>
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>

        {{-- Paginación Laravel --}}
        @if ($paginado)
            <div class="mt-4">
                {{ $productos->appends(['cantidad' => request('cantidad')])->links() }}
            </div>
        @else
            <p class="text-sm text-gray-600 mt-2">
                Mostrando todos los registros ({{ $productos->count() }} en total)
            </p>
        @endif
    </div>

    @push('scripts')
        <script>
            $('#tablaProductos').DataTable({
                paging: false,
                lengthChange: false,
                info: false,
                dom: '<"flex justify-end mb-4"f> <"flex justify-start mb-2"B> rt <"clear">',
                buttons: [
                    'copy', 'excel', 'pdf', 'csv'
                ],
                language: {
                    "search": "Buscar:",
                    "buttons": {
                        "copy": "Copiar",
                        "excel": "Excel",
                        "pdf": "PDF",
                        "csv": "CSV",
                        "print": "Imprimir"
                    }
                }
            });
        </script>
    @endpush
@endsection
