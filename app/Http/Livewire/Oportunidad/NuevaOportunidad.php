<?php

namespace App\Http\Livewire\Oportunidad;

use Livewire\Component;
use App\Models\Prospecto;
use App\Models\ContactoProspecto;
use App\Models\LineaNegocio;
use App\Models\Servicio;
use App\Models\Oportunidad;
use App\Models\Compania;
use App\Models\EtapaOportunidad;
use App\Models\Moneda;
use Illuminate\Support\Facades\Auth;

class NuevaOportunidad extends Component
{
    
    public $buscar_contacto="";
    public $buscar_empresa="";

    public $opcion_contacto=[];
    public $opcion_empresa=[];

    public $empresa;
    public $contacto;

    public $ver_contacto=0;

    public $linea_negocio;
    public $lineas_negocio=[];

    public $compañia;
    public $compañias=[];

    public $servicio;
    public $servicios=[];

    public $oportunidad;
    public $partner;
    public $producto;
    public $comentarios;
    public $etapa=1;

    public $procesando=0;

    public $moneda;
    public $monedas=[];

    public $horas_consultoria;
    public $valor_propuesta;
    public $costo_fabricante;
    public $costo_consultoria;
    public $margen_estimado;
    public $estimacion_cierre;
    public $dias_credito;

    protected $listeners = ['prospectoAgregado' => 'carga_nuevo_prospecto','contactoAgregado'=>'carga_nuevo_contacto'];

    public function render()
    {
        return view('livewire.oportunidad.nueva-oportunidad');
    }

    public function carga_nuevo_prospecto()
    {
        $this->opcion_empresa=Prospecto::orderBy('razon_social','ASC')->get();
    }
    public function carga_nuevo_contacto()
    {
        $this->opcion_contacto=ContactoProspecto::where('prospecto_id',$this->empresa)
                    ->orderBy('nombre','ASC')
                    ->get();
    }
    public function mount()
    {
        $this->opcion_empresa=Prospecto::orderBy('razon_social','ASC')->get();
        $this->compañias=Compania::orderBy('nombre','ASC')->get();
        $this->opcion_contacto=[];
        $this->ver_contacto=0;
        $this->lineas_negocio=LineaNegocio::all();
        $this->servicios=Servicio::all();
        $this->monedas=Moneda::all();
    }
    public function updatedBuscarEmpresa($valor)
    {
        $this->empresa=0;
        $this->ver_contacto=0;
        $this->opcion_empresa=Prospecto::where('razon_social','LIKE','%'.$valor.'%')
                        ->orWhere('rfc','LIKE','%'.$valor.'%')
                        ->orderBy('razon_social','ASC')
                        ->get();
        $this->opcion_contacto=[];
    }
    public function updatedEmpresa($valor)
    {
        if($valor>0)
        {
            $this->ver_contacto=1;
            $this->opcion_contacto=ContactoProspecto::where('prospecto_id',$valor)
                                    ->orderBy('nombre','ASC')
                                    ->get();
            session(['idEmpresa' => $valor]);
        }
    }
    public function updatedBuscarContacto($valor)
    {
        $this->contacto=0;
        $this->opcion_contacto=ContactoProspecto::where('prospecto_id',$this->empresa)
                    ->where('nombre','LIKE','%'.$valor.'%')
                    ->orderBy('nombre','ASC')
                    ->get();
    }

    public function validacion()
    {
        $reglas = [
            'compañia'=>'required',
            'empresa'=>'required',
            'contacto'=>'required',
            'linea_negocio'=>'required',
            'servicio'=>'required',
            'oportunidad'=>'required',
            'partner'=>'required',
            'producto'=>'required',
            'moneda'=>'required',
            'horas_consultoria'=>'required',
            'valor_propuesta'=>'required',
            'costo_fabricante'=>'required',
            'costo_consultoria'=>'required',
            'margen_estimado'=>'required',
            'estimacion_cierre'=>'required',
            'dias_credito'=>'required',
            
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

        $dias_escalacion=EtapaOportunidad::find(1)->dias;

        $fecha_actual = date("Y-m-d");
        $fecha_nueva = new \DateTime($fecha_actual);
        $fecha_nueva->modify("+".$dias_escalacion." days");
        $fecha_nueva_formateada = $fecha_nueva->format("Y-m-d");

        Oportunidad::create([
            'user_id'=>Auth::user()->id,
            'compania_id'=>$this->compañia,
            'prospecto_id'=>$this->empresa,
            'contacto_prospecto_id'=>$this->contacto,
            'linea_negocio_id'=>$this->linea_negocio,
            'servicio_id'=>$this->servicio,
            'oportunidad'=>$this->oportunidad,
            'partner'=>$this->partner,
            'producto'=>$this->producto,
            'etapa_id'=>$this->etapa,
            'due_date_etapa'=>$fecha_nueva_formateada,
            'comentarios'=>$this->comentarios,
            'moneda_id'=>$this->moneda,
            'horas_consultoria'=>$this->horas_consultoria,
            'valor_propuesta'=>$this->valor_propuesta,
            'costo_fabricante'=>$this->costo_fabricante,
            'costo_consultoria'=>$this->costo_consultoria,
            'margen_estimado'=>$this->margen_estimado,
            'estimacion_cierre'=>$this->estimacion_cierre,
            'dias_credito'=>$this->dias_credito,
        ]);

        $this->emit('alert_ok','La oportunidad se creo satisfactoriamente');
        $this->resetErrorBag();
        $this->resetValidation();
        $this->reset();
    }
}
