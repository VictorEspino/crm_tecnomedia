<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProyectoBitacora extends Model
{
    use HasFactory;
    protected $fillable=['id_proyecto',
                         'user_consultor_id',
                         'user_carga_id',
                         'horas',
                         'actividad',
                         'actividad_tipo_id',
                        ];

    public function consultor()
    {
        return $this->belongsTo(User::class,'user_consultor_id');
    }
    public function carga()
    {
        return $this->belongsTo(User::class,'user_carga_id');
    }
    public function tipo()
    {
        return $this->belongsTo(TipoActividad::class,'actividad_tipo_id');
    }
}
