<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cotizacion extends Model
{
    use HasFactory;

    protected $fillable=[
        'oportunidad_id',
        'fecha_presentacion',
        'descripcion',
        'total_propuesta',
        'user_id',
        'compania_id',
        'moneda_id',
        'anos',
    ];
}
