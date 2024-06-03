<?php

namespace App\Http\Livewire\Documentos;

use Livewire\Component;
use App\Models\ProyectoLicenciaSeccion;

class DocumentosProyectoFinanzas extends Component
{

    public $id_proyecto;
    public $prospecto;
    public $nombre;
    public $open;
    public $monto;

    public $tipo;
    public $seccion;
    public $secciones=[];
    public $procesando=0;
    public $archivo_valor;

    public function render()
    {
        return view('livewire.documentos.documentos-proyecto-finanzas');
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
        $this->secciones=ProyectoLicenciaSeccion::where('id_proyecto',$this->id_proyecto)->get();
    }

    public function cancelar()
    {
        $this->open=false;
        $this->resetErrorBag();
        $this->resetValidation();
        $this->resetExcept('id_proyecto','prospecto','nombre');
    }

    public function archivo_seleccionado($valor)
    {
        $this->archivo_valor=$valor;
    }
}
