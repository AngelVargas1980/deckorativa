<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CotizacionDetalle extends Model
{
    use HasFactory;

    protected $table = 'cotizacion_detalles';

    protected $fillable = [
        'cotizacion_id',
        'servicio_id',
        'cantidad',
        'precio_unitario',
        'subtotal',
        'notas'
    ];

    protected $casts = [
        'cantidad' => 'integer',
        'precio_unitario' => 'decimal:2',
        'subtotal' => 'decimal:2'
    ];

    protected static function boot()
    {
        parent::boot();
        
        static::saving(function ($detalle) {
            $detalle->subtotal = $detalle->cantidad * $detalle->precio_unitario;
        });

        static::saved(function ($detalle) {
            $detalle->cotizacion->calcularTotales();
        });

        static::deleted(function ($detalle) {
            $detalle->cotizacion->calcularTotales();
        });
    }

    public function cotizacion()
    {
        return $this->belongsTo(Cotizacion::class);
    }

    public function servicio()
    {
        return $this->belongsTo(Servicio::class);
    }

    public function getSubtotalFormateadoAttribute()
    {
        return 'Q' . number_format($this->subtotal, 2);
    }

    public function getPrecioUnitarioFormateadoAttribute()
    {
        return 'Q' . number_format($this->precio_unitario, 2);
    }
}
