@extends('layouts.app')

@section('content')
    <div class="animate-slideInUp">
        <!-- Header -->
        <div class="page-header mb-4 md:mb-6">
            <div class="flex flex-col lg:flex-row lg:items-center lg:justify-between gap-4">
                <div class="flex-1">
                    <div class="flex items-center mb-2">
                        <a href="{{ route('pedidos.index') }}"
                            class="text-gray-500 hover:text-gray-700 mr-3 transition-colors">
                            <i class="fas fa-arrow-left"></i>
                        </a>
                        <h1 class="page-title text-gradient text-xl md:text-2xl lg:text-3xl">
                            <i class="fas fa-edit mr-2 md:mr-3"></i>
                            Editar Pedido
                        </h1>
                    </div>
                    <p class="page-subtitle text-sm md:text-base">
                        <i class="fas fa-file-invoice mr-2"></i>
                        Modificar información del pedido {{ $pedido->numero_pedido }}
                    </p>
                </div>
                <div class="flex justify-start lg:justify-end">
                    <span
                        class="inline-flex items-center px-3 md:px-4 py-2 bg-blue-50 text-blue-700 rounded-lg border border-blue-200 text-sm md:text-base">
                        <i class="fas fa-hashtag mr-2"></i>
                        {{ $pedido->numero_pedido }}
                    </span>
                </div>
            </div>
        </div>

        @if ($errors->any())
            <div class="alert alert-error mb-4 md:mb-6">
                <i class="fas fa-exclamation-triangle text-xl"></i>
                <div class="flex-1">
                    <h4 class="font-semibold">Por favor corrige los siguientes errores:</h4>
                    <ul class="list-disc list-inside mt-2 text-sm md:text-base">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            </div>
        @endif

        <form action="{{ route('pedidos.update', $pedido->id) }}" method="POST" id="formEditarPedido">
            @csrf
            @method('PUT')

            <div class="grid grid-cols-1 lg:grid-cols-3 gap-4 md:gap-6">
                <!-- Columna principal (2/3) -->
                <div class="lg:col-span-2 space-y-4 md:space-y-6">
                    <!-- Información del Cliente -->
                    <div class="card">
                        <div class="card-header">
                            <i class="fas fa-user-tie text-blue-600 mr-2"></i>
                            <h3 class="card-title text-base md:text-lg">Información del Cliente</h3>
                        </div>
                        <div class="card-body">
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                <!-- Cliente -->
                                <div class="md:col-span-2">
                                    <label for="client_id" class="form-label required text-sm md:text-base">Cliente</label>
                                    <select name="client_id" id="client_id" class="form-select text-sm md:text-base"
                                        required>
                                        <option value="">Seleccionar cliente</option>
                                        @foreach ($clientes as $cliente)
                                            <option value="{{ $cliente->id }}"
                                                {{ old('client_id', $pedido->client_id) == $cliente->id ? 'selected' : '' }}
                                                data-email="{{ $cliente->email }}" data-phone="{{ $cliente->phone }}">
                                                {{ $cliente->first_name }} {{ $cliente->last_name }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('client_id')
                                        <p class="form-error text-sm">{{ $message }}</p>
                                    @enderror
                                </div>

                                <!-- Teléfono de Contacto -->
                                <div>
                                    <label for="telefono_contacto" class="form-label required text-sm md:text-base">Teléfono
                                        de Contacto</label>
                                    <div class="relative">
                                        <span class="absolute left-3 top-1/2 -translate-y-1/2 text-gray-400">
                                            <i class="fas fa-phone text-sm"></i>
                                        </span>
                                        <input type="text" name="telefono_contacto" id="telefono_contacto"
                                            class="form-input pl-10 text-sm md:text-base"
                                            value="{{ old('telefono_contacto', $pedido->telefono_contacto) }}"
                                            placeholder="Ej: 5512345678" required>
                                    </div>
                                    @error('telefono_contacto')
                                        <p class="form-error text-sm">{{ $message }}</p>
                                    @enderror
                                </div>

                                <!-- Fecha de Entrega -->
                                <div>
                                    <label for="fecha_entrega" class="form-label required text-sm md:text-base">Fecha de
                                        Entrega</label>
                                    <div class="relative">
                                        <span class="absolute left-3 top-1/2 -translate-y-1/2 text-gray-400">
                                            <i class="fas fa-calendar text-sm"></i>
                                        </span>
                                        <input type="date" name="fecha_entrega" id="fecha_entrega"
                                            class="form-input pl-10 text-sm md:text-base"
                                            value="{{ old('fecha_entrega', $pedido->fecha_entrega?->format('Y-m-d')) }}"
                                            min="{{ date('Y-m-d') }}" required>
                                    </div>
                                    @error('fecha_entrega')
                                        <p class="form-error text-sm">{{ $message }}</p>
                                    @enderror
                                </div>

                                <!-- Dirección de Entrega -->
                                <div class="md:col-span-2">
                                    <label for="direccion_entrega"
                                        class="form-label required text-sm md:text-base">Dirección de Entrega</label>
                                    <div class="relative">
                                        <span class="absolute left-3 top-3 text-gray-400">
                                            <i class="fas fa-map-marker-alt text-sm"></i>
                                        </span>
                                        <textarea name="direccion_entrega" id="direccion_entrega" rows="3" class="form-input pl-10 text-sm md:text-base"
                                            placeholder="Ingresa la dirección completa de entrega" required>{{ old('direccion_entrega', $pedido->direccion_entrega) }}</textarea>
                                    </div>
                                    @error('direccion_entrega')
                                        <p class="form-error text-sm">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Detalles del Pedido -->
                    <div class="card">
                        <div class="card-header">
                            <i class="fas fa-list-ul text-purple-600 mr-2"></i>
                            <h3 class="card-title text-base md:text-lg">Detalles del Pedido</h3>
                        </div>
                        <div class="card-body">
                            <div class="mb-4">
                                <button type="button" onclick="agregarDetalle()"
                                    class="btn-outline btn-sm text-sm md:text-base w-full sm:w-auto">
                                    <i class="fas fa-plus mr-2"></i>
                                    Agregar Servicio
                                </button>
                            </div>

                            <!-- Vista Desktop: Tabla -->
                            <div class="hidden md:block overflow-x-auto">
                                <table class="min-w-full divide-y divide-gray-200">
                                    <thead class="bg-gray-50">
                                        <tr>
                                            <th
                                                class="px-3 lg:px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                                Servicio
                                            </th>
                                            <th
                                                class="px-3 lg:px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                                Cantidad
                                            </th>
                                            <th
                                                class="px-3 lg:px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                                Precio Unit.
                                            </th>
                                            <th
                                                class="px-3 lg:px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                                Subtotal
                                            </th>
                                            <th
                                                class="px-3 lg:px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                                Acción
                                            </th>
                                        </tr>
                                    </thead>
                                    <tbody id="detallesContainerDesktop" class="bg-white divide-y divide-gray-200">
                                        @foreach ($pedido->detalles as $index => $detalle)
                                            <tr class="detalle-row" data-index="{{ $index }}">
                                                <td class="px-3 lg:px-4 py-3">
                                                    <select name="detalles[{{ $index }}][servicio_id]"
                                                        class="form-select servicio-select text-sm" required
                                                        onchange="actualizarPrecio(this)">
                                                        <option value="">Seleccionar servicio</option>
                                                        @foreach ($servicios as $servicio)
                                                            <option value="{{ $servicio->id }}"
                                                                data-precio="{{ $servicio->precio }}"
                                                                {{ $detalle->servicio_id == $servicio->id ? 'selected' : '' }}>
                                                                {{ $servicio->nombre }}
                                                            </option>
                                                        @endforeach
                                                    </select>
                                                </td>
                                                <td class="px-3 lg:px-4 py-3">
                                                    <input type="number" name="detalles[{{ $index }}][cantidad]"
                                                        class="form-input cantidad-input text-sm"
                                                        value="{{ $detalle->cantidad }}" min="1" required
                                                        onchange="calcularSubtotal(this)">
                                                </td>
                                                <td class="px-3 lg:px-4 py-3">
                                                    <input type="number"
                                                        name="detalles[{{ $index }}][precio_unitario]"
                                                        class="form-input precio-input text-sm"
                                                        value="{{ $detalle->precio_unitario }}" step="0.01"
                                                        min="0" required onchange="calcularSubtotal(this)">
                                                </td>
                                                <td class="px-3 lg:px-4 py-3">
                                                    <input type="number" name="detalles[{{ $index }}][subtotal]"
                                                        class="form-input subtotal-input bg-gray-50 text-sm"
                                                        value="{{ $detalle->subtotal }}" readonly>
                                                </td>
                                                <td class="px-3 lg:px-4 py-3">
                                                    <button type="button" onclick="eliminarDetalle(this)"
                                                        class="text-red-600 hover:text-red-800">
                                                        <i class="fas fa-trash"></i>
                                                    </button>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>

                            <!-- Vista Mobile: Cards -->
                            <div id="detallesContainerMobile" class="md:hidden space-y-4">
                                @foreach ($pedido->detalles as $index => $detalle)
                                    <div class="detalle-card border border-gray-200 rounded-lg p-4 bg-white"
                                        data-index="{{ $index }}">
                                        <div class="flex justify-between items-start mb-3">
                                            <span class="text-xs font-semibold text-gray-500 uppercase">Servicio
                                                #{{ $index + 1 }}</span>
                                            <button type="button" onclick="eliminarDetalleMobile(this)"
                                                class="text-red-600 hover:text-red-800">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </div>

                                        <div class="space-y-3">
                                            <div>
                                                <label
                                                    class="block text-xs font-medium text-gray-700 mb-1">Servicio</label>
                                                <select name="detalles[{{ $index }}][servicio_id]"
                                                    class="form-select servicio-select-mobile text-sm w-full" required
                                                    onchange="actualizarPrecioMobile(this)">
                                                    <option value="">Seleccionar servicio</option>
                                                    @foreach ($servicios as $servicio)
                                                        <option value="{{ $servicio->id }}"
                                                            data-precio="{{ $servicio->precio }}"
                                                            {{ $detalle->servicio_id == $servicio->id ? 'selected' : '' }}>
                                                            {{ $servicio->nombre }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                            </div>

                                            <div class="grid grid-cols-2 gap-3">
                                                <div>
                                                    <label
                                                        class="block text-xs font-medium text-gray-700 mb-1">Cantidad</label>
                                                    <input type="number" name="detalles[{{ $index }}][cantidad]"
                                                        class="form-input cantidad-input-mobile text-sm w-full"
                                                        value="{{ $detalle->cantidad }}" min="1" required
                                                        onchange="calcularSubtotalMobile(this)">
                                                </div>
                                                <div>
                                                    <label class="block text-xs font-medium text-gray-700 mb-1">Precio
                                                        Unit.</label>
                                                    <input type="number"
                                                        name="detalles[{{ $index }}][precio_unitario]"
                                                        class="form-input precio-input-mobile text-sm w-full"
                                                        value="{{ $detalle->precio_unitario }}" step="0.01"
                                                        min="0" required onchange="calcularSubtotalMobile(this)">
                                                </div>
                                            </div>

                                            <div>
                                                <label
                                                    class="block text-xs font-medium text-gray-700 mb-1">Subtotal</label>
                                                <input type="number" name="detalles[{{ $index }}][subtotal]"
                                                    class="form-input subtotal-input-mobile bg-gray-50 text-sm w-full font-semibold"
                                                    value="{{ $detalle->subtotal }}" readonly>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>

                            <div id="noDetalles"
                                class="text-center py-8 {{ count($pedido->detalles) > 0 ? 'hidden' : '' }}">
                                <i class="fas fa-inbox text-4xl text-gray-300 mb-3"></i>
                                <p class="text-gray-500 text-sm md:text-base">No hay servicios agregados</p>
                            </div>
                        </div>
                    </div>

                    <!-- Observaciones -->
                    <div class="card">
                        <div class="card-header">
                            <i class="fas fa-comment-alt text-orange-600 mr-2"></i>
                            <h3 class="card-title text-base md:text-lg">Observaciones</h3>
                        </div>
                        <div class="card-body">
                            <textarea name="observaciones" id="observaciones" rows="4" class="form-input text-sm md:text-base"
                                placeholder="Agrega notas o comentarios adicionales sobre el pedido...">{{ old('observaciones', $pedido->observaciones) }}</textarea>
                            @error('observaciones')
                                <p class="form-error text-sm">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>
                </div>

                <!-- Columna lateral (1/3) -->
                <div class="space-y-4 md:space-y-6">
                    <!-- Estado del Pedido -->
                    <div class="card">
                        <div class="card-header">
                            <i class="fas fa-flag text-green-600 mr-2"></i>
                            <h3 class="card-title text-base md:text-lg">Estado</h3>
                        </div>
                        <div class="card-body">
                            <label for="estado" class="form-label required text-sm md:text-base">Estado del
                                Pedido</label>
                            <select name="estado" id="estado" class="form-select text-sm md:text-base" required>
                                <option value="pendiente"
                                    {{ old('estado', $pedido->estado) == 'pendiente' ? 'selected' : '' }}>
                                    Pendiente
                                </option>
                                <option value="en_proceso"
                                    {{ old('estado', $pedido->estado) == 'en_proceso' ? 'selected' : '' }}>
                                    En Proceso
                                </option>
                                <option value="completado"
                                    {{ old('estado', $pedido->estado) == 'completado' ? 'selected' : '' }}>
                                    Completado
                                </option>
                                <option value="cancelado"
                                    {{ old('estado', $pedido->estado) == 'cancelado' ? 'selected' : '' }}>
                                    Cancelado
                                </option>
                            </select>
                            @error('estado')
                                <p class="form-error text-sm">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    <!-- Cotización Relacionada -->
                    <div class="card">
                        <div class="card-header">
                            <i class="fas fa-file-invoice-dollar text-indigo-600 mr-2"></i>
                            <h3 class="card-title text-base md:text-lg">Cotización</h3>
                        </div>
                        <div class="card-body">
                            <label for="cotizacion_id" class="form-label text-sm md:text-base">Cotización
                                Relacionada</label>
                            <select name="cotizacion_id" id="cotizacion_id" class="form-select text-sm md:text-base">
                                <option value="">Sin cotización</option>
                                @foreach ($cotizaciones as $cotizacion)
                                    <option value="{{ $cotizacion->id }}"
                                        {{ old('cotizacion_id', $pedido->cotizacion_id) == $cotizacion->id ? 'selected' : '' }}>
                                        {{ $cotizacion->numero_cotizacion }} - ${{ number_format($cotizacion->total, 2) }}
                                    </option>
                                @endforeach
                            </select>
                            @error('cotizacion_id')
                                <p class="form-error text-sm">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    <!-- Resumen del Pedido -->
                    <div class="card bg-gradient-to-br from-blue-50 to-indigo-50 border-blue-200">
                        <div class="card-header bg-blue-100 border-blue-200">
                            <i class="fas fa-calculator text-blue-600 mr-2"></i>
                            <h3 class="card-title text-blue-900 text-base md:text-lg">Resumen</h3>
                        </div>
                        <div class="card-body">
                            <div class="space-y-3">
                                <div class="flex justify-between items-center pb-3 border-b border-blue-200">
                                    <span class="text-gray-700 font-medium text-sm md:text-base">Subtotal:</span>
                                    <span class="text-gray-900 font-semibold text-sm md:text-base" id="subtotalDisplay">
                                        ${{ number_format($pedido->total, 2) }}
                                    </span>
                                </div>
                                <div
                                    class="flex justify-between items-center text-base md:text-lg font-bold text-blue-900 pt-2">
                                    <span>Total:</span>
                                    <span id="totalDisplay">${{ number_format($pedido->total, 2) }}</span>
                                </div>
                            </div>
                            <input type="hidden" name="total" id="totalInput" value="{{ $pedido->total }}">
                        </div>
                    </div>

                    <!-- Botones de Acción -->
                    <div class="card">
                        <div class="card-body space-y-3">
                            <button type="submit" class="btn-primary w-full text-sm md:text-base">
                                <i class="fas fa-save mr-2"></i>
                                Actualizar Pedido
                            </button>
                            <a href="{{ route('pedidos.index') }}"
                                class="btn-outline w-full text-center text-sm md:text-base">
                                <i class="fas fa-times mr-2"></i>
                                Cancelar
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>

    @push('scripts')
        <script>
            let detalleIndex = {{ count($pedido->detalles) }};

            // Autocompletar teléfono al seleccionar cliente
            document.getElementById('client_id').addEventListener('change', function() {
                const selectedOption = this.options[this.selectedIndex];
                const phone = selectedOption.getAttribute('data-phone');
                if (phone) {
                    document.getElementById('telefono_contacto').value = phone;
                }
            });

            function agregarDetalle() {
                const containerDesktop = document.getElementById('detallesContainerDesktop');
                const containerMobile = document.getElementById('detallesContainerMobile');
                const noDetalles = document.getElementById('noDetalles');

                // Agregar fila en desktop
                const row = document.createElement('tr');
                row.className = 'detalle-row';
                row.setAttribute('data-index', detalleIndex);
                row.innerHTML = `
                    <td class="px-3 lg:px-4 py-3">
                        <select name="detalles[${detalleIndex}][servicio_id]" 
                                class="form-select servicio-select text-sm" 
                                required
                                onchange="actualizarPrecio(this)">
                            <option value="">Seleccionar servicio</option>
                            @foreach ($servicios as $servicio)
                                <option value="{{ $servicio->id }}" 
                                        data-precio="{{ $servicio->precio }}">
                                    {{ $servicio->nombre }}
                                </option>
                            @endforeach
                        </select>
                    </td>
                    <td class="px-3 lg:px-4 py-3">
                        <input type="number" 
                               name="detalles[${detalleIndex}][cantidad]" 
                               class="form-input cantidad-input text-sm" 
                               value="1"
                               min="1" 
                               required
                               onchange="calcularSubtotal(this)">
                    </td>
                    <td class="px-3 lg:px-4 py-3">
                        <input type="number" 
                               name="detalles[${detalleIndex}][precio_unitario]" 
                               class="form-input precio-input text-sm" 
                               value="0"
                               step="0.01" 
                               min="0" 
                               required
                               onchange="calcularSubtotal(this)">
                    </td>
                    <td class="px-3 lg:px-4 py-3">
                        <input type="number" 
                               name="detalles[${detalleIndex}][subtotal]" 
                               class="form-input subtotal-input bg-gray-50 text-sm" 
                               value="0"
                               readonly>
                    </td>
                    <td class="px-3 lg:px-4 py-3">
                        <button type="button" 
                                onclick="eliminarDetalle(this)" 
                                class="text-red-600 hover:text-red-800">
                            <i class="fas fa-trash"></i>
                        </button>
                    </td>
                `;

                // Agregar card en mobile
                const card = document.createElement('div');
                card.className = 'detalle-card border border-gray-200 rounded-lg p-4 bg-white';
                card.setAttribute('data-index', detalleIndex);
                card.innerHTML = `
                    <div class="flex justify-between items-start mb-3">
                        <span class="text-xs font-semibold text-gray-500 uppercase">Servicio #${detalleIndex + 1}</span>
                        <button type="button" 
                                onclick="eliminarDetalleMobile(this)" 
                                class="text-red-600 hover:text-red-800">
                            <i class="fas fa-trash"></i>
                        </button>
                    </div>
                    
                    <div class="space-y-3">
                        <div>
                            <label class="block text-xs font-medium text-gray-700 mb-1">Servicio</label>
                            <select name="detalles[${detalleIndex}][servicio_id]" 
                                    class="form-select servicio-select-mobile text-sm w-full" 
                                    required
                                    onchange="actualizarPrecioMobile(this)">
                                <option value="">Seleccionar servicio</option>
                                @foreach ($servicios as $servicio)
                                    <option value="{{ $servicio->id }}" 
                                            data-precio="{{ $servicio->precio }}">
                                        {{ $servicio->nombre }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="grid grid-cols-2 gap-3">
                            <div>
                                <label class="block text-xs font-medium text-gray-700 mb-1">Cantidad</label>
                                <input type="number" 
                                       name="detalles[${detalleIndex}][cantidad]" 
                                       class="form-input cantidad-input-mobile text-sm w-full" 
                                       value="1"
                                       min="1" 
                                       required
                                       onchange="calcularSubtotalMobile(this)">
                            </div>
                            <div>
                                <label class="block text-xs font-medium text-gray-700 mb-1">Precio Unit.</label>
                                <input type="number" 
                                       name="detalles[${detalleIndex}][precio_unitario]" 
                                       class="form-input precio-input-mobile text-sm w-full" 
                                       value="0"
                                       step="0.01" 
                                       min="0" 
                                       required
                                       onchange="calcularSubtotalMobile(this)">
                            </div>
                        </div>

                        <div>
                            <label class="block text-xs font-medium text-gray-700 mb-1">Subtotal</label>
                            <input type="number" 
                                   name="detalles[${detalleIndex}][subtotal]" 
                                   class="form-input subtotal-input-mobile bg-gray-50 text-sm w-full font-semibold" 
                                   value="0"
                                   readonly>
                        </div>
                    </div>
                `;

                containerDesktop.appendChild(row);
                containerMobile.appendChild(card);
                noDetalles.classList.add('hidden');
                detalleIndex++;
            }

            function eliminarDetalle(button) {
                const row = button.closest('tr');
                const index = row.getAttribute('data-index');
                row.remove();

                // Eliminar también de mobile
                const cardMobile = document.querySelector(`.detalle-card[data-index="${index}"]`);
                if (cardMobile) cardMobile.remove();

                verificarDetallesVacios();
                calcularTotal();
            }

            function eliminarDetalleMobile(button) {
                const card = button.closest('.detalle-card');
                const index = card.getAttribute('data-index');
                card.remove();

                // Eliminar también de desktop
                const rowDesktop = document.querySelector(`.detalle-row[data-index="${index}"]`);
                if (rowDesktop) rowDesktop.remove();

                verificarDetallesVacios();
                calcularTotal();
            }

            function verificarDetallesVacios() {
                const containerDesktop = document.getElementById('detallesContainerDesktop');
                const containerMobile = document.getElementById('detallesContainerMobile');
                const noDetalles = document.getElementById('noDetalles');

                if (containerDesktop.children.length === 0) {
                    noDetalles.classList.remove('hidden');
                }
            }

            function actualizarPrecio(select) {
                const row = select.closest('tr');
                const index = row.getAttribute('data-index');
                const precioInput = row.querySelector('.precio-input');
                const selectedOption = select.options[select.selectedIndex];
                const precio = selectedOption.getAttribute('data-precio') || 0;

                precioInput.value = precio;

                // Actualizar también en mobile
                const cardMobile = document.querySelector(`.detalle-card[data-index="${index}"]`);
                if (cardMobile) {
                    const selectMobile = cardMobile.querySelector('.servicio-select-mobile');
                    const precioInputMobile = cardMobile.querySelector('.precio-input-mobile');
                    selectMobile.value = select.value;
                    precioInputMobile.value = precio;
                    calcularSubtotalMobile(precioInputMobile);
                }

                calcularSubtotal(precioInput);
            }

            function actualizarPrecioMobile(select) {
                const card = select.closest('.detalle-card');
                const index = card.getAttribute('data-index');
                const precioInput = card.querySelector('.precio-input-mobile');
                const selectedOption = select.options[select.selectedIndex];
                const precio = selectedOption.getAttribute('data-precio') || 0;

                precioInput.value = precio;

                // Actualizar también en desktop
                const rowDesktop = document.querySelector(`.detalle-row[data-index="${index}"]`);
                if (rowDesktop) {
                    const selectDesktop = rowDesktop.querySelector('.servicio-select');
                    const precioInputDesktop = rowDesktop.querySelector('.precio-input');
                    selectDesktop.value = select.value;
                    precioInputDesktop.value = precio;
                    calcularSubtotal(precioInputDesktop);
                }

                calcularSubtotalMobile(precioInput);
            }

            function calcularSubtotal(input) {
                const row = input.closest('tr');
                const index = row.getAttribute('data-index');
                const cantidad = parseFloat(row.querySelector('.cantidad-input').value) || 0;
                const precio = parseFloat(row.querySelector('.precio-input').value) || 0;
                const subtotal = cantidad * precio;

                row.querySelector('.subtotal-input').value = subtotal.toFixed(2);

                // Sincronizar con mobile
                const cardMobile = document.querySelector(`.detalle-card[data-index="${index}"]`);
                if (cardMobile) {
                    cardMobile.querySelector('.cantidad-input-mobile').value = cantidad;
                    cardMobile.querySelector('.precio-input-mobile').value = precio;
                    cardMobile.querySelector('.subtotal-input-mobile').value = subtotal.toFixed(2);
                }

                calcularTotal();
            }

            function calcularSubtotalMobile(input) {
                const card = input.closest('.detalle-card');
                const index = card.getAttribute('data-index');
                const cantidad = parseFloat(card.querySelector('.cantidad-input-mobile').value) || 0;
                const precio = parseFloat(card.querySelector('.precio-input-mobile').value) || 0;
                const subtotal = cantidad * precio;

                card.querySelector('.subtotal-input-mobile').value = subtotal.toFixed(2);

                // Sincronizar con desktop
                const rowDesktop = document.querySelector(`.detalle-row[data-index="${index}"]`);
                if (rowDesktop) {
                    rowDesktop.querySelector('.cantidad-input').value = cantidad;
                    rowDesktop.querySelector('.precio-input').value = precio;
                    rowDesktop.querySelector('.subtotal-input').value = subtotal.toFixed(2);
                }

                calcularTotal();
            }

            function calcularTotal() {
                let total = 0;

                // Calcular desde desktop (fuente única de verdad)
                document.querySelectorAll('#detallesContainerDesktop .subtotal-input').forEach(input => {
                    total += parseFloat(input.value) || 0;
                });

                document.getElementById('subtotalDisplay').textContent = '$' + total.toFixed(2).replace(/\d(?=(\d{3})+\.)/g,
                    '$&,');
                document.getElementById('totalDisplay').textContent = '$' + total.toFixed(2).replace(/\d(?=(\d{3})+\.)/g,
                '$&,');
                document.getElementById('totalInput').value = total.toFixed(2);
            }

            // Calcular total al cargar la página
            document.addEventListener('DOMContentLoaded', function() {
                calcularTotal();
            });

            // Validación antes de enviar
            document.getElementById('formEditarPedido').addEventListener('submit', function(e) {
                const detalles = document.querySelectorAll('.detalle-row');

                if (detalles.length === 0) {
                    e.preventDefault();
                    alert('Debes agregar al menos un servicio al pedido');
                    return false;
                }
            });
        </script>
    @endpush
@endsection
