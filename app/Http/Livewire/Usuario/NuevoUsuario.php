<?php

namespace App\Http\Livewire\Usuario;

use Livewire\Component;
use App\Models\Compania;
use App\Models\Puesto;
use App\Models\Area;
use App\Models\SubArea;
use App\Models\User;

class NuevoUsuario extends Component
{
    public $open=false;
    public $procesando;

    public $user;
    public $email;
    public $nombre;
    public $puesto;
    public $compania;
    public $companias=[];
    public $puestos=[];

    public $area;
    public $areas=[];
    public $sub_area;
    public $sub_areas=[];


    public function render()
    {
        return view('livewire.usuario.nuevo-usuario');
    }

    public function mount()
    {
        $this->companias=Compania::where('estatus',1)
                        ->orderBy('nombre','asc')
                        ->get();
        $this->areas=Area::where('estatus',1)
                        ->orderBy('nombre','asc')
                        ->get();
        $this->puestos=Puesto::where('estatus',1)->orderBy('puesto','asc')->get();
    }

    public function updatedArea()
    {
        $this->sub_areas=SubArea::where('area_id',$this->area)
                                ->where('estatus',1)
                                ->orderBy('nombre','asc')
                                ->get();
    }
    public function nuevo()
    {
        $this->open=true;
        $this->procesando=0;
    }
    public function cancelar()
    {
        $this->open=false;
        $this->email='';
        $this->user='';
        $this->nombre='';
        $this->puesto='';
        $this->compania='';
        $this->resetErrorBag();
        $this->resetValidation();
    }
    public function validacion()
    {
        $reglas = [
            'user'=>'required|unique:users,user',
            'email'=>'required|email|unique:users,email',
            'nombre' => 'required',
            'puesto' => 'required',
            'compania'=>'required',
            'area'=>'required',
            'sub_area'=>'required',
          ];
        //dd($reglas);
        $this->validate($reglas,
            [
                'required' => 'Campo requerido.',
                'numeric'=>'Debe ser un numero',
                'unique'=>'El valor ya existe en la base de datos',
                'email'=>'Se requiere una direccion de correo valida'
            ]
          );
    }
    public function guardar()
    {
        $this->validacion();
        $this->procesando=1;

        User::create([
            'user'=>$this->user,
            'name'=>$this->nombre,
            'puesto'=> $this->puesto,
            'compania'=> $this->compania,
            'email'=>$this->email,
            'area'=>$this->area,
            'sub_area'=>$this->sub_area,
            'password'=>'$2y$10$nK/ZCp9pnpgEBKW.BmdXF.4z660oLuWUan0v7YCsmrHQdrf7sNHQK',
        ]);


        $this->emit('usuarioAgregado');
        $this->emit('alert_ok','El usuario se creo satisfactoriamente');
        $this->open=false;
        $this->email='';
        $this->usuario='';
        $this->nombre='';
        $this->puesto='';
        $this->compania='';
        $this->resetErrorBag();
        $this->resetValidation();
    }
}
