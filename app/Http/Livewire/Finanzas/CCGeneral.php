<?php

namespace App\Http\Livewire\Finanzas;

use Livewire\Component;
use App\Models\ProyectoDocumentoFinanzasFacturaCliente;

class CCGeneral extends Component
{
    public $facturas_vencidas=[];
    public $facturas_vigentes=[];
    public $pagos=[];
    public function render()
    {
        return view('livewire.finanzas.c-c-general');
    }
    public function mount()
    {
        $this->facturas_vencidas=ProyectoDocumentoFinanzasFacturaCliente::with('moneda_documento')->whereRaw('fecha_vencimiento<=now()')                                                    
                                                            ->get();
        $this->facturas_vigentes=ProyectoDocumentoFinanzasFacturaCliente::with('moneda_documento')->whereRaw('fecha_vencimiento>now()')
                                                            ->get();        
    }
}
