<x-app-layout>
    <x-slot name="header">
        {{ __('Actividades') }}
    </x-slot>
    <x-ticket-nav />
    <div class="w-full h-full bg-gray-100 flex flex-col pt-5 px-8">
        <div class="w-full text-base text-gray-600 font-semibold">
            {{Auth::user()->name}}
        </div>
        <div class="w-full flex flex-col pt-5 rounded-t-lg">
            <div class="w-full bg-gray-200 py-1 px-2 font-bold text-gray-600 rounded-t-lg">
                Solicitudes en proceso
            </div>
            <div class="w-full h-72 bg-white shadow-lg rounded-b-lg flex flex-col">
                <div class="w-full border-b flex flex-row pt-5 pb-2 font-semibold text-gray-600">
                    <div class="w-20 flex justify-center">
                        !
                    </div>
                    <div class="w-24 ml-2">
                        Folio
                    </div>
                    <div class="w-1/2 ml-3">
                        Asunto
                    </div>
                    <div class="w-1/6 flex justify-center">
                        Autor
                    </div>
                    <div class="flex-1">
                        Última respuesta
                    </div>
                </div>
                <div class="w-full overflow-y-auto flex flex-col">
                    @foreach ($asignados_a_mi as $ticket)
                    <div class="w-full flex flex-row pt-2 border-b pb-3">
                        <div class="w-20 flex justify-center px-2 items-start">
                            <div class="w-full py-1 px-3 {{$ticket->prioridad=="1"?'bg-green-400':'bg-red-400'}} text-gray-100 text-xs font-semibold flex justify-center rounded">
                                {{$ticket->prioridad=="1"?'Normal':'Alta'}}
                            </div>
                        </div>
                        <div class="w-24 text-sm text-blue-500 ml-2 pt-1">
                            <a href="{{route('ticket',['id'=>$ticket->id])}}">{{ticket($ticket->id)}}</a>
                        </div>
                        <div class="w-1/2 ml-3 flex flex-col">
                            <div class="w-full text-blue-500 text-base font-normal">
                                <a href="{{route('ticket',['id'=>$ticket->id])}}">
                                    {{$ticket->asunto}}
                                </a>
                            </div>
                            <div class="w-full text-gray-600 text-xs font-normal">
                                {{$ticket->created_at}}
                            </div>
                            <div class="w-full text-gray-600 text-xs font-normal">
                                Topico : <b>{{$ticket->topico->nombre}}</b>
                            </div>

                        </div>
                        <div class="w-1/6 text-xs font-bold">
                            {{$ticket->solicitante->name}} 
                            <span class="text-xs font-normal">({{$ticket->area_solicitante->nombre}} - {{$ticket->subarea_solicitante->nombre}})</span>
                        </div>
                        <div class="flex-1 text-xs">
                            {{$ticket->updated_at}}
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>
        <div class="w-full flex flex-row pt-3">
            <div class="w-3/4 flex flex-col">
                <div class="w-full flex flex-col pt-5 rounded-t-lg">
                    <div class="w-full bg-gray-200 py-1 px-2 font-bold text-gray-600 rounded-t-lg">
                        Creados por mi
                    </div>
                    <div class="w-full h-72 bg-white shadow-lg rounded-b-lg flex flex-col">
                        <div class="w-full border-b flex flex-row pt-5 pb-2 font-semibold text-gray-600">
                            <div class="w-20 flex justify-center">
                                !
                            </div>
                            <div class="w-24 ml-2">
                                Folio
                            </div>
                            <div class="w-1/2 ml-3">
                                Asunto
                            </div>
                            <div class="w-1/6 flex justify-center">
                                Asesor
                            </div>
                            <div class="flex-1">
                                Última respuesta
                            </div>
                        </div>
                        <div class="w-full overflow-y-auto flex flex-col">
                            @foreach ($creados_por_mi as $ticket)
                            <div class="w-full flex flex-row pt-2 border-b pb-3">
                                <div class="w-20 flex justify-center px-2 items-start">
                                    <div class="w-full py-1 px-3 {{$ticket->prioridad=="1"?'bg-green-400':'bg-red-400'}} text-gray-100 text-xs font-semibold flex justify-center rounded">
                                        {{$ticket->prioridad=="1"?'Normal':'Alta'}}
                                    </div>
                                </div>
                                <div class="w-24 text-sm text-blue-500 ml-2 pt-1">
                                    <a href="{{route('ticket',['id'=>$ticket->id])}}">{{ticket($ticket->id)}}</a>
                                </div>
                                <div class="w-1/2 ml-3 flex flex-col">
                                    <div class="w-full text-blue-500 text-base font-normal">
                                        <a href="{{route('ticket',['id'=>$ticket->id])}}">
                                            {{$ticket->asunto}}
                                        </a>
                                    </div>
                                    <div class="w-full text-gray-600 text-xs font-normal">
                                        {{$ticket->created_at}}
                                    </div>
                                    <div class="w-full text-gray-600 text-xs font-normal">
                                        Topico : <b>{{$ticket->topico->nombre}}</b>
                                    </div>
        
                                </div>
                                <div class="w-1/6 flex justify-center text-xs font-bold">
                                    {{$ticket->asesor->name}}
                                </div>
                                <div class="flex-1 text-xs">
                                    {{$ticket->updated_at}}
                                </div>
                            </div>
                            @endforeach
                        </div>
                    </div>
                    
                </div>

                <div class="w-full flex flex-col pt-8 rounded-t-lg">
                    <div class="w-full bg-gray-200 py-1 px-2 font-bold text-gray-600 rounded-t-lg flex flex-row space-x-3">
                        <div class="w-7/12 flex items-center">
                            Actividades en mis grupos de atencion o como invitado
                        </div>
                        <div class="w-5/12 text-xs flex items-center text-center">
                            <select class="w-full text-xs border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm" onChange="filtrar(this.value)">
                                <option value='0'>Todos los topicos</option>
                                @foreach ($topicos_participante as $topico_filtro)
                                    <option value='{{$topico_filtro['topico_id']}}' {{$busqueda==$topico_filtro['topico_id']?'selected':''}}>{{$topico_filtro['nombre']}}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div style="height: 32rem;" class="w-full bg-white shadow-lg rounded-b-lg flex flex-col">
                        <div class="w-full border-b flex flex-row pt-5 pb-2 font-semibold text-gray-600">
                            <div class="w-20 flex justify-center">
                                !
                            </div>
                            <div class="w-24 ml-2">
                                Folio
                            </div>
                            <div class="w-1/3 ml-3">
                                Asunto
                            </div>
                            <div class="w-1/6 flex justify-center">
                                Solicitante
                            </div>
                            <div class="w-1/6 flex justify-center">
                                Asesor
                            </div>
                            <div class="flex-1">
                                Última respuesta
                            </div>
                        </div>
                        <div class="w-full overflow-y-auto flex flex-col">
                            @foreach ($participante as $ticket)
                            @if(($filtro && $busqueda==$ticket->topico_id) || !$filtro)
                            <div class="w-full flex flex-row pt-2 border-b pb-3">
                                <div class="w-20 flex justify-center px-2 items-start">
                                    <div class="w-full py-1 px-3 {{$ticket->prioridad=="1"?'bg-green-400':'bg-red-400'}} text-gray-100 text-xs font-semibold flex justify-center rounded">
                                        {{$ticket->prioridad=="1"?'Normal':'Alta'}}
                                    </div>
                                </div>
                                <div class="w-24 text-sm text-blue-500 ml-2 pt-1">
                                    <a href="{{route('ticket',['id'=>$ticket->id])}}">{{ticket($ticket->id)}}</a>
                                </div>
                                <div class="w-1/3 ml-3 flex flex-col">
                                    <div class="w-full text-blue-500 text-base font-normal">
                                        <a href="{{route('ticket',['id'=>$ticket->id])}}">
                                            {{$ticket->asunto}}
                                        </a>
                                    </div>
                                    <div class="w-full text-gray-600 text-xs font-normal">
                                        {{$ticket->created_at}}
                                    </div>
                                    <div class="w-full text-gray-600 text-xs font-normal">
                                        Topico : <b>{{$ticket->topico->nombre}}</b>
                                    </div>
        
                                </div>
                                <div class="w-1/6 text-xs font-bold">
                                    {{$ticket->solicitante->name}}
                                    <span class="text-xs font-normal">({{$ticket->area_solicitante->nombre}} - {{$ticket->subarea_solicitante->nombre}})</span>
                                </div>
                                <div class="w-1/6 flex justify-center text-xs font-bold">
                                    {{$ticket->asesor->name}}
                                </div>
                                <div class="flex-1 text-xs">
                                    {{$ticket->updated_at}}
                                </div>
                            </div>
                            @endif
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
            <div class="flex-1 pt-5 flex flex-col space-y-5">
                <div class="w-full">
                    @livewire('ticket.buscar-ticket')
                </div>
                <div class="w-full">
                    @livewire('ticket.cerrados-recientemente')
                </div>
            </div>
        </div>
    </div>
<script>
    function filtrar(valor)
    {
        if(valor!=0)
        {
            window.location.href = "/tickets?f=1&tid="+valor;
        }
        else
        {
            window.location.href = "/tickets";
        }
    }
</script>
</x-app-layout>