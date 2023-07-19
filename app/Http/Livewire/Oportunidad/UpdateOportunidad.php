<?php

namespace App\Http\Livewire\Oportunidad;

use Livewire\Component;
use App\Models\Oportunidad;
use App\Models\BitacoraOportunidad;
use App\Models\TipoBitacoraOportunidad;
use Illuminate\Support\Facades\Auth;

class UpdateOportunidad extends Component
{
    public $open=false;
    public $oportunidad_id;
    public $procesando=0;

    public $oportunidad;

    public $oportunidad_text;

    public $razon_social;
    public $contacto;
    public $correo;
    public $telefono;
    public $linea_negocio;
    public $servicio;
    public $producto;

    public $partner;

    public $bitacora_oportunidads=[];

    public $nuevas_bitacoras=[];

    public $tipos=[];

    public function render()
    {
        return view('livewire.oportunidad.update-oportunidad');
    }
    public function mount($oportunidad_id)
    {
        $this->oportunidad_id=$oportunidad_id;
    }
    public function edit_open()
    {
        $this->open=true;
        $this->oportunidad=Oportunidad::with('prospecto','contacto','linea_negocio','servicio')
                                    ->where('id',$this->oportunidad_id)
                                    ->get()
                                    ->first();
        $this->razon_social=$this->oportunidad->prospecto->razon_social;
        $this->contacto=$this->oportunidad->contacto->nombre;
        $this->telefono=$this->oportunidad->contacto->telefono1;
        $this->correo=$this->oportunidad->contacto->correo1;
        $this->linea_negocio=$this->oportunidad->linea_negocio->nombre;
        $this->servicio=$this->oportunidad->servicio->nombre;
        $this->producto=$this->oportunidad->producto;
        $this->oportunidad_text=$this->oportunidad->oportunidad;
        $this->partner=$this->oportunidad->partner;

        $this->bitacora_oportunidads=BitacoraOportunidad::with('tipo')
                                            ->where('oportunidad_id',$this->oportunidad_id)
                                            ->orderBy('id','desc')
                                            ->get();

        $this->tipos=TipoBitacoraOportunidad::where('visible',1)->orderBy('id','asc')->get();
        
        if(is_null($this->bitacora_oportunidads)) $this->bitacora_oportunidads=[];
    }

    public function agregar_bitacora()
    {
        $this->nuevas_bitacoras[]=[
            'tipo'=>'',
            'detalles'=>'',
            'gasto'=>'0',
            'concepto_gasto'=>'',
            'due_date'=>'',
        ];
    }
    public function eliminar_bitacora($id)
    {
        unset($this->nuevas_bitacoras[$id]);
        $this->nuevas_bitacoras=array_values($this->nuevas_bitacoras);
    }
    public function validacion()
    {
        $reglas = ['oportunidad_id'=>'required'];
        foreach ($this->nuevas_bitacoras as $index => $campos) 
          {
            $reglas = array_merge($reglas, [
              'nuevas_bitacoras.'.$index.'.tipo' => 'required',
              'nuevas_bitacoras.'.$index.'.detalles' => 'required',
              'nuevas_bitacoras.'.$index.'.gasto' => 'numeric',
              'nuevas_bitacoras.'.$index.'.concepto_gasto' => 'required',
              'nuevas_bitacoras.'.$index.'.due_date' => 'required',
            ]);
          }
        //dd($reglas);
        $this->validate($reglas,
            [
                'required' => 'Campo requerido.',
                'numeric'=>'Debe ser un numero'
            ],
          );
    }
    public function guardar_bitacoras()
    {
        $this->validacion();
        $this->procesando=1;
        foreach($this->nuevas_bitacoras as $nueva)
        {
            BitacoraOportunidad::create([
            'user_id'=>Auth::user()->id,
            'oportunidad_id'=>$this->oportunidad_id,
            'tipo_id'=>$nueva['tipo'],
            'detalles'=>$nueva['detalles'],
            'gasto'=>$nueva['gasto'],
            'concepto_gasto'=>$nueva['concepto_gasto'],
            'due_date'=>$nueva['due_date'],
            ]);
        }
        $this->emit('alert_ok','El oportunidad se actualizo satisfactoriamente');
        $this->resetErrorBag();
        $this->resetValidation();
        $this->resetExcept('oportunidad_id');
    }
    public function cancelar()
    {
        $this->open=false;
        $this->resetErrorBag();
        $this->resetValidation();
        $this->resetExcept('oportunidad_id');
    }
}
