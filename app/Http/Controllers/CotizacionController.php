<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Cotizacion;

class CotizacionController extends Controller
{
    public function cotizaciones(Request $request)
    {
        $registros=Cotizacion::where('oportunidad_id',$request->id_oportunidad)->get();
        return(view('cotizacion.base_cotizaciones',['registros'=>$registros,'id_oportunidad'=>$request->id_oportunidad]));
    }
}
