<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProyectoDocumentoFinanzasFacturaCliente extends Model
{
    use HasFactory;

    protected $fillable=[
                            'proyecto_id',
                            'seccion_id',
                            'id_cliente',
                            'folio_cfdi',
                            'moneda',
                            'tipo_cambio',
                            'cantidad_si',
                            'impuestos_trasladados',
                            'impuestos_retenidos',
                            'cantidad_ci',
                            'fecha_emision',
                            'dias_pago',
                            'fecha_vencimiento',
                            'cuenta_contable',
                            'orden_compra',
                            'notas',
                            'saldo'
                        ];

    public function seccion()
    {
        return $this->belongsTo(ProyectoLicenciaSeccion::class,'proyecto_id');
    }
    public function cliente()
    {
        return $this->belongsTo(Prospecto::class,'id_cliente');
    }
    public function proyecto()
    {
        return $this->belongsTo(Proyecto::class,'proyecto_id');
    }
    public function moneda_documento()
    {
        return $this->belongsTo(Moneda::class,'moneda');
    }
}
