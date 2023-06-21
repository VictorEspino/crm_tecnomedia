<?php

namespace App\Http\Livewire\Lead;

use Livewire\Component;
use App\Models\Prospecto;
use App\Models\ContactoProspecto;
use App\Models\LineaNegocio;
use App\Models\Servicio;
use App\Models\FuenteLead;
use App\Models\Lead;

class NuevoLead extends Component
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

    public $servicio;
    public $servicios=[];

    public $fuente;
    public $fuentes=[];

    public $fecha_contacto;
    public $oportunidad;
    public $partner;
    public $producto;
    public $comentarios;
    public $etapa=1;

    public $procesando=0;

    protected $listeners = ['prospectoAgregado' => 'carga_nuevo_prospecto','contactoAgregado'=>'carga_nuevo_contacto'];

    public function render()
    {
        
        return view('livewire.lead.nuevo-lead');
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
        $this->opcion_contacto=[];
        $this->ver_contacto=0;
        $this->lineas_negocio=LineaNegocio::all();
        $this->servicios=Servicio::all();
        $this->fuentes=FuenteLead::all();
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
            'empresa'=>'required',
            'contacto'=>'required',
            'linea_negocio'=>'required',
            'fecha_contacto'=>'required',
            'servicio'=>'required',
            'fuente'=>'required',
            'oportunidad'=>'required',
            'partner'=>'required',
            'producto'=>'required',
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

        Lead::create([
            'prospecto_id'=>$this->empresa,
            'contacto_prospecto_id'=>$this->contacto,
            'linea_negocio_id'=>$this->linea_negocio,
            'servicio_id'=>$this->servicio,
            'oportunidad'=>$this->oportunidad,
            'partner'=>$this->partner,
            'producto'=>$this->producto,
            'etapa_id'=>$this->etapa,
            'fuente_id'=>$this->fuente,
            'fecha_contacto'=>$this->fecha_contacto,
            'comentarios'=>$this->comentarios
        ]);

        $this->emit('alert_ok','El lead se creo satisfactoriamente');
        $this->resetErrorBag();
        $this->resetValidation();
        $this->reset();
    }


}
