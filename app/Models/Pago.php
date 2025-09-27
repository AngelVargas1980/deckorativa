<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class Pago extends Model
{
    use HasFactory;

    protected $fillable = [
        'checkout_id',
        'payment_intent_id',
        'client_id',
        'customer_email',
        'customer_name',
        'estado',
        'subtotal',
        'impuesto',
        'total',
        'moneda',
        'items',
        'checkout_url',
        'recurrente_response',
        'fecha_pago',
        'metodo_pago',
        'notas'
    ];

    protected $casts = [
        'subtotal' => 'decimal:2',
        'impuesto' => 'decimal:2',
        'total' => 'decimal:2',
        'items' => 'array',
        'recurrente_response' => 'array',
        'fecha_pago' => 'datetime'
    ];

    // Relaciones
    public function client()
    {
        return $this->belongsTo(Client::class);
    }

    // Scopes
    public function scopePendientes($query)
    {
        return $query->where('estado', 'pending');
    }

    public function scopeCompletados($query)
    {
        return $query->where('estado', 'completed');
    }

    public function scopeFallidos($query)
    {
        return $query->where('estado', 'failed');
    }

    // Métodos auxiliares
    public function getTotalFormateadoAttribute()
    {
        return 'Q' . number_format($this->total, 2);
    }

    public function getSubtotalFormateadoAttribute()
    {
        return 'Q' . number_format($this->subtotal, 2);
    }

    public function getImpuestoFormateadoAttribute()
    {
        return 'Q' . number_format($this->impuesto, 2);
    }

    public function getEstadoColorAttribute()
    {
        return match($this->estado) {
            'pending' => 'warning',
            'completed' => 'success',
            'failed' => 'danger',
            'cancelled' => 'secondary',
            default => 'secondary'
        };
    }

    public function getEstadoTextoAttribute()
    {
        return match($this->estado) {
            'pending' => 'Pendiente',
            'completed' => 'Completado',
            'failed' => 'Fallido',
            'cancelled' => 'Cancelado',
            default => 'Desconocido'
        };
    }

    public function isCompletado()
    {
        return $this->estado === 'completed';
    }

    public function isPendiente()
    {
        return $this->estado === 'pending';
    }

    public function isFallido()
    {
        return $this->estado === 'failed';
    }

    public function marcarComoCompletado($paymentIntentId = null, $metodoPago = null)
    {
        $this->update([
            'estado' => 'completed',
            'fecha_pago' => Carbon::now(),
            'payment_intent_id' => $paymentIntentId,
            'metodo_pago' => $metodoPago
        ]);
    }

    public function marcarComoFallido($razon = null)
    {
        $this->update([
            'estado' => 'failed',
            'notas' => $razon
        ]);
    }
}
