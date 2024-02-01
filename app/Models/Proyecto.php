<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Proyecto extends Model
{
    use HasFactory;
    protected $fillable=['id_prospecto',
                         'id_negocio',
                         'id_tipo',
                         'consecutivo',
                         'nombre',
                         'descripcion',
                         'presupuesto',
                         'precio_venta',
                         'precio_costo',
                         'fecha_inicio',
                         'fecha_fin',
                         'user_responsable_id',
                         'estatus',
                        ];

    public function prospecto()
    {
        return $this->belongsTo(Prospecto::class,'id_prospecto');
    }
    public function responsable()
    {
        return $this->belongsTo(User::class,'user_responsable_id');
    }
    public function negocio()
    {
        return $this->belongsTo(LineaNegocio::class,'id_negocio');
    }
    public function tipo()
    {
        return $this->belongsTo(TipoProyecto::class,'id_tipo');
    }
}
