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

        @if($errors->any())
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 mb-6">
                <div class="alert alert-error">
                    <i class="fas fa-exclamation-triangle text-xl"></i>
                    <div>
                        <h4 class="font-semibold">Error en el formulario</h4>
                        <ul class="list-disc list-inside mt-2">
                            @foreach($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            </div>
        @endif

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
                                <select name="client_id" id="select-cliente" class="form-select @error('client_id') border-red-500 @enderror" required>
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

                        <!-- Mensaje cuando no hay servicios -->
                        <div class="text-center py-8 text-gray-500" id="no-servicios">
                            <i class="fas fa-layer-group text-3xl mb-2"></i>
                            <p>No has agregado servicios o productos aún</p>
                            <p class="text-sm">Haz clic en "Agregar Item" para comenzar</p>
                        </div>

                        <!-- Lista de servicios seleccionados -->
                        <div id="servicios-seleccionados"></div>
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
                                <button type="submit" class="w-full btn-primary" onclick="return validarFormulario(event)">
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
        <div id="modal-servicios" class="fixed inset-0 bg-gray-600 bg-opacity-50 hidden z-50" onclick="event.target === this && cerrarModal()">
            <div class="flex items-center justify-center min-h-screen p-4">
                <div class="bg-white rounded-lg shadow-xl max-w-6xl w-full max-h-[90vh] overflow-hidden" onclick="event.stopPropagation()">
                    <div class="px-6 py-4 border-b border-gray-200 flex items-center justify-between bg-gradient-to-r from-purple-600 to-indigo-600">
                        <h3 class="text-lg font-semibold text-white">
                            <i class="fas fa-shopping-cart mr-2"></i>
                            Seleccionar Servicios/Productos
                        </h3>
                        <button type="button" onclick="cerrarModal()" class="text-white hover:text-gray-200 transition">
                            <i class="fas fa-times text-2xl"></i>
                        </button>
                    </div>

                    <!-- Filtros dentro del modal -->
                    <div class="px-6 py-4 bg-gray-50 border-b">
                        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Categoría</label>
                                <select id="filtro-categoria-modal" class="form-select" onchange="filtrarServiciosModal()">
                                    <option value="">Todas las categorías</option>
                                    @foreach($categorias as $categoria)
                                        <option value="{{ $categoria->id }}">{{ $categoria->nombre }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Tipo</label>
                                <select id="filtro-tipo-modal" class="form-select" onchange="filtrarServiciosModal()">
                                    <option value="">Todos</option>
                                    <option value="servicio">Servicios</option>
                                    <option value="producto">Productos</option>
                                </select>
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Buscar</label>
                                <input type="text" id="filtro-buscar-modal" class="form-input"
                                       placeholder="Buscar por nombre..." onkeyup="filtrarServiciosModal()">
                            </div>
                        </div>
                    </div>

                    <div class="p-6 overflow-y-auto" style="max-height: calc(90vh - 300px);" id="lista-servicios">
                        <!-- Los servicios se cargarán aquí via JavaScript -->
                    </div>

                    <!-- Paginación -->
                    <div class="px-6 py-3 bg-gray-50 border-t border-b" id="paginacion-modal">
                        <!-- La paginación se cargará aquí -->
                    </div>
                    <div class="px-6 py-4 border-t border-gray-200 bg-gray-50 flex justify-between items-center">
                        <p class="text-sm text-gray-600">
                            <i class="fas fa-info-circle mr-1"></i>
                            Haz clic en los items para agregarlos. El modal no se cerrará automáticamente.
                        </p>
                        <button type="button" onclick="cerrarModal()" class="btn-primary">
                            <i class="fas fa-check mr-2"></i>
                            Cerrar y Continuar
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @push('styles')
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <style>
        .select2-container--default .select2-selection--single {
            height: 42px !important;
            border: 1px solid #d1d5db !important;
            border-radius: 0.5rem !important;
            padding: 0.5rem !important;
        }
        .select2-container--default .select2-selection--single .select2-selection__rendered {
            line-height: 28px !important;
            padding-left: 0 !important;
        }
        .select2-container--default .select2-selection--single .select2-selection__arrow {
            height: 40px !important;
        }
        .select2-dropdown {
            border: 1px solid #d1d5db !important;
            border-radius: 0.5rem !important;
        }
    </style>
    @endpush

    @push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <script>
        // Inicializar Select2 para el selector de clientes
        $(document).ready(function() {
            $('#select-cliente').select2({
                placeholder: 'Buscar cliente por nombre o email...',
                allowClear: true,
                width: '100%'
            });
        });

        // Cargar servicios con sus categorías
        let serviciosDisponibles = [];
        @foreach($categorias as $categoria)
            @foreach($categoria->servicios as $servicio)
                serviciosDisponibles.push({
                    id: {{ $servicio->id }},
                    nombre: "{{ addslashes($servicio->nombre) }}",
                    descripcion: "{{ addslashes($servicio->descripcion ?? '') }}",
                    precio: {{ $servicio->precio }},
                    tipo: "{{ $servicio->tipo }}",
                    categoria_id: {{ $servicio->categoria_id }},
                    activo: {{ $servicio->activo ? 'true' : 'false' }},
                    imagen: "{{ $servicio->imagen ?? '' }}",
                    categoria: {
                        id: {{ $categoria->id }},
                        nombre: "{{ addslashes($categoria->nombre) }}"
                    }
                });
            @endforeach
        @endforeach

        let serviciosSeleccionados = [];
        let contadorServicios = 0;
        let paginaActual = 1;
        let itemsPorPagina = 12;

        function agregarServicio() {
            document.getElementById('modal-servicios').classList.remove('hidden');
            paginaActual = 1;
            cargarServicios();
        }

        function filtrarServicios() {
            const categoriaFiltro = document.getElementById('filtro-categoria').value;
            const tipoFiltro = document.getElementById('filtro-tipo').value;
            const busqueda = document.getElementById('filtro-buscar').value.toLowerCase();

            let serviciosFiltrados = serviciosDisponibles.filter(servicio => {
                let coincide = servicio.activo;

                if (categoriaFiltro && servicio.categoria_id != categoriaFiltro) {
                    coincide = false;
                }

                if (tipoFiltro && servicio.tipo != tipoFiltro) {
                    coincide = false;
                }

                if (busqueda && !servicio.nombre.toLowerCase().includes(busqueda)) {
                    coincide = false;
                }

                return coincide;
            });

            cargarServicios(serviciosFiltrados);
        }

        function filtrarServiciosModal() {
            paginaActual = 1;
            const categoriaFiltro = document.getElementById('filtro-categoria-modal').value;
            const tipoFiltro = document.getElementById('filtro-tipo-modal').value;
            const busqueda = document.getElementById('filtro-buscar-modal').value.toLowerCase();

            let serviciosFiltrados = serviciosDisponibles.filter(servicio => {
                let coincide = servicio.activo;

                if (categoriaFiltro && servicio.categoria_id != categoriaFiltro) {
                    coincide = false;
                }

                if (tipoFiltro && servicio.tipo != tipoFiltro) {
                    coincide = false;
                }

                if (busqueda && !servicio.nombre.toLowerCase().includes(busqueda)) {
                    coincide = false;
                }

                return coincide;
            });

            cargarServicios(serviciosFiltrados);
        }

        function cargarServicios(servicios = null) {
            let listaServicios = servicios || serviciosDisponibles.filter(s => s.activo);

            // Calcular paginación
            const totalPaginas = Math.ceil(listaServicios.length / itemsPorPagina);
            const inicio = (paginaActual - 1) * itemsPorPagina;
            const fin = inicio + itemsPorPagina;
            const serviciosPaginados = listaServicios.slice(inicio, fin);

            let html = '<div class="grid grid-cols-1 md:grid-cols-3 gap-4">';

            if (serviciosPaginados.length === 0) {
                html = '<div class="text-center py-8 text-gray-500"><i class="fas fa-search text-3xl mb-2"></i><p>No se encontraron servicios o productos</p></div>';
            } else {
                serviciosPaginados.forEach(servicio => {
                    const imagen = servicio.imagen ? `/storage/${servicio.imagen}` : '';
                    html += `
                        <div class="border border-gray-200 rounded-lg overflow-hidden hover:shadow-lg transition-all cursor-pointer transform hover:scale-105" onclick="seleccionarServicio(${servicio.id})">
                            <div class="h-32 bg-gray-100 flex items-center justify-center">
                                ${imagen ? `<img src="${imagen}" alt="${servicio.nombre}" class="h-full w-full object-cover">` : '<i class="fas fa-image text-4xl text-gray-300"></i>'}
                            </div>
                            <div class="p-3">
                                <div class="flex gap-1 mb-2">
                                    <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium ${servicio.tipo == 'servicio' ? 'bg-purple-100 text-purple-700' : 'bg-blue-100 text-blue-700'}">
                                        ${servicio.tipo.charAt(0).toUpperCase() + servicio.tipo.slice(1)}
                                    </span>
                                    <span class="inline-flex items-center px-2 py-1 rounded-full text-xs bg-gray-100 text-gray-600">
                                        ${servicio.categoria?.nombre || 'Sin categoría'}
                                    </span>
                                </div>
                                <h4 class="font-semibold text-gray-900 text-sm mb-1">${servicio.nombre}</h4>
                                <p class="text-sm text-gray-600 mb-2 line-clamp-2">${servicio.descripcion || ''}</p>
                                <div class="flex justify-between items-center">
                                    <p class="text-lg font-bold text-green-600">Q${parseFloat(servicio.precio).toFixed(2)}</p>
                                    <button type="button" class="btn-primary btn-sm" onclick="event.stopPropagation(); seleccionarServicio(${servicio.id})">
                                        <i class="fas fa-plus"></i>
                                    </button>
                                </div>
                            </div>
                        </div>
                    `;
                });
            }

            html += '</div>';
            document.getElementById('lista-servicios').innerHTML = html;

            // Renderizar paginación
            renderizarPaginacion(totalPaginas, listaServicios);
        }

        function renderizarPaginacion(totalPaginas, servicios) {
            if (totalPaginas <= 1) {
                document.getElementById('paginacion-modal').innerHTML = '';
                return;
            }

            let html = '<div class="flex items-center justify-between">';
            html += `<p class="text-sm text-gray-600">Mostrando ${servicios.length} servicios - Página ${paginaActual} de ${totalPaginas}</p>`;
            html += '<div class="flex gap-2">';

            // Botón anterior
            if (paginaActual > 1) {
                html += `<button type="button" onclick="cambiarPagina(${paginaActual - 1})" class="px-3 py-1 bg-gray-200 hover:bg-gray-300 rounded"><i class="fas fa-chevron-left"></i></button>`;
            }

            // Páginas
            for (let i = 1; i <= totalPaginas; i++) {
                if (i === paginaActual) {
                    html += `<button type="button" class="px-3 py-1 bg-purple-600 text-white rounded">${i}</button>`;
                } else {
                    html += `<button type="button" onclick="cambiarPagina(${i})" class="px-3 py-1 bg-gray-200 hover:bg-gray-300 rounded">${i}</button>`;
                }
            }

            // Botón siguiente
            if (paginaActual < totalPaginas) {
                html += `<button type="button" onclick="cambiarPagina(${paginaActual + 1})" class="px-3 py-1 bg-gray-200 hover:bg-gray-300 rounded"><i class="fas fa-chevron-right"></i></button>`;
            }

            html += '</div></div>';
            document.getElementById('paginacion-modal').innerHTML = html;
        }

        function cambiarPagina(pagina) {
            paginaActual = pagina;
            filtrarServiciosModal();
        }

        function seleccionarServicio(servicioId) {
            let servicio = serviciosDisponibles.find(s => s.id == servicioId);
            if (servicio) {
                agregarServicioACotizacion(servicio);
                // No cerramos el modal para permitir agregar múltiples items
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

            // Mostrar notificación
            mostrarNotificacion(`✓ ${servicio.nombre} agregado`);
        }

        function mostrarNotificacion(mensaje) {
            const notif = document.createElement('div');
            notif.className = 'fixed top-4 right-4 bg-green-500 text-white px-6 py-3 rounded-lg shadow-lg z-50 animate-fade-in';
            notif.innerHTML = `<i class="fas fa-check-circle mr-2"></i>${mensaje}`;
            document.body.appendChild(notif);

            setTimeout(() => {
                notif.remove();
            }, 2000);
        }

        function renderizarServicios() {
            let container = document.getElementById('servicios-seleccionados');
            let noServicios = document.getElementById('no-servicios');

            if (serviciosSeleccionados.length === 0) {
                noServicios.style.display = 'block';
                container.innerHTML = '';
                return;
            }

            noServicios.style.display = 'none';

            let html = '';
            serviciosSeleccionados.forEach((item, index) => {
                html += `
                    <div class="border border-gray-200 rounded-lg p-4 mb-4 relative" data-item-id="${item.id}">
                        <input type="hidden" name="servicios[${index}][servicio_id]" value="${item.servicio_id}">
                        <div class="flex items-start justify-between mb-3">
                            <div class="flex-1 pr-12">
                                <h4 class="font-semibold text-gray-900">${item.servicio.nombre}</h4>
                                <p class="text-sm text-gray-600">${item.servicio.categoria?.nombre || ''}</p>
                            </div>
                            <button type="button" onclick="removerServicio(${item.id})"
                                    class="w-8 h-8 bg-red-500 text-white rounded-full hover:bg-red-600 transition-all flex items-center justify-center shadow-lg">
                                <i class="fas fa-times"></i>
                            </button>
                        </div>
                        <div class="grid grid-cols-3 gap-4">
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
            console.log('Removiendo servicio ID:', itemId);
            console.log('Antes:', serviciosSeleccionados);
            serviciosSeleccionados = serviciosSeleccionados.filter(s => s.id !== itemId);
            console.log('Después:', serviciosSeleccionados);
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

        function validarFormulario(event) {
            console.log('=== VALIDACIÓN FORMULARIO ===');

            // Validar que haya seleccionado un cliente
            const clienteId = document.querySelector('select[name="client_id"]').value;
            console.log('Cliente seleccionado:', clienteId);

            if (!clienteId) {
                event.preventDefault();
                alert('Por favor selecciona un cliente');
                return false;
            }

            // Validar que haya al menos un servicio
            console.log('Servicios seleccionados:', serviciosSeleccionados.length);

            if (serviciosSeleccionados.length === 0) {
                event.preventDefault();
                alert('Por favor agrega al menos un servicio o producto a la cotización');
                return false;
            }

            // CRÍTICO: Re-renderizar servicios para asegurar que los inputs estén en el DOM
            console.log('⚠️ Re-renderizando servicios antes de enviar...');
            renderizarServicios();

            // Pequeño delay para asegurar que el DOM se actualice
            setTimeout(() => {
                // Verificar campos de servicios en el DOM
                const servicioInputs = document.querySelectorAll('input[name^="servicios"]');
                console.log('=== CAMPOS DE SERVICIOS EN DOM ===', servicioInputs.length);
                servicioInputs.forEach(input => {
                    console.log(`${input.name} = ${input.value}`);
                });

                // Verificar si el contenedor está dentro del form
                const container = document.getElementById('servicios-seleccionados');
                const form = document.getElementById('cotizacion-form');
                console.log('Container dentro del form:', form.contains(container));

                // Log para debug de datos que se enviarán
                const formData = new FormData(document.getElementById('cotizacion-form'));
                console.log('=== DATOS DEL FORMULARIO (FormData) ===');
                let hasServicios = false;
                for (let pair of formData.entries()) {
                    console.log(pair[0] + ': ' + pair[1]);
                    if (pair[0].startsWith('servicios')) {
                        hasServicios = true;
                    }
                }

                if (!hasServicios) {
                    console.error('❌ ERROR: Los servicios NO se están enviando en el FormData');
                    console.log('Servicios en memoria:', serviciosSeleccionados);
                } else {
                    console.log('✅ Servicios detectados en FormData, enviando formulario...');
                    // Enviar el formulario manualmente
                    document.getElementById('cotizacion-form').submit();
                }
            }, 100);

            // Prevenir el envío automático para que podamos enviarlo después del delay
            event.preventDefault();
            return false;
        }

        // Debug: Mostrar errores de validación si existen
        @if($errors->any())
            console.error('Errores de validación:', @json($errors->all()));
            alert('Error en el formulario:\n' + @json($errors->all()).join('\n'));
        @endif

        // Agregar log cuando se carga la página
        console.log('=== FORMULARIO CREACIÓN COTIZACIÓN CARGADO ===');
    </script>
    @endpush
@endsection