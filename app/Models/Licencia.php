<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Licencia extends Model
{
    use HasFactory;

    public function linea_negocio()
    {
        return $this->belongsTo(LineaNegocio::class,'linea_negocio_id');
    }
    public function moneda()
    {
        return $this->belongsTo(Moneda::class,'moneda_id');
    }
}
