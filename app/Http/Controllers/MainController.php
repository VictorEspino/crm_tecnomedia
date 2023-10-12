<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Prospecto;

class MainController extends Controller
{
    public function base_principal(Request $request)
    {
        //return($request->all());
        $filtro_text='';
        $filtro=false;

        $prospecto=0;
        $linea=0;
        $servicio=0;
        $compañia=0;


        if(isset($_GET['filtro']))
        {
            $filtro=true;
            $filtro_text=$_GET["query"];
        }

        $registros=Prospecto::orderBy('razon_social','asc')
                        ->when($filtro && $filtro_text!='',function ($query) use ($filtro_text)
                            {
                                $query->where(function ($anidado) use ($filtro_text){
                                    $anidado->where('rfc','like','%'.$filtro_text.'%');
                                    $anidado->orWhere('razon_social','like','%'.$filtro_text.'%');
                                    $anidado->orWhere('regimen','like','%'.$filtro_text.'%');
                                    $anidado->orWhere('calle','like','%'.$filtro_text.'%');
                                });               
                            })
                        ->paginate(10);                
        if($filtro)
        {
            $registros->appends([
                    'filtro'=>'ACTIVE',
                    'query' => $filtro_text,
                    ]);   
        }      

        return(view('principal.lista_prospectos',[
                                    'registros'=>$registros,
                                    'query'=>$filtro_text,
                    ]));
    }
}
