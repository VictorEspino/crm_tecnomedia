<?php

namespace App\Http\Livewire\Prospecto;

use Livewire\Component;
use App\Models\Prospecto;
use App\Models\CatalogoCodigo;
use App\Models\RegimenFiscal;

class NuevoProspecto extends Component
{
    public $open=false;
    public $procesando=0;

    public $rfc;
    public $regimen;
    public $razon_social;
    public $fecha_io;
    public $terminos_pago;
    public $calle;
    public $colonia;
    public $num_ext;
    public $num_int;
    public $cp;
    public $ciudad;
    public $estado;
    public $pais;

    public $opciones_colonia=0;
    public $colonias=[];
    public $regimenes=[];

    public function render()
    {
        return view('livewire.prospecto.nuevo-prospecto');
    }
    public function nuevo()
    {
        $this->open=true;
        $this->regimenes=RegimenFiscal::all();
    }
    public function cancelar()
    {
        $this->open=false;
        $this->reset();
    }
    public function validacion()
    {
        $reglas = [
            'rfc'=>'required|unique:prospectos,rfc',
            'regimen'=>'required',
            'razon_social'=>'required',
            'fecha_io'=>'required',
            'terminos_pago'=>'required',
            'calle'=>'required',
            'colonia'=>'required',
            'num_ext'=>'required',
            'cp'=>'required|numeric|digits:5',
            'ciudad'=>'required',
            'pais'=>'required',
            'estado'=>'required'
          ];
        //dd($reglas);
        $this->validate($reglas,
            [
                'required' => 'Campo requerido.',
                'numeric'=>'Debe ser un numero',
                'unique'=>'El valor ya existe en la base de datos',
                'email'=>'Se requiere una direccion de correo valida',
                'digits'=>'Debe constar de 5 digitos'
            ],
          );
    }
    public function guardar()
    {
        $this->validacion();
        $this->procesando=1;

        Prospecto::create([
            'rfc'=>strtoupper($this->rfc),
            'regimen'=>$this->regimen,
            'razon_social'=>strtoupper($this->razon_social),
            'fecha_io'=>$this->fecha_io,
            'terminos_pago'=>$this->terminos_pago,
            'calle'=>$this->calle,
            'colonia'=>$this->colonia,
            'num_ext'=>$this->num_ext,
            'cp'=>$this->cp,
            'ciudad'=>$this->ciudad,
            'pais'=>$this->pais,
            'estado'=>$this->estado,
        ]);
        
        $this->emit('prospectoAgregado');
        $this->emit('alert_ok','El prospecto se creo satisfactoriamente');
        $this->resetErrorBag();
        $this->resetValidation();
        $this->reset();

    }
    public function updatedCp()
    {
        $this->validarCodigoPostal();
    }
    public function validarCodigoPostal()
    {
        $filtro=$this->cp;
        $this->ciudad="";
        $this->estado="";
        $this->colonia="";
        $this->opciones_colonia=0;
        $this->colonias=[];
        $opciones=CatalogoCodigo::where('cp',$filtro)->get();
        foreach($opciones as $opcion)
        {
            $this->ciudad=$opcion->ciudad;
            $this->estado=$opcion->estado;
            if($this->opciones_colonia==0) //Asigna solo la primera opcion de la colonia;
            {
                $this->colonia=$opcion->colonia;
            }
            $this->colonias[]=['colonia'=>$opcion->colonia];
            $this->opciones_colonia=$this->opciones_colonia+1;
        }
        if($this->opciones_colonia>0) 
        {
            $this->pais='Mexico';
        }
        
    }
}
