
<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Bienvenido al Cotizador Decorativo
        </h2>
    </x-slot>

    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 grid grid-cols-1 md:grid-cols-2 gap-4">
            <div class="bg-white p-6 rounded shadow">
                <h3 class="text-lg font-bold mb-2">Nueva Cotización</h3>
                <p class="mb-4">Genera una cotización para un cliente.</p>
                <a href="{{ route('cotizaciones.create') }}" class="text-blue-600 hover:underline">Ir a cotizar</a>
            </div>

            <div class="bg-white p-6 rounded shadow">
                <h3 class="text-lg font-bold mb-2">Administrar Productos</h3>
                <p class="mb-4">Ver, crear o editar productos decorativos.</p>
                <a href="{{ route('productos.index') }}" class="text-blue-600 hover:underline">Ver productos</a>
            </div>

            <div class="bg-white p-6 rounded shadow">
                <h3 class="text-lg font-bold mb-2">Servicios</h3>
                <p class="mb-4">Gestiona los servicios ofrecidos a clientes.</p>
                <a href="{{ route('servicios.index') }}" class="text-blue-600 hover:underline">Ver servicios</a>
            </div>
        </div>
    </div>
</x-app-layout>



{{--Esto venia en la vista original de dashboard.blade.php cuando se instalo breeze--}}

{{--<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    {{ __("You're logged in!") }}
                </div>
            </div>
        </div>
    </div>
</x-app-layout>--}}
