<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Cotizacion;
use App\Models\Oportunidad;

class CotizacionController extends Controller
{
    public function cotizaciones(Request $request)
    {
        $oportunidad=Oportunidad::with('prospecto','linea_negocio','moneda','servicio')->find($request->id_oportunidad);
        $registros=Cotizacion::where('oportunidad_id',$request->id_oportunidad)->paginate(10);
        return(view('cotizacion.base_cotizaciones',['oportunidad'=>$oportunidad,'registros'=>$registros,'id_oportunidad'=>$request->id_oportunidad]));
    }
}
