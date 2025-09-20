<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pedido extends Model
{
    use HasFactory;

    protected $fillable = [
        'numero_pedido',
        'client_id',
        'cotizacion_id',
        'estado',
        'total',
        'observaciones',
        'fecha_entrega',
        'direccion_entrega',
        'telefono_contacto'
    ];

    protected $casts = [
        'fecha_entrega' => 'date',
        'total' => 'decimal:2'
    ];

    public function cliente()
    {
        return $this->belongsTo(Client::class, 'client_id');
    }

    public function cotizacion()
    {
        return $this->belongsTo(Cotizacion::class);
    }

    public function detalles()
    {
        return $this->hasMany(PedidoDetalle::class);
    }

    public function getEstadoFormateadoAttribute()
    {
        return ucfirst(str_replace('_', ' ', $this->estado));
    }

    public static function generarNumeroPedido()
    {
        $ultimo = self::latest('id')->first();
        $numero = $ultimo ? $ultimo->id + 1 : 1;
        return 'PED-' . str_pad($numero, 6, '0', STR_PAD_LEFT);
    }
}
