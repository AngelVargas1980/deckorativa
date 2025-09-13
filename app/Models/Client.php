<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Client extends Model
{
    use HasFactory;

    protected $fillable = [
        'first_name',
        'last_name',
        'email',
        'phone',
        'email_verified',
        'identification_number',
    ];

    protected $casts = [
        'email_verified' => 'boolean',
    ];

    public function getNameAttribute()
    {
        return trim($this->first_name . ' ' . $this->last_name);
    }

    public function cotizaciones()
    {
        return $this->hasMany(Cotizacion::class);
    }
}
