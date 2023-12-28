<?php

namespace App\Http\Livewire\Lead;

use Livewire\Component;
use App\Models\Lead;
use App\Models\BitacoraLead;
use App\Models\TipoBitacoraLead;
use App\Models\ConceptoGasto;
use Illuminate\Support\Facades\Auth;

class UpdateLead extends Component
{
    public $open=false;
    public $lead_id;
    public $procesando=0;

    public $lead;

    public $razon_social;
    public $contacto;
    public $correo;
    public $telefono;
    public $linea_negocio;
    public $servicio;
    public $producto;
    public $oportunidad;
    public $partner;

    public $bitacora_leads=[];

    public $nuevas_bitacoras=[];

    public $tipos=[];

    public $concepto_gastos=[];

    public function render()
    {
        return view('livewire.lead.update-lead');
    }
    public function mount($lead_id)
    {
        $this->lead_id=$lead_id;
    }
    public function edit_open()
    {
        $this->open=true;
        $this->lead=Lead::with('prospecto','contacto','linea_negocio','servicio','fuente')
                                    ->where('id',$this->lead_id)
                                    ->get()
                                    ->first();
        $this->razon_social=$this->lead->prospecto->razon_social;
        $this->contacto=$this->lead->contacto->nombre;
        $this->telefono=$this->lead->contacto->telefono1;
        $this->correo=$this->lead->contacto->correo1;
        $this->linea_negocio=$this->lead->linea_negocio->nombre;
        $this->servicio=$this->lead->servicio->nombre;
        $this->producto=$this->lead->producto;
        $this->oportunidad=$this->lead->oportunidad;
        $this->partner=$this->lead->partner;

        $this->bitacora_leads=BitacoraLead::with('tipo','ticket','c_gasto')
                                            ->where('lead_id',$this->lead_id)
                                            ->orderBy('id','desc')
                                            ->get();

        $this->tipos=TipoBitacoraLead::where('visible',1)->orderBy('id','asc')->get();
        $this->concepto_gastos=ConceptoGasto::all();
        
        if(is_null($this->bitacora_leads)) $this->bitacora_leads=[];
    }

    public function agregar_bitacora()
    {
        $this->nuevas_bitacoras[]=[
            'tipo'=>'',
            'detalles'=>'',
            'gasto'=>'0',
            'concepto_gasto'=>'1',
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
        $reglas = ['lead_id'=>'required'];
        foreach ($this->nuevas_bitacoras as $index => $campos) 
          {
            $reglas = array_merge($reglas, [
              'nuevas_bitacoras.'.$index.'.tipo' => 'required',
              'nuevas_bitacoras.'.$index.'.detalles' => 'required',
              'nuevas_bitacoras.'.$index.'.gasto' => 'numeric',                            
              'nuevas_bitacoras.'.$index.'.due_date' => 'required',
                ]);
            if($this->nuevas_bitacoras[$index]['gasto']>0)
            {
                $reglas = array_merge($reglas, [
                'nuevas_bitacoras.'.$index.'.concepto_gasto' => 'required|numeric|min:2',
                ]);
            }
          }
        //dd($reglas);
        $this->validate($reglas,
            [
                'required' => 'Campo requerido.',
                'numeric'=>'Debe ser un numero',
                'min'=>'Seleccione una opcion valida'
            ],
          );
    }
    public function guardar_bitacoras()
    {
        $this->validacion();
        $this->procesando=1;
        foreach($this->nuevas_bitacoras as $nueva)
        {
            $ticket_id=0;
            if($nueva['gasto']>0)
            {
                $ticket_id=nuevoTicketSistema(160,'AUTORIZACION DE GASTO DE PROMOCION ('.$this->razon_social.')','Se solicita la autorizacion de gasto por $'.$nueva['gasto'].', para el concepto: '.$nueva['concepto_gasto']);
            }
            BitacoraLead::create([
            'user_id'=>Auth::user()->id,
            'lead_id'=>$this->lead_id,
            'tipo_id'=>$nueva['tipo'],
            'detalles'=>$nueva['detalles'],
            'gasto'=>$nueva['gasto'],
            'concepto_gasto'=>$nueva['gasto']=='0'?1:$nueva['concepto_gasto'],
            'due_date'=>$nueva['due_date'],
            'ticket_id'=>$ticket_id,
            ]);
        }
        $this->emit('alert_ok','El lead se actualizo satisfactoriamente');
        $this->resetErrorBag();
        $this->resetValidation();
        $this->resetExcept('lead_id');
    }
    public function cancelar()
    {
        $this->open=false;
        $this->resetErrorBag();
        $this->resetValidation();
        $this->resetExcept('lead_id');
    }
}
