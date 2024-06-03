<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProyectoDocumentoFinanzasPagoCliente extends Model
{
    use HasFactory;

    protected $fillable=[
            'factura_id',
            'moneda',
            'tipo_cambio_pago',
            'tipo_cambio_efectivo',
            'cantidad_pago',
            'complemento_pago',
            'banco_pago',
            'tipo_pago',
            'f_pago',
    ];
}
