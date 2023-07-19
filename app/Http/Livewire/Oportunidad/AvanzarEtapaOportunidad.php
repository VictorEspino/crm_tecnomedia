<?php

namespace App\Http\Livewire\Oportunidad;

use Livewire\Component;

use App\Models\Oportunidad;
use App\Models\EtapaOportunidad;
use App\Models\BitacoraOportunidad;
use Illuminate\Support\Facades\Auth;

class AvanzarEtapaOportunidad extends Component
{
    public $open=false;
    public $oportunidad_id;
    public $procesando=0;

    public $oportunidad;

    public $razon_social;
    public $contacto;
    public $correo;
    public $telefono;
    public $linea_negocio;
    public $servicio;
    public $producto;
    public $oportunidad_text;
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
        return view('livewire.oportunidad.avanzar-etapa-oportunidad');
    }

    public function mount($oportunidad_id)
    {
        $this->oportunidad_id=$oportunidad_id;
        $this->desc_etapa_actual=EtapaOportunidad::find(1);
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
        $this->etapa_actual=$this->oportunidad->etapa_id;

        $this->desc_etapa_actual=Etapaoportunidad::find($this->etapa_actual);
        
        $this->opciones_avance=[];

        if($this->etapa_actual<=7)
        {
            $siguiente=Etapaoportunidad::find($this->etapa_actual+1);
            $this->opciones_avance[]=[
                                        'id'=>$this->etapa_actual+1,
                                        'nombre'=>$siguiente->nombre,
                                        'mensaje'=>$siguiente->mensaje,
                                        'dias'=>$siguiente->dias,
                                    ];
        }

        if($this->etapa_actual!=7)
        {
            $this->opciones_avance[]=[
                'id'=>8,
                'nombre'=>'Cerrado ganado',
                'mensaje'=>'Esta estatus indica que el prospecto CALIFICA para ser cliente de TecnoMedia con esta ruta de contacto, se procede al seguimiento en el modulo de proyectos para su implementacion.',
                'dias'=>0,
            ];
            $this->opciones_avance[]=[
                'id'=>9,
                'nombre'=>'Cerrado perdido',
                'mensaje'=>'Esta estatus indica que el prospecto no acepta la propuesta de solucion de Tecnomedia y sus parametros financieros',
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
                if($this->avanzar_a!=8 && $this->avanzar_a!=9 && $this->avanzar_a!='')
                    $this->dias_dd="A partir de esta fecha tendras ".$this->dias_avance." dias para concluir esta accion.";
                    if($this->avanzar_a==8)
                    $this->dias_dd="Esto dara la oportunidad por GANADA y se comenzara el seguimiento en el modulo de proyectos";
                if($this->avanzar_a==9)
                    $this->dias_dd="Esto eliminara el oportunidad de la tabla de seguimiento y lo dara por cerrado";
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

        BitacoraOportunidad::create([
            'user_id'=>Auth::user()->id,
            'oportunidad_id'=>$this->oportunidad_id,
            'tipo_id'=>4,
            'detalles'=>'Avanza a etapa: '.$this->avance_nombre,
            'gasto'=>0,
            'concepto_gasto'=>'',
            'due_date'=>$fecha_nueva_formateada,
            ]);

        Oportunidad::where('id',$this->oportunidad_id)
            ->update([
                'etapa_id'=>$this->avanzar_a,
                'due_date_etapa'=>$fecha_nueva_formateada
            ]);
 
        $this->emit('alert_ok','La etapa del oportunidad se actualizo satisfactoriamente');
        $this->resetErrorBag();
        $this->resetValidation();
        $this->resetExcept('oportunidad_id','desc_etapa_actual');
    }
    public function cancelar()
    {
        $this->open=false;
        $this->resetErrorBag();
        $this->resetValidation();
        $this->resetExcept('oportunidad_id','desc_etapa_actual');
    }
}
