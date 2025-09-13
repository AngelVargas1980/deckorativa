@extends('layouts.app')

@section('content')
    <div class="animate-slideInUp">
        <div class="page-header">
            <div class="flex flex-col lg:flex-row lg:items-center lg:justify-between">
                <div>
                    <h1 class="page-title text-gradient">
                        <i class="fas fa-plus mr-3"></i>
                        Nueva Cotización
                    </h1>
                    <p class="page-subtitle">
                        <i class="fas fa-calculator mr-2"></i>
                        Crea una cotización personalizada para tu cliente
                    </p>
                </div>
                <div class="mt-6 lg:mt-0">
                    <a href="{{ route('cotizaciones.index') }}" class="btn-outline">
                        <i class="fas fa-arrow-left mr-2"></i>
                        Volver al Listado
                    </a>
                </div>
            </div>
        </div>

        <form action="{{ route('cotizaciones.store') }}" method="POST" id="cotizacion-form">
            @csrf
            
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
                                    <option value="">Seleccionar cliente</option>
                                    @foreach($clientes as $cliente)
                                        <option value="{{ $cliente->id }}" {{ old('client_id') == $cliente->id ? 'selected' : '' }}>
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
                                       value="{{ old('fecha_vigencia', now()->addDays(30)->format('Y-m-d')) }}" 
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
                                      placeholder="Notas adicionales sobre la cotización...">{{ old('observaciones') }}</textarea>
                            @error('observaciones')
                                <p class="form-error">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    <!-- Servicios y Productos -->
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

                        <!-- Filtros para selección -->
                        <div class="bg-gray-50 p-4 rounded-lg mb-4">
                            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-1">Categoría</label>
                                    <select id="filtro-categoria" class="form-select" onchange="filtrarServicios()">
                                        <option value="">Todas las categorías</option>
                                        @foreach($categorias as $categoria)
                                            <option value="{{ $categoria->id }}">{{ $categoria->nombre }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-1">Tipo</label>
                                    <select id="filtro-tipo" class="form-select" onchange="filtrarServicios()">
                                        <option value="">Todos</option>
                                        <option value="servicio">Servicios</option>
                                        <option value="producto">Productos</option>
                                    </select>
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-1">Buscar</label>
                                    <input type="text" id="filtro-buscar" class="form-input" 
                                           placeholder="Buscar por nombre..." onkeyup="filtrarServicios()">
                                </div>
                            </div>
                        </div>

                        <!-- Lista de servicios seleccionados -->
                        <div id="servicios-seleccionados">
                            <div class="text-center py-8 text-gray-500" id="no-servicios">
                                <i class="fas fa-layer-group text-3xl mb-2"></i>
                                <p>No has agregado servicios o productos aún</p>
                                <p class="text-sm">Haz clic en "Agregar Item" para comenzar</p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Resumen de la Cotización -->
                <div class="lg:col-span-1">
                    <div class="card sticky top-6">
                        <h3 class="text-lg font-semibold text-gray-900 mb-4">
                            <i class="fas fa-calculator mr-2 text-purple-600"></i>
                            Resumen de Cotización
                        </h3>

                        <div class="space-y-4">
                            <div class="flex justify-between items-center">
                                <span class="text-gray-600">Subtotal:</span>
                                <span id="subtotal" class="font-semibold">Q0.00</span>
                            </div>

                            <div class="flex justify-between items-center">
                                <div>
                                    <span class="text-gray-600">Descuento:</span>
                                    <div class="mt-1">
                                        <input type="number" name="descuento" value="{{ old('descuento', 0) }}" 
                                               step="0.01" min="0" class="form-input text-sm" 
                                               style="width: 80px;" onchange="calcularTotales()">
                                    </div>
                                </div>
                                <span id="descuento-display" class="font-semibold text-red-600">-Q0.00</span>
                            </div>

                            <div class="flex justify-between items-center">
                                <span class="text-gray-600">IVA (12%):</span>
                                <span id="impuesto" class="font-semibold">Q0.00</span>
                            </div>

                            <div class="border-t pt-4">
                                <div class="flex justify-between items-center">
                                    <span class="text-lg font-bold text-gray-900">Total:</span>
                                    <span id="total" class="text-2xl font-bold text-green-600">Q0.00</span>
                                </div>
                            </div>

                            <div class="pt-4 border-t">
                                <button type="submit" class="w-full btn-primary">
                                    <i class="fas fa-save mr-2"></i>
                                    Crear Cotización
                                </button>
                                <a href="{{ route('cotizaciones.index') }}" class="w-full btn-outline mt-2">
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

        <!-- Modal para agregar servicios -->
        <div id="modal-servicios" class="fixed inset-0 bg-gray-600 bg-opacity-50 hidden z-50">
            <div class="flex items-center justify-center min-h-screen p-4">
                <div class="bg-white rounded-lg shadow-xl max-w-4xl w-full max-h-96 overflow-hidden">
                    <div class="px-6 py-4 border-b border-gray-200">
                        <h3 class="text-lg font-semibold">Seleccionar Servicios/Productos</h3>
                        <button type="button" onclick="cerrarModal()" class="absolute top-4 right-4 text-gray-400 hover:text-gray-600">
                            <i class="fas fa-times text-xl"></i>
                        </button>
                    </div>
                    <div class="p-6 overflow-y-auto max-h-80" id="lista-servicios">
                        <!-- Los servicios se cargarán aquí via JavaScript -->
                    </div>
                </div>
            </div>
        </div>
    </div>

    @push('scripts')
    <script>
        let serviciosDisponibles = @json($categorias->load('servicios')->pluck('servicios')->flatten());
        let serviciosSeleccionados = [];
        let contadorServicios = 0;

        function agregarServicio() {
            document.getElementById('modal-servicios').classList.remove('hidden');
            cargarServicios();
        }

        function cargarServicios() {
            let html = '<div class="grid grid-cols-1 md:grid-cols-2 gap-4">';
            serviciosDisponibles.forEach(servicio => {
                if (servicio.activo) {
                    html += `
                        <div class="border border-gray-200 rounded-lg p-4 hover:shadow-md transition-shadow cursor-pointer" onclick="seleccionarServicio(${servicio.id})">
                            <div class="flex items-center justify-between">
                                <div class="flex-1">
                                    <h4 class="font-semibold text-gray-900">${servicio.nombre}</h4>
                                    <p class="text-sm text-gray-600">${servicio.categoria?.nombre || ''}</p>
                                    <p class="text-lg font-bold text-green-600">Q${parseFloat(servicio.precio).toFixed(2)}</p>
                                </div>
                                <div class="text-right">
                                    <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium ${servicio.tipo == 'servicio' ? 'bg-blue-100 text-blue-800' : 'bg-green-100 text-green-800'}">
                                        ${servicio.tipo.charAt(0).toUpperCase() + servicio.tipo.slice(1)}
                                    </span>
                                </div>
                            </div>
                        </div>
                    `;
                }
            });
            html += '</div>';
            document.getElementById('lista-servicios').innerHTML = html;
        }

        function seleccionarServicio(servicioId) {
            let servicio = serviciosDisponibles.find(s => s.id == servicioId);
            if (servicio) {
                agregarServicioACotizacion(servicio);
                cerrarModal();
            }
        }

        function agregarServicioACotizacion(servicio) {
            contadorServicios++;
            serviciosSeleccionados.push({
                id: contadorServicios,
                servicio_id: servicio.id,
                servicio: servicio,
                cantidad: 1,
                precio_unitario: servicio.precio,
                subtotal: servicio.precio
            });

            renderizarServicios();
            calcularTotales();
        }

        function renderizarServicios() {
            let container = document.getElementById('servicios-seleccionados');
            let noServicios = document.getElementById('no-servicios');

            if (serviciosSeleccionados.length === 0) {
                noServicios.style.display = 'block';
                return;
            }

            noServicios.style.display = 'none';

            let html = '';
            serviciosSeleccionados.forEach((item, index) => {
                html += `
                    <div class="border border-gray-200 rounded-lg p-4 mb-4">
                        <input type="hidden" name="servicios[${index}][servicio_id]" value="${item.servicio_id}">
                        <div class="flex items-center justify-between">
                            <div class="flex-1">
                                <h4 class="font-semibold text-gray-900">${item.servicio.nombre}</h4>
                                <p class="text-sm text-gray-600">${item.servicio.categoria?.nombre || ''}</p>
                            </div>
                            <button type="button" onclick="removerServicio(${item.id})" class="text-red-600 hover:text-red-800">
                                <i class="fas fa-trash"></i>
                            </button>
                        </div>
                        <div class="grid grid-cols-3 gap-4 mt-4">
                            <div>
                                <label class="block text-sm text-gray-600">Cantidad</label>
                                <input type="number" name="servicios[${index}][cantidad]" value="${item.cantidad}" min="1" 
                                       class="form-input" onchange="actualizarCantidad(${item.id}, this.value)">
                            </div>
                            <div>
                                <label class="block text-sm text-gray-600">Precio Unit.</label>
                                <input type="text" value="Q${parseFloat(item.precio_unitario).toFixed(2)}" class="form-input" readonly>
                            </div>
                            <div>
                                <label class="block text-sm text-gray-600">Subtotal</label>
                                <input type="text" value="Q${parseFloat(item.subtotal).toFixed(2)}" class="form-input font-bold text-green-600" readonly>
                            </div>
                        </div>
                        <div class="mt-2">
                            <label class="block text-sm text-gray-600">Notas (opcional)</label>
                            <input type="text" name="servicios[${index}][notas]" class="form-input" placeholder="Notas adicionales...">
                        </div>
                    </div>
                `;
            });

            container.innerHTML = html;
        }

        function actualizarCantidad(itemId, cantidad) {
            let item = serviciosSeleccionados.find(s => s.id == itemId);
            if (item) {
                item.cantidad = parseInt(cantidad);
                item.subtotal = item.cantidad * item.precio_unitario;
                renderizarServicios();
                calcularTotales();
            }
        }

        function removerServicio(itemId) {
            serviciosSeleccionados = serviciosSeleccionados.filter(s => s.id != itemId);
            renderizarServicios();
            calcularTotales();
        }

        function calcularTotales() {
            let subtotal = serviciosSeleccionados.reduce((sum, item) => sum + parseFloat(item.subtotal), 0);
            let descuento = parseFloat(document.querySelector('input[name="descuento"]').value) || 0;
            let subtotalConDescuento = subtotal - descuento;
            let impuesto = subtotalConDescuento * 0.12;
            let total = subtotalConDescuento + impuesto;

            document.getElementById('subtotal').textContent = 'Q' + subtotal.toFixed(2);
            document.getElementById('descuento-display').textContent = '-Q' + descuento.toFixed(2);
            document.getElementById('impuesto').textContent = 'Q' + impuesto.toFixed(2);
            document.getElementById('total').textContent = 'Q' + total.toFixed(2);
        }

        function cerrarModal() {
            document.getElementById('modal-servicios').classList.add('hidden');
        }
    </script>
    @endpush
@endsection