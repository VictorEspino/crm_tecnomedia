<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BitacoraOportunidad extends Model
{
    use HasFactory;

    protected $fillable=[
        'oportunidad_id',
        'user_id',
        'tipo_id',
        'detalles',
        'gasto',
        'concepto_gasto',
        'due_date',
    ];

    public function tipo()
    {
        return $this->belongsTo(TipoBitacoraOportunidad::class,'tipo_id');
    }
    public function lead()
    {
        return $this->belongsTo(Oportunidad::class,'oportunidad_id');
    }
}
