<?php

function getSQLUniverso($user_id)
{
    $usuario=App\Models\User::find($user_id);
    $subarea=$usuario->sub_area;
    $puesto=$usuario->puesto;

    if($subarea == 10 || $puesto==114)
    {
        $subarea=100000;
    }

    $sql="
    select distinct ticket_id from (
        SELECT id as ticket_id FROM `tickets` WHERE de_id=".$user_id." or asignado_a=".$user_id." or subarea_id=".$subarea." 
        UNION 
        select distinct ticket_id from actividad_tickets where grupo_id in (SELECT grupo_id FROM `miembro_grupos` WHERE user_id=".$user_id.") 
        UNION 
        select distinct ticket_id from invitado_tickets where user_id=".$user_id." 
    ) as a
    ";
    return($sql);
}
function getSQLParticipante($user_id)
{
    $sql="select distinct ticket_id from (select distinct ticket_id from actividad_tickets where grupo_id in (SELECT grupo_id FROM `miembro_grupos` WHERE user_id=".$user_id.") UNION select distinct ticket_id from invitado_tickets where user_id=".$user_id.") as a";
    return($sql);
}
function getSQLGruposComunicacion($user_id)
{
    $sql="select distinct grupo_id from miembro_grupo_comunicacions where user_id='".$user_id."'";
    return($sql);
}

function esManagerDeGrupo()
{
    $cuantos=App\Models\MiembroGrupo::select(Illuminate\Support\Facades\DB::raw('count(*) as n'))
                                    ->where('user_id',Illuminate\Support\Facades\Auth::user()->id)
                                    ->where('manager',1)
                                    ->get()->first();
    if($cuantos->n>0) return(true);
    return(false);
}
function actividadesAtrasadas()
{
    $grupos_manager=App\Models\MiembroGrupo::select('grupo_id')
                                    ->where('user_id',Illuminate\Support\Facades\Auth::user()->id)
                                    ->where('manager',1)
                                    ->get();
    $grupos_manager=$grupos_manager->pluck('grupo_id');
    $registros_escalacion=App\Models\TiempoTranscurrido::select(Illuminate\Support\Facades\DB::raw('count(*) as n'))
                                                ->whereIn('grupo_id',$grupos_manager)
                                                ->whereRaw('tiempo_transcurrido>sla')
                                                ->get();
    return($registros_escalacion->first()->n);
}

function nuevoTicketSistema($topico_id,$asunto,$descripcion)
{
    //return $request->all();
    $actividades_topico=App\Models\ActividadTopico::where('topico_id',$topico_id)
                                        ->get();
    $n_actividades=0;
    $n_minutos=0;
    $tipo_asignacion_requerido=0;
    $grupo_a_asignar=0;
    $asignacion_automatica=0;
    //$asignacion_seleccionada_usuario=$request->atencion_por;
    $asignacion_seleccionada_usuario=0;
    $asignacion=0;
    foreach($actividades_topico as $actividad_estructura)
    {
        $n_actividades=$n_actividades+1;
        $n_minutos=$n_minutos+intval($actividad_estructura->sla);
        if($actividad_estructura->secuencia=='0')
        {
            $tipo_asignacion_requerido=$actividad_estructura->tipo_asignacion;
            $grupo_a_asignar=$actividad_estructura->grupo_id;
            $asignacion_automatica=$actividad_estructura->user_id_automatico;
        }
    }
    $asignacion=nuevoTicketSistemaAsignacion($tipo_asignacion_requerido,$grupo_a_asignar,$asignacion_automatica,$asignacion_seleccionada_usuario);

    $ticket=App\Models\Ticket::create([
                    'creador_id'=>Auth::user()->id,
                    'de_id'=>Auth::user()->id,
                    'area_id'=>Auth::user()->area,
                    'subarea_id'=>Auth::user()->sub_area,
                    'topico_id'=>$topico_id,
                    'asunto'=>$asunto,
                    'prioridad'=>1,
                    'asignado_a'=>$asignacion,
                    'actividad_actual'=>0,
                    'a_a0'=>$asignacion,
                    'n_actividades'=>$n_actividades,
                    'n_minutos'=>$n_minutos,
                    'emite_autorizacion'=>1,
                    ]);
    
    $actividad_principal=0;
    foreach($actividades_topico as $actividad_estructura)
    {
        $actividad_ticket=App\Models\ActividadTicket::create([
                                'ticket_id'=>$ticket->id,
                                'secuencia'=>$actividad_estructura->secuencia,
                                'nombre'=>$actividad_estructura->secuencia=='0'?$asunto:$actividad_estructura->nombre,
                                'descripcion'=>$actividad_estructura->secuencia=='0'?$descripcion:$actividad_estructura->descripcion,
                                'sla'=>$actividad_estructura->sla,
                                'grupo_id'=>$actividad_estructura->grupo_id,
                                'tipo_asignacion'=>$actividad_estructura->tipo_asignacion,
                                'user_id_automatico'=>$actividad_estructura->user_id_automatico,
                            ]);

        if($actividad_estructura->secuencia=='0')
        {
            $actividad_principal=$actividad_ticket->id;
        }

        $invitados_estructura=App\Models\Invitado::where('actividad_id',$actividad_estructura->id)
                                        ->get();
        foreach($invitados_estructura as $invitado_actividad)
        {
            $invitado_al_ticket=App\Models\User::find($invitado_actividad->user_id);
            App\Models\InvitadoTicket::create([
                'user_id'=>$invitado_actividad->user_id,
                'actividad_id'=>$actividad_ticket->id,
                'ticket_id'=>$ticket->id,
                'area_id'=>$invitado_al_ticket->area,
                'subarea_id'=>$invitado_al_ticket->sub_area,
            ]);
        }
    }

    return ($ticket->id);
}
function nuevoTicketSistemaAsignacion($tipo,$grupo_id,$automatico,$seleccionada)
{
    if($tipo=='1') return(0); //MANUAL
    if($tipo=='2') return($automatico); //AUTOMATICA
    if($tipo=='3') //ALEATORIO
    {            
        $sql_miembros="
        select user_id,manager,COALESCE(atendiendo, 0) as atendiendo from(
        (SELECT * FROM `miembro_grupos` as a where a.grupo_id=".$grupo_id.") as a
        left join 
        (select asignado_a,count(*) as atendiendo from tickets where estatus=1 group by asignado_a ) as b 
        ON a.user_id=b.asignado_a)
        where manager=0
        order by atendiendo asc
        ";
        $miembros=DB::select(DB::raw($sql_miembros));
        $miembros=collect($miembros);
        $usuarios=$miembros->pluck('user_id');            
        return($usuarios[rand(0,count($usuarios)-1)]);
    }
    if($tipo=='4') //MENOS OCUPADO
    { 
        $sql_miembros="
        select user_id,manager,COALESCE(atendiendo, 0) as atendiendo from(
        (SELECT * FROM `miembro_grupos` as a where a.grupo_id=".$grupo_id.") as a
        left join 
        (select asignado_a,count(*) as atendiendo from tickets where estatus=1 group by asignado_a ) as b 
        ON a.user_id=b.asignado_a)
        where manager=0
        order by atendiendo asc
        ";
        $miembros=DB::select(DB::raw($sql_miembros));
        $miembros=collect($miembros);
        return($miembros->first()->user_id);
    }
    if($tipo=='5')  //MANAGER
    {
        $sql_miembros="
        select user_id,manager,COALESCE(atendiendo, 0) as atendiendo from(
        (SELECT * FROM `miembro_grupos` as a where a.grupo_id=".$grupo_id.") as a
        left join 
        (select asignado_a,count(*) as atendiendo from tickets where estatus=1 group by asignado_a ) as b 
        ON a.user_id=b.asignado_a)
        where manager=1
        order by atendiendo asc
        ";
        $miembros=DB::select(DB::raw($sql_miembros));
        $miembros=collect($miembros);
        return($miembros->first()->user_id);
    }
    if($tipo=='6')  //SELECCIONADO POR USUARIO
    {
        return($seleccionada);
    }
}