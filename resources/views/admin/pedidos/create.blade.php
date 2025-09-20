@extends('layouts.app')

@section('content')
    <div class="animate-slideInUp">
        <div class="page-header">
            <div class="flex flex-col lg:flex-row lg:items-center lg:justify-between">
                <div>
                    <h1 class="page-title text-gradient">
                        <i class="fas fa-plus-circle mr-3"></i>
                        Crear Nuevo Pedido
                    </h1>
                    <p class="page-subtitle">
                        <i class="fas fa-info-circle mr-2"></i>
                        Complete los datos del pedido para el cliente
                    </p>
                </div>
                <div class="mt-6 lg:mt-0">
                    <a href="{{ route('pedidos.index') }}" class="btn-outline">
                        <i class="fas fa-arrow-left mr-2"></i>
                        Volver al Listado
                    </a>
                </div>
            </div>
        </div>

        @if($errors->any())
            <div class="alert alert-error mb-6">
                <i class="fas fa-exclamation-triangle text-xl"></i>
                <div>
                    <h4 class="font-semibold">Errores de validación</h4>
                    <ul class="list-disc list-inside mt-2">
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            </div>
        @endif

        <div class="max-w-4xl mx-auto">
            <form action="{{ route('pedidos.store') }}" method="POST" id="pedidoForm">
                @csrf

                <div class="space-y-8">
                    <!-- Información del Cliente -->
                    <div class="form-section">
                        <div class="form-section-header">
                            <h3 class="form-section-title">
                                <i class="fas fa-user mr-2"></i>
                                Información del Cliente
                            </h3>
                            <p class="form-section-subtitle">Seleccione el cliente para este pedido</p>
                        </div>

                        <div class="form-section-content">
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <div>
                                    <label class="form-label">Cliente *</label>
                                    <select name="client_id" class="form-select" required>
                                        <option value="">Seleccionar cliente...</option>
                                        @foreach($clientes as $cliente)
                                            <option value="{{ $cliente->id }}" {{ old('client_id') == $cliente->id ? 'selected' : '' }}>
                                                {{ $cliente->nombre }} - {{ $cliente->email }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>

                                <div>
                                    <label class="form-label">Cotización Base (Opcional)</label>
                                    <select name="cotizacion_id" class="form-select">
                                        <option value="">Sin cotización base...</option>
                                        @foreach($cotizaciones as $cotizacion)
                                            <option value="{{ $cotizacion->id }}" {{ old('cotizacion_id') == $cotizacion->id ? 'selected' : '' }}>
                                                {{ $cotizacion->numero_cotizacion }} - Q{{ number_format($cotizacion->total, 2) }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Información del Pedido -->
                    <div class="form-section">
                        <div class="form-section-header">
                            <h3 class="form-section-title">
                                <i class="fas fa-clipboard-list mr-2"></i>
                                Información del Pedido
                            </h3>
                            <p class="form-section-subtitle">Datos de entrega y contacto</p>
                        </div>

                        <div class="form-section-content">
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <div class="md:col-span-2">
                                    <label class="form-label">Dirección de Entrega *</label>
                                    <textarea name="direccion_entrega" rows="3" class="form-input" required>{{ old('direccion_entrega') }}</textarea>
                                </div>

                                <div>
                                    <label class="form-label">Teléfono de Contacto *</label>
                                    <input type="text" name="telefono_contacto" class="form-input" value="{{ old('telefono_contacto') }}" required>
                                </div>

                                <div>
                                    <label class="form-label">Fecha de Entrega (Estimada)</label>
                                    <input type="date" name="fecha_entrega" class="form-input" value="{{ old('fecha_entrega') }}" min="{{ date('Y-m-d') }}">
                                </div>

                                <div class="md:col-span-2">
                                    <label class="form-label">Observaciones</label>
                                    <textarea name="observaciones" rows="3" class="form-input" placeholder="Instrucciones especiales, notas adicionales...">{{ old('observaciones') }}</textarea>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Detalles del Pedido -->
                    <div class="form-section">
                        <div class="form-section-header">
                            <h3 class="form-section-title">
                                <i class="fas fa-list mr-2"></i>
                                Detalles del Pedido
                            </h3>
                            <p class="form-section-subtitle">Agregue los servicios/productos para este pedido</p>
                        </div>

                        <div class="form-section-content">
                            <div id="detalles-container">
                                <div class="detalle-item bg-gray-50 p-4 rounded-lg border border-gray-200" data-index="0">
                                    <div class="flex justify-between items-start mb-4">
                                        <h4 class="font-medium text-gray-900">Item #1</h4>
                                        <button type="button" class="btn-danger btn-sm remove-detalle" style="display: none;">
                                            <i class="fas fa-trash mr-1"></i>
                                            Eliminar
                                        </button>
                                    </div>

                                    <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
                                        <div>
                                            <label class="form-label">Servicio (Opcional)</label>
                                            <select name="detalles[0][servicio_id]" class="form-select servicio-select" onchange="llenarDatosServicio(this, 0)">
                                                <option value="">Seleccionar...</option>
                                                @foreach($servicios as $servicio)
                                                    <option value="{{ $servicio->id }}" data-nombre="{{ $servicio->nombre }}" data-precio="{{ $servicio->precio }}">
                                                        {{ $servicio->nombre }} - Q{{ number_format($servicio->precio, 2) }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>

                                        <div>
                                            <label class="form-label">Nombre del Item *</label>
                                            <input type="text" name="detalles[0][nombre_item]" class="form-input nombre-item" required>
                                        </div>

                                        <div>
                                            <label class="form-label">Cantidad *</label>
                                            <input type="number" name="detalles[0][cantidad]" class="form-input cantidad" min="1" value="1" required onchange="calcularSubtotal(0)">
                                        </div>

                                        <div>
                                            <label class="form-label">Precio Unitario *</label>
                                            <input type="number" name="detalles[0][precio_unitario]" class="form-input precio-unitario" step="0.01" min="0" required onchange="calcularSubtotal(0)">
                                        </div>

                                        <div class="md:col-span-4">
                                            <label class="form-label">Descripción</label>
                                            <textarea name="detalles[0][descripcion]" class="form-input descripcion" rows="2" placeholder="Descripción del servicio/producto..."></textarea>
                                        </div>

                                        <div class="md:col-span-4">
                                            <div class="text-right">
                                                <span class="text-lg font-semibold text-gray-900">Subtotal: Q<span class="subtotal">0.00</span></span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="mt-4 flex justify-between items-center">
                                <button type="button" class="btn-outline" onclick="agregarDetalle()">
                                    <i class="fas fa-plus mr-2"></i>
                                    Agregar Item
                                </button>

                                <div class="text-right">
                                    <div class="text-2xl font-bold text-green-600">
                                        Total: Q<span id="total-pedido">0.00</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Botones de Acción -->
                    <div class="flex justify-end space-x-4 pt-6 border-t border-gray-200">
                        <a href="{{ route('pedidos.index') }}" class="btn-outline">
                            <i class="fas fa-times mr-2"></i>
                            Cancelar
                        </a>
                        <button type="submit" class="btn-primary">
                            <i class="fas fa-save mr-2"></i>
                            Crear Pedido
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    @push('scripts')
        <script>
            let detalleIndex = 1;

            function agregarDetalle() {
                const container = document.getElementById('detalles-container');
                const newDetalle = `
                    <div class="detalle-item bg-gray-50 p-4 rounded-lg border border-gray-200 mt-4" data-index="${detalleIndex}">
                        <div class="flex justify-between items-start mb-4">
                            <h4 class="font-medium text-gray-900">Item #${detalleIndex + 1}</h4>
                            <button type="button" class="btn-danger btn-sm remove-detalle" onclick="removerDetalle(this)">
                                <i class="fas fa-trash mr-1"></i>
                                Eliminar
                            </button>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
                            <div>
                                <label class="form-label">Servicio (Opcional)</label>
                                <select name="detalles[${detalleIndex}][servicio_id]" class="form-select servicio-select" onchange="llenarDatosServicio(this, ${detalleIndex})">
                                    <option value="">Seleccionar...</option>
                                    @foreach($servicios as $servicio)
                                        <option value="{{ $servicio->id }}" data-nombre="{{ $servicio->nombre }}" data-precio="{{ $servicio->precio }}">
                                            {{ $servicio->nombre }} - Q{{ number_format($servicio->precio, 2) }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            <div>
                                <label class="form-label">Nombre del Item *</label>
                                <input type="text" name="detalles[${detalleIndex}][nombre_item]" class="form-input nombre-item" required>
                            </div>

                            <div>
                                <label class="form-label">Cantidad *</label>
                                <input type="number" name="detalles[${detalleIndex}][cantidad]" class="form-input cantidad" min="1" value="1" required onchange="calcularSubtotal(${detalleIndex})">
                            </div>

                            <div>
                                <label class="form-label">Precio Unitario *</label>
                                <input type="number" name="detalles[${detalleIndex}][precio_unitario]" class="form-input precio-unitario" step="0.01" min="0" required onchange="calcularSubtotal(${detalleIndex})">
                            </div>

                            <div class="md:col-span-4">
                                <label class="form-label">Descripción</label>
                                <textarea name="detalles[${detalleIndex}][descripcion]" class="form-input descripcion" rows="2" placeholder="Descripción del servicio/producto..."></textarea>
                            </div>

                            <div class="md:col-span-4">
                                <div class="text-right">
                                    <span class="text-lg font-semibold text-gray-900">Subtotal: Q<span class="subtotal">0.00</span></span>
                                </div>
                            </div>
                        </div>
                    </div>
                `;

                container.insertAdjacentHTML('beforeend', newDetalle);
                detalleIndex++;
                actualizarBotonesEliminar();
            }

            function removerDetalle(button) {
                button.closest('.detalle-item').remove();
                actualizarBotonesEliminar();
                calcularTotal();
            }

            function actualizarBotonesEliminar() {
                const detalles = document.querySelectorAll('.detalle-item');
                const botones = document.querySelectorAll('.remove-detalle');

                botones.forEach((boton, index) => {
                    boton.style.display = detalles.length > 1 ? 'inline-flex' : 'none';
                });
            }

            function llenarDatosServicio(select, index) {
                const option = select.options[select.selectedIndex];
                const detalleItem = select.closest('.detalle-item');

                if (option.value) {
                    const nombre = option.getAttribute('data-nombre');
                    const precio = option.getAttribute('data-precio');

                    detalleItem.querySelector('.nombre-item').value = nombre;
                    detalleItem.querySelector('.precio-unitario').value = precio;

                    calcularSubtotal(index);
                }
            }

            function calcularSubtotal(index) {
                const detalleItem = document.querySelector(`[data-index="${index}"]`);
                const cantidad = parseFloat(detalleItem.querySelector('.cantidad').value) || 0;
                const precio = parseFloat(detalleItem.querySelector('.precio-unitario').value) || 0;
                const subtotal = cantidad * precio;

                detalleItem.querySelector('.subtotal').textContent = subtotal.toFixed(2);
                calcularTotal();
            }

            function calcularTotal() {
                let total = 0;
                document.querySelectorAll('.subtotal').forEach(subtotalSpan => {
                    total += parseFloat(subtotalSpan.textContent) || 0;
                });

                document.getElementById('total-pedido').textContent = total.toFixed(2);
            }

            // Inicializar
            document.addEventListener('DOMContentLoaded', function() {
                actualizarBotonesEliminar();
            });
        </script>
    @endpush
@endsection