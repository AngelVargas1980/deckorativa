@extends('layouts.app')

@section('content')
    <div class="animate-slideInUp">
        <div class="page-header">
            <div class="flex flex-col lg:flex-row lg:items-center lg:justify-between">
                <div>
                    <h1 class="page-title text-gradient">
                        <i class="fas fa-edit mr-3"></i>
                        Editar Cotización
                    </h1>
                    <p class="page-subtitle">
                        <i class="fas fa-hashtag mr-2"></i>
                        {{ $cotizacion->numero_cotizacion }} - {{ $cotizacion->client->name }}
                    </p>
                </div>
                <div class="mt-6 lg:mt-0 flex gap-3">
                    <a href="{{ route('cotizaciones.show', $cotizacion) }}" class="btn-outline">
                        <i class="fas fa-eye mr-2"></i>
                        Ver Cotización
                    </a>
                    <a href="{{ route('cotizaciones.index') }}" class="btn-outline">
                        <i class="fas fa-arrow-left mr-2"></i>
                        Volver al Listado
                    </a>
                </div>
            </div>
        </div>

        @if($cotizacion->estado !== 'borrador')
            <div class="alert alert-warning mb-6">
                <i class="fas fa-exclamation-triangle text-xl"></i>
                <div>
                    <h4 class="font-semibold">Atención</h4>
                    <p>Esta cotización no está en estado borrador. Solo se pueden editar cotizaciones en borrador.</p>
                </div>
            </div>
        @else
            <form action="{{ route('cotizaciones.update', $cotizacion) }}" method="POST" id="cotizacion-form">
                @csrf
                @method('PUT')

                <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                    <!-- Información del Cliente -->
                    <div class="lg:col-span-2">
                        <div class="card mb-6">
                            <h3 class="text-lg font-semibold text-gray-900 mb-4">
                                <i class="fas fa-user mr-2 text-blue-600"></i>
                                Información del Cliente
                            </h3>

                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                <div>
                                    <label class="form-label required">Cliente</label>
                                    <select name="client_id" class="form-select @error('client_id') border-red-500 @enderror" required>
                                        @foreach($clientes as $cliente)
                                            <option value="{{ $cliente->id }}" {{ old('client_id', $cotizacion->client_id) == $cliente->id ? 'selected' : '' }}>
                                                {{ $cliente->name }} - {{ $cliente->email }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('client_id')
                                        <p class="form-error">{{ $message }}</p>
                                    @enderror
                                </div>

                                <div>
                                    <label class="form-label">Fecha de Vigencia</label>
                                    <input type="date" name="fecha_vigencia"
                                           value="{{ old('fecha_vigencia', $cotizacion->fecha_vigencia->format('Y-m-d')) }}"
                                           class="form-input @error('fecha_vigencia') border-red-500 @enderror"
                                           min="{{ now()->format('Y-m-d') }}">
                                    @error('fecha_vigencia')
                                        <p class="form-error">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>

                            <div class="mt-4">
                                <label class="form-label">Observaciones</label>
                                <textarea name="observaciones" rows="3"
                                          class="form-input @error('observaciones') border-red-500 @enderror"
                                          placeholder="Notas adicionales sobre la cotización...">{{ old('observaciones', $cotizacion->observaciones) }}</textarea>
                                @error('observaciones')
                                    <p class="form-error">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>

                        <!-- Servicios Existentes -->
                        <div class="card">
                            <div class="flex items-center justify-between mb-4">
                                <h3 class="text-lg font-semibold text-gray-900">
                                    <i class="fas fa-layer-group mr-2 text-green-600"></i>
                                    Servicios y Productos
                                </h3>
                                <button type="button" onclick="agregarServicio()" class="btn-primary btn-sm">
                                    <i class="fas fa-plus mr-2"></i>
                                    Agregar Item
                                </button>
                            </div>

                            <div id="servicios-seleccionados">
                                @foreach($cotizacion->detalles as $index => $detalle)
                                    <div class="border border-gray-200 rounded-lg p-4 mb-4" data-servicio="{{ $detalle->servicio_id }}">
                                        <input type="hidden" name="servicios[{{ $index }}][servicio_id]" value="{{ $detalle->servicio_id }}">
                                        <div class="flex items-center justify-between">
                                            <div class="flex-1">
                                                <h4 class="font-semibold text-gray-900">{{ $detalle->servicio->nombre }}</h4>
                                                <p class="text-sm text-gray-600">{{ $detalle->servicio->categoria->nombre }}</p>
                                            </div>
                                            <button type="button" onclick="removerServicioExistente(this)" class="text-red-600 hover:text-red-800">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </div>
                                        <div class="grid grid-cols-3 gap-4 mt-4">
                                            <div>
                                                <label class="block text-sm text-gray-600">Cantidad</label>
                                                <input type="number" name="servicios[{{ $index }}][cantidad]" value="{{ $detalle->cantidad }}" min="1"
                                                       class="form-input" onchange="recalcular()">
                                            </div>
                                            <div>
                                                <label class="block text-sm text-gray-600">Precio Unit.</label>
                                                <input type="text" value="Q{{ number_format($detalle->precio_unitario, 2) }}" class="form-input" readonly>
                                            </div>
                                            <div>
                                                <label class="block text-sm text-gray-600">Subtotal</label>
                                                <input type="text" value="Q{{ number_format($detalle->subtotal, 2) }}" class="form-input font-bold text-green-600" readonly>
                                            </div>
                                        </div>
                                        <div class="mt-2">
                                            <label class="block text-sm text-gray-600">Notas (opcional)</label>
                                            <input type="text" name="servicios[{{ $index }}][notas]" value="{{ $detalle->notas }}" class="form-input" placeholder="Notas adicionales...">
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>

                    <!-- Resumen -->
                    <div class="lg:col-span-1">
                        <div class="card sticky top-6">
                            <h3 class="text-lg font-semibold text-gray-900 mb-4">
                                <i class="fas fa-calculator mr-2 text-purple-600"></i>
                                Resumen de Cotización
                            </h3>

                            <div class="space-y-4">
                                <div class="flex justify-between items-center">
                                    <span class="text-gray-600">Subtotal:</span>
                                    <span id="subtotal" class="font-semibold">Q{{ number_format($cotizacion->subtotal, 2) }}</span>
                                </div>

                                <div class="flex justify-between items-center">
                                    <div>
                                        <span class="text-gray-600">Descuento:</span>
                                        <div class="mt-1">
                                            <input type="number" name="descuento" value="{{ old('descuento', $cotizacion->descuento) }}"
                                                   step="0.01" min="0" class="form-input text-sm"
                                                   style="width: 80px;" onchange="recalcular()">
                                        </div>
                                    </div>
                                    <span id="descuento-display" class="font-semibold text-red-600">-Q{{ number_format($cotizacion->descuento, 2) }}</span>
                                </div>

                                <div class="flex justify-between items-center">
                                    <span class="text-gray-600">IVA (12%):</span>
                                    <span id="impuesto" class="font-semibold">Q{{ number_format($cotizacion->total_impuesto, 2) }}</span>
                                </div>

                                <div class="border-t pt-4">
                                    <div class="flex justify-between items-center">
                                        <span class="text-lg font-bold text-gray-900">Total:</span>
                                        <span id="total" class="text-2xl font-bold text-green-600">Q{{ number_format($cotizacion->total, 2) }}</span>
                                    </div>
                                </div>

                                <div class="pt-4 border-t">
                                    <button type="submit" class="w-full btn-primary">
                                        <i class="fas fa-save mr-2"></i>
                                        Actualizar Cotización
                                    </button>
                                    <a href="{{ route('cotizaciones.show', $cotizacion) }}" class="w-full btn-outline mt-2">
                                        <i class="fas fa-times mr-2"></i>
                                        Cancelar
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                </div>
            </form>
        @endif
    </div>

    @push('scripts')
    <script>
        function removerServicioExistente(button) {
            if (confirm('¿Estás seguro de remover este servicio?')) {
                button.closest('.border').remove();
                recalcular();
            }
        }

        function recalcular() {
        }

        function agregarServicio() {
            alert('Función de agregar servicio - por implementar completamente');
        }
    </script>
    @endpush
@endsection
