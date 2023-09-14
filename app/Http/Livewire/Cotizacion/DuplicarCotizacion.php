<?php

namespace App\Http\Livewire\Cotizacion;

use Livewire\Component;

use App\Models\Oportunidad;
use App\Models\Cotizacion;
use App\Models\CotizacionSeccion;
use App\Models\CotizacionSeccionItem;
use Illuminate\Support\Facades\Auth;

class DuplicarCotizacion extends Component
{
    public $procesando=0;
    public $open=false;
    public $oportunidad_id;
    public $folio;
    public $valido=0;

    public $linea_negocio_id;
    public $servicio_id;
    public $moneda_id;
    public $leyenda;


    public function render()
    {
        return view('livewire.cotizacion.duplicar-cotizacion');
    }
    public function mount($oportunidad_id)
    {
        $this->oportunidad_id=$oportunidad_id;
        $oportunidad=Oportunidad::find($oportunidad_id);
        $this->linea_negocio_id=$oportunidad->linea_negocio_id;
        $this->servicio_id=$oportunidad->servicio_id;
        $this->moneda_id=$oportunidad->moneda_id;
        $this->compania_id=$oportunidad->compania_id;

    }
    public function nuevo()
    {
        $this->open=true;
        $this->procesando=0;
    }
    public function updatedFolio()
    {
        $fuente_linea_negocio=0;
        $fuente_servicio=0;
        $fuente_moneda=0;
        $this->leyenda="";
        $this->valido=0;

        if($this->folio!=0 && $this->folio!="")
        {
            $a_duplicar=Cotizacion::with('oportunidad')->where('id',$this->folio)->get();
            foreach($a_duplicar as $fuente)
            {
                $fuente_linea_negocio=$fuente->oportunidad->linea_negocio_id;
                $fuente_servicio=$fuente->oportunidad->servicio_id;
                $fuente_moneda=$fuente->oportunidad->moneda_id;
            }
            if($fuente_linea_negocio==$this->linea_negocio_id &&
            $fuente_servicio==$this->servicio_id &&
            $fuente_moneda==$this->moneda_id
            )
            {
                $this->leyenda="Cotizacion compatible";
                $this->valido=1;
            }
            else
                {
                    $this->leyenda="Esta cotizacion no es compatible con esta oportunidad, se encuentran diferencias en la linea de negocio, el servicio y/o la moneda de la oportunidad original, por lo que se pueden crear inconsistencias en el seguimiento";
                    $this->valido=0;
                }  
        }
    }
    public function cancelar()
    {
        $this->open=false;
        $this->resetErrorBag();
        $this->resetValidation();
        $this->resetExcept('oportunidad_id','linea_negocio_id','servicio_id','moneda_id','compania_id');
    }

    public function duplicar()
    {
        $cotizacion_fuente=Cotizacion::find($this->folio);
        $cotizacion_creada=Cotizacion::create
        (
            [
                'oportunidad_id'=>$this->oportunidad_id,
                'fecha_presentacion'=>$cotizacion_fuente->fecha_presentacion,
                'descripcion'=>'(copia)'.$cotizacion_fuente->descripcion,
                'total_propuesta'=>$cotizacion_fuente->total_propuesta,
                'user_id'=>Auth::user()->id,
                'compania_id'=>$this->compania_id,
                'moneda_id'=>$this->moneda_id,
                'anos'=>$cotizacion_fuente->anos,
                'estatus'=>0,
                'ticket_id'=>0,
            ]
        );

        $seccion_fuente=CotizacionSeccion::where('cotizacion_id',$this->folio)->get();

        foreach($seccion_fuente as $sf)
        {
            $seccion_creada=CotizacionSeccion::create([
                            'cotizacion_id'=>$cotizacion_creada->id,
                            'nombre'=>$sf->nombre,
                            't_a1'=>$sf->t_a1,
                            't_a2'=>$sf->t_a2,
                            't_a3'=>$sf->t_a3,
                            't_a4'=>$sf->t_a4,
                            't_a5'=>$sf->t_a5,
                            'total'=>$sf->total,
            ]);

            $items_seccion_fuente=CotizacionSeccionItem::where('seccion_id',$sf->id)->get();

            foreach($items_seccion_fuente as $isf)
            {
                CotizacionSeccionItem::create([
                    'seccion_id'=>$seccion_creada->id,
                    'cantidad'=>$isf->cantidad,
                    'descripcion'=>$isf->descripcion,
                    'unidad'=>$isf->unidad,
                    'unitario'=>$isf->unitario,
                    'descuento'=>$isf->descuento,
                    'p_final'=>$isf->p_final,
                    'a1'=>$isf->a1,
                    'a2'=>$isf->a2,
                    'a3'=>$isf->a3,
                    'a4'=>$isf->a4,
                    'a5'=>$isf->a5,
                ]);
            }

        }
        $this->emit('actualiza_fuente');
    }
}
