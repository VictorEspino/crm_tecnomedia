<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Oportunidad;
use App\Models\Prospecto;
use App\Models\LineaNegocio;
use App\Models\Servicio;
use App\Models\Compania;
use Illuminate\Support\Facades\Auth;

class OportunidadController extends Controller
{
    public function base_oportunidades(Request $request)
    {
        //return($request->all());
        $filtro_text='';
        $f_inicio='';
        $f_fin='';
        $filtro=false;

        $excel="NO";
        $prospecto=0;
        $linea=0;
        $servicio=0;
        $compañia=0;


        if(isset($_GET['filtro']))
        {
            $filtro=true;
            $filtro_text=$_GET["query"];
            $f_inicio=$_GET["f_inicio"];
            $f_fin=$_GET["f_fin"];
            $excel=$_GET["excel"];
            $linea=$_GET["linea"];
            $prospecto=$_GET["prospecto"];
            $servicio=$_GET["servicio"];
            $compañia=$_GET["compañia"];
        }
        if($excel=="NO")
        {
        $registros=Oportunidad::with('user','prospecto','contacto','linea_negocio','servicio','etapa','compania','moneda')
                        ->orderBy('created_at','desc')
                        ->when ($prospecto>0,function ($query) use ($prospecto)
                        {
                            $query->where('prospecto_id',$prospecto);
                        })
                        ->when ($compañia>0,function ($query) use ($compañia)
                        {
                            $query->where('compania_id',$compañia);
                        })
                        ->when ($servicio>0,function ($query) use ($servicio)
                        {
                            $query->where('servicio_id',$servicio);
                        })
                        ->when ($linea>0,function ($query) use ($linea)
                        {
                            $query->where('linea_negocio_id',$linea);
                        })
                        //LAS SIGUIENTES CONDICIONES DETERMINAN EL ALCANCE DE LA CONSULTA DE ACUERDO AL PERFIL
                        /*
                        ->when (Auth::user()->puesto==1,function ($query)
                        {
                            $query->where('ejecutivo',Auth::user()->id);
                        })
                        ->when (Auth::user()->puesto==2,function ($query)
                        {
                            $query->where('sub_area',Auth::user()->sub_area);
                        })*/
                        ->when($filtro && $filtro_text!='',function ($query) use ($filtro_text)
                            {
                                $query->where(function ($anidado) use ($filtro_text){
                                    $anidado->where('oportunidad','like','%'.$filtro_text.'%');
                                    $anidado->orWhere('partner','like','%'.$filtro_text.'%');
                                    $anidado->orWhere('producto','like','%'.$filtro_text.'%');
                                });               
                            })
                        ->when($filtro && $f_inicio!='',function ($query) use ($f_inicio)
                            {
                                $query->where('fecha_contacto','>=',$f_inicio);
                            })
                        ->when($filtro && $f_fin!='',function ($query) use ($f_fin)
                            {
                                $query->where('fecha_contacto','<=',$f_fin);
                            })
                        ->paginate(10);
        }    
        else
        {
            $registros=Oportunidad::with('user','prospecto','contacto','linea_negocio','servicio','etapa','compania','moneda')
                        ->orderBy('created_at','desc')
                        ->when ($prospecto>0,function ($query) use ($prospecto)
                        {
                            $query->where('prospecto_id',$prospecto);
                        })
                        ->when ($compañia>0,function ($query) use ($compañia)
                        {
                            $query->where('compania_id',$compañia);
                        })
                        ->when ($servicio>0,function ($query) use ($servicio)
                        {
                            $query->where('servicio_id',$servicio);
                        })
                        ->when ($linea>0,function ($query) use ($linea)
                        {
                            $query->where('linea_negocio_id',$linea);
                        })
                        //LAS SIGUIENTES CONDICIONES DETERMINAN EL ALCANCE DE LA CONSULTA DE ACUERDO AL PERFIL
                        /*
                        ->when (Auth::user()->puesto==1,function ($query)
                        {
                            $query->where('ejecutivo',Auth::user()->id);
                        })
                        ->when (Auth::user()->puesto==2,function ($query)
                        {
                            $query->where('sub_area',Auth::user()->sub_area);
                        })*/
                        ->when($filtro && $filtro_text!='',function ($query) use ($filtro_text)
                            {
                                $query->where(function ($anidado) use ($filtro_text){
                                    $anidado->where('oportunidad','like','%'.$filtro_text.'%');
                                    $anidado->orWhere('partner','like','%'.$filtro_text.'%');
                                    $anidado->orWhere('producto','like','%'.$filtro_text.'%');
                                });               
                            })
                        ->when($filtro && $f_inicio!='',function ($query) use ($f_inicio)
                            {
                                $query->where('fecha_contacto','>=',$f_inicio);
                            })
                        ->when($filtro && $f_fin!='',function ($query) use ($f_fin)
                            {
                                $query->where('fecha_contacto','<=',$f_fin);
                            })
                        ->get();
        }           
        
        if($filtro && $excel=="NO")
        {
            $registros->appends([
                    'filtro'=>'ACTIVE',
                    'query' => $filtro_text,
                    'f_fin'=>$f_fin,
                    'f_inicio'=>$f_inicio,
                    'excel'=>$excel,
                    'servicio'=>$servicio,
                    'linea'=>$linea,
                    'prospecto'=>$prospecto,
                    'compañia'=>$compañia
                    ]);   
        }      
        $prospectos=Prospecto::orderBy('razon_social','ASC')->get(); 
        $lineas=LineaNegocio::all();  
        $servicios=Servicio::all();  
        $compañias=Compania::orderBy('nombre','ASC')->get();      

        return(view($excel=="NO"?'oportunidades.base_oportunidades':'oportunidades.export',[
                                    'registros'=>$registros,
                                    'query'=>$filtro_text,
                                    'f_inicio'=>$f_inicio,
                                    'f_fin'=>$f_fin,
                                    'excel'=>$excel,
                                    'compañia'=>$compañia,
                                    'compañias'=>$compañias,
                                    'servicio'=>$servicio,
                                    'servicios'=>$servicios,
                                    'linea'=>$linea,
                                    'lineas'=>$lineas,
                                    'prospecto'=>$prospecto,
                                    'prospectos'=>$prospectos]));
    }
}
