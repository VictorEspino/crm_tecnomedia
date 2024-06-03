<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProyectoDocumentoFinanzasFacturaProveedor extends Model
{
    use HasFactory;

    protected $fillable=[
                            'proyecto_id',
                            'seccion_id',
                            'partner_id',
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
    public function partner()
    {
        return $this->belongsTo(Partner::class,'partner_id');
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
