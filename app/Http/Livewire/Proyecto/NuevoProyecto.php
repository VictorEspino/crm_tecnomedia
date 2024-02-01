<?php

namespace App\Http\Livewire\Proyecto;

use Livewire\Component;
use App\Models\LineaNegocio;
use App\Models\User;
use App\Models\TipoProyecto;
use App\Models\Proyecto;

class NuevoProyecto extends Component
{
    public $open=false;
    public $procesando=0;

    public $id_prospecto;
    public $prospecto;
    public $negocio;
    public $responsable;
    public $presupuesto=0;
    public $precio_venta=0;
    public $precio_costo=0;
    public $fecha_inicio='';
    public $fecha_fin='';
    public $nombre='';
    public $descripcion='';
    public $tipo_proyecto='';

    public $negocios=[];
    public $responsables=[];
    public $tipos=[];

    public function render()
    {
        return view('livewire.proyecto.nuevo-proyecto');
    }
    public function mount($id_prospecto,$prospecto)
    {
        $this->id_prospecto=$id_prospecto;
        $this->prospecto=$prospecto;
    } 

    public function cargar()
    {
        $this->open=true;
        $this->negocios=LineaNegocio::all();
        $this->responsables=User::where('puesto','>','1')->get();
        $this->tipos=TipoProyecto::all();
    }

    public function cancelar()
    {
        $this->open=false;
    }

    public function validacion()
    {
        $reglas = ['nombre'=>'required',
                   'descripcion'=>'required',
                   'tipo_proyecto'=>'required',
                   'negocio'=>'required',
                   'responsable'=>'required',
                   'presupuesto'=>'required|numeric|min:0',
                   'precio_costo'=>'required|numeric|min:1',
                   'precio_venta'=>'required|numeric|min:1',
                   'fecha_inicio'=>'required',
                   'fecha_fin'=>'required',

                  ];         
        $this->validate($reglas,
            [
                'required' => 'Campo requerido.',
                'numeric'=>'Debe ser un numero',
                'min'=>'Indique una cantidad valida'
            ],
          );


    }
    public function guardar()
    {
        $this->validacion();
        $this->procesando=1;
        Proyecto::create([
                         'id_prospecto'=>$this->id_prospecto,
                         'id_negocio'=>$this->negocio,
                         'consecutivo'=>1,
                         'id_tipo'=>$this->tipo_proyecto,
                         'nombre'=>$this->nombre,
                         'descripcion'=>$this->descripcion,
                         'presupuesto'=>$this->presupuesto,
                         'precio_venta'=>$this->precio_venta,
                         'precio_costo'=>$this->precio_costo,
                         'fecha_inicio'=>$this->fecha_inicio,
                         'fecha_fin'=>$this->fecha_fin,
                         'user_responsable_id'=>$this->responsable,
                         'estatus'=>1,
                        ]);

        $this->emit('alert_ok','El proyecto se creo satisfactoriamente');
        $this->resetErrorBag();
        $this->resetValidation();
        $this->resetExcept('id_prospecto','prospecto');
        $this->open=false;
    }
}
