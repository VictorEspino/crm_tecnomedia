<?php

namespace App\Http\Livewire\Finanzas;

use Livewire\Component;
use App\Models\ProyectoDocumentoFinanzasFacturaCliente;
use App\Models\ProyectoDocumentoFinanzasNotaCreditoCliente;
use App\Models\ProyectoLicenciaSeccion;

class RegistroNotaCreditoCliente extends Component
{
    public $id_factura;
    public $procesando=0;
    public $open=false;

    public $seccion_registrada;

    public $moneda;
    public $moneda_nombre;

    public $folio;
    public $cantidad_nota;
    public $fecha_emision;
    public $notas;

    public $nota_factura;
    public $vencimiento_factura;
    public $saldo_factura;
    public $total_factura;

    public function render()
    {
        return view('livewire.finanzas.registro-nota-credito-cliente');
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
            'folio'=>'required',
            'cantidad_nota'=>'required|numeric|min:1|max:'.$this->saldo_factura,
            'fecha_emision'=>'required',
            'notas'=>'required',
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
        ProyectoDocumentoFinanzasNotaCreditoCliente::create([
            'factura_id'=>$this->id_factura,
            'cantidad'=>$this->cantidad_nota,
            'folio'=>$this->folio,
            'f_emision'=>$this->fecha_emision,
            'notas'=>$this->notas,        
        ]);

        ProyectoDocumentoFinanzasFacturaCliente::where('id',$this->id_factura)
                        ->update([
                                    'saldo'=>$this->saldo_factura-$this->cantidad_nota
                                ]);

        $notas_seccion=ProyectoLicenciaSeccion::find($this->seccion_registrada)->i_nc;
        
        ProyectoLicenciaSeccion::where('id',$this->seccion_registrada)
                        ->update([
                                    'i_nc'=>$notas_seccion+$this->cantidad_nota
                                ]);

        $this->emit('actualizacion');
        $this->emit('alert_ok','Nota de credito registrada satisfactoriamente');
        $this->resetExcept('id_factura');
        $this->resetErrorBag();
        $this->resetValidation();  

        $this->procesando=0;
        $this->open=false;
    }
}
