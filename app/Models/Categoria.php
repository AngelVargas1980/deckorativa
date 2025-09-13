<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Categoria extends Model
{
    use HasFactory;

    protected $fillable = [
        'nombre',
        'descripcion',
        'imagen',
        'activo'
    ];

    protected $casts = [
        'activo' => 'boolean'
    ];

    public function servicios()
    {
        return $this->hasMany(Servicio::class);
    }

    public function scopeActivo($query)
    {
        return $query->where('activo', true);
    }
}
