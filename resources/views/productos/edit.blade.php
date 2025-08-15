@extends('layouts.app')

@section('content')
    <div class="container">
        <h1>Editar Producto</h1>
        <form action="{{ route('productos.update', $producto->idproducto) }}" method="POST">
            @csrf
            @method('PUT')
            <div class="form-group">
                <label for="codigo">Código</label>
                <input type="text" name="codigo" class="form-control" id="codigo" value="{{ $producto->codigo }}" required>
            </div>
            <div class="form-group">
                <label for="nombre">Nombre</label>
                <input type="text" name="nombre" class="form-control" id="nombre" value="{{ $producto->nombre }}" required>
            </div>
            <div class="form-group">
                <label for="descripcion">Descripción</label>
                <textarea name="descripcion" class="form-control" id="descripcion" required>{{ $producto->descripcion }}</textarea>
            </div>
            <div class="form-group">
                <label for="precio">Precio</label>
                <input type="number" step="0.01" name="precio" class="form-control" id="precio" value="{{ $producto->precio }}" required>
            </div>
            <div class="form-group">
                <label for="existencia">Existencia</label>
                <input type="number" name="existencia" class="form-control" id="existencia" value="{{ $producto->existencia }}" required>
            </div>
            <div class="form-group">
                <label for="unidad">Unidad</label>
                <input type="text" name="unidad" class="form-control" id="unidad" value="{{ $producto->unidad }}" required>
            </div>
            <div class="form-group">
                <label for="imagen">Imagen</label>
                <input type="text" name="imagen" class="form-control" id="imagen" value="{{ $producto->imagen }}" required>
            </div>
            <div class="form-group">
                <label for="status">Estado</label>
                <select name="status" class="form-control" id="status">
                    <option value="1" {{ $producto->status == 1 ? 'selected' : '' }}>Activo</option>
                    <option value="0" {{ $producto->status == 0 ? 'selected' : '' }}>Inactivo</option>
                </select>
            </div>
            <button type="submit" class="btn btn-warning">Actualizar Producto</button>
        </form>
    </div>
@endsection
