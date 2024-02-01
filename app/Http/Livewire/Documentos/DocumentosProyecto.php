<?php

namespace App\Http\Livewire\Documentos;

use Livewire\Component;

use Livewire\WithFileUploads;
use App\Models\ProyectoDocumento;

class DocumentosProyecto extends Component
{
    use WithFileUploads;
    public $open=false;

    public $id_proyecto;
    public $nombre;
    public $prospecto;

    public $procesando=0;

    public $tipo;
    public $vigencia;
    public $archivo;

    public $archivo_valor;

    public $historico=[];

    public function render()
    {
        return view('livewire.documentos.documentos-proyecto');
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
        $this->historico=ProyectoDocumento::with('user')
                                    ->where('id_proyecto',$this->id_proyecto)
                                    ->orderByRaw('tipo ASC, created_at DESC')
                                    ->get();

        $this->tipo=null;
        $this->vigencia=null;
        $this->archivo=null;
    }

    public function cancelar()
    {
        $this->open=false;
        $this->resetErrorBag();
        $this->resetValidation();
        $this->resetExcept('id_proyecto','prospecto','nombre');
    }

    public function validacion()
    {
        $reglas = [
            'tipo'=>'required',
            'vigencia'=>'required',
            'archivo_valor' => 'required',
          ];
        //dd($reglas);
        $this->validate($reglas,
            [
                'required' => 'Campo requerido.',
                'numeric'=>'Debe ser un numero',
                'miembros.min'=> 'El grupo debe tener al menos un miembro',
                'manager.min'=> 'El grupo debe tener al menos un manager'
            ],
          );
    }
    public function guardar()
    {
        $this->validacion();  
        $this->procesando=1;                     
        $this->emit('livewire_to_controller','nuevo_doc_proyecto');
        
    }

    public function archivo_seleccionado($valor)
    {
        $this->archivo_valor=$valor;
    }
}
