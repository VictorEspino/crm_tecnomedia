<?php

namespace App\Http\Livewire\Finanzas;

use Livewire\Component;
use App\Models\Proyecto;
use App\Models\ProyectoLicenciaSeccion;
use App\Models\ProyectoLicenciaSeccionItem;
use App\Models\ProyectoDocumentoFinanzasFacturaCliente;
use App\Models\ProyectoDocumentoFinanzasFacturaProveedor;
use App\Models\Partner;
use App\Models\Moneda;
use Illuminate\Support\Facades\DB;

class RegistroMovimientos extends Component
{
    public $id_proyecto;
    public $nombre_proyecto;
    public $linea_negocio;
    public $prospecto;
    public $id_prospecto;
    public $tipo;

    public $secciones=[];
    public $items_guardados=[];

    public $documentos=[];
    public $monedas=[];

    public $open_cliente=false;
    public $open_proveedor=false;

    public $moneda_documento;
    public $tipo_cambio_documento;
    public $solicitar_tc=false;

    ////-----------------------------------
    //Universo carga cliente
    ////-----------------------------------
    public $procesando=0;
    
    public $seccion_a_registrar;
    public $cantidad_si=0;
    public $cantidad_ci=0;
    public $impuestos_trasladados=0;
    public $impuestos_retenidos=0;
    public $notas="";
    public $f_emision;
    public $folio_documento="";
    public $dias_prospecto;
    public $cuenta_contable;
    public $orden_compra;

     ////-----------------------------------
    //Universo carga proveedor
    ////-----------------------------------

    public $partners_seccion=[];
    public $partner;
    public $dias_credito_partner=0;

    protected $listeners = ['actualizacion' => 'render'];

    public function render()
    {
        return view('livewire.finanzas.registro-movimientos');
    }

    public function mount($id_proyecto)
    {
        $this->id_proyecto=$id_proyecto;        
        $proyecto=Proyecto::with('prospecto','negocio','tipo')->find($this->id_proyecto);
        $this->nombre_proyecto=$proyecto->nombre;
        $this->id_prospecto=$proyecto->prospecto->id;
        $this->linea_negocio=$proyecto->negocio->nombre;
        $this->prospecto=$proyecto->prospecto->razon_social;
        $this->tipo=$proyecto->tipo->nombre;
        $this->monedas=Moneda::all();
        $this->secciones=ProyectoLicenciaSeccion::where('id_proyecto',$id_proyecto)->get();
        $secciones_guardadas=$this->secciones->pluck('id');        
        $this->items_guardados=ProyectoLicenciaSeccionItem::with('mayorista')->whereIn('seccion_id',$secciones_guardadas)->get();
        $this->dias_prospecto=$proyecto->prospecto->terminos_pago;
        $this->documentos=ProyectoDocumentoFinanzasFacturaCliente::with('moneda_documento')->where('proyecto_id',$this->id_proyecto)->get();
        $this->documentos_proveedor=ProyectoDocumentoFinanzasFacturaProveedor::with('moneda_documento')->where('proyecto_id',$this->id_proyecto)->get();
    }
    public function agregar_documento_cliente($seccion,$tc)
    {
        $this->open_cliente=true;
        $this->seccion_a_registrar=$seccion;
        $this->solicitar_tc=false;
        $this->cantidad_si=0;
        $this->cantidad_ci=0;
        $this->impuestos_trasladados=0;
        $this->impuestos_retenidos=0;
        $this->notas="";
        $this->f_emision=null;
        $this->folio_documento="";
        $this->cuenta_contable=null;
        $this->orden_compra=null;
        $this->tipo_cambio_documento=null;
        if($tc==1)
        {
            $this->moneda_documento=1;
            $this->solicitar_tc=false;
            $this->tipo_cambio_documento=1;
        }
        if($tc>1)
        {
            $this->moneda_documento=2;
            $this->solicitar_tc=true;
            $this->tipo_cambio_documento=0;
         }        
    }
    public function agregar_documento_proveedor($seccion)
    {
        $this->open_proveedor=true;

        $this->seccion_a_registrar=$seccion;
        $this->solicitar_tc=false;
        $this->cantidad_si=0;
        $this->cantidad_ci=0;
        $this->impuestos_trasladados=0;
        $this->impuestos_retenidos=0;
        $this->notas="";
        $this->f_emision=null;
        $this->folio_documento="";
        $this->cuenta_contable=null;
        $this->orden_compra=null;
        $this->moneda_documento=null;
        $this->tipo_cambio_documento=null;
        $this->partner=null;
        $this->dias_credito_parner=0;
        
        $arreglo_valido_partners=ProyectoLicenciaSeccionItem::select(DB::raw('distinct partner_id as partners'))
                                                            ->where('seccion_id',$seccion)
                                                            ->get();

        $arreglo_valido_partners=$arreglo_valido_partners->pluck('partners');

        $this->partners_seccion=Partner::whereIn('id',$arreglo_valido_partners)
                                ->orderBy('nombre')
                                ->get();
    }
    public function updatedPartner()
    {
        $this->dias_credito_partner=Partner::find($this->partner)->terminos_pago;
    }
    public function updatedCantidadSi()
    {
        $this->actualizar_total_cliente();
    }
    public function updatedImpuestosTrasladados()
    {
        $this->actualizar_total_cliente();
    }
    public function updatedImpuestosRetenidos()
    {
        $this->actualizar_total_cliente();
    }
    public function actualizar_total_cliente()
    {
        if($this->impuestos_retenidos=="") $this->impuestos_retenidos=0;
        if($this->impuestos_trasladados=="") $this->impuestos_trasladados=0;
        if($this->cantidad_si=="") $this->cantidad_si=0;

        $this->impuestos_retenidos=$this->impuestos_retenidos*1;
        $this->impuestos_trasladados=$this->impuestos_trasladados*1;
        $this->cantidad_si=$this->cantidad_si*1;

        $this->cantidad_ci=$this->cantidad_si+$this->impuestos_trasladados-$this->impuestos_retenidos;
    }
    public function updatedMonedaDocumento()
    {
        $this->tipo_cambio_documento=0;
        if($this->moneda_documento>1)
        {
            $this->solicitar_tc=true;
            $this->tipo_cambio_documento=0;
        }
        if($this->moneda_documento==1)
        {
            $this->solicitar_tc=false;
            $this->tipo_cambio_documento=1;
        }
    }
    public function cancelar_cliente()
    {
        $this->open_cliente=false;
        $this->procesando=0;
        $this->resetErrorBag();
    }

    public function cancelar_proveedor()
    {
        $this->open_proveedor=false;
        $this->procesando=0;
        $this->resetErrorBag();
    }

    public function validacion_cliente()
    {
        $reglas = [
            'cantidad_si'=>'required|numeric|min:1',
            'folio_documento'=>'required',
            'moneda_documento'=>'required',
            'tipo_cambio_documento'=>'required|numeric|min:1',
            'impuestos_trasladados'=>'numeric|min:0',
            'impuestos_retenidos'=>'numeric|min:0',
            'f_emision'=>'required',
            'cuenta_contable'=>'required',
            'orden_compra'=>'required',

          ];
        //dd($reglas);
        $this->validate($reglas,
            [
                'required' => 'Campo requerido.',
                'numeric'=>'Debe ser un numero',
                'unique'=>'El valor ya existe en la base de datos',
                'email'=>'Se requiere una direccion de correo valida',
                'digits'=>'Debe constar de 5 digitos',
                'min'=>'Indique un numero valido'
            ],
          );
    }
    public function guardar_cliente()
    {
        $this->validacion_cliente();
        $this->procesando=1;

        $fechaActual = $this->f_emision;
        $intervalo = new \DateInterval('P'.$this->dias_prospecto.'D');
        $fechaNueva = new \DateTime($fechaActual);
        $fechaNueva->add($intervalo);
        $fechaNuevaFormateada = $fechaNueva->format('Y-m-d'); // Formatea la nueva fecha como yyyy-mm-d
        
        ProyectoDocumentoFinanzasFacturaCliente::create([
                         'proyecto_id'=>$this->id_proyecto,
                         'seccion_id'=>$this->seccion_a_registrar,
                         'id_cliente'=>$this->id_prospecto,
                         'folio_cfdi'=>$this->folio_documento,
                         'moneda'=>$this->moneda_documento,
                         'tipo_cambio'=>$this->tipo_cambio_documento,
                         'cantidad_si'=>$this->cantidad_si,
                         'impuestos_trasladados'=>$this->impuestos_trasladados,
                         'impuestos_retenidos'=>$this->impuestos_retenidos,
                         'cantidad_ci'=>$this->cantidad_ci,
                         'fecha_emision'=>$this->f_emision,
                         'dias_pago'=>$this->dias_prospecto,
                         'fecha_vencimiento'=>$fechaNuevaFormateada,
                         'cuenta_contable'=>$this->cuenta_contable,
                         'orden_compra'=>$this->orden_compra,
                         'notas'=>$this->notas,
                         'saldo'=>$this->cantidad_si,
        ]);

        $seccion=ProyectoLicenciaSeccion::find($this->seccion_a_registrar);
        $facturado_actual=$seccion->i_facturado;
        $facturado_actual=$facturado_actual+$this->cantidad_si;
        ProyectoLicenciaSeccion::where('id',$this->seccion_a_registrar)
            ->update(
                [
                    'i_facturado'=> $facturado_actual
                ]
            );

        $this->documentos=ProyectoDocumentoFinanzasFacturaCliente::where('proyecto_id',$this->id_proyecto)->get();
        
        $this->emit('actualizacion');
        $this->emit('alert_ok','Documento agregado satisfactoriamente');
        $this->resetErrorBag();
        $this->resetValidation();

        $this->open_cliente=false;
        $this->procesando=0;
    }

    public function validacion_proveedor()
    {
        $reglas = [
            'cantidad_si'=>'required|numeric|min:1',
            'folio_documento'=>'required',
            'moneda_documento'=>'required',
            'tipo_cambio_documento'=>'required|numeric|min:1',
            'impuestos_trasladados'=>'numeric|min:0',
            'impuestos_retenidos'=>'numeric|min:0',
            'f_emision'=>'required',
            'cuenta_contable'=>'required',
            'orden_compra'=>'required',
            'partner'=>'required',
          ];
        //dd($reglas);
        $this->validate($reglas,
            [
                'required' => 'Campo requerido.',
                'numeric'=>'Debe ser un numero',
                'unique'=>'El valor ya existe en la base de datos',
                'email'=>'Se requiere una direccion de correo valida',
                'digits'=>'Debe constar de 5 digitos',
                'min'=>'Indique un numero valido'
            ],
          );
    }
    public function guardar_proveedor()
    {
        $this->validacion_proveedor();
        $this->procesando=1;

        $fechaActual = $this->f_emision;
        $intervalo = new \DateInterval('P'.$this->dias_credito_partner.'D');
        $fechaNueva = new \DateTime($fechaActual);
        $fechaNueva->add($intervalo);
        $fechaNuevaFormateada = $fechaNueva->format('Y-m-d'); // Formatea la nueva fecha como yyyy-mm-d

        ProyectoDocumentoFinanzasFacturaProveedor::create([
                        'proyecto_id'=>$this->id_proyecto,
                        'seccion_id'=>$this->seccion_a_registrar,
                        'partner_id'=>$this->partner,
                        'folio_cfdi'=>$this->folio_documento,
                        'moneda'=>$this->moneda_documento,
                        'tipo_cambio'=>$this->tipo_cambio_documento,
                        'cantidad_si'=>$this->cantidad_si,
                        'impuestos_trasladados'=>$this->impuestos_trasladados,
                        'impuestos_retenidos'=>$this->impuestos_retenidos,
                        'cantidad_ci'=>$this->cantidad_ci,
                        'fecha_emision'=>$this->f_emision,
                        'dias_pago'=>$this->dias_credito_parner,
                        'fecha_vencimiento'=>$fechaNuevaFormateada,
                        'cuenta_contable'=>$this->cuenta_contable,
                        'orden_compra'=>$this->orden_compra,
                        'notas'=>$this->notas,
                        'saldo'=>$this->cantidad_si,
                    ]);

        $seccion=ProyectoLicenciaSeccion::find($this->seccion_a_registrar);

        $facturado_actual=$seccion->c_facturado;
        $facturado_actual=$facturado_actual+$this->cantidad_si;
        ProyectoLicenciaSeccion::where('id',$this->seccion_a_registrar)
                                ->update(
                                    [
                                        'c_facturado'=> $facturado_actual
                                    ]
                                );
        


        $this->documentos_proveedor=ProyectoDocumentoFinanzasFacturaProveedor::where('proyecto_id',$this->id_proyecto)->get();
        
        $this->emit('actualizacion');
        $this->emit('alert_ok','Documento agregado satisfactoriamente');
        $this->resetErrorBag();
        $this->resetValidation();  
        
        $this->open_proveedor=false;
        $this->procesando=0;
    }
}
