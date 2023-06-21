<?php

namespace App\Http\Livewire\Lead;

use Livewire\Component;
use App\Models\Prospecto;
use App\Models\ContactoProspecto;
use App\Models\LineaNegocio;
use App\Models\Servicio;
use App\Models\FuenteLead;

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

    public function render()
    {
        return view('livewire.lead.nuevo-lead');
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


}
