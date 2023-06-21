<?php

namespace App\Http\Livewire\Contacto;

use Livewire\Component;
use App\Models\ContactoProspecto;

class NuevoContacto extends Component
{
    public $open=false;
    public $prospecto_id;
    public $procesando=0;

    public $nombre;
    public $area;
    public $posicion;
    public $correo1;
    public $correo2;
    public $correo3;
    public $telefono1;
    public $telefono2;
    public $telefono3;
    public $notas;
    
    public function render()
    {
        $this->prospecto_id = session('idEmpresa');
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

    public function validacion()
    {
        $reglas = [
            'nombre'=>'required',
            'area'=>'required',
            'posicion'=>'required',
            'correo1'=>'required|email',
            'telefono1'=>'required',
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

        ContactoProspecto::create([
            'prospecto_id'=>$this->prospecto_id,
            'nombre'=>$this->nombre,
            'area'=>$this->area,
            'posicion'=>$this->posicion,
            'correo1'=>$this->correo1,
            'correo2'=>$this->correo2,
            'correo3'=>$this->correo3,
            'telefono1'=>$this->telefono1,
            'telefono2'=>$this->telefono2,
            'telefono3'=>$this->telefono3,
            'notas'=>$this->notas
        ]);
        
        $this->emit('contactoAgregado');
        $this->emit('alert_ok','El contacto se creo satisfactoriamente');
        $this->resetErrorBag();
        $this->resetValidation();
        $this->reset();

    }
}
