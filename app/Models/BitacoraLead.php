<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BitacoraLead extends Model
{
    use HasFactory;

    protected $fillable=[
        'lead_id',
        'tipo_id',
        'detalles',
        'gasto',
        'concepto_gasto',
        'due_date',
    ];

    public function tipo()
    {
        return $this->belongsTo(TipoBitacoraLead::class,'tipo_id');
    }
    public function lead()
    {
        return $this->belongsTo(Lead::class,'lead_id');
    }
}
