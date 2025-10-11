@extends('layouts.app')

@section('content')
    <div class="animate-slideInUp">
        <div class="page-header">
            <div class="flex flex-col lg:flex-row lg:items-center lg:justify-between">
                <div>
                    <h1 class="page-title text-gradient">
                        <i class="fas fa-edit mr-3"></i>
                        Editar Categoría
                    </h1>
                    <p class="page-subtitle">
                        <i class="fas fa-tag mr-2"></i>
                        Modifica los datos de: <strong>{{ $categoria->nombre }}</strong>
                    </p>
                </div>
                <div class="mt-6 lg:mt-0 flex gap-3">
                    <a href="{{ route('categorias.show', $categoria) }}" class="btn-outline">
                        <i class="fas fa-eye mr-2"></i>
                        Ver Categoría
                    </a>
                    <a href="{{ route('categorias.index') }}" class="btn-outline">
                        <i class="fas fa-arrow-left mr-2"></i>
                        Volver al Listado
                    </a>
                </div>
            </div>
        </div>

        <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="card">
                <form id="form-categoria" action="{{ route('categorias.update', $categoria) }}" method="POST" enctype="multipart/form-data" onsubmit="return validarFormulario(event)">
                @csrf
                @method('PUT')
                
                <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
                    <!-- Información Básica -->
                    <div class="space-y-6">
                        <h3 class="text-lg font-semibold text-gray-900 border-b border-gray-200 pb-2">
                            <i class="fas fa-info-circle mr-2 text-blue-600"></i>
                            Información Básica
                        </h3>

                        <div>
                            <label class="form-label required">Nombre de la Categoría</label>
                            <input type="text" name="nombre" value="{{ old('nombre', $categoria->nombre) }}" 
                                   class="form-input @error('nombre') border-red-500 @enderror" 
                                   placeholder="Ej: Decoración Interior" required>
                            @error('nombre')
                                <p class="form-error">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label class="form-label">Descripción</label>
                            <textarea name="descripcion" rows="4" 
                                      class="form-input @error('descripcion') border-red-500 @enderror" 
                                      placeholder="Describe brevemente esta categoría...">{{ old('descripcion', $categoria->descripcion) }}</textarea>
                            @error('descripcion')
                                <p class="form-error">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label class="form-label flex items-center">
                                <input type="hidden" name="activo" value="0">
                                <input type="checkbox" id="checkbox-activo" name="activo" value="1" {{ old('activo', $categoria->activo ? '1' : '0') == '1' ? 'checked' : '' }}
                                       class="mr-2 rounded">
                                <i class="fas fa-check-circle mr-2 text-green-600"></i>
                                Categoría Activa
                            </label>
                            <p class="text-sm text-gray-600 mt-1">Las categorías inactivas no aparecerán en las listas de selección</p>
                        </div>

                        <!-- Información adicional -->
                        <div class="bg-gray-50 p-4 rounded-lg">
                            <h4 class="font-medium text-gray-900 mb-2">
                                <i class="fas fa-info-circle mr-2 text-blue-600"></i>
                                Información del Registro
                            </h4>
                            <div class="grid grid-cols-2 gap-4 text-sm">
                                <div>
                                    <span class="text-gray-600">ID:</span>
                                    <span class="font-mono text-gray-900">#{{ $categoria->id }}</span>
                                </div>
                                <div>
                                    <span class="text-gray-600">Servicios:</span>
                                    <span class="font-medium text-gray-900">{{ $categoria->servicios->count() }}</span>
                                </div>
                                <div>
                                    <span class="text-gray-600">Creado:</span>
                                    <span class="text-gray-900">{{ $categoria->created_at->format('d/m/Y') }}</span>
                                </div>
                                <div>
                                    <span class="text-gray-600">Actualizado:</span>
                                    <span class="text-gray-900">{{ $categoria->updated_at->format('d/m/Y') }}</span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Imagen y Vista Previa -->
                    <div class="space-y-6">
                        <h3 class="text-lg font-semibold text-gray-900 border-b border-gray-200 pb-2">
                            <i class="fas fa-image mr-2 text-purple-600"></i>
                            Imagen de la Categoría
                        </h3>

                        <!-- Imagen Actual -->
                        @if($categoria->imagen)
                        <div class="mb-4">
                            <label class="block text-sm font-medium text-gray-700 mb-2">Imagen Actual</label>
                            <div class="relative inline-block">
                                <img src="{{ asset('storage/' . $categoria->imagen) }}" 
                                     alt="{{ $categoria->nombre }}" 
                                     class="h-32 w-32 object-cover rounded-lg shadow-md">
                                <button type="button" 
                                        onclick="if(confirm('¿Estás seguro de eliminar la imagen actual?')) { removeCurrentImage(); }"
                                        class="absolute -top-2 -right-2 bg-red-500 text-white rounded-full w-6 h-6 flex items-center justify-center hover:bg-red-600 transition-colors">
                                    <i class="fas fa-times text-xs"></i>
                                </button>
                            </div>
                            <input type="hidden" id="remove_image" name="remove_image" value="0">
                        </div>
                        @endif

                        <div>
                            <label class="form-label">{{ $categoria->imagen ? 'Cambiar Imagen' : 'Agregar Imagen' }} (opcional)</label>
                            <div id="drop-zone" class="mt-1 flex justify-center px-6 pt-5 pb-6 border-2 border-gray-300 border-dashed rounded-lg hover:border-gray-400 transition-colors">
                                <div class="space-y-1 text-center">
                                    <div id="preview-container" class="hidden">
                                        <img id="image-preview" class="mx-auto h-32 w-32 object-cover rounded-lg shadow-md">
                                        <button type="button" onclick="removeImage()" class="mt-2 text-red-600 hover:text-red-800 text-sm">
                                            <i class="fas fa-times mr-1"></i>
                                            Remover imagen nueva
                                        </button>
                                    </div>
                                    <div id="upload-placeholder">
                                        <svg class="mx-auto h-12 w-12 text-gray-400" stroke="currentColor" fill="none" viewBox="0 0 48 48">
                                            <path d="M28 8H12a4 4 0 00-4 4v20m32-12v8m0 0v8a4 4 0 01-4 4H12a4 4 0 01-4-4v-4m32-4l-3.172-3.172a4 4 0 00-5.656 0L28 28M8 32l9.172-9.172a4 4 0 015.656 0L28 28m0 0l4 4m4-24h8m-4-4v8m-12 4h.02" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                                        </svg>
                                        <div class="flex text-sm text-gray-600">
                                            <label class="relative cursor-pointer bg-white rounded-md font-medium text-indigo-600 hover:text-indigo-500 focus-within:outline-none focus-within:ring-2 focus-within:ring-offset-2 focus-within:ring-indigo-500">
                                                <span>{{ $categoria->imagen ? 'Cambiar imagen' : 'Subir una imagen' }}</span>
                                                <input id="imagen" name="imagen" type="file" accept="image/*" class="sr-only" onchange="previewImage(event)">
                                            </label>
                                            <p class="pl-1">o arrastra y suelta</p>
                                        </div>
                                        <p class="text-xs text-gray-500">PNG, JPG, GIF hasta 2MB</p>
                                    </div>
                                </div>
                            </div>
                            @error('imagen')
                                <p class="form-error">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>
                </div>

                <!-- Botones de Acción -->
                <div class="flex justify-end space-x-4 pt-8 border-t border-gray-200">
                    <a href="{{ route('categorias.show', $categoria) }}" class="btn-outline">
                        <i class="fas fa-times mr-2"></i>
                        Cancelar
                    </a>
                    <button type="submit" class="btn-primary">
                        <i class="fas fa-save mr-2"></i>
                        Actualizar Categoría
                    </button>
                </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Modal de Advertencia -->
    <div id="modal-advertencia" class="fixed inset-0 bg-gray-600 bg-opacity-50 hidden z-50">
        <div class="flex items-center justify-center min-h-screen p-4">
            <div class="bg-white rounded-lg shadow-xl max-w-2xl w-full">
                <div class="px-6 py-4 bg-yellow-500">
                    <h3 class="text-lg font-semibold text-white flex items-center">
                        <i class="fas fa-exclamation-triangle mr-3"></i>
                        No se puede desactivar la categoría
                    </h3>
                </div>
                <div class="p-6">
                    <p class="text-gray-700 mb-4">
                        Esta categoría tiene <strong id="count-servicios"></strong> servicios/productos activos.
                        No puedes desactivar la categoría mientras tenga elementos activos.
                    </p>

                    <!-- Lista de Servicios -->
                    <div class="bg-gray-50 rounded-lg p-4 mb-4 max-h-60 overflow-y-auto">
                        <h4 class="font-medium text-gray-900 mb-3">
                            <i class="fas fa-list mr-2"></i>
                            Servicios/Productos Activos:
                        </h4>
                        <ul id="lista-servicios-activos" class="space-y-2">
                            <!-- Se llenará con JavaScript -->
                        </ul>
                    </div>

                    <div class="bg-blue-50 border-l-4 border-blue-500 p-4 mb-4">
                        <p class="text-sm text-blue-700">
                            <i class="fas fa-info-circle mr-2"></i>
                            <strong>Opciones:</strong>
                        </p>
                        <ul class="list-disc list-inside text-sm text-blue-700 mt-2 ml-4">
                            <li>Desactiva manualmente cada servicio/producto desde su página de edición</li>
                            <li>O usa el botón "Desactivar Todo" para desactivarlos automáticamente</li>
                        </ul>
                    </div>
                </div>
                <div class="px-6 py-4 bg-gray-50 flex justify-between">
                    <button type="button" onclick="cerrarModal()" class="btn-outline">
                        <i class="fas fa-times mr-2"></i>
                        Cancelar
                    </button>
                    <button type="button" onclick="desactivarTodo()" class="bg-red-600 text-white px-6 py-2 rounded-lg hover:bg-red-700 transition-colors font-medium">
                        <i class="fas fa-power-off mr-2"></i>
                        Desactivar Todo y Continuar
                    </button>
                </div>
            </div>
        </div>
    </div>

    @push('scripts')
    <script>
        const categoriaId = {{ $categoria->id }};
        const estadoInicial = {{ $categoria->activo ? 'true' : 'false' }};
        let serviciosActivos = @json($categoria->servicios);
        let formularioValidado = false;

        function validarFormulario(event) {
            // Si ya fue validado, permitir envío
            if (formularioValidado) {
                return true;
            }

            const checkbox = document.getElementById('checkbox-activo');
            const quiereDesactivar = !checkbox.checked;

            // Si está intentando desactivar la categoría que estaba activa
            if (quiereDesactivar && estadoInicial) {
                // Verificar si hay servicios activos
                const serviciosActivosFiltrados = serviciosActivos.filter(s => s.activo);

                if (serviciosActivosFiltrados.length > 0) {
                    // Prevenir el envío del formulario
                    event.preventDefault();

                    // Mostrar modal
                    mostrarModal(serviciosActivosFiltrados);
                    return false;
                }
            }

            // Si no hay problemas, permitir el envío
            return true;
        }

        function mostrarModal(servicios) {
            document.getElementById('count-servicios').textContent = servicios.length;

            const lista = document.getElementById('lista-servicios-activos');
            lista.innerHTML = '';

            servicios.forEach(servicio => {
                const li = document.createElement('li');
                li.className = 'flex items-center justify-between p-2 bg-white rounded border border-gray-200';
                li.innerHTML = `
                    <div class="flex items-center">
                        <i class="fas fa-${servicio.tipo == 'servicio' ? 'handshake' : 'box'} mr-2 text-${servicio.tipo == 'servicio' ? 'blue' : 'green'}-600"></i>
                        <span class="font-medium">${servicio.nombre}</span>
                        <span class="ml-2 px-2 py-1 text-xs rounded-full bg-${servicio.tipo == 'servicio' ? 'blue' : 'green'}-100 text-${servicio.tipo == 'servicio' ? 'blue' : 'green'}-700">
                            ${servicio.tipo.charAt(0).toUpperCase() + servicio.tipo.slice(1)}
                        </span>
                    </div>
                    <a href="/servicios/${servicio.id}/edit" target="_blank" class="text-sm text-indigo-600 hover:text-indigo-800">
                        <i class="fas fa-external-link-alt mr-1"></i>
                        Editar
                    </a>
                `;
                lista.appendChild(li);
            });

            document.getElementById('modal-advertencia').classList.remove('hidden');
        }

        function cerrarModal() {
            document.getElementById('modal-advertencia').classList.add('hidden');
        }

        async function desactivarTodo() {
            try {
                // Mostrar loader o desactivar botón
                const boton = event.target;
                boton.disabled = true;
                boton.innerHTML = '<i class="fas fa-spinner fa-spin mr-2"></i>Desactivando...';

                // Desactivar servicios mediante fetch
                const response = await fetch(`/categorias/${categoriaId}/desactivar-servicios`, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}',
                        'Accept': 'application/json'
                    }
                });

                if (response.ok) {
                    // Actualizar el array de servicios activos
                    serviciosActivos = serviciosActivos.map(s => ({...s, activo: false}));

                    // Cerrar modal
                    cerrarModal();

                    // Marcar como validado y enviar el formulario principal
                    formularioValidado = true;
                    document.getElementById('form-categoria').submit();
                } else {
                    alert('Error al desactivar los servicios. Por favor intenta nuevamente.');
                    boton.disabled = false;
                    boton.innerHTML = '<i class="fas fa-power-off mr-2"></i>Desactivar Todo y Continuar';
                }
            } catch (error) {
                console.error('Error:', error);
                alert('Error al desactivar los servicios. Por favor intenta nuevamente.');
            }
        }

        function previewImage(event) {
            const file = event.target.files[0];
            if (file) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    document.getElementById('image-preview').src = e.target.result;
                    document.getElementById('preview-container').classList.remove('hidden');
                    document.getElementById('upload-placeholder').classList.add('hidden');
                };
                reader.readAsDataURL(file);
            }
        }

        function removeImage() {
            document.getElementById('imagen').value = '';
            document.getElementById('preview-container').classList.add('hidden');
            document.getElementById('upload-placeholder').classList.remove('hidden');
        }

        function removeCurrentImage() {
            document.getElementById('remove_image').value = '1';
            document.querySelector('.relative.inline-block').style.display = 'none';
        }

        // Drag & Drop functionality
        const dropZone = document.getElementById('drop-zone');
        const fileInput = document.getElementById('imagen');

        if (dropZone && fileInput) {
            ['dragenter', 'dragover', 'dragleave', 'drop'].forEach(eventName => {
                dropZone.addEventListener(eventName, preventDefaults, false);
            });

            function preventDefaults(e) {
                e.preventDefault();
                e.stopPropagation();
            }

            ['dragenter', 'dragover'].forEach(eventName => {
                dropZone.addEventListener(eventName, () => {
                    dropZone.classList.add('border-indigo-500', 'bg-indigo-50');
                }, false);
            });

            ['dragleave', 'drop'].forEach(eventName => {
                dropZone.addEventListener(eventName, () => {
                    dropZone.classList.remove('border-indigo-500', 'bg-indigo-50');
                }, false);
            });

            dropZone.addEventListener('drop', handleDrop, false);

            function handleDrop(e) {
                const dt = e.dataTransfer;
                const files = dt.files;

                if (files.length > 0) {
                    fileInput.files = files;
                    previewImage({ target: { files: files } });
                }
            }
        }
    </script>
    @endpush
@endsection