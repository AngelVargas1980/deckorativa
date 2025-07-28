@extends('layouts.app')

@section('content')
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

        {{-- Título y breadcrumb --}}
        <div class="flex justify-between items-center mb-2">
            <h1 class="text-2xl font-bold">Roles – Cotizador Virtual index</h1>
            <div class="flex items-center text-sm text-gray-600">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                     stroke-width="1.5" stroke="currentColor" class="w-5 h-5 mr-1">
                    <path stroke-linecap="round" stroke-linejoin="round"
                          d="M3 12l9-9 9 9M4.5 10.5V21h15V10.5" />
                </svg>
                <span class="mr-2">/ Roles</span>
            </div>
        </div>

        {{-- Combo Laravel --}}
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
                {{-- El buscador DataTables se inyectará aquí --}}
            </div>
        </div>

        {{-- Tabla --}}
        <table id="tablaRoles" class="table-auto w-full text-center border-collapse border border-gray-300 bg-white shadow rounded">

            <thead class="bg-gray-100">
            <tr>
                <th class="border border-gray-300 px-4 py-2 text-center">ID</th>
                <th class="border border-gray-300 px-4 py-2 text-center">Nombre</th>
                <th class="border border-gray-300 px-4 py-2 text-center">Rol</th>
                <th class="border border-gray-300 px-4 py-2 text-center">Acciones</th>
            </tr>
            </thead>
            <tbody>
            @foreach ($usuarios as $usuario)
                <tr>
                    <td class="border border-gray-300 px-4 py-2 text-center">{{ $usuario->id }}</td>
                    <td class="border border-gray-300 px-4 py-2 text-center">{{ $usuario->name }}</td>
                    <td class="border border-gray-300 px-4 py-2 text-center">{{ $usuario->roles->pluck('name')->implode(', ') }}</td>
                    <td class="border border-gray-300 px-4 py-2 text-center">
                        <form action="{{ route('roles.update', $usuario->id) }}" method="POST" style="display: inline;">
                            @csrf
                            @method('PATCH')
                            <select name="rol" class="border border-gray-300 rounded p-2 min-w-[160px]">
                                @foreach ($roles as $rol)
                                    <option value="{{ $rol->name }}" {{ $usuario->hasRole($rol->name) ? 'selected' : '' }}>
                                        {{ $rol->name }}
                                    </option>
                                @endforeach
                            </select>
                            <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700 text-sm mt-1">
                                Cambiar Rol
                            </button>
                        </form>
                    </td>
                </tr>
            @endforeach
            </tbody>

        </table>

        {{-- Paginación de Laravel --}}
        @if ($paginado)
            <div class="mt-4">
                {{ $usuarios->appends(['cantidad' => request('cantidad')])->links() }}
            </div>
        @else
            <p class="text-sm text-gray-600 mt-2">
                Mostrando todos los registros ({{ $usuarios->count() }} en total)
            </p>
        @endif
    </div>

    {{-- Scripts --}}
    @push('scripts')
        <script>
            $('#tablaRoles').DataTable({
                paging: false, // Laravel se encarga
                lengthChange: false,
                info: false,
                dom: '<"flex justify-end mb-4"f> <"flex justify-start mb-2"B> rt <"clear">',
                buttons: ['copy', 'excel', 'pdf', 'csv'],
                language: {
                    search: "Buscar:",
                    buttons: {
                        copy: "Copiar",
                        excel: "Excel",
                        pdf: "PDF",
                        csv: "CSV",
                        print: "Imprimir"
                    }
                }
            });
        </script>
    @endpush
@endsection

