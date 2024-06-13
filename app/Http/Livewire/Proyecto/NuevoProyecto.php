<?php

namespace App\Http\Livewire\Proyecto;

use Livewire\Component;
use App\Models\LineaNegocio;
use App\Models\User;
use App\Models\TipoProyecto;
use App\Models\Proyecto;
use App\Models\Partner;
use App\Models\Fabricante;
use App\Models\Moneda;
use App\Models\ProyectoLicenciaSeccion;
use App\Models\ProyectoLicenciaSeccionItem;
use Illuminate\Support\Facades\DB;

class NuevoProyecto extends Component
{
    public $open=false;
    public $procesando=0;

    public $actualizado='';

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
    public $fabricantes=[];
    public $monedas=[];

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
        $this->fabricantes=Fabricante::all();
        $this->monedas=Moneda::all();
    }

    public function cancelar()
    {
        $this->open=false;
        $this->resetExcept('id_prospecto','prospecto');
        $this->resetErrorBag();
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
                'secciones.'.$index.'.i_moneda' => 'required',
                'secciones.'.$index.'.c_moneda' => 'required',
                'secciones.'.$index.'.i_tc' => ['required','numeric','min:1'],
                'secciones.'.$index.'.c_tc' => ['required','numeric','min:1'],
            ]);
            
                foreach($this->secciones[$index]['items'] as $index2=>$item)
                {
                    $reglas = array_merge($reglas, [
                        'secciones.'.$index.'.items.'.$index2.'.tipo'=>'required',
                        'secciones.'.$index.'.items.'.$index2.'.descripcion'=>'required',
                        'secciones.'.$index.'.items.'.$index2.'.cantidad'=>['numeric', 'min:1'],
                        'secciones.'.$index.'.items.'.$index2.'.total_cliente'=>['numeric', 'min:1'],
                        'secciones.'.$index.'.items.'.$index2.'.total_tecnomedia'=>['numeric', 'min:1'],
                        'secciones.'.$index.'.items.'.$index2.'.partner'=>'required',
                        'secciones.'.$index.'.items.'.$index2.'.fabricante'=>'required',
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
                    'i_moneda'=>$this->secciones[$index]['i_moneda'],
                    'i_tc'=>$this->secciones[$index]['i_tc'],
                    'c_moneda'=>$this->secciones[$index]['c_moneda'],
                    'c_tc'=>$this->secciones[$index]['c_tc'],
                        ]);

                $t_ingreso=0;
                $t_costo=0;
                $margen=0;
                $porcentaje_margen=0;

                foreach($this->secciones[$index]['items'] as $index2=>$item)
                {
                    $i_ingreso=$this->secciones[$index]['items'][$index2]['total_cliente']*$this->secciones[$index]['i_tc'];
                    $i_costo=$this->secciones[$index]['items'][$index2]['total_tecnomedia']*$this->secciones[$index]['c_tc'];
                    $i_margen=$i_ingreso-$i_costo;
                    $i_porc_margen=$i_ingreso>0?$i_margen/$i_ingreso:0;

                    ProyectoLicenciaSeccionItem::create([
                            'seccion_id'=>$seccion_creada->id,
                            'tipo'=>$this->secciones[$index]['items'][$index2]['tipo'],
                            'descripcion'=>$this->secciones[$index]['items'][$index2]['descripcion'],
                            'cantidad'=>$this->secciones[$index]['items'][$index2]['cantidad'],
                            'total_cliente'=>$this->secciones[$index]['items'][$index2]['total_cliente'],
                            'total_tecnomedia'=>$this->secciones[$index]['items'][$index2]['total_tecnomedia'],
                            'partner_id'=>$this->secciones[$index]['items'][$index2]['partner'],
                            'fabricante_id'=>$this->secciones[$index]['items'][$index2]['fabricante'],
                            'margen'=>$i_margen,
                            'porcentaje_margen'=>$i_porc_margen,
                            
                            ]);

                    $t_ingreso=$t_ingreso+$this->secciones[$index]['items'][$index2]['total_cliente'];
                    $t_costo=$t_costo+$this->secciones[$index]['items'][$index2]['total_tecnomedia'];
                }

                $margen=($t_ingreso*$this->secciones[$index]['i_tc'])-($t_costo*$this->secciones[$index]['c_tc']);
                $porcentaje_margen=(($t_ingreso*$this->secciones[$index]['i_tc']))>0?$margen/($t_ingreso*$this->secciones[$index]['i_tc']):0;

                ProyectoLicenciaSeccion::where('id',$seccion_creada->id)
                                        ->update([
                                            'total_ingreso'=>$t_ingreso,
                                            'total_costo'=>$t_costo,
                                            'margen'=>$margen,
                                            'porcentaje_margen'=>$porcentaje_margen,
                                        ]);
            }
            $fecha_inicio=ProyectoLicenciaSeccion::select(DB::raw('min(f_inicio) as f_inicio'))
                                                ->where('id_proyecto',$proyecto_creado->id)
                                                ->get()->first()
                                                ->f_inicio;
            $fecha_max=ProyectoLicenciaSeccion::select(DB::raw('max(f_fin) as f_fin'))
                                                ->where('id_proyecto',$proyecto_creado->id)
                                                ->get()->first()
                                                ->f_fin;
            Proyecto::where('id',$proyecto_creado->id)
                    ->update(
                        [
                            'fecha_inicio'=>$fecha_inicio,
                            'fecha_fin'=>$fecha_max
                        ]
                        );
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
                            'i_moneda'=>null,
                            'c_moneda'=>null,
                            'i_tc'=>null,
                            'c_tc'=>null,
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
                                'total_cliente'=>0,
                                'total_tecnomedia'=>0,
                                'partner'=>'',
                                'fabricante'=>'',
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
        /*
        if($this->secciones[$index1]["items"][$index2]['cantidad']=="") $this->secciones[$index1]["items"][$index2]['cantidad']=0;        
        if($this->secciones[$index1]["items"][$index2]['total_cliente']=="") $this->secciones[$index1]["items"][$index2]['total_cliente']=0;        
        if($this->secciones[$index1]["items"][$index2]['total_tecnomedia']=="") $this->secciones[$index1]["items"][$index2]['total_tecnomedia']=0;
        
        dd($this->secciones);

        $this->secciones[$index1]["items"][$index2]['margen']=($this->secciones[$index1]["items"][$index2]['total_cliente']*$this->secciones[$index1]['i_tc'])-($this->secciones[$index1]["items"][$index2]['total_tecnomedia']*$this->secciones[$index1]['c_tc']);
        dd($this->secciones[$index1]["items"][$index2]['margen']);
        if($this->secciones[$index1]["items"][$index2]['total_cliente']==0)
        {
            $this->secciones[$index1]["items"][$index2]['porcentaje_margen']=0;
        }
        else
        {
            $this->secciones[$index1]["items"][$index2]['porcentaje_margen']=1-($this->secciones[$index1]["items"][$index2]['total_tecnomedia']**$this->secciones[$index1]['c_tc'])/($this->secciones[$index1]["items"][$index2]['total_cliente']**$this->secciones[$index1]['i_tc']);    
        }
        //$this->update_totales();
        */
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

    public function updated($name, $value)
    {
        $arreglo=explode(".",$name);
        if(count($arreglo)==3)
        {
            if($arreglo[2]=='i_moneda')
            {
                $indice=1*$arreglo[1];
                if($value==1)
                    $this->secciones[$indice]['i_tc']=1;
                else
                    $this->secciones[$indice]['i_tc']=0;
            }
            if($arreglo[2]=='c_moneda')
            {
                $indice=1*$arreglo[1];
                if($value==1)
                    $this->secciones[$indice]['c_tc']=1;
                else
                    $this->secciones[$indice]['c_tc']=0;
            }
        }            
        else
            $this->actualizado=$name;

    }
}
