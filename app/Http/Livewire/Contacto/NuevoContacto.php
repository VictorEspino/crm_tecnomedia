<?php

namespace App\Http\Livewire\Contacto;

use Livewire\Component;

class NuevoContacto extends Component
{
    public $open=false;
    public $empresa;
    
    public function render()
    {
        $this->empresa = session('idEmpresa');
        return view('livewire.contacto.nuevo-contacto');
    }
    public function nuevo()
    {
        $this->open=true;
    }
    public function cancelar()
    {
        $this->open=false;
    }
}
