<x-app-layout>
    <x-slot name="header">
            {{ __('Base de Proyectos') }}
    </x-slot>

    <div class="flex flex-col w-full text-gray-700 px-2 md:px-8">
        <div class="w-full rounded-t-lg bg-slate-300 p-3 flex flex-col border-b border-gray-800"> <!--ENCABEZADO-->
            <div class="w-full text-lg font-semibold">Base proyectos</div>
            <div class="w-full text-sm">({{Auth::user()->user}}) - {{Auth::user()->name}}</div>            
            <div class="w-full text-sm">{{App\Models\User::with('compania_desc')->find(Auth::user()->id)->compania_desc->nombre}}</div>            
        </div> <!--FIN ENCABEZADO-->
        
        <div class="w-full rounded-b-lg bg-white p-3 flex flex-col"> <!--CONTENIDO-->
            <form class="w-full" action="{{route('base_proyectos')}}" class="">
            <input type="hidden" name="filtro" value="ACTIVE"> 
            <div class="w-full flex flex-row space-x-2 bg-slate-400 py-3 px-3">
                    <div class="w-1/6">
                        <x-jet-label class="text-white text-sm">Buscar</x-jet-label>
                        <x-jet-input class="text-xs w-full border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm py-1" type="text" name="query" value="{{$query}}"></x-jet-input> 
                    </div>
                    <div class="w-1/6">
                        <x-jet-label class="text-white text-sm">Buscar prospecto</x-jet-label>
                        <select class="text-xs w-full border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm py-1" name="prospecto">
                            <option value="" class=""></option>
                            @foreach($prospectos as $pros)
                            <option value="{{$pros->id}}" class="" {{$prospecto==$pros->id?'selected':''}}>{{$pros->razon_social}}</option>
                            @endforeach
                        </select>  
                    </div>
                    <div class="w-1/6">
                        <x-jet-label class="text-white text-sm">Linea de negocio</x-jet-label>
                        <select class="text-xs w-full border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm py-1" name="negocio">
                            <option value="" class=""></option>
                            @foreach($negocios as $lin)
                            <option value="{{$lin->id}}" class="" {{$negocio==$lin->id?'selected':''}}>{{$lin->nombre}}</option>
                            @endforeach
                        </select>  
                    </div>
                    <div class="w-1/6">
                        <x-jet-label class="text-white text-sm">Responsable</x-jet-label>
                        <select class="text-xs w-full border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm py-1" name="responsable">
                            <option value="" class=""></option>
                            @foreach($responsables as $serv)
                            <option value="{{$serv->id}}" class="" {{$responsable==$serv->id?'selected':''}}>{{$serv->name}}</option>
                            @endforeach
                        </select>  
                    </div>

                    <div class="w-1/6">
                        <x-jet-label class="text-white text-sm">Desde:</x-jet-label>
                        <x-jet-input class="text-xs w-full border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm py-1" type="date" name="f_inicio" value="{{$f_inicio}}"></x-jet-input>
                    </div>
                    <div class="w-1/6">
                        <x-jet-label class="text-white text-sm">Hasta:</x-jet-label>
                        <x-jet-input class="text-xs w-full border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm py-1" type="date" name="f_fin" value="{{$f_fin}}"></x-jet-input>
                    </div>
                    <div class="w-1/12">
                        <x-jet-label class="text-white text-sm">Estatus</x-jet-label>
                        <select class="text-xs w-full border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm py-1" name="estatus">
                            <option value="0" class=""></option>
                            <option value="1" class="" {{$estatus=='1'?'selected':''}}>Activo</option>
                            <option value="2" class="" {{$estatus=='2'?'selected':''}}>Inactivo</option>
                            <option value="3" class="" {{$estatus=='3'?'selected':''}}>Borrador</option>
                        </select>  
                    </div>
                    @if(Auth::user()->puesto=="Administrador Sistema")
                    <div class="w-1/12">
                        <x-jet-label class="text-white text-sm">Excel</x-jet-label>
                        <select class="text-xs w-full border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm py-1" name="excel">
                            <option value="" class=""></option>
                            <option value="NO" class="" {{$excel=='NO'?'selected':''}}>NO</option>
                            <option value="SI" class="" {{$excel=='SI'?'selected':''}}>SI</option>
                        </select>  
                    </div>
                    @else
                        <input type="hidden" name="excel" value="NO">
                    @endif
                    <div class="w-1/6 flex justify-center">
                        <x-jet-button>Buscar</x-jet-button>
                    </div>
                </form>
            </div>
            </form>
            <div class="flex justify-end text-xs pt-2">
                {{$registros->links()}}
            </div>
            <div class="w-full flex justify-center pt-5 flex-col"> <!--TABLA DE CONTENIDO-->
                <div class="w-full flex justify-center pb-3"><span class="font-semibold text-sm text-gray-700">Registros de Ventas</span></div>
                <div class="w-full flex justify-center">
                <table>
                    <tr class="">
                        <td class="border border-gray-300 font-semibold bg-slate-600 text-gray-200 p-1 text-sm" colspan=3></td>
                        <td class="border border-gray-300 font-semibold bg-slate-600 text-gray-200 p-1 text-sm"><center>Clave Proyecto</td>
                        <td class="border border-gray-300 font-semibold bg-slate-600 text-gray-200 p-1 text-sm"><center>Prospecto</td>
                        <td class="border border-gray-300 font-semibold bg-slate-600 text-gray-200 p-1 text-sm"><center>Nombre</td>
                        <td class="border border-gray-300 font-semibold bg-slate-600 text-gray-200 p-1 text-sm"><center>Tipo</td>
                        <td class="border border-gray-300 font-semibold bg-slate-600 text-gray-200 p-1 text-sm"><center>Linea de Negocio</td>
                        <td class="border border-gray-300 font-semibold bg-slate-600 text-gray-200 p-1 text-sm"><center>Responsable</td>
                        <td class="border border-gray-300 font-semibold bg-slate-600 text-gray-200 p-1 text-sm"><center>Fecha Inicio</td>
                        <td class="border border-gray-300 font-semibold bg-slate-600 text-gray-200 p-1 text-sm"><center>Fecha Fin</td>
                        <td class="border border-gray-300 font-semibold bg-slate-600 text-gray-200 p-1 text-sm"><center>Estatus</td>                       
                        <td class="border border-gray-300 font-semibold bg-slate-600 text-gray-200 p-1 text-sm" colspan=2></td>
                        
                        
                    </tr>
                <?php
                    $color=false;
                    foreach($registros as $reg)
                    {
                ?>
                    <tr class="">
                        <td class="border border-gray-300 font-light {{$color?'bg-lime-100':''}} text-gray-700 p-1 text-xs">
                            @livewire('proyecto.editar-proyecto',['id_proyecto'=>$reg->id,'prospecto'=>$reg->prospecto->razon_social,'nombre'=>$reg->nombre,'key'=>$reg->id])
                        </td>
                        <td class="border border-gray-300 font-light {{$color?'bg-lime-100':''}} text-gray-700 p-1 text-xs">
                            @livewire('documentos.documentos-proyecto',['id_proyecto'=>$reg->id,'prospecto'=>$reg->prospecto->razon_social,'nombre'=>$reg->nombre,'key'=>5600+$reg->id])
                        </td>
                        <td class="border border-gray-300 font-light {{$color?'bg-lime-100':''}} text-gray-700 p-1 text-xs">
                            <a href="{{route('finanzas_registros',['id_proyecto'=>$reg->id])}}">
                                <i class="text-blue-400 fas fa-money-check-alt" style="cursor: pointer;"></i>
                            </a>
                        </td>
                        <td class="border border-gray-300 font-light {{$color?'bg-lime-100':''}} text-gray-700 p-1 text-xs">{{pad_0($reg->id,3)}}/{{pad_0($reg->id_negocio,3)}}/0001</td>
                        <td class="border border-gray-300 font-light {{$color?'bg-lime-100':''}} text-gray-700 p-1 text-xs font-bold">{{$reg->prospecto->razon_social}}</td>
                        <td class="border border-gray-300 font-light {{$color?'bg-lime-100':''}} text-gray-700 p-1 text-xs">{{$reg->nombre}}</td>
                        <td class="border border-gray-300 font-light {{$color?'bg-lime-100':''}} text-gray-700 p-1 text-xs">{{$reg->tipo->nombre}}</td>
                        <td class="border border-gray-300 font-light {{$color?'bg-lime-100':''}} text-gray-700 p-1 text-xs">{{$reg->negocio->nombre}}</td>
                        <td class="border border-gray-300 font-light {{$color?'bg-lime-100':''}} text-gray-700 p-1 text-xs">{{$reg->responsable->name}}</td>
                        <td class="border border-gray-300 font-light {{$color?'bg-lime-100':''}} text-gray-700 p-1 text-xs">{{$reg->fecha_inicio}}</td>
                        @php
                        $fechaActual = date('Y-m-d'); 
                        $datetime2 = date_create($reg->fecha_fin);
                        $datetime1 = date_create($fechaActual);
                        $contador = date_diff($datetime1, $datetime2);
                        $differenceFormat = '%r%a';
                        $disponibles=$contador->format($differenceFormat);
                        @endphp
                        <td class="border border-gray-300 font-light {{$color?'bg-lime-100':''}} text-gray-700 p-1 text-xs">{{$reg->fecha_fin}}<br><span class="font-bold {{$disponibles>=0?'text-green-500':'text-red-500'}}">{{$disponibles>=0?$disponibles:-1*$disponibles}} dias {{$disponibles>=0?'vigentes':'atrasados'}}</span></td>
                        <td class="border border-gray-300 font-light {{$color?'bg-lime-100':''}} text-gray-700 p-1 text-xs"><center>{{$reg->estatus==1?'Activo':($reg->estatus==2?'Inactivo':'Borrador')}}</td>
                        <td class="border border-gray-300 font-light {{$color?'bg-lime-100':''}} text-gray-700 p-1 text-xs">
                            @livewire('proyecto.bitacora-proyecto',['id_proyecto'=>$reg->id,'prospecto'=>$reg->prospecto->razon_social,'nombre'=>$reg->nombre,'presupuesto'=>$reg->presupuesto,'key'=>1000+$reg->id])              
                        </td>
                    </tr>
                <?php
                    $color=!$color;
                    }
                ?>
                </table>
                </div>
            </div><!--FIN DE TABLA -->

        </div> <!-- FIN DEL CONTENIDO -->
    </div> <!--DIV PRINCIPAL -->
</x-app-layout>
