<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Proyecto;
use App\Models\Prospecto;
use App\Models\LineaNegocio;
use App\Models\User;

class ProyectoController extends Controller
{
    public function base_proyectos(Request $request)
    {
        //return($request->all());
        $filtro_text='';
        $f_inicio='';
        $f_fin='';
        $filtro=false;

        $excel="NO";
        $prospecto=0;
        $negocio=0;
        $responsable=0;
        $estatus=0;



        if(isset($_GET['filtro']))
        {
            $filtro=true;
            $filtro_text=$_GET["query"];
            $f_inicio=$_GET["f_inicio"];
            $f_fin=$_GET["f_fin"];
            $excel=$_GET["excel"];
            $estatus=$_GET["estatus"];
            $prospecto=$_GET["prospecto"];
            $negocio=$_GET["negocio"];
            $responsable=$_GET["responsable"];
        }
        if($excel=="NO")
        {
        $registros=Proyecto::with('prospecto','responsable','negocio','tipo')
                        ->orderBy('created_at','desc')
                        ->when ($prospecto>0,function ($query) use ($prospecto)
                        {
                            $query->where('id_prospecto',$prospecto);
                        })
                        ->when ($negocio>0,function ($query) use ($negocio)
                        {
                            $query->where('id_negocio',$negocio);
                        })
                        ->when ($responsable>0,function ($query) use ($responsable)
                        {
                            $query->where('user_responsable_id',$responsable);
                        })
                        //LAS SIGUIENTES CONDICIONES DETERMINAN EL ALCANCE DE LA CONSULTA DE ACUERDO AL PERFIL
                        /*->when (Auth::user()->puesto==1,function ($query)
                        {
                            $query->where('ejecutivo',Auth::user()->id);
                        })
                        ->when (Auth::user()->puesto==2,function ($query)
                        {
                            $query->where('sub_area',Auth::user()->sub_area);
                        })
                        */
                        ->when($filtro && $filtro_text!='',function ($query) use ($filtro_text)
                            {
                                $query->where(function ($anidado) use ($filtro_text){
                                    $anidado->where('nombre','like','%'.$filtro_text.'%');
                                    $anidado->orWhere('descripcion','like','%'.$filtro_text.'%');
                                });               
                            })
                        ->when($filtro && $f_inicio!='',function ($query) use ($f_inicio)
                            {
                                $query->where('fecha_inicio','>=',$f_inicio);
                            })
                        ->when($filtro && $f_fin!='',function ($query) use ($f_fin)
                            {
                                $query->where('fecha_fin','<=',$f_fin);
                            })
                        ->when ($estatus>0,function ($query) use ($estatus)
                            {
                                $query->where('estatus',$estatus);
                            })
                        ->paginate(10);
        }    
        else
        {
            $registros=Proyecto::with('prospecto','responsable','negocio','tipo')
                        ->orderBy('fecha_contacto','desc')
                        ->when ($prospecto>0,function ($query) use ($prospecto)
                        {
                            $query->where('id_prospecto',$prospecto);
                        })
                        ->when ($negocio>0,function ($query) use ($negocio)
                        {
                            $query->where('id_negocio',$negocio);
                        })
                        ->when ($responsable>0,function ($query) use ($responsable)
                        {
                            $query->where('user_responsable_id',$responsable);
                        })
                        //LAS SIGUIENTES CONDICIONES DETERMINAN EL ALCANCE DE LA CONSULTA DE ACUERDO AL PERFIL
                        /*->when (Auth::user()->puesto==1,function ($query)
                        {
                            $query->where('ejecutivo',Auth::user()->id);
                        })
                        ->when (Auth::user()->puesto==2,function ($query)
                        {
                            $query->where('sub_area',Auth::user()->sub_area);
                        })
                        */
                        ->when($filtro && $filtro_text!='',function ($query) use ($filtro_text)
                            {
                                $query->where(function ($anidado) use ($filtro_text){
                                    $anidado->where('nombre','like','%'.$filtro_text.'%');
                                    $anidado->orWhere('descripcion','like','%'.$filtro_text.'%');
                                });               
                            })
                        ->when($filtro && $f_inicio!='',function ($query) use ($f_inicio)
                            {
                                $query->where('fecha_inicio','>=',$f_inicio);
                            })
                        ->when($filtro && $f_fin!='',function ($query) use ($f_fin)
                            {
                                $query->where('fecha_fin','<=',$f_fin);
                            })
                        ->when ($estatus>0,function ($query) use ($estatus)
                            {
                                $query->where('estatus',$estatus);
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
                    'negocio'=>$negocio,
                    'responsable'=>$responsable,
                    'prospecto'=>$prospecto,
                    'estatus'=>$estatus,

                    ]);   
        }      
        $prospectos=Prospecto::orderBy('razon_social','ASC')->get(); 
        $negocios=LineaNegocio::all();  
        $responsables=User::where('puesto','>','1')->get();  

        return(view($excel=="NO"?'proyecto.base_proyectos':'proyecto.export',[
                                    'registros'=>$registros,
                                    'query'=>$filtro_text,
                                    'f_inicio'=>$f_inicio,
                                    'f_fin'=>$f_fin,
                                    'excel'=>$excel,
                                    'negocio'=>$negocio,
                                    'negocios'=>$negocios,
                                    'responsable'=>$responsable,
                                    'responsables'=>$responsables,
                                    'prospecto'=>$prospecto,
                                    'prospectos'=>$prospectos,
                                    'estatus'=>$estatus

                                ]));
    }
}
