<?php

namespace App\Http\Livewire\Documentos;

use Livewire\Component;

use Livewire\WithFileUploads;
use App\Models\ClienteDocumento;

class DocumentosCliente extends Component
{

    use WithFileUploads;

    public function render()
    {
        return view('livewire.documentos.documentos-cliente');
    }
    public $open=false;

    public $id_prospecto;
    public $prospecto;

    public $procesando=0;

    public $tipo;
    public $vigencia;
    public $archivo;
    public $archivo_valor;

    public $historico=[];


    public function mount($id_prospecto,$prospecto)
    {
        $this->id_prospecto=$id_prospecto;
        $this->prospecto=$prospecto;
    } 

    public function cargar()
    {
 
        $this->open=true;
        $this->historico=ClienteDocumento::with('user')
                                    ->where('id_cliente',$this->id_prospecto)
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
        $this->resetExcept('id_prospecto','prospecto');
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
        $this->emit('livewire_to_controller','nuevo_doc_cliente');
        
    }

    public function archivo_seleccionado($valor)
    {
        $this->archivo_valor=$valor;
    }
}
