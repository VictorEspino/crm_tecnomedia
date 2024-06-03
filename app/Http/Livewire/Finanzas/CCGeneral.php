<?php

namespace App\Http\Livewire\Finanzas;

use Livewire\Component;
use App\Models\ProyectoDocumentoFinanzas;

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
        $this->facturas_vencidas=ProyectoDocumentoFinanzas::whereRaw('fecha_vencimiento<=now()')
                                                            ->where('etiqueta','FACTURA')
                                                            ->where('universo','CC')
                                                            ->get();
        $this->facturas_vigentes=ProyectoDocumentoFinanzas::whereRaw('fecha_vencimiento>now()')
                                                            ->where('etiqueta','FACTURA')
                                                            ->where('universo','CC')
                                                            ->get();        
        $this->pagos=ProyectoDocumentoFinanzas::whereRaw('fecha_vencimiento>now()')
                                                            ->where('etiqueta','!=','FACTURA')
                                                            ->where('universo','CC')
                                                            ->get();
    }
}
