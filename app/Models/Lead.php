<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Lead extends Model
{
    use HasFactory;

    protected $fillable = [
        'prospecto_id',
        'contacto_prospecto_id',
        'linea_negocio_id',
        'servicio_id',
        'oportunidad',
        'partner',
        'producto',
        'etapa_id',
        'fuente_id',
        'fecha_contacto',
        'comentarios',
    ];
}
