<?php

namespace App\Http\Livewire\Proyecto;

use Livewire\Component;
use App\Models\User;
use App\Models\TipoActividad;
use App\Models\ProyectoBitacora;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;


class BitacoraProyecto extends Component
{
    public function render()
    {
        return view('livewire.proyecto.bitacora-proyecto');
    }

    public $open=false;
    public $procesando=0;
    public $presupuesto=0;

    public $id_proyecto;
    public $prospecto;
    public $nombre='';
    public $devengadas=0;
    public $disponibles=0;

    public $horas;
    public $actividad;
    public $tipo_actividad;

    public $consultor;
    public $consultores=[];
    public $tipos=[];
    public $bitacoras=[];

    public function mount($id_proyecto,$prospecto,$nombre,$presupuesto)
    {
        $this->id_proyecto=$id_proyecto;
        $this->prospecto=$prospecto;
        $this->nombre=$nombre;
        $this->presupuesto=$presupuesto;
    } 

    public function cargar()
    {
        $this->open=true;
        $this->consultores=User::where('puesto','>','1')->get();
        $this->tipos=TipoActividad::all();

        $this->devengadas=ProyectoBitacora::select(DB::raw('sum(horas)+0 as devengadas'))
                            ->where('id_proyecto',$this->id_proyecto)
                            ->get()->first()->devengadas;

        if(is_null($this->devengadas)){$this->devengadas=0;}

        $this->bitacoras=ProyectoBitacora::with('consultor','carga','tipo')
                        ->where('id_proyecto',$this->id_proyecto)
                        ->get();

        $this->disponibles=$this->presupuesto-$this->devengadas;
    }

    public function cancelar()
    {
        $this->open=false;
    }

    public function validacion()
    {
        $reglas = ['consultor'=>'required',
                   'horas'=>'required|numeric|min:1|max:'.$this->disponibles,
                   'actividad'=>'required',
                   'tipo_actividad'=>'required',

                  ];         
        $this->validate($reglas,
            [
                'required' => 'Campo requerido.',
                'numeric'=>'Debe ser un numero',
                'min'=>'Indique una cantidad valida',
                'max'=>'No hay suficientes horas disponibles para este registro'
            ],
          );


    }
    public function guardar()
    {
        $this->validacion();

        $this->procesando=1;
        ProyectoBitacora::create([
                         'id_proyecto'=>$this->id_proyecto,
                         'user_consultor_id'=>$this->consultor,
                         'user_carga_id'=>Auth::user()->id,
                         'horas'=>$this->horas,
                         'actividad'=>$this->actividad,
                         'actividad_tipo_id'=>$this->tipo_actividad,
                        ]);

        $this->emit('alert_ok','La bitacora del proyecto se creo satisfactoriamente');
        $this->resetErrorBag();
        $this->resetValidation();
        $this->resetExcept('id_proyecto','prospecto','nombre','presupuesto');
        $this->open=false;
        
    }
}
