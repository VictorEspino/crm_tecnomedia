<?php

namespace App\Http\Livewire\Finanzas;

use Livewire\Component;
use App\Models\ProyectoDocumentoFinanzasFacturaProveedor;
use App\Models\Partner;

class CPGeneral extends Component
{
    public $filtro_proveedor=0;
    public $proveedores=[];
    
    public function render()
    {
        return view('livewire.finanzas.c-p-general');
    }

    public function mount()
    {
        $this->facturas_vencidas=ProyectoDocumentoFinanzasFacturaProveedor::with('moneda_documento','partner')->whereRaw('fecha_vencimiento<=now()')
                                                            ->get();
        $this->facturas_vigentes=ProyectoDocumentoFinanzasFacturaProveedor::with('moneda_documento','partner')->whereRaw('fecha_vencimiento>now()')
                                                            ->get();        
        $this->proveedores=Partner::all();
    }

    public function updatedFiltroProveedor()
    {
        $filtro=$this->filtro_proveedor;
        $this->facturas_vencidas=ProyectoDocumentoFinanzasFacturaProveedor::with('moneda_documento','partner')->whereRaw('fecha_vencimiento<=now()')
                                                            ->when($filtro > 0, function ($query) use ($filtro) {
                                                                $query->where('partner_id', $filtro);
                                                            })
                                                            ->get();
        $this->facturas_vigentes=ProyectoDocumentoFinanzasFacturaProveedor::with('moneda_documento','partner')->whereRaw('fecha_vencimiento>now()')
                                                            ->when($filtro > 0, function ($query) use ($filtro) {
                                                                $query->where('partner_id', $filtro);
                                                            })
                                                            ->get();        
    }
    public function nada()
    {

    }

}
