<?php

namespace App\Http\Livewire\Proyecto;

use Livewire\Component;
use App\Models\LineaNegocio;
use App\Models\User;
use App\Models\TipoProyecto;
use App\Models\Proyecto;
use App\Models\BitacoraPresupuestoProyecto;
use Illuminate\Support\Facades\Auth;
use App\Models\ProyectoLicenciaSeccion;
use App\Models\ProyectoLicenciaSeccionItem;

class EditarProyecto extends Component
{
    public $open=false;
    public $procesando=0;

    public $id_proyecto;
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

    public $horas_originales;
    public $estatus;

    public $bitacoras=[];

    public $partners=[];
    public $secciones=[];
    public $items_guardados=[];

    public function render()
    {
        return view('livewire.proyecto.editar-proyecto');
    }
    public function mount($id_proyecto,$prospecto,$nombre)
    {
        $this->id_proyecto=$id_proyecto;
        $this->prospecto=$prospecto;
        $this->nombre=$nombre;
    } 

    public function cargar()
    {
        $this->open=true;
        $this->negocios=LineaNegocio::all();
        $this->responsables=User::where('puesto','>','1')->get();
        $this->tipos=TipoProyecto::all();
        $proyecto_actual=Proyecto::find($this->id_proyecto);

        $this->negocio=$proyecto_actual->id_negocio;        
        $this->responsable=$proyecto_actual->user_responsable_id;
        $this->presupuesto=$proyecto_actual->presupuesto;
        $this->precio_venta=$proyecto_actual->precio_venta;
        $this->precio_costo=$proyecto_actual->precio_costo;
        $this->fecha_inicio=$proyecto_actual->fecha_inicio;
        $this->fecha_fin=$proyecto_actual->fecha_fin;
        $this->descripcion=$proyecto_actual->descripcion;
        $this->tipo_proyecto=$proyecto_actual->id_tipo; 
        $this->estatus=$proyecto_actual->estatus;
        
        $this->horas_originales=$proyecto_actual->presupuesto;

        $this->bitacoras=BitacoraPresupuestoProyecto::with('usuario')->where('id_proyecto',$this->id_proyecto)->get();

        $this->secciones=ProyectoLicenciaSeccion::where('id_proyecto',$this->id_proyecto)->get();
        $secciones_guardadas=$this->secciones->pluck('id');
        
        $this->items_guardados=ProyectoLicenciaSeccionItem::with('mayorista')->whereIn('seccion_id',$secciones_guardadas)->get();
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
        Proyecto::where('id',$this->id_proyecto)
                  ->update([
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
                         'estatus'=>$this->estatus,
                        ]);

        //registro de bitacora de horas

        if($this->horas_originales!=$this->presupuesto)
        {
            $leyenda="Disminucion";
            if($this->presupuesto>$this->horas_originales)
            {
                $leyenda="Incremento";
            }
            $diferencia=$this->presupuesto-$this->horas_originales;
            BitacoraPresupuestoProyecto::create([
                                'id_proyecto'=>$this->id_proyecto,
                                'id_user'=>Auth::user()->id,
                                'campo'=>'Presupuesto',
                                'descripcion'=>$leyenda,
                                'original'=>$this->horas_originales,
                                'diferencia'=>$diferencia,
                                'nuevo'=>$this->presupuesto,
                                    ]);
        }           

        $this->emit('alert_ok','El proyecto se modifico satisfactoriamente');
        $this->resetErrorBag();
        $this->resetValidation();
        $this->resetExcept('id_proyecto','prospecto','nombre');
        $this->emit('actualiza_fuente');
        $this->open=false;
    }
}
