<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProyectoLicenciaSeccionItem extends Model
{
    use HasFactory;

    protected $fillable=['seccion_id',
                         'tipo',
                         'descripcion',
                         'cantidad',
                         'unitario_cliente',
                         'total_cliente',
                         'unitario_tecnomedia',
                         'total_tecnomedia',
                         'partner_id',
                         'margen',
                         'porcentaje_margen',
                        ];

    public function mayorista()
    {
        return $this->belongsTo(Partner::class,'partner_id');
    }
}
