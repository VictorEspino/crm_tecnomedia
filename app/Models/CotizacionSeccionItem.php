<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CotizacionSeccionItem extends Model
{
    use HasFactory;

    protected $fillable=[
            'seccion_id',
            'cantidad',
            'descripcion',
            'unidad',
            'unitario',
            'descuento',
            'p_final',
            'a1',
            'a2',
            'a3',
            'a4',
            'a5',
    ];
}
