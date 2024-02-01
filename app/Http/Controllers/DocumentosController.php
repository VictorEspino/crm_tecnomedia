<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\ClienteDocumento;
use App\Models\ProyectoDocumento;
use Illuminate\Support\Facades\Auth;

class DocumentosController extends Controller
{
    public function nuevo_doc_cliente(Request $request)
    {
        $upload_path = ruta_archivos();
        try{
            $file_name = $request->archivo->getClientOriginalName();
            $generated_new_name = $request->tipo.'_'.time().'.'.$request->archivo->getClientOriginalExtension();
            $request->archivo->move($upload_path, $generated_new_name);
        }
        catch(\Exception $e)
        {
            $generated_new_name="";
        }
        $archivo=$generated_new_name;
        
        ClienteDocumento::create([
                        'id_cliente'=>$request->id_prospecto,
                        'tipo'=>$request->tipo,
                        'vigencia'=>$request->vigencia,
                        'id_user'=>Auth::user()->id,
                        'documento'=>$archivo
                                ]);

        return back();
    }

    public function nuevo_doc_proyecto(Request $request)
    {
        $upload_path = ruta_archivos();
        try{
            $file_name = $request->archivo->getClientOriginalName();
            $generated_new_name = $request->tipo.'_'.time().'.'.$request->archivo->getClientOriginalExtension();
            $request->archivo->move($upload_path, $generated_new_name);
        }
        catch(\Exception $e)
        {
            $generated_new_name="";
        }
        $archivo=$generated_new_name;
        
        ProyectoDocumento::create([
                        'id_proyecto'=>$request->id_proyecto,
                        'tipo'=>$request->tipo,
                        'vigencia'=>$request->vigencia,
                        'id_user'=>Auth::user()->id,
                        'documento'=>$archivo
                                ]);

        return back();
    }
}
