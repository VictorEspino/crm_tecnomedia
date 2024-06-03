<?php

namespace App\Http\Livewire\Finanzas;

use Livewire\Component;
use App\Models\ProyectoDocumentoFinanzas;
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
        $this->facturas_vencidas=ProyectoDocumentoFinanzas::whereRaw('fecha_vencimiento<=now()')
                                                            ->where('etiqueta','FACTURA')
                                                            ->where('universo','CP')
                                                            ->get();
        $this->facturas_vigentes=ProyectoDocumentoFinanzas::whereRaw('fecha_vencimiento>now()')
                                                            ->where('etiqueta','FACTURA')
                                                            ->where('universo','CP')
                                                            ->get();        
        $this->pagos=ProyectoDocumentoFinanzas::whereRaw('fecha_vencimiento>now()')
                                                            ->where('etiqueta','!=','FACTURA')
                                                            ->where('universo','CP')                                                            
                                                            ->get();
        $this->proveedores=Partner::all();
    }

    public function updatedFiltroProveedor()
    {
        $filtro=$this->filtro_proveedor;
        $this->facturas_vencidas=ProyectoDocumentoFinanzas::whereRaw('fecha_vencimiento<=now()')
                                                            ->where('etiqueta','FACTURA')
                                                            ->where('universo','CP')
                                                            ->when($filtro > 0, function ($query) use ($filtro) {
                                                                $query->where('id_principal', $filtro);
                                                            })
                                                            ->get();
        $this->facturas_vigentes=ProyectoDocumentoFinanzas::whereRaw('fecha_vencimiento>now()')
                                                            ->where('etiqueta','FACTURA')
                                                            ->where('universo','CP')
                                                            ->when($filtro > 0, function ($query) use ($filtro) {
                                                                $query->where('id_principal', $filtro);
                                                            })
                                                            ->get();        
        $this->pagos=ProyectoDocumentoFinanzas::whereRaw('fecha_vencimiento>now()')
                                                            ->where('etiqueta','!=','FACTURA')
                                                            ->where('universo','CP') 
                                                            ->when($filtro > 0, function ($query) use ($filtro) {
                                                                $query->where('id_principal', $filtro);
                                                            })                                                           
                                                            ->get();
    }
    public function nada()
    {

    }

}
