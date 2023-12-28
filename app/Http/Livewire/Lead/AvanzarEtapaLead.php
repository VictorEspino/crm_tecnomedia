<?php

namespace App\Http\Livewire\Lead;

use Livewire\Component;
use App\Models\Lead;
use App\Models\EtapaLead;
use App\Models\BitacoraLead;
use Illuminate\Support\Facades\Auth;

class AvanzarEtapaLead extends Component
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

    public $etapa_actual;

    public $desc_etapa_actual;

    public $opciones_avance=[];
    public $avanzar_a;
    public $avance_nombre;
    public $mensaje_avance;
    public $dias_avance;
    public $dias_dd;


    public function render()
    {
        return view('livewire.lead.avanzar-etapa-lead');
    }

    public function mount($lead_id)
    {
        $this->lead_id=$lead_id;
        $this->desc_etapa_actual=EtapaLead::find(1);
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
        $this->etapa_actual=$this->lead->etapa_id;

        $this->desc_etapa_actual=EtapaLead::find($this->etapa_actual);
        
        $this->opciones_avance=[];

        if($this->etapa_actual<=4)
        {
            $siguiente=EtapaLead::find($this->etapa_actual+1);
            $this->opciones_avance[]=[
                                        'id'=>$this->etapa_actual+1,
                                        'nombre'=>$siguiente->nombre,
                                        'mensaje'=>$siguiente->mensaje,
                                        'dias'=>$siguiente->dias,
                                    ];
        }

        if($this->etapa_actual!=5)
        {
            $this->opciones_avance[]=[
                'id'=>6,
                'nombre'=>'Cierre',
                'mensaje'=>'Esta estatus indica que el prospecto no califica para ser cliente de TecnoMedia con esta ruta de contacto.',
                'dias'=>0,
            ];
        }
    }
    public function updatedAvanzarA()
    {
        $this->mensaje_avance="";
        $this->dias_dd="";
        $this->dias_avance=0;
        $this->avance_nombre="";
        foreach($this->opciones_avance as $opcion)
        {
            if($opcion['id']==$this->avanzar_a)
            {
                $this->mensaje_avance=$opcion['mensaje'];
                $this->dias_avance=$opcion['dias'];
                $this->avance_nombre=$opcion['nombre'];
                if($this->avanzar_a!=6 && $this->avanzar_a!='')
                    $this->dias_dd="A partir de esta fecha tendras ".$this->dias_avance." dias para concluir esta accion.";
                if($this->avanzar_a==6)
                    $this->dias_dd="Esto eliminara el LEAD de la tabla de seguimiento y lo dara por cerrado";
            }
        }
    }
    public function validacion()
    {
        $reglas = [
            'avanzar_a'=>'required',
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

        $fecha_actual = date("Y-m-d");
        $fecha_nueva = new \DateTime($fecha_actual);
        $fecha_nueva->modify("+".$this->dias_avance." days");
        $fecha_nueva_formateada = $fecha_nueva->format("Y-m-d");

        BitacoraLead::create([
            'user_id'=>Auth::user()->id,
            'lead_id'=>$this->lead_id,
            'tipo_id'=>4,
            'detalles'=>'Avanza a etapa: '.$this->avance_nombre,
            'gasto'=>0,
            'concepto_gasto'=>'1',
            'due_date'=>$fecha_nueva_formateada,
            ]);

        Lead::where('id',$this->lead_id)
            ->update([
                'etapa_id'=>$this->avanzar_a,
                'due_date_etapa'=>$fecha_nueva_formateada
            ]);
 
        $this->emit('alert_ok','La etapa del lead se actualizo satisfactoriamente');
        $this->emit('actualiza_fuente');
        $this->resetErrorBag();
        $this->resetValidation();
        $this->resetExcept('lead_id','desc_etapa_actual');
    }
    public function cancelar()
    {
        $this->open=false;
        $this->resetErrorBag();
        $this->resetValidation();
        $this->resetExcept('lead_id','desc_etapa_actual');
    }
}
