<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProyectoDocumentoFinanzasNotaCreditoCliente extends Model
{
    use HasFactory;
    
    protected $fillable=[
            'factura_id',
            'cantidad',
            'folio',
            'f_emision',
            'notas'
            ]; 
}
