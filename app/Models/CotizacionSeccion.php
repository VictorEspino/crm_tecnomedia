<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CotizacionSeccion extends Model
{
    use HasFactory;

    protected $fillable=[
                            'cotizacion_id',
                            'nombre',
                            't_a1',
                            't_a2',
                            't_a3',
                            't_a4',
                            't_a5',
                            'total'
                        ];
}
