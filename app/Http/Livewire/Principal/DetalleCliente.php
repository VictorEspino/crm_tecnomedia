<?php

namespace App\Http\Livewire\Principal;

use Livewire\Component;
use App\Models\Prospecto;
use App\Models\Licencia;

class DetalleCliente extends Component
{
    public $open=false;
    public $id_prospecto;

    public $razon_social;
    public $rfc;
    public $regimen;
    public $fecha_io;
    public $terminos_pago;
    public $calle;
    public $colonia;
    public $num_ext;
    public $num_int;
    public $cp;
    public $ciudad;
    public $pais;

    public $licencias=[];

    public function mount($id_prospecto)
    {
        $this->id_prospecto=$id_prospecto;
    }

    public function render()
    {
        return view('livewire.principal.detalle-cliente');
    }
    public function cargar()
    {
        $this->open=true;
        $prospecto=Prospecto::find($this->id_prospecto);
        $this->razon_social=$prospecto->razon_social;
        $this->rfc=$prospecto->rfc;
        $this->regimen=$prospecto->regimen;
        $this->fecha_io=$prospecto->fecha_io;
        $this->terminos_pago=$prospecto->terminos_pago;
        $this->calle=$prospecto->calle;
        $this->colonia=$prospecto->colonia;
        $this->num_ext=$prospecto->num_ext;
        $this->num_int=$prospecto->num_int;
        $this->cp=$prospecto->cp;
        $this->ciudad=$prospecto->ciudad;
        $this->pais=$prospecto->pais;
        $this->licencias=Licencia::with('linea_negocio','moneda')->where('prospecto_id',$this->id_prospecto)->get();
    }
    public function cancelar()
    {
        $this->open=false;
    }
}
