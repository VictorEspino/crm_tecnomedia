<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Prospecto extends Model
{
    use HasFactory;

    protected $fillable=[
            'rfc',
            'regimen',
            'razon_social',
            'fecha_io',
            'terminos_pago',
            'estatus',
            'calle',
            'colonia',
            'num_ext',
            'num_int',
            'cp',
            'ciudad',
            'pais',
            'estado',
    ];
}
