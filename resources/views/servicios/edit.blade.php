@extends('layouts.app')

@section('content')
    <div class="animate-slideInUp">
        <div class="page-header">
            <div class="flex flex-col lg:flex-row lg:items-center lg:justify-between">
                <div>
                    <h1 class="page-title text-gradient">
                        <i class="fas fa-edit mr-3"></i>
                        Editar {{ ucfirst($servicio->tipo) }}
                    </h1>
                    <p class="page-subtitle">
                        <i class="fas fa-layer-group mr-2"></i>
                        Modifica: <strong>{{ $servicio->nombre }}</strong>
                    </p>
                </div>
                <div class="mt-6 lg:mt-0 flex gap-3">
                    <a href="{{ route('servicios.show', $servicio) }}" class="btn-outline">
                        <i class="fas fa-eye mr-2"></i>
                        Ver {{ ucfirst($servicio->tipo) }}
                    </a>
                    <a href="{{ route('servicios.index') }}" class="btn-outline">
                        <i class="fas fa-arrow-left mr-2"></i>
                        Volver al Catálogo
                    </a>
                </div>
            </div>
        </div>

        <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="card">
                <form action="{{ route('servicios.update', $servicio) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                
                <!-- Mismos campos que create pero con valores del servicio -->
                <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
                    <div class="space-y-6">
                        <h3 class="text-lg font-semibold text-gray-900 border-b border-gray-200 pb-2">
                            <i class="fas fa-info-circle mr-2 text-blue-600"></i>
                            Información Básica
                        </h3>

                        <div>
                            <label class="form-label required">Nombre</label>
                            <input type="text" name="nombre" value="{{ old('nombre', $servicio->nombre) }}" 
                                   class="form-input @error('nombre') border-red-500 @enderror" required>
                            @error('nombre')
                                <p class="form-error">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label class="form-label">Descripción</label>
                            <textarea name="descripcion" rows="4" 
                                      class="form-input @error('descripcion') border-red-500 @enderror">{{ old('descripcion', $servicio->descripcion) }}</textarea>
                            @error('descripcion')
                                <p class="form-error">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div>
                                <label class="form-label required">Tipo</label>
                                <select name="tipo" class="form-select @error('tipo') border-red-500 @enderror" required>
                                    <option value="servicio" {{ old('tipo', $servicio->tipo) == 'servicio' ? 'selected' : '' }}>Servicio</option>
                                    <option value="producto" {{ old('tipo', $servicio->tipo) == 'producto' ? 'selected' : '' }}>Producto</option>
                                </select>
                                @error('tipo')
                                    <p class="form-error">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label class="form-label required">Categoría</label>
                                <select name="categoria_id" class="form-select @error('categoria_id') border-red-500 @enderror" required>
                                    @foreach($categorias as $categoria)
                                        <option value="{{ $categoria->id }}" {{ old('categoria_id', $servicio->categoria_id) == $categoria->id ? 'selected' : '' }}>
                                            {{ $categoria->nombre }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('categoria_id')
                                    <p class="form-error">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div>
                                <label class="form-label required">Precio</label>
                                <div class="relative">
                                    <span class="absolute left-3 top-1/2 transform -translate-y-1/2 text-gray-500">Q</span>
                                    <input type="number" name="precio" value="{{ old('precio', $servicio->precio) }}" step="0.01" min="0"
                                           class="form-input pl-8 @error('precio') border-red-500 @enderror" required>
                                </div>
                                @error('precio')
                                    <p class="form-error">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label class="form-label required">Unidad de Medida</label>
                                <select name="unidad_medida" class="form-select @error('unidad_medida') border-red-500 @enderror" required>
                                    <option value="unidad" {{ old('unidad_medida', $servicio->unidad_medida) == 'unidad' ? 'selected' : '' }}>Unidad</option>
                                    <option value="servicio" {{ old('unidad_medida', $servicio->unidad_medida) == 'servicio' ? 'selected' : '' }}>Servicio</option>
                                    <option value="metro" {{ old('unidad_medida', $servicio->unidad_medida) == 'metro' ? 'selected' : '' }}>Metro</option>
                                    <option value="metro2" {{ old('unidad_medida', $servicio->unidad_medida) == 'metro2' ? 'selected' : '' }}>Metro²</option>
                                    <option value="hora" {{ old('unidad_medida', $servicio->unidad_medida) == 'hora' ? 'selected' : '' }}>Hora</option>
                                    <option value="evento" {{ old('unidad_medida', $servicio->unidad_medida) == 'evento' ? 'selected' : '' }}>Evento</option>
                                </select>
                                @error('unidad_medida')
                                    <p class="form-error">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>

                        <div>
                            <label class="form-label">Tiempo Estimado (minutos)</label>
                            <input type="number" name="tiempo_estimado" value="{{ old('tiempo_estimado', $servicio->tiempo_estimado) }}" min="1"
                                   class="form-input @error('tiempo_estimado') border-red-500 @enderror">
                            @error('tiempo_estimado')
                                <p class="form-error">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label class="form-label flex items-center">
                                <input type="checkbox" name="activo" value="1" {{ old('activo', $servicio->activo) ? 'checked' : '' }} 
                                       class="mr-2 rounded">
                                <i class="fas fa-check-circle mr-2 text-green-600"></i>
                                Activo
                            </label>
                        </div>
                    </div>

                    <div class="space-y-6">
                        <h3 class="text-lg font-semibold text-gray-900 border-b border-gray-200 pb-2">
                            <i class="fas fa-image mr-2 text-purple-600"></i>
                            Imagen
                        </h3>

                        <div>
                            <label class="form-label">{{ $servicio->imagen ? 'Cambiar Imagen' : 'Agregar Imagen' }} (opcional)</label>
                            <div id="drop-zone" class="mt-1 flex justify-center px-6 pt-5 pb-6 border-2 border-gray-300 border-dashed rounded-lg hover:border-gray-400 transition-colors">
                                <div class="space-y-1 text-center">
                                    <div id="preview-container" class="{{ $servicio->imagen ? '' : 'hidden' }}">
                                        <img id="image-preview"
                                             src="{{ $servicio->imagen ? asset('storage/' . $servicio->imagen) : '' }}"
                                             class="mx-auto h-32 w-32 object-cover rounded-lg shadow-md">
                                        <button type="button" onclick="removeImage()" class="mt-2 text-red-600 hover:text-red-800 text-sm">
                                            <i class="fas fa-times mr-1"></i>
                                            Remover imagen
                                        </button>
                                    </div>
                                    <div id="upload-placeholder" class="{{ $servicio->imagen ? 'hidden' : '' }}">
                                        <i class="fas fa-image text-4xl text-gray-400 mb-4"></i>
                                        <div class="flex text-sm text-gray-600">
                                            <label class="relative cursor-pointer bg-white rounded-md font-medium text-indigo-600 hover:text-indigo-500">
                                                <span>Subir una imagen</span>
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

                <div class="flex justify-end space-x-4 pt-8 border-t border-gray-200">
                    <a href="{{ route('servicios.show', $servicio) }}" class="btn-outline">
                        <i class="fas fa-times mr-2"></i>
                        Cancelar
                    </a>
                    <button type="submit" class="btn-primary">
                        <i class="fas fa-save mr-2"></i>
                        Actualizar
                    </button>
                </div>
                </form>
            </div>
        </div>
    </div>

    @push('scripts')
    <script>
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

        // Drag & Drop functionality
        const dropZone = document.getElementById('drop-zone');
        const fileInput = document.getElementById('imagen');

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
    </script>
    @endpush
@endsection