<?php

namespace App\Http\Livewire\Servicios;

use Livewire\Component;

class DetalleCliente extends Component
{
    public $open=false;
    public function render()
    {
        return view('livewire.servicios.detalle-cliente');
    }
    public function cargar()
    {
        $this->open=true;
    }
    public function cancelar()
    {
        $this->open=false;
    }
}
