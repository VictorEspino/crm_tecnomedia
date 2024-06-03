<?php

namespace App\Http\Livewire\Proyecto;

use Livewire\Component;
use App\Models\LineaNegocio;
use App\Models\User;
use App\Models\TipoProyecto;
use App\Models\Proyecto;
use App\Models\Partner;
use App\Models\ProyectoLicenciaSeccion;
use App\Models\ProyectoLicenciaSeccionItem;

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
    public $partners=[];

    public $secciones=[];

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
        $this->partners=Partner::all();
    }

    public function cancelar()
    {
        $this->open=false;
        $this->resetExcept('id_prospecto','prospecto');
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
        if($this->tipo_proyecto==2)
        {     
            foreach ($this->secciones as $index => $seccion) 
            {
            $reglas = array_merge($reglas, [
                'secciones.'.$index.'.nombre' => 'required',
                'secciones.'.$index.'.f_inicio' => 'required',
                'secciones.'.$index.'.f_fin' => 'required',
            ]);
            
                foreach($this->secciones[$index]['items'] as $index2=>$item)
                {
                    $reglas = array_merge($reglas, [
                        'secciones.'.$index.'.items.'.$index2.'.tipo'=>'required',
                        'secciones.'.$index.'.items.'.$index2.'.descripcion'=>'required',
                        'secciones.'.$index.'.items.'.$index2.'.cantidad'=>['numeric', 'min:1'],
                        'secciones.'.$index.'.items.'.$index2.'.unitario_cliente'=>['numeric', 'min:1'],
                        'secciones.'.$index.'.items.'.$index2.'.total_cliente'=>['numeric', 'min:1'],
                        'secciones.'.$index.'.items.'.$index2.'.unitario_tecnomedia'=>['numeric', 'min:1'],
                        'secciones.'.$index.'.items.'.$index2.'.total_tecnomedia'=>['numeric', 'min:1'],
                        'secciones.'.$index.'.items.'.$index2.'.partner'=>'required',
                        ]);
                    
                }
            } 
        }
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
        $proyecto_creado=Proyecto::create([
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
        if($this->tipo_proyecto==2)
        {

            foreach ($this->secciones as $index => $seccion) 
            {
                $seccion_creada=ProyectoLicenciaSeccion::create([
                    'id_proyecto'=>$proyecto_creado->id,
                    'nombre'=>$this->secciones[$index]['nombre'],
                    'f_inicio'=>$this->secciones[$index]['f_inicio'],
                    'f_fin'=>$this->secciones[$index]['f_fin'],
                        ]);

                $t_ingreso=0;
                $t_costo=0;
                $margen=0;
                $porcentaje_margen=0;

                foreach($this->secciones[$index]['items'] as $index2=>$item)
                {
                    ProyectoLicenciaSeccionItem::create([
                            'seccion_id'=>$seccion_creada->id,
                            'tipo'=>$this->secciones[$index]['items'][$index2]['tipo'],
                            'descripcion'=>$this->secciones[$index]['items'][$index2]['descripcion'],
                            'cantidad'=>$this->secciones[$index]['items'][$index2]['cantidad'],
                            'unitario_cliente'=>$this->secciones[$index]['items'][$index2]['unitario_cliente'],
                            'total_cliente'=>$this->secciones[$index]['items'][$index2]['total_cliente'],
                            'unitario_tecnomedia'=>$this->secciones[$index]['items'][$index2]['unitario_tecnomedia'],
                            'total_tecnomedia'=>$this->secciones[$index]['items'][$index2]['total_tecnomedia'],
                            'partner_id'=>$this->secciones[$index]['items'][$index2]['partner'],
                            'margen'=>$this->secciones[$index]['items'][$index2]['margen'],
                            'porcentaje_margen'=>$this->secciones[$index]['items'][$index2]['porcentaje_margen'],
                            
                            ]);

                    $t_ingreso=$t_ingreso+$this->secciones[$index]['items'][$index2]['total_cliente'];
                    $t_costo=$t_costo+$this->secciones[$index]['items'][$index2]['total_tecnomedia'];
                }

                $margen=$t_ingreso-$t_costo;
                $porcentaje_margen=$t_ingreso>0?$margen/$t_ingreso:0;

                ProyectoLicenciaSeccion::where('id',$seccion_creada->id)
                                        ->update([
                                            'total_ingreso'=>$t_ingreso,
                                            'total_costo'=>$t_costo,
                                            'margen'=>$margen,
                                            'porcentaje_margen'=>$porcentaje_margen,
                                        ]);
            }

        }
        $this->emit('alert_ok','El proyecto se creo satisfactoriamente');
        $this->resetErrorBag();
        $this->resetValidation();
        $this->resetExcept('id_prospecto','prospecto');
        $this->open=false;
    }

    public function agregar_seccion()
    {
        $this->secciones[]=[
                            'nombre'=>'',
                            'f_inicio'=>'',
                            'f_fin'=>'',
                            'total_ingreso'=>0,
                            'total_costo'=>0,
                            'margen'=>0,
                            'porcentaje_margen'=>0,
                            'items'=>[],
                        ];
    }

    public function eliminar_seccion($id)
    {
        unset($this->secciones[$id]);
        $this->secciones=array_values($this->secciones);
    }

    public function agregar_item($index_seccion)
    {
        $this->secciones[$index_seccion]['items'][]=
                            [
                                'tipo'=>'',
                                'descripcion'=>'',
                                'cantidad'=>0,
                                'unitario_cliente'=>0,
                                'total_cliente'=>0,
                                'unitario_tecnomedia'=>0,
                                'total_tecnomedia'=>0,
                                'partner'=>'',
                                'margen'=>0,
                                'porcentaje_margen'=>0,
                            ];
    }
    public function eliminar_item($id_seccion,$id_item)
    {
        unset($this->secciones[$id_seccion]['items'][$id_item]);
        $this->secciones[$id_seccion]['items']=array_values($this->secciones[$id_seccion]['items']);
    }

    public function actualiza_item($index1,$index2)
    {
        if($this->secciones[$index1]["items"][$index2]['cantidad']=="") $this->secciones[$index1]["items"][$index2]['cantidad']=0;
        if($this->secciones[$index1]["items"][$index2]['unitario_cliente']=="") $this->secciones[$index1]["items"][$index2]['unitario_cliente']=0;
        if($this->secciones[$index1]["items"][$index2]['total_cliente']=="") $this->secciones[$index1]["items"][$index2]['total_cliente']=0;
        if($this->secciones[$index1]["items"][$index2]['unitario_tecnomedia']=="") $this->secciones[$index1]["items"][$index2]['unitario_tecnomedia']=0;
        if($this->secciones[$index1]["items"][$index2]['total_tecnomedia']=="") $this->secciones[$index1]["items"][$index2]['total_tecnomedia']=0;
        
        $this->secciones[$index1]["items"][$index2]['margen']=$this->secciones[$index1]["items"][$index2]['total_cliente']-$this->secciones[$index1]["items"][$index2]['total_tecnomedia'];
        if($this->secciones[$index1]["items"][$index2]['total_cliente']==0)
        {
            $this->secciones[$index1]["items"][$index2]['porcentaje_margen']=0;
        }
        else
        {
            $this->secciones[$index1]["items"][$index2]['porcentaje_margen']=1-$this->secciones[$index1]["items"][$index2]['total_tecnomedia']/$this->secciones[$index1]["items"][$index2]['total_cliente'];    
        }
        //$this->update_totales();
    }

    public function aplica_tipo()
    {
        if($this->tipo_proyecto==2)
        {
            $this->presupuesto=0;
            $this->precio_costo=1;
            $this->precio_venta=1;
            $this->fecha_inicio='2024-01-01';
            $this->fecha_fin='2024-01-01';
        }
    }
}
