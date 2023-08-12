<?php

namespace App\Http\Livewire\Cotizacion;

use Livewire\Component;

class DetallesCotizacion extends Component
{
    public $nuevas_bitacoras=[];
    public $open=false;
    public $procesando=0;

    public function render()
    {
        return view('livewire.cotizacion.detalles-cotizacion');
    }
    public function edit_open()
    {
        $this->open=true;
    }
}
