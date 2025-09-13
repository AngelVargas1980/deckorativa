<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Servicio extends Model
{
    use HasFactory;

    protected $fillable = [
        'nombre',
        'descripcion',
        'precio',
        'imagen',
        'tipo',
        'categoria_id',
        'activo',
        'tiempo_estimado',
        'unidad_medida'
    ];

    protected $casts = [
        'precio' => 'decimal:2',
        'activo' => 'boolean',
        'tiempo_estimado' => 'integer'
    ];

    public function categoria()
    {
        return $this->belongsTo(Categoria::class);
    }

    public function cotizacionDetalles()
    {
        return $this->hasMany(CotizacionDetalle::class);
    }

    public function scopeActivo($query)
    {
        return $query->where('activo', true);
    }

    public function scopeServicio($query)
    {
        return $query->where('tipo', 'servicio');
    }

    public function scopeProducto($query)
    {
        return $query->where('tipo', 'producto');
    }

    public function scopePorCategoria($query, $categoriaId)
    {
        return $query->where('categoria_id', $categoriaId);
    }

    public function getPrecioFormateadoAttribute()
    {
        return 'Q' . number_format($this->precio, 2);
    }
}
