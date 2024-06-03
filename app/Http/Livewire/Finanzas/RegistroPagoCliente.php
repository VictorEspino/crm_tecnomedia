<?php

namespace App\Http\Livewire\Finanzas;

use Livewire\Component;
use App\Models\ProyectoDocumentoFinanzasFacturaCliente;
use App\Models\ProyectoDocumentoFinanzasPagoCliente;
use App\Models\ProyectoLicenciaSeccion;

class RegistroPagoCliente extends Component
{
    public $id_factura;
    public $procesando=0;
    public $open=false;

    public $seccion_registrada;

    public $moneda;
    public $moneda_nombre;
    public $complemento_pago;
    public $tipo_cambio_pago;
    public $tipo_cambio_efectivo;
    public $cantidad_pago;
    public $banco_pago;
    public $tipo_pago;
    public $fecha_pago;

    public $nota_factura;
    public $vencimiento_factura;
    public $saldo_factura;
    public $total_factura;

    public function render()
    {
        return view('livewire.finanzas.registro-pago-cliente');
    }
    public function mount($id_factura)
    {
        $this->id_factura=$id_factura;
    }
    public function abrir()
    {
        $this->open=true;
        $factura=ProyectoDocumentoFinanzasFacturaCliente::with('moneda_documento')->find($this->id_factura);

        $this->nota_factura=$factura->notas;
        $this->vencimiento_factura=$factura->fecha_vencimiento;
        $this->saldo_factura=$factura->saldo;
        $this->total_factura=$factura->cantidad_si;
        $this->seccion_registrada=$factura->seccion_id;
        $this->moneda=$factura->moneda;
        $this->moneda_nombre=$factura->moneda_documento->nombre;

        if($this->moneda==1)
        {
            $this->tipo_cambio_pago=1;
            $this->tipo_cambio_efectivo=1;
        }

    }
    public function cancelar()
    {
        $this->open=false;
        $this->resetExcept('id_factura');
        $this->resetErrorBag();
        $this->resetValidation();  
    }

    public function validacion()
    {
        $reglas = [
            'complemento_pago'=>'required',
            'tipo_cambio_pago'=>'required|numeric|min:1',
            'tipo_cambio_efectivo'=>'required|numeric|min:1',
            'cantidad_pago'=>'required|numeric|min:1|max:'.$this->saldo_factura,
            'banco_pago'=>'required',
            'tipo_pago'=>'required',
            'fecha_pago'=>'required',
          ];
        //dd($reglas);
        $this->validate($reglas,
            [
                'required' => 'Campo requerido.',
                'numeric'=>'Debe ser un numero',
                'unique'=>'El valor ya existe en la base de datos',
                'email'=>'Se requiere una direccion de correo valida',
                'digits'=>'Debe constar de 5 digitos',
                'min'=>'Indique un numero valido',
                'max'=>'La cantidad es mayor al saldo pendiente de la factura'
            ],
          );
    }
    public function guardar()
    {
        $this->validacion();
        $this->procesando=1;
        ProyectoDocumentoFinanzasPagoCliente::create([
            'factura_id'=>$this->id_factura,
            'moneda'=>$this->moneda,
            'tipo_cambio_pago'=>$this->tipo_cambio_pago,
            'tipo_cambio_efectivo'=>$this->tipo_cambio_efectivo,
            'cantidad_pago'=>$this->cantidad_pago,
            'complemento_pago'=>$this->complemento_pago,
            'banco_pago'=>$this->banco_pago,
            'tipo_pago'=>$this->tipo_pago, 
            'f_pago'=>$this->fecha_pago           
        ]);

        ProyectoDocumentoFinanzasFacturaCliente::where('id',$this->id_factura)
                        ->update([
                                    'saldo'=>$this->saldo_factura-$this->cantidad_pago
                                ]);

        $pagos_seccion=ProyectoLicenciaSeccion::find($this->seccion_registrada)->i_pagos;
        
        ProyectoLicenciaSeccion::where('id',$this->seccion_registrada)
                        ->update([
                                    'i_pagos'=>$pagos_seccion+$this->cantidad_pago
                                ]);

        $this->emit('actualizacion');
        $this->emit('alert_ok','Pago registrado satisfactoriamente');
        $this->resetExcept('id_factura');
        $this->resetErrorBag();
        $this->resetValidation();  

        $this->procesando=0;
        $this->open=false;
    }
}
