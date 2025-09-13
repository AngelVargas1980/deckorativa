<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class Cotizacion extends Model
{
    use HasFactory;

    protected $table = 'cotizaciones';

    protected $fillable = [
        'numero_cotizacion',
        'client_id',
        'user_id',
        'estado',
        'subtotal',
        'impuesto',
        'total_impuesto',
        'descuento',
        'total',
        'observaciones',
        'fecha_vigencia',
        'enviada_cliente',
        'fecha_envio'
    ];

    protected $casts = [
        'subtotal' => 'decimal:2',
        'impuesto' => 'decimal:2',
        'total_impuesto' => 'decimal:2',
        'descuento' => 'decimal:2',
        'total' => 'decimal:2',
        'enviada_cliente' => 'boolean',
        'fecha_vigencia' => 'date',
        'fecha_envio' => 'datetime'
    ];

    protected static function boot()
    {
        parent::boot();
        
        static::creating(function ($cotizacion) {
            if (!$cotizacion->numero_cotizacion) {
                $cotizacion->numero_cotizacion = self::generarNumeroCotizacion();
            }
            if (!$cotizacion->fecha_vigencia) {
                $cotizacion->fecha_vigencia = Carbon::now()->addDays(30);
            }
        });
    }

    public static function generarNumeroCotizacion()
    {
        $year = date('Y');
        $ultimo = self::whereYear('created_at', $year)->count() + 1;
        return 'COT-' . $year . '-' . str_pad($ultimo, 4, '0', STR_PAD_LEFT);
    }

    public function client()
    {
        return $this->belongsTo(Client::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function detalles()
    {
        return $this->hasMany(CotizacionDetalle::class);
    }

    public function scopePorEstado($query, $estado)
    {
        return $query->where('estado', $estado);
    }

    public function scopeVigentes($query)
    {
        return $query->where('fecha_vigencia', '>=', Carbon::now());
    }

    public function scopeVencidas($query)
    {
        return $query->where('fecha_vigencia', '<', Carbon::now());
    }

    public function calcularTotales()
    {
        $this->subtotal = $this->detalles->sum('subtotal');
        $this->total_impuesto = ($this->subtotal * $this->impuesto) / 100;
        $this->total = $this->subtotal + $this->total_impuesto - $this->descuento;
        $this->save();
    }

    public function getTotalFormateadoAttribute()
    {
        return 'Q' . number_format($this->total, 2);
    }

    public function getEstadoColorAttribute()
    {
        return match($this->estado) {
            'borrador' => 'secondary',
            'enviada' => 'warning',
            'aprobada' => 'success',
            'rechazada' => 'danger',
            default => 'secondary'
        };
    }

    public function isVencida()
    {
        return $this->fecha_vigencia < Carbon::now();
    }
}
