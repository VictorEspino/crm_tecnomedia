<?php

namespace App\Http\Livewire\Prospecto;

use Livewire\Component;
use App\Models\Prospecto;

class NuevoProspecto extends Component
{
    public $open=false;
    public $procesando=0;

    public $rfc;
    public $regimen;
    public $razon_social;
    public $fecha_io;
    public $terminos_pago;
    public $calle;
    public $colonia;
    public $num_ext;
    public $num_int;
    public $cp;
    public $ciudad;
    public $pais;

    public function render()
    {
        return view('livewire.prospecto.nuevo-prospecto');
    }
    public function nuevo()
    {
        $this->open=true;
    }
    public function cancelar()
    {
        $this->open=false;
        $this->reset();
    }
    public function validacion()
    {
        $reglas = [
            'rfc'=>'required|unique:prospectos,rfc',
            'regimen'=>'required',
            'razon_social'=>'required',
            'fecha_io'=>'required',
            'terminos_pago'=>'required',
            'calle'=>'required',
            'colonia'=>'required',
            'num_ext'=>'required',
            'cp'=>'required',
            'ciudad'=>'required',
            'pais'=>'required',
          ];
        //dd($reglas);
        $this->validate($reglas,
            [
                'required' => 'Campo requerido.',
                'numeric'=>'Debe ser un numero',
                'unique'=>'El valor ya existe en la base de datos',
                'email'=>'Se requiere una direccion de correo valida'
            ],
          );
    }
    public function guardar()
    {
        $this->validacion();
        $this->procesando=1;

        Prospecto::create([
            'rfc'=>$this->rfc,
            'regimen'=>$this->regimen,
            'razon_social'=>$this->razon_social,
            'fecha_io'=>$this->fecha_io,
            'terminos_pago'=>$this->terminos_pago,
            'calle'=>$this->calle,
            'colonia'=>$this->colonia,
            'num_ext'=>$this->num_ext,
            'cp'=>$this->cp,
            'ciudad'=>$this->ciudad,
            'pais'=>$this->pais,
        ]);
        
        $this->emit('prospectoAgregado');
        $this->emit('alert_ok','El prospecto se creo satisfactoriamente');
        $this->resetErrorBag();
        $this->resetValidation();
        $this->reset();

    }
}
