@extends('layouts.app')

@section('content')
    <style>
        /* Custom Select Styles */
        .custom-select-container {
            position: relative;
        }

        .select-dropdown {
            max-height: 200px;
            overflow-y: auto;
            border: 1px solid #d1d5db;
            border-top: none;
            background: white;
            position: absolute;
            top: 100%;
            left: 0;
            right: 0;
            z-index: 1000;
            border-radius: 0 0 0.375rem 0.375rem;
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1);
        }

        .select-option {
            padding: 0.5rem;
            cursor: pointer;
            border-bottom: 1px solid #f3f4f6;
            transition: background-color 0.2s;
            font-size: 0.875rem;
        }

        .select-option:hover {
            background-color: #f3f4f6;
        }

        .select-option.selected {
            background-color: #dbeafe;
            color: #1e40af;
        }

        .select-option.highlighted {
            background-color: #e0e7ff;
        }

        .select-option:last-child {
            border-bottom: none;
        }

        .select-input {
            appearance: none;
            background-image: url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' fill='none' viewBox='0 0 20 20'%3e%3cpath stroke='%236b7280' stroke-linecap='round' stroke-linejoin='round' stroke-width='1.5' d='m6 8 4 4 4-4'/%3e%3c/svg%3e");
            background-position: right 0.5rem center;
            background-repeat: no-repeat;
            background-size: 1.5em 1.5em;
            padding-right: 2.5rem;
        }

        .select-input:focus {
            background-image: url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' fill='none' viewBox='0 0 20 20'%3e%3cpath stroke='%233b82f6' stroke-linecap='round' stroke-linejoin='round' stroke-width='1.5' d='m6 12 4-4 4 4'/%3e%3c/svg%3e");
        }
    </style>

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
                <input type="hidden" name="total" id="total-hidden" value="0">

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
                                    
                                    <!-- Select original oculto -->
                                    <select name="client_id" id="client_id" class="hidden" required>
                                        <option value="">Seleccionar cliente...</option>
                                        @foreach($clientes as $cliente)
                                            <option value="{{ $cliente->id }}" {{ old('client_id') == $cliente->id ? 'selected' : '' }}>
                                                {{ $cliente->first_name }} {{ $cliente->last_name }} - {{ $cliente->email }}
                                            </option>
                                        @endforeach
                                    </select>

                                    <!-- Custom select con autocomplete -->
                                    <div class="custom-select-container relative">
                                        <input type="text" id="selectInputCliente"
                                            class="select-input form-select focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                                            placeholder="Buscar cliente..." autocomplete="off" readonly>

                                        <div id="dropdownCliente" class="select-dropdown hidden"></div>
                                    </div>
                                    
                                    @error('client_id')
                                        <p class="text-red-500 text-xs italic mt-1">{{ $message }}</p>
                                    @enderror
                                </div>

                                <div>
                                    <label class="form-label">Cotización Base (Opcional)</label>
                                    <select name="cotizacion_id" id="cotizacion_id" class="form-select">
                                        <option value="">Sin cotización base...</option>
                                        @foreach($cotizaciones as $cotizacion)
                                            @php
                                                // Mapear los detalles al formato esperado por el formulario
                                                $detallesMapeados = $cotizacion->detalles->map(function($detalle) {
                                                    return [
                                                        'servicio_id' => $detalle->servicio_id,
                                                        'nombre_item' => $detalle->servicio ? $detalle->servicio->nombre : 'Item sin nombre',
                                                        'cantidad' => $detalle->cantidad,
                                                        'precio_unitario' => $detalle->precio_unitario,
                                                        'descripcion' => $detalle->notas ?? ''
                                                    ];
                                                });
                                            @endphp
                                            <option value="{{ $cotizacion->id }}" 
                                                    data-detalles="{{ json_encode($detallesMapeados) }}"
                                                    {{ old('cotizacion_id') == $cotizacion->id ? 'selected' : '' }}>
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
                                    <textarea name="direccion_entrega" id="direccion_entrega" rows="3" class="form-input" required>{{ old('direccion_entrega') }}</textarea>
                                </div>

                                <div>
                                    <label class="form-label">Teléfono de Contacto *</label>
                                    <input type="text" name="telefono_contacto" id="telefono_contacto" class="form-input" value="{{ old('telefono_contacto') }}" required>
                                </div>

                                <div>
                                    <label class="form-label">Fecha de Entrega (Estimada)</label>
                                    <input type="date" name="fecha_entrega" id="fecha_entrega" class="form-input" value="{{ old('fecha_entrega') }}" min="{{ date('Y-m-d') }}">
                                </div>

                                <div class="md:col-span-2">
                                    <label class="form-label">Observaciones</label>
                                    <textarea name="observaciones" id="observaciones" rows="3" class="form-input" placeholder="Instrucciones especiales, notas adicionales...">{{ old('observaciones') }}</textarea>
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
                                            <select name="detalles[0][servicio_id]" class="form-select servicio-select">
                                                <option value="">Seleccionar...</option>
                                                @foreach($servicios as $servicio)
                                                    <option value="{{ $servicio->id }}" 
                                                            data-nombre="{{ $servicio->nombre }}" 
                                                            data-precio="{{ $servicio->precio }}">
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
                                            <input type="number" name="detalles[0][cantidad]" class="form-input cantidad" min="1" value="1" required>
                                        </div>

                                        <div>
                                            <label class="form-label">Precio Unitario *</label>
                                            <input type="number" name="detalles[0][precio_unitario]" class="form-input precio-unitario" step="0.01" min="0" required>
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
                                <button type="button" class="btn-outline" id="btn-agregar-detalle">
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
                        <button type="submit" class="btn-primary" id="btn-submit">
                            <i class="fas fa-save mr-2"></i>
                            Crear Pedido
                        </button>
                    </div>
                </div>
            </form>
        </div>

        <!-- Modal de Confirmación para Cargar Cotización -->
        <div id="modal-confirmar-carga" class="fixed inset-0 bg-gray-600 bg-opacity-50 hidden z-50">
            <div class="flex items-center justify-center min-h-screen p-4">
                <div class="bg-white rounded-lg shadow-xl max-w-md w-full mx-4">
                    <div class="px-6 py-4 bg-yellow-500">
                        <h3 class="text-lg font-semibold text-white flex items-center">
                            <i class="fas fa-exclamation-triangle mr-3"></i>
                            Confirmar Carga de Cotización
                        </h3>
                    </div>
                    <div class="p-6">
                        <p class="text-gray-700 mb-4">
                            ¿Desea cargar los detalles de esta cotización?
                        </p>
                        <p class="text-sm text-gray-500 bg-yellow-50 border border-yellow-200 rounded p-3">
                            <i class="fas fa-info-circle mr-1"></i>
                            Esto reemplazará los items actuales del pedido.
                        </p>
                    </div>
                    <div class="px-6 py-4 bg-gray-50 flex flex-col sm:flex-row justify-end space-y-2 sm:space-y-0 sm:space-x-3">
                        <button type="button" onclick="cerrarModalConfirmarCarga()"
                            class="px-4 py-2 bg-gray-200 text-gray-700 rounded-lg hover:bg-gray-300 transition w-full sm:w-auto">
                            Cancelar
                        </button>
                        <button type="button" onclick="confirmarCargaCotizacion()"
                            class="px-4 py-2 bg-yellow-500 text-white rounded-lg hover:bg-yellow-600 transition w-full sm:w-auto">
                            <i class="fas fa-check mr-2"></i>
                            Cargar Cotización
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @push('scripts')
        <script>
            let detalleIndex = 1;
            let cotizacionSelectPendiente = null;

            // Funciones para controlar el modal
            function abrirModalConfirmarCarga() {
                document.getElementById('modal-confirmar-carga').classList.remove('hidden');
            }

            function cerrarModalConfirmarCarga() {
                document.getElementById('modal-confirmar-carga').classList.add('hidden');
                // NO resetear el select, solo limpiar la referencia pendiente
                cotizacionSelectPendiente = null;
            }

            function confirmarCargaCotizacion() {
                if (cotizacionSelectPendiente) {
                    cargarDetallesCotizacion(cotizacionSelectPendiente);
                    cerrarModalConfirmarCarga();
                }
            }

            // Clase para el Custom Select de Clientes
            class CustomSelectCliente {
                constructor(originalSelectId, inputId, dropdownId) {
                    this.originalSelect = document.getElementById(originalSelectId);
                    this.input = document.getElementById(inputId);
                    this.dropdown = document.getElementById(dropdownId);
                    this.options = [];
                    this.isOpen = false;
                    this.selectedIndex = -1;

                    this.init();
                }

                init() {
                    // Cargar opciones del select original
                    this.loadOptions();

                    // Event listeners
                    this.input.addEventListener('click', () => this.toggle());
                    this.input.addEventListener('input', (e) => this.filter(e.target.value));
                    this.input.addEventListener('keydown', (e) => this.handleKeyboard(e));

                    // Cerrar dropdown al hacer click fuera
                    document.addEventListener('click', (e) => {
                        if (!e.target.closest('.custom-select-container')) {
                            this.close();
                        }
                    });
                }

                loadOptions() {
                    // Limpiar opciones
                    this.options = [];

                    // Obtener opciones del select original
                    Array.from(this.originalSelect.options).forEach(option => {
                        this.options.push({
                            value: option.value,
                            text: option.textContent.trim()
                        });
                    });

                    // Renderizar opciones
                    this.renderOptions();

                    // Restaurar valor si existe (para errores de validación)
                    this.restoreOldValue();
                }

                restoreOldValue() {
                    const oldValue = this.originalSelect.value;
                    if (oldValue) {
                        const option = this.options.find(opt => opt.value === oldValue);
                        if (option) {
                            this.input.value = option.text;
                            this.input.setAttribute('readonly', true);
                        }
                    }
                }

                renderOptions(filteredOptions = null) {
                    const optionsToRender = filteredOptions || this.options;

                    this.dropdown.innerHTML = '';

                    optionsToRender.forEach((option, index) => {
                        if (option.value === '') return; // Skip empty option

                        const div = document.createElement('div');
                        div.className = 'select-option';
                        div.textContent = option.text;
                        div.dataset.value = option.value;
                        div.dataset.originalIndex = index;

                        // Marcar como seleccionado si coincide con el valor actual
                        if (option.value === this.originalSelect.value) {
                            div.classList.add('selected');
                        }

                        div.addEventListener('click', () => {
                            this.selectOption(option);
                        });

                        this.dropdown.appendChild(div);
                    });

                    // Mensaje si no hay resultados
                    if (optionsToRender.length === 0 || (optionsToRender.length === 1 && optionsToRender[0].value === '')) {
                        const div = document.createElement('div');
                        div.className = 'select-option text-gray-500 text-center';
                        div.textContent = 'No se encontraron clientes';
                        this.dropdown.appendChild(div);
                    }
                }

                filter(searchTerm) {
                    if (!searchTerm) {
                        this.renderOptions();
                        return;
                    }

                    const filtered = this.options.filter(option =>
                        option.text.toLowerCase().includes(searchTerm.toLowerCase()) &&
                        option.value !== ''
                    );

                    this.renderOptions(filtered);

                    if (!this.isOpen) {
                        this.open();
                    }
                }

                selectOption(option) {
                    // Actualizar el select original
                    this.originalSelect.value = option.value;

                    // Actualizar el input
                    this.input.value = option.text;
                    this.input.setAttribute('readonly', true);

                    // Marcar opción como seleccionada visualmente
                    this.dropdown.querySelectorAll('.select-option').forEach(opt => {
                        opt.classList.remove('selected');
                    });

                    const selectedElement = this.dropdown.querySelector(`[data-value="${option.value}"]`);
                    if (selectedElement) {
                        selectedElement.classList.add('selected');
                    }

                    this.close();

                    // Disparar evento change en el select original
                    this.originalSelect.dispatchEvent(new Event('change'));
                }

                toggle() {
                    if (this.isOpen) {
                        this.close();
                    } else {
                        this.open();
                    }
                }

                open() {
                    this.isOpen = true;
                    this.dropdown.classList.remove('hidden');
                    this.input.removeAttribute('readonly');
                    this.input.focus();
                    this.input.select(); // Seleccionar todo el texto para facilitar búsqueda
                }

                close() {
                    this.isOpen = false;
                    this.dropdown.classList.add('hidden');
                    this.selectedIndex = -1;

                    // Si no hay selección, restaurar readonly y limpiar
                    if (!this.originalSelect.value) {
                        this.input.setAttribute('readonly', true);
                        this.input.value = '';
                    } else {
                        this.input.setAttribute('readonly', true);
                        // Restaurar el texto de la opción seleccionada si se canceló la búsqueda
                        const selectedOption = this.options.find(opt => opt.value === this.originalSelect.value);
                        if (selectedOption) {
                            this.input.value = selectedOption.text;
                        }
                    }
                }

                handleKeyboard(e) {
                    const options = this.dropdown.querySelectorAll('.select-option');

                    switch (e.key) {
                        case 'ArrowDown':
                            e.preventDefault();
                            if (!this.isOpen) {
                                this.open();
                            } else {
                                this.selectedIndex = Math.min(this.selectedIndex + 1, options.length - 1);
                                this.highlightOption(options);
                            }
                            break;

                        case 'ArrowUp':
                            e.preventDefault();
                            this.selectedIndex = Math.max(this.selectedIndex - 1, 0);
                            this.highlightOption(options);
                            break;

                        case 'Enter':
                            e.preventDefault();
                            if (this.selectedIndex >= 0 && options[this.selectedIndex]) {
                                const value = options[this.selectedIndex].dataset.value;
                                const option = this.options.find(opt => opt.value === value);
                                if (option) {
                                    this.selectOption(option);
                                }
                            }
                            break;

                        case 'Escape':
                            e.preventDefault();
                            this.close();
                            break;
                    }
                }

                highlightOption(options) {
                    // Remover highlight anterior
                    options.forEach(opt => opt.classList.remove('highlighted'));

                    // Aplicar highlight actual
                    if (options[this.selectedIndex]) {
                        options[this.selectedIndex].classList.add('highlighted');
                        options[this.selectedIndex].scrollIntoView({
                            block: 'nearest'
                        });
                    }
                }
            }

            // Función para cargar detalles desde cotización
            function cargarDetallesCotizacion(cotizacionSelect) {
                const selectedOption = cotizacionSelect.options[cotizacionSelect.selectedIndex];
                
                if (!selectedOption.value) {
                    // Si se deselecciona la cotización, limpiar detalles
                    return;
                }

                const detallesJSON = selectedOption.getAttribute('data-detalles');
                
                if (!detallesJSON) {
                    console.error('No se encontraron detalles en la cotización');
                    return;
                }

                try {
                    const detalles = JSON.parse(detallesJSON);
                    
                    if (!detalles || detalles.length === 0) {
                        console.warn('Esta cotización no tiene detalles asociados');
                        return;
                    }

                    // Limpiar detalles existentes
                    const container = document.getElementById('detalles-container');
                    container.innerHTML = '';
                    detalleIndex = 0;

                    // Agregar cada detalle de la cotización
                    detalles.forEach((detalle, index) => {
                        agregarDetalleDesdeData(detalle, index);
                    });

                    // Actualizar eventos y botones
                    actualizarEventos();
                    actualizarBotonesEliminar();
                    calcularTotal();

                } catch (error) {
                    console.error('Error al parsear detalles de cotización:', error);
                }
            }

            // Función para agregar detalle con datos específicos
            function agregarDetalleDesdeData(detalle, index) {
                const container = document.getElementById('detalles-container');
                const newDetalle = document.createElement('div');
                newDetalle.className = 'detalle-item bg-gray-50 p-4 rounded-lg border border-gray-200 mt-4';
                newDetalle.setAttribute('data-index', index);
                
                const servicioOptions = @json($servicios);
                let servicioOptionsHTML = '<option value="">Seleccionar...</option>';
                servicioOptions.forEach(servicio => {
                    const selected = detalle.servicio_id == servicio.id ? 'selected' : '';
                    servicioOptionsHTML += `<option value="${servicio.id}" 
                                                   data-nombre="${servicio.nombre}" 
                                                   data-precio="${servicio.precio}"
                                                   ${selected}>
                                               ${servicio.nombre} - Q${parseFloat(servicio.precio).toFixed(2)}
                                           </option>`;
                });
                
                newDetalle.innerHTML = `
                    <div class="flex justify-between items-start mb-4">
                        <h4 class="font-medium text-gray-900">Item #${index + 1}</h4>
                        <button type="button" class="btn-danger btn-sm remove-detalle" style="display: ${index > 0 ? 'inline-flex' : 'none'};">
                            <i class="fas fa-trash mr-1"></i>
                            Eliminar
                        </button>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
                        <div>
                            <label class="form-label">Servicio (Opcional)</label>
                            <select name="detalles[${index}][servicio_id]" class="form-select servicio-select">
                                ${servicioOptionsHTML}
                            </select>
                        </div>

                        <div>
                            <label class="form-label">Nombre del Item *</label>
                            <input type="text" name="detalles[${index}][nombre_item]" class="form-input nombre-item" value="${detalle.nombre_item || ''}" required>
                        </div>

                        <div>
                            <label class="form-label">Cantidad *</label>
                            <input type="number" name="detalles[${index}][cantidad]" class="form-input cantidad" min="1" value="${detalle.cantidad || 1}" required>
                        </div>

                        <div>
                            <label class="form-label">Precio Unitario *</label>
                            <input type="number" name="detalles[${index}][precio_unitario]" class="form-input precio-unitario" step="0.01" min="0" value="${detalle.precio_unitario || 0}" required>
                        </div>

                        <div class="md:col-span-4">
                            <label class="form-label">Descripción</label>
                            <textarea name="detalles[${index}][descripcion]" class="form-input descripcion" rows="2" placeholder="Descripción del servicio/producto...">${detalle.descripcion || ''}</textarea>
                        </div>

                        <div class="md:col-span-4">
                            <div class="text-right">
                                <span class="text-lg font-semibold text-gray-900">Subtotal: Q<span class="subtotal">0.00</span></span>
                            </div>
                        </div>
                    </div>
                `;

                container.appendChild(newDetalle);
                
                // Calcular subtotal del item recién agregado
                const cantidad = parseFloat(detalle.cantidad) || 0;
                const precioUnitario = parseFloat(detalle.precio_unitario) || 0;
                const subtotal = cantidad * precioUnitario;
                newDetalle.querySelector('.subtotal').textContent = subtotal.toFixed(2);
                
                detalleIndex++;
            }

            // Función para agregar detalle
            function agregarDetalle() {
                const container = document.getElementById('detalles-container');
                const newDetalle = document.createElement('div');
                newDetalle.className = 'detalle-item bg-gray-50 p-4 rounded-lg border border-gray-200 mt-4';
                newDetalle.setAttribute('data-index', detalleIndex);
                
                const servicioOptions = @json($servicios);
                let servicioOptionsHTML = '<option value="">Seleccionar...</option>';
                servicioOptions.forEach(servicio => {
                    servicioOptionsHTML += `<option value="${servicio.id}" 
                                                   data-nombre="${servicio.nombre}" 
                                                   data-precio="${servicio.precio}">
                                               ${servicio.nombre} - Q${parseFloat(servicio.precio).toFixed(2)}
                                           </option>`;
                });
                
                newDetalle.innerHTML = `
                    <div class="flex justify-between items-start mb-4">
                        <h4 class="font-medium text-gray-900">Item #${detalleIndex + 1}</h4>
                        <button type="button" class="btn-danger btn-sm remove-detalle">
                            <i class="fas fa-trash mr-1"></i>
                            Eliminar
                        </button>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
                        <div>
                            <label class="form-label">Servicio (Opcional)</label>
                            <select name="detalles[${detalleIndex}][servicio_id]" class="form-select servicio-select">
                                ${servicioOptionsHTML}
                            </select>
                        </div>

                        <div>
                            <label class="form-label">Nombre del Item *</label>
                            <input type="text" name="detalles[${detalleIndex}][nombre_item]" class="form-input nombre-item" required>
                        </div>

                        <div>
                            <label class="form-label">Cantidad *</label>
                            <input type="number" name="detalles[${detalleIndex}][cantidad]" class="form-input cantidad" min="1" value="1" required>
                        </div>

                        <div>
                            <label class="form-label">Precio Unitario *</label>
                            <input type="number" name="detalles[${detalleIndex}][precio_unitario]" class="form-input precio-unitario" step="0.01" min="0" required>
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
                `;

                container.appendChild(newDetalle);
                detalleIndex++;
                actualizarEventos();
                actualizarBotonesEliminar();
            }

            // Función para remover detalle
            function removerDetalle(button) {
                const detalleItem = button.closest('.detalle-item');
                detalleItem.remove();
                actualizarBotonesEliminar();
                calcularTotal();
            }

            // Función para actualizar botones de eliminar
            function actualizarBotonesEliminar() {
                const detalles = document.querySelectorAll('.detalle-item');
                const botones = document.querySelectorAll('.remove-detalle');

                botones.forEach((boton) => {
                    boton.style.display = detalles.length > 1 ? 'inline-flex' : 'none';
                });
            }

            // Función para llenar datos del servicio
            function llenarDatosServicio(select) {
                const option = select.options[select.selectedIndex];
                const detalleItem = select.closest('.detalle-item');

                if (option.value) {
                    const nombre = option.getAttribute('data-nombre');
                    const precio = option.getAttribute('data-precio');

                    detalleItem.querySelector('.nombre-item').value = nombre;
                    detalleItem.querySelector('.precio-unitario').value = precio;

                    calcularSubtotalItem(detalleItem);
                }
            }

            // Función para calcular subtotal de un item
            function calcularSubtotalItem(detalleItem) {
                const cantidad = parseFloat(detalleItem.querySelector('.cantidad').value) || 0;
                const precio = parseFloat(detalleItem.querySelector('.precio-unitario').value) || 0;
                const subtotal = cantidad * precio;

                detalleItem.querySelector('.subtotal').textContent = subtotal.toFixed(2);
                calcularTotal();
            }

            // Función para calcular total
            function calcularTotal() {
                let total = 0;
                document.querySelectorAll('.subtotal').forEach(subtotalSpan => {
                    total += parseFloat(subtotalSpan.textContent) || 0;
                });

                document.getElementById('total-pedido').textContent = total.toFixed(2);
                document.getElementById('total-hidden').value = total.toFixed(2);
            }

            // Función para actualizar eventos
            function actualizarEventos() {
                // Event listeners para servicios
                document.querySelectorAll('.servicio-select').forEach(select => {
                    select.removeEventListener('change', handleServicioChange);
                    select.addEventListener('change', handleServicioChange);
                });

                // Event listeners para cantidad y precio
                document.querySelectorAll('.cantidad, .precio-unitario').forEach(input => {
                    input.removeEventListener('input', handleCalculoChange);
                    input.addEventListener('input', handleCalculoChange);
                });

                // Event listeners para botones de eliminar
                document.querySelectorAll('.remove-detalle').forEach(button => {
                    button.removeEventListener('click', handleRemoveClick);
                    button.addEventListener('click', handleRemoveClick);
                });
            }

            // Handlers
            function handleServicioChange(e) {
                llenarDatosServicio(e.target);
            }

            function handleCalculoChange(e) {
                const detalleItem = e.target.closest('.detalle-item');
                calcularSubtotalItem(detalleItem);
            }

            function handleRemoveClick(e) {
                removerDetalle(e.target.closest('button'));
            }

            // Validación antes de enviar
            function validarFormulario() {
                const detalles = document.querySelectorAll('.detalle-item');
                
                if (detalles.length === 0) {
                    alert('Debe agregar al menos un item al pedido');
                    return false;
                }

                let valido = true;
                detalles.forEach((detalle, index) => {
                    const nombreItem = detalle.querySelector('.nombre-item').value.trim();
                    const cantidad = detalle.querySelector('.cantidad').value;
                    const precio = detalle.querySelector('.precio-unitario').value;

                    if (!nombreItem || !cantidad || !precio) {
                        alert(`Complete todos los campos requeridos del Item #${index + 1}`);
                        valido = false;
                        return;
                    }

                    if (parseFloat(cantidad) <= 0) {
                        alert(`La cantidad del Item #${index + 1} debe ser mayor a 0`);
                        valido = false;
                        return;
                    }

                    if (parseFloat(precio) < 0) {
                        alert(`El precio del Item #${index + 1} no puede ser negativo`);
                        valido = false;
                        return;
                    }
                });

                if (!valido) return false;

                const total = parseFloat(document.getElementById('total-hidden').value);
                if (total <= 0) {
                    alert('El total del pedido debe ser mayor a 0');
                    return false;
                }

                return true;
            }

            // Inicializar cuando el DOM esté listo
            document.addEventListener('DOMContentLoaded', function() {
                // Inicializar el custom select para clientes
                const customSelectCliente = new CustomSelectCliente('client_id', 'selectInputCliente', 'dropdownCliente');

                // Event listener para el select de cotización
                const cotizacionSelect = document.getElementById('cotizacion_id');
                cotizacionSelect.addEventListener('change', function() {
                    if (this.value) {
                        // Verificar si hay items actuales
                        if (document.querySelectorAll('.detalle-item').length > 0) {
                            // Guardar referencia del select para usar después
                            cotizacionSelectPendiente = this;
                            // Mostrar modal de confirmación
                            abrirModalConfirmarCarga();
                        } else {
                            // Si no hay items, cargar directamente
                            cargarDetallesCotizacion(this);
                        }
                    }
                });

                // Botón agregar detalle
                document.getElementById('btn-agregar-detalle').addEventListener('click', agregarDetalle);

                // Validación del formulario
                document.getElementById('pedidoForm').addEventListener('submit', function(e) {
                    if (!validarFormulario()) {
                        e.preventDefault();
                        return false;
                    }
                    
                    // Deshabilitar botón de submit para evitar doble envío
                    const btnSubmit = document.getElementById('btn-submit');
                    btnSubmit.disabled = true;
                    btnSubmit.innerHTML = '<i class="fas fa-spinner fa-spin mr-2"></i>Guardando...';
                });

                // Actualizar eventos iniciales
                actualizarEventos();
                actualizarBotonesEliminar();
            });
        </script>
    @endpush
@endsection
