<?php

namespace App\Http\Livewire\Cotizacion;

use Livewire\Component;
use App\Models\UnidadServicio;
use App\Models\Cotizacion;
use App\Models\Oportunidad;
use App\Models\CotizacionSeccion;
use App\Models\CotizacionSeccionItem;
use Illuminate\Support\Facades\Auth;

class UpdateCotizacion extends Component
{
    public $cotizacion_id;
    public $oportunidad_id;
    public $unidades_servicio=[];
    public $procesando=0;
    public $open=false;
    public $fecha_presentacion;
    public $descripcion;
    public $años=1;
    public $total_propuesta=0;

    public $compania_id;
    public $moneda_id;

    public $secciones=[];

    public $estatus;

    public function render()
    {
        return view('livewire.cotizacion.update-cotizacion');
    }
    public function mount($cotizacion_id)
    {
        $this->cotizacion_id=$cotizacion_id;
        $cotizacion=Cotizacion::find($cotizacion_id);
        $this->oportunidad_id=$cotizacion->oportunidad_id;
        $this->compania_id=$cotizacion->compania_id;
        $this->moneda_id=$cotizacion->moneda_id;
        $this->unidades_servicio=UnidadServicio::all();
    }
    public function cargar()
    {
        $cotizacion=Cotizacion::find($this->cotizacion_id);
        $this->fecha_presentacion=$cotizacion->fecha_presentacion;
        $this->años=$cotizacion->anos;
        $this->descripcion=$cotizacion->descripcion;
        $this->total_propuesta=$cotizacion->total_propuesta;
        $this->estatus=$cotizacion->estatus;

        $secciones_cotizacion=CotizacionSeccion::where('cotizacion_id',$this->cotizacion_id)
                            ->get();
        $this->secciones=[];
        $index1=0;
        foreach($secciones_cotizacion as $s_carga)
        {
            $this->secciones[]=[
                            'nombre'=>$s_carga->nombre,
                            't_a1'=>$s_carga->t_a1,
                            't_a2'=>$s_carga->t_a2,
                            't_a3'=>$s_carga->t_a3,
                            't_a4'=>$s_carga->t_a4,
                            't_a5'=>$s_carga->t_a5,
                            'total'=>$s_carga->total,
                            'items'=>[],
                                ];
            $items=CotizacionSeccionItem::where('seccion_id',$s_carga->id)->get();
            foreach($items as $items_cargados)
            {
                $this->secciones[$index1]['items'][]=[
                    'cantidad'=>$items_cargados->cantidad,
                    'descripcion'=>$items_cargados->descripcion,
                    'unidad'=>$items_cargados->unidad,
                    'unitario'=>$items_cargados->unitario,
                    'descuento'=>$items_cargados->descuento,
                    'p_final'=>$items_cargados->p_final,
                    'a1'=>$items_cargados->a1,
                    'a2'=>$items_cargados->a2,
                    'a3'=>$items_cargados->a3,
                    'a4'=>$items_cargados->a4,
                    'a5'=>$items_cargados->a5,
                    'cuadra'=>1
                ];
            }
            $index1=$index1+1;
        }
        $this->open=true;
        $this->procesando=0;
    }

    public function agregar_seccion()
    {
        $this->secciones[]=[
                            'nombre'=>'',
                            't_a1'=>0,
                            't_a2'=>0,
                            't_a3'=>0,
                            't_a4'=>0,
                            't_a5'=>0,
                            'total'=>0,
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
                                'cantidad'=>0,
                                'descripcion'=>'',
                                'unidad'=>'',
                                'unitario'=>0,
                                'descuento'=>0,
                                'p_final'=>0,
                                'a1'=>0,
                                'a2'=>0,
                                'a3'=>0,
                                'a4'=>0,
                                'a5'=>0,
                                'cuadra'=>1
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
        if($this->secciones[$index1]["items"][$index2]['unitario']=="") $this->secciones[$index1]["items"][$index2]['unitario']=0;
        if($this->secciones[$index1]["items"][$index2]['descuento']=="") $this->secciones[$index1]["items"][$index2]['descuento']=0;
        if($this->secciones[$index1]["items"][$index2]['a1']=="") $this->secciones[$index1]["items"][$index2]['a1']=0;
        if($this->secciones[$index1]["items"][$index2]['a2']=="") $this->secciones[$index1]["items"][$index2]['a2']=0;
        if($this->secciones[$index1]["items"][$index2]['a3']=="") $this->secciones[$index1]["items"][$index2]['a3']=0;
        if($this->secciones[$index1]["items"][$index2]['a4']=="") $this->secciones[$index1]["items"][$index2]['a4']=0;
        if($this->secciones[$index1]["items"][$index2]['a5']=="") $this->secciones[$index1]["items"][$index2]['a5']=0;

        $this->secciones[$index1]["items"][$index2]['p_final']=
            $this->secciones[$index1]["items"][$index2]['cantidad']*
            $this->secciones[$index1]["items"][$index2]['unitario']*
            (1-0.01*$this->secciones[$index1]["items"][$index2]['descuento']);

            $this->secciones[$index1]["items"][$index2]['a1']=$this->secciones[$index1]["items"][$index2]['p_final'];
            $this->secciones[$index1]["items"][$index2]['a2']=0;
            $this->secciones[$index1]["items"][$index2]['a3']=0;
            $this->secciones[$index1]["items"][$index2]['a4']=0;
            $this->secciones[$index1]["items"][$index2]['a5']=0;

        $this->update_totales();
    }

    public function verifica_cuadre($index1,$index2)
    {
        if($this->secciones[$index1]["items"][$index2]['cantidad']=="") $this->secciones[$index1]["items"][$index2]['cantidad']=0;
        if($this->secciones[$index1]["items"][$index2]['unitario']=="") $this->secciones[$index1]["items"][$index2]['unitario']=0;
        if($this->secciones[$index1]["items"][$index2]['descuento']=="") $this->secciones[$index1]["items"][$index2]['descuento']=0;
        if($this->secciones[$index1]["items"][$index2]['a1']=="") $this->secciones[$index1]["items"][$index2]['a1']=0;
        if($this->secciones[$index1]["items"][$index2]['a2']=="") $this->secciones[$index1]["items"][$index2]['a2']=0;
        if($this->secciones[$index1]["items"][$index2]['a3']=="") $this->secciones[$index1]["items"][$index2]['a3']=0;
        if($this->secciones[$index1]["items"][$index2]['a4']=="") $this->secciones[$index1]["items"][$index2]['a4']=0;
        if($this->secciones[$index1]["items"][$index2]['a5']=="") $this->secciones[$index1]["items"][$index2]['a5']=0;

        if($this->secciones[$index1]["items"][$index2]['p_final']==
            $this->secciones[$index1]["items"][$index2]['a1']+
            $this->secciones[$index1]["items"][$index2]['a2']+
            $this->secciones[$index1]["items"][$index2]['a3']+
            $this->secciones[$index1]["items"][$index2]['a4']+
            $this->secciones[$index1]["items"][$index2]['a5'])
            {
                $this->secciones[$index1]["items"][$index2]['cuadra']=1;
            }
        else 
            {
                $this->secciones[$index1]["items"][$index2]['cuadra']=0;
            }

        $this->update_totales();
    }

    public function update_totales()
    {
        $this->procesando=0;
        $algun_error=0;
        $this->total_propuesta=0;

        foreach($this->secciones as $index=>$seccion)
        {
            $this->secciones[$index]['t_a1']=0;
            $this->secciones[$index]['t_a2']=0;
            $this->secciones[$index]['t_a3']=0;
            $this->secciones[$index]['t_a4']=0;
            $this->secciones[$index]['t_a5']=0;
            $this->secciones[$index]['total']=0;
            
            foreach($this->secciones[$index]['items'] as $index2=>$item)
            {
                $this->secciones[$index]['t_a1']=$this->secciones[$index]['t_a1']+$this->secciones[$index]['items'][$index2]['a1'];
                $this->secciones[$index]['t_a2']=$this->secciones[$index]['t_a2']+$this->secciones[$index]['items'][$index2]['a2'];
                $this->secciones[$index]['t_a3']=$this->secciones[$index]['t_a3']+$this->secciones[$index]['items'][$index2]['a3'];
                $this->secciones[$index]['t_a4']=$this->secciones[$index]['t_a4']+$this->secciones[$index]['items'][$index2]['a4'];
                $this->secciones[$index]['t_a5']=$this->secciones[$index]['t_a5']+$this->secciones[$index]['items'][$index2]['a5'];
                $this->secciones[$index]['total']=$this->secciones[$index]['total']+
                                                  $this->secciones[$index]['items'][$index2]['a1']+
                                                  $this->secciones[$index]['items'][$index2]['a2']+
                                                  $this->secciones[$index]['items'][$index2]['a3']+
                                                  $this->secciones[$index]['items'][$index2]['a4']+
                                                  $this->secciones[$index]['items'][$index2]['a5'];
                if($this->secciones[$index]['items'][$index2]['cuadra']==0)
                {
                    $algun_error=$algun_error+1; 
                }
            }
            $this->total_propuesta=$this->total_propuesta+$this->secciones[$index]['total'];
        }
        if($algun_error>0)
        {
            $this->procesando=1;
        }
    }

    public function validacion()
    {
        $reglas = ['fecha_presentacion'=>'required',
                    'descripcion'=>'required',
                  ];         
        foreach ($this->secciones as $index => $seccion) 
          {
            $reglas = array_merge($reglas, [
              'secciones.'.$index.'.nombre' => 'required',
            ]);
            foreach($this->secciones[$index]['items'] as $index2=>$item)
            {
                $reglas = array_merge($reglas, [
                    'secciones.'.$index.'.items.'.$index2.'.cantidad' => ['numeric', 'min:1'],
                    'secciones.'.$index.'.items.'.$index2.'.descripcion' => 'required',
                    'secciones.'.$index.'.items.'.$index2.'.unidad' => 'required',
                    'secciones.'.$index.'.items.'.$index2.'.unitario' => ['numeric', 'min:1'],
                  ]);
                
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
    public function guardar($estatus)
    {
        $this->validacion();
        $ticket_id=0;
        if($estatus==1)
        {
            $empresa=Oportunidad::with('prospecto')->find($this->oportunidad_id)->prospecto->razon_social;
            $ticket_id=nuevoTicketSistema(161,'AUTORIZACION DE COTIZACION PARA ('.$empresa.')','Se solicita la autorizacion de la siguiente propuesta economica:');
        }
        Cotizacion::where('id',$this->cotizacion_id)
        ->update([
            'fecha_presentacion'=>$this->fecha_presentacion,
            'descripcion'=>$this->descripcion,
            'total_propuesta'=>$this->total_propuesta,
            'user_id'=>Auth::user()->id,
            'compania_id'=>$this->compania_id,
            'moneda_id'=>$this->moneda_id,
            'anos'=>$this->años,
            'estatus'=>$estatus,
            'ticket_id'=>$ticket_id,
        ]);
        $secciones=CotizacionSeccion::select('id')->where('cotizacion_id',$this->cotizacion_id)->get();
        $secciones=$secciones->pluck('id');

        CotizacionSeccionItem::whereIn('seccion_id',$secciones)->delete();
        CotizacionSeccion::whereIn('id',$secciones)->delete();

    
        foreach($this->secciones as $index=>$seccion)
        {
            $seccion_creada=CotizacionSeccion::create([
                'cotizacion_id'=>$this->cotizacion_id,
                'nombre'=>$this->secciones[$index]['nombre'],
                't_a1'=>$this->secciones[$index]['t_a1'],
                't_a2'=>$this->secciones[$index]['t_a2'],
                't_a3'=>$this->secciones[$index]['t_a3'],
                't_a4'=>$this->secciones[$index]['t_a4'],
                't_a5'=>$this->secciones[$index]['t_a5'],
                'total'=>$this->secciones[$index]['total']
                    ]);
            foreach($this->secciones[$index]['items'] as $index2=>$item)
            {
                CotizacionSeccionItem::create([
                        'seccion_id'=>$seccion_creada->id,
                        'cantidad'=>$this->secciones[$index]['items'][$index2]['cantidad'],
                        'descripcion'=>$this->secciones[$index]['items'][$index2]['descripcion'],
                        'unidad'=>$this->secciones[$index]['items'][$index2]['unidad'],
                        'unitario'=>$this->secciones[$index]['items'][$index2]['unitario'],
                        'descuento'=>$this->secciones[$index]['items'][$index2]['descuento'],
                        'p_final'=>$this->secciones[$index]['items'][$index2]['p_final'],
                        'a1'=>$this->secciones[$index]['items'][$index2]['a1'],
                        'a2'=>$this->secciones[$index]['items'][$index2]['a2'],
                        'a3'=>$this->secciones[$index]['items'][$index2]['a3'],
                        'a4'=>$this->secciones[$index]['items'][$index2]['a4'],
                        'a5'=>$this->secciones[$index]['items'][$index2]['a5'],
                        ]);
            }
        }
        $this->emit('actualiza_fuente');
    }

    public function cancelar()
    {
        $this->open=false;
        $this->resetErrorBag();
        $this->resetValidation();
        $this->resetExcept('cotizacion_id','unidades_servicio','compania_id','moneda_id');
    }
}
