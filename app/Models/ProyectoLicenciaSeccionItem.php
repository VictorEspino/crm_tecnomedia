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
                         'total_cliente',
                         'total_tecnomedia',
                         'partner_id',
                         'fabricante_id',
                         'margen',
                         'porcentaje_margen',
                        ];

    public function mayorista()
    {
        return $this->belongsTo(Partner::class,'partner_id');
    }
    public function fabricante()
    {
        return $this->belongsTo(Fabricante::class,'fabricante_id');
    }
}
