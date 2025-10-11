@extends('layouts.app')

@section('content')
    <div class="animate-slideInUp">
        <div class="page-header">
            <div class="flex flex-col lg:flex-row lg:items-center lg:justify-between">
                <div>
                    <h1 class="page-title text-gradient">
                        <i class="fas fa-plus mr-3"></i>
                        Nueva Categoría
                    </h1>
                    <p class="page-subtitle">
                        <i class="fas fa-tag mr-2"></i>
                        Crea una nueva categoría para organizar servicios y productos
                    </p>
                </div>
                <div class="mt-6 lg:mt-0">
                    <a href="{{ route('categorias.index') }}" class="btn-outline">
                        <i class="fas fa-arrow-left mr-2"></i>
                        Volver al Listado
                    </a>
                </div>
            </div>
        </div>

        <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="card">
                <form action="{{ route('categorias.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                
                <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
                    <!-- Información Básica -->
                    <div class="space-y-6">
                        <h3 class="text-lg font-semibold text-gray-900 border-b border-gray-200 pb-2">
                            <i class="fas fa-info-circle mr-2 text-blue-600"></i>
                            Información Básica
                        </h3>

                        <div>
                            <label class="form-label required">Nombre de la Categoría</label>
                            <input type="text" name="nombre" value="{{ old('nombre') }}" 
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
                                      placeholder="Describe brevemente esta categoría...">{{ old('descripcion') }}</textarea>
                            @error('descripcion')
                                <p class="form-error">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label class="form-label flex items-center">
                                <input type="hidden" name="activo" value="0">
                                <input type="checkbox" name="activo" value="1" {{ old('activo', '1') == '1' ? 'checked' : '' }}
                                       class="mr-2 rounded">
                                <i class="fas fa-check-circle mr-2 text-green-600"></i>
                                Categoría Activa
                            </label>
                            <p class="text-sm text-gray-600 mt-1">Las categorías inactivas no aparecerán en las listas de selección</p>
                        </div>
                    </div>

                    <!-- Imagen y Vista Previa -->
                    <div class="space-y-6">
                        <h3 class="text-lg font-semibold text-gray-900 border-b border-gray-200 pb-2">
                            <i class="fas fa-image mr-2 text-purple-600"></i>
                            Imagen de la Categoría
                        </h3>

                        <div>
                            <label class="form-label">Imagen (opcional)</label>
                            <div id="drop-zone" class="mt-1 flex justify-center px-6 pt-5 pb-6 border-2 border-gray-300 border-dashed rounded-lg hover:border-gray-400 transition-colors">
                                <div class="space-y-1 text-center">
                                    <div id="preview-container" class="hidden">
                                        <img id="image-preview" class="mx-auto h-32 w-32 object-cover rounded-lg shadow-md">
                                        <button type="button" onclick="removeImage()" class="mt-2 text-red-600 hover:text-red-800 text-sm">
                                            <i class="fas fa-times mr-1"></i>
                                            Remover imagen
                                        </button>
                                    </div>
                                    <div id="upload-placeholder">
                                        <svg class="mx-auto h-12 w-12 text-gray-400" stroke="currentColor" fill="none" viewBox="0 0 48 48">
                                            <path d="M28 8H12a4 4 0 00-4 4v20m32-12v8m0 0v8a4 4 0 01-4 4H12a4 4 0 01-4-4v-4m32-4l-3.172-3.172a4 4 0 00-5.656 0L28 28M8 32l9.172-9.172a4 4 0 015.656 0L28 28m0 0l4 4m4-24h8m-4-4v8m-12 4h.02" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                                        </svg>
                                        <div class="flex text-sm text-gray-600">
                                            <label class="relative cursor-pointer bg-white rounded-md font-medium text-indigo-600 hover:text-indigo-500 focus-within:outline-none focus-within:ring-2 focus-within:ring-offset-2 focus-within:ring-indigo-500">
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

                <!-- Botones de Acción -->
                <div class="flex justify-end space-x-4 pt-8 border-t border-gray-200">
                    <a href="{{ route('categorias.index') }}" class="btn-outline">
                        <i class="fas fa-times mr-2"></i>
                        Cancelar
                    </a>
                    <button type="submit" class="btn-primary">
                        <i class="fas fa-save mr-2"></i>
                        Crear Categoría
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