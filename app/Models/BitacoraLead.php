<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BitacoraLead extends Model
{
    use HasFactory;

    protected $fillable=[
        'lead_id',
        'user_id',
        'tipo_id',
        'detalles',
        'gasto',
        'concepto_gasto',
        'due_date',
        'ticket_id',
    ];

    public function tipo()
    {
        return $this->belongsTo(TipoBitacoraLead::class,'tipo_id');
    }
    public function lead()
    {
        return $this->belongsTo(Lead::class,'lead_id');
    }
    public function ticket()
    {
        return $this->belongsTo(Ticket::class,'ticket_id');
    }
}
