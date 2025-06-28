@extends('layouts.app')

@section('content')
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

        {{-- Fila principal: título y breadcrumb --}}
        <div class="flex justify-between items-center mb-2">

            {{-- Título a la izquierda --}}
            <h1 class="text-2xl font-bold">Usuarios – Cotizador Virtual index</h1>

            {{-- Breadcrumb a la derecha --}}
            <div class="flex items-center text-sm text-gray-600">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                     stroke-width="1.5" stroke="currentColor" class="w-5 h-5 mr-1">
                    <path stroke-linecap="round" stroke-linejoin="round"
                          d="M3 12l9-9 9 9M4.5 10.5V21h15V10.5" />
                </svg>
                <span class="mr-2">/ Usuarios</span>
            </div>
        </div>

        <br />
        <br />
        {{-- Botón debajo alineado a la derecha --}}
        <div class="flex justify-end mb-4 mt-14">
            <a href="{{ route('usuarios.create') }}" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">
                ➕ Nuevo Usuario
            </a>
        </div>

        <table id="tablaUsuarios" class="table-auto w-full border-collapse border border-gray-300 bg-white shadow rounded">
            <thead class="bg-gray-100">
            <tr>
                <th class="border border-gray-300 px-4 py-2">ID</th>
                <th class="border border-gray-300 px-4 py-2">Nombres</th>
                <th class="border border-gray-300 px-4 py-2">Apellidos</th>
                <th class="border border-gray-300 px-4 py-2">Teléfono</th>
                <th class="border border-gray-300 px-4 py-2">Correo</th>
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
                    <td class="border border-gray-300 px-4 py-2">{{ $usuario->apellidos }}</td>
                    <td class="border border-gray-300 px-4 py-2">{{ $usuario->telefono }}</td>
                    <td class="border border-gray-300 px-4 py-2">{{ $usuario->email }}</td>
                    <td class="border border-gray-300 px-4 py-2">{{ $usuario->rol }}</td>
                    <td class="border border-gray-300 px-4 py-2">{{ $usuario->estado ? 'Activo' : 'Inactivo' }}</td>
                    <td class="border border-gray-300 px-4 py-2 space-x-2 text-center">
                        <a href="{{ route('usuarios.show', $usuario->id) }}"
                           class="bg-blue-500 text-white px-2 py-1 rounded hover:bg-blue-600 text-sm"
                           title="Consultar">
                            👁️
                        </a>
                        <a href="{{ route('usuarios.edit', $usuario->id) }}"
                           class="bg-yellow-500 text-white px-2 py-1 rounded hover:bg-yellow-600 text-sm"
                           title="Editar">
                            ✏️
                        </a>
                        <form action="{{ route('usuarios.destroy', $usuario->id) }}" method="POST" class="inline-block" onsubmit="return confirm('¿Estás seguro de eliminar este usuario?');">
                            @csrf
                            @method('DELETE')
                            <button type="submit"
                                    class="bg-red-600 text-white px-2 py-1 rounded hover:bg-red-700 text-sm"
                                    title="Eliminar">
                                🗑️
                            </button>
                        </form>
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>

        @push('scripts')
            <script>
                $('#tablaUsuarios').DataTable({    //esto genera un buscador
                    dom: '<"flex justify-between items-center mb-4"l f> <"flex justify-start mb-2"B> rt <"bottom"ip><"clear">',
                    buttons: [
                        'copy', 'excel', 'pdf', 'csv'
                    ],
                    language: {
                        "decimal": "",
                        "emptyTable": "No hay datos disponibles en la tabla",
                        "info": "Mostrando _START_ a _END_ de _TOTAL_ registros",
                        "infoEmpty": "Mostrando 0 a 0 de 0 registros",
                        "infoFiltered": "(filtrado de _MAX_ registros totales)",
                        "lengthMenu": "Mostrar _MENU_ registros",
                        "loadingRecords": "Cargando...",
                        "processing": "Procesando...",
                        "search": "Buscar:",
                        "zeroRecords": "No se encontraron resultados",
                        "paginate": {
                            "first": "Primero",
                            "last": "Último",
                            "next": "Siguiente",
                            "previous": "Anterior"
                        },
                        "buttons": {
                            "copy": "Copiar",
                            "excel": "Excel",
                            "pdf": "PDF",
                            "csv": "CSV",
                            "print": "Imprimir"
                        }
                    }
                });

                // Mover contenedor DataTables arriba del botón "Nuevo Usuario"
                $(document).ready(function () {
                    $('.flex.justify-between.items-center.mb-4').insertBefore('.flex.justify-end.mb-4');
                });






            </script>
        @endpush

    </div>
@endsection
