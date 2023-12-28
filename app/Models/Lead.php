<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Lead extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'compania_id',
        'prospecto_id',
        'contacto_prospecto_id',
        'linea_negocio_id',
        'servicio_id',
        'oportunidad',
        'partner',
        'producto',
        'etapa_id',
        'due_date_etapa',
        'fuente_id',
        'fecha_contacto',
        'comentarios',
    ];

    public function prospecto()
    {
        return $this->belongsTo(Prospecto::class,'prospecto_id');
    }
    public function contacto()
    {
        return $this->belongsTo(ContactoProspecto::class,'contacto_prospecto_id');
    }
    public function linea_negocio()
    {
        return $this->belongsTo(LineaNegocio::class,'linea_negocio_id');
    }
    public function servicio()
    {
        return $this->belongsTo(Servicio::class,'servicio_id');
    }
    public function fuente()
    {
        return $this->belongsTo(FuenteLead::class,'fuente_id');
    }
    public function compania()
    {
        return $this->belongsTo(Compania::class,'compania_id');
    }
    public function etapa()
    {
        return $this->belongsTo(EtapaLead::class,'etapa_id');
    }
    public function user()
    {
        return $this->belongsTo(User::class,'user_id');
    }
    public function part()
    {
        return $this->belongsTo(Partner::class,'partner');
    }
}
