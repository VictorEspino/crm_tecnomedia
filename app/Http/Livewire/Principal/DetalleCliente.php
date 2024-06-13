<?php

namespace App\Http\Livewire\Principal;

use Livewire\Component;
use App\Models\Prospecto;
use App\Models\Licencia;
use App\Models\Proyecto;
use App\Models\ProyectoLicenciaSeccion;
use App\Models\ProyectoLicenciaSeccionItem;

class DetalleCliente extends Component
{
    public $open=false;
    public $id_prospecto;

    public $razon_social;
    public $rfc;
    public $regimen;
    public $fecha_io;
    public $terminos_pago;
    public $calle;
    public $colonia;
    public $num_ext;
    public $num_int;
    public $cp;
    public $ciudad;
    public $pais;
    public $licencias=[];

    public $proyectos_activos=[];

    public function mount($id_prospecto)
    {
        $this->id_prospecto=$id_prospecto;
    }

    public function render()
    {
        return view('livewire.principal.detalle-cliente');
    }
    public function cargar()
    {
        $this->open=true;
        $prospecto=Prospecto::find($this->id_prospecto);
        $this->razon_social=$prospecto->razon_social;
        $this->rfc=$prospecto->rfc;
        $this->regimen=$prospecto->regimen;
        $this->fecha_io=$prospecto->fecha_io;
        $this->terminos_pago=$prospecto->terminos_pago;
        $this->calle=$prospecto->calle;
        $this->colonia=$prospecto->colonia;
        $this->num_ext=$prospecto->num_ext;
        $this->num_int=$prospecto->num_int;
        $this->cp=$prospecto->cp;
        $this->ciudad=$prospecto->ciudad;
        $this->pais=$prospecto->pais;
        $this->licencias=Licencia::with('linea_negocio','moneda')->where('prospecto_id',$this->id_prospecto)->get();

        $fecha_actual = date("Y-m-d");
        $proyectos_activos=Proyecto::with('negocio')
                                        ->whereRaw('fecha_inicio <= "'.$fecha_actual.'" and fecha_fin>="'.$fecha_actual.'"')
                                        ->where('id_prospecto',$this->id_prospecto)
                                        ->get();
        
        foreach($proyectos_activos as $proy)
        {
            $secciones_previas=[];
            $secciones_activas=[];
            $secciones_siguientes=[];
            //Primero consulta la secciones ya finalizadas
            $secciones_proyecto=ProyectoLicenciaSeccion::whereRaw('f_fin<="'.$fecha_actual.'"')
                                                        ->where('id_proyecto',$proy->id)
                                                        ->get();

            foreach($secciones_proyecto as $secc)
            {
                $items=[];

                $elemento=ProyectoLicenciaSeccionItem::with('mayorista','fabricante')
                                                       ->where('seccion_id',$secc->id)
                                                       ->get();

                foreach($elemento as $elem)
                {
                    $items[]=[
                                'descripcion'=>$elem->descripcion,
                                'cantidad'=>$elem->cantidad,
                                'total_cliente'=>$elem->total_cliente,
                                'mayorista'=>$elem->mayorista->nombre,
                                'fabricante'=>$elem->fabricante->nombre,
                                'porcentaje_margen'=>$elem->porcentaje_margen,
                            ];
                }

                $secciones_previas[]=[
                                        'nombre'=>$secc->nombre,
                                        'f_inicio'=>$secc->f_inicio,
                                        'f_fin'=>$secc->f_fin,
                                        'total_ingreso'=>$secc->total_ingreso,
                                        'i_tc'=>$secc->i_tc,
                                        'porcentaje_margen'=>$secc->porcentaje_margen,
                                        'items'=>$items


                                    ];
            }

            //Primero consulta la secciones con vigencia
            $secciones_proyecto=ProyectoLicenciaSeccion::whereRaw('f_inicio<="'.$fecha_actual.'" and f_fin>="'.$fecha_actual.'"')
                                                        ->where('id_proyecto',$proy->id)
                                                        ->get();

            foreach($secciones_proyecto as $secc)
            {
                $items=[];

                $elemento=ProyectoLicenciaSeccionItem::with('mayorista','fabricante')
                                                       ->where('seccion_id',$secc->id)
                                                       ->get();

                foreach($elemento as $elem)
                {
                    $items[]=[
                                'descripcion'=>$elem->descripcion,
                                'cantidad'=>$elem->cantidad,
                                'total_cliente'=>$elem->total_cliente,
                                'mayorista'=>$elem->mayorista->nombre,
                                'fabricante'=>$elem->fabricante->nombre,
                                'porcentaje_margen'=>$elem->porcentaje_margen,
                            ];
                }

                $secciones_activas[]=[
                                        'nombre'=>$secc->nombre,
                                        'f_inicio'=>$secc->f_inicio,
                                        'f_fin'=>$secc->f_fin,
                                        'total_ingreso'=>$secc->total_ingreso,
                                        'i_tc'=>$secc->i_tc,
                                        'porcentaje_margen'=>$secc->porcentaje_margen,
                                        'items'=>$items

                                    ];
            }

            //Primero consulta la secciones que tienen inicio posterior
            $secciones_proyecto=ProyectoLicenciaSeccion::whereRaw('f_inicio>="'.$fecha_actual.'"')
                                                        ->where('id_proyecto',$proy->id)
                                                        ->get();

            foreach($secciones_proyecto as $secc)
            {
                $items=[];

                $elemento=ProyectoLicenciaSeccionItem::with('mayorista','fabricante')
                                                       ->where('seccion_id',$secc->id)
                                                       ->get();

                foreach($elemento as $elem)
                {
                    $items[]=[
                                'descripcion'=>$elem->descripcion,
                                'cantidad'=>$elem->cantidad,
                                'total_cliente'=>$elem->total_cliente,
                                'mayorista'=>$elem->mayorista->nombre,
                                'fabricante'=>$elem->fabricante->nombre,
                                'porcentaje_margen'=>$elem->porcentaje_margen,
                            ];
                }

                $secciones_siguientes[]=[
                                        'nombre'=>$secc->nombre,
                                        'f_inicio'=>$secc->f_inicio,
                                        'f_fin'=>$secc->f_fin,
                                        'total_ingreso'=>$secc->total_ingreso,
                                        'i_tc'=>$secc->i_tc,
                                        'porcentaje_margen'=>$secc->porcentaje_margen,
                                        'items'=>$items

                                    ];
            }
            $this->proyectos_activos[]=[
                                        'fecha_inicio'=>$proy->fecha_inicio,
                                        'fecha_fin'=>$proy->fecha_fin,
                                        'negocio'=>$proy->negocio->nombre,
                                        'nombre'=>$proy->nombre,
                                        'descripcion'=>$proy->descripcion,
                                        'secciones_activas'=>$secciones_activas,
                                        'secciones_previas'=>$secciones_previas,
                                        'secciones_siguientes'=>$secciones_siguientes,
                                       ];
        }

    }
    public function cancelar()
    {
        $this->open=false;
    }
}
