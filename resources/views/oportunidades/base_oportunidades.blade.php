<x-app-layout>
    <x-slot name="header">
            {{ __('Base de Oportunidades') }}
    </x-slot>

    <div class="flex flex-col w-full text-gray-700 px-2 md:px-8">
        <div class="w-full rounded-t-lg bg-slate-300 p-3 flex flex-col border-b border-gray-800"> <!--ENCABEZADO-->
            <div class="w-full text-lg font-semibold">Base oportunidades</div>
            <div class="w-full text-sm">({{Auth::user()->usuario}}) - {{Auth::user()->name}}</div>            
            <div class="w-full text-sm">{{App\Models\User::with('compania_desc')->find(Auth::user()->id)->compania_desc->nombre}}</div>            
        </div> <!--FIN ENCABEZADO-->
        
        <div class="w-full rounded-b-lg bg-white p-3 flex flex-col"> <!--CONTENIDO-->
            <form class="w-full" action="{{route('base_oportunidades')}}" class="">
            <input type="hidden" name="filtro" value="ACTIVE"> 
            <div class="w-full flex flex-row space-x-2 bg-slate-400 py-3 px-3">
                    <div class="w-1/6">
                        <x-jet-label class="text-white text-sm">Buscar</x-jet-label>
                        <x-jet-input class="text-xs w-full border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm py-1" type="text" name="query" value="{{$query}}"></x-jet-input> 
                    </div>
                    <div class="w-1/6">
                        <x-jet-label class="text-white text-sm">Compañia</x-jet-label>
                        <select class="text-xs w-full border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm py-1" name="compañia">
                            <option value="" class=""></option>
                            @foreach($compañias as $comp)
                            <option value="{{$comp->id}}" class="" {{$compañia==$comp->id?'selected':''}}>{{$comp->nombre}}</option>
                            @endforeach
                        </select>  
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
                        <select class="text-xs w-full border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm py-1" name="linea">
                            <option value="" class=""></option>
                            @foreach($lineas as $lin)
                            <option value="{{$lin->id}}" class="" {{$linea==$lin->id?'selected':''}}>{{$lin->nombre}}</option>
                            @endforeach
                        </select>  
                    </div>
                    <div class="w-1/6">
                        <x-jet-label class="text-white text-sm">Servicio</x-jet-label>
                        <select class="text-xs w-full border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm py-1" name="servicio">
                            <option value="" class=""></option>
                            @foreach($servicios as $serv)
                            <option value="{{$serv->id}}" class="" {{$servicio==$serv->id?'selected':''}}>{{$serv->nombre}}</option>
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
                        <td class="border border-gray-300 font-semibold bg-slate-600 text-gray-200 p-1 text-sm"><center>Compañia</td>
                        <td class="border border-gray-300 font-semibold bg-slate-600 text-gray-200 p-1 text-sm"><center>Vendedor</td>
                        <td class="border border-gray-300 font-semibold bg-slate-600 text-gray-200 p-1 text-sm"><center>Linea de Negocio</td>
                        <td class="border border-gray-300 font-semibold bg-slate-600 text-gray-200 p-1 text-sm"><center>Servicio</td>
                        <td class="border border-gray-300 font-semibold bg-slate-600 text-gray-200 p-1 text-sm"><center>Oportunidad</td>
                        <td class="border border-gray-300 font-semibold bg-slate-600 text-gray-200 p-1 text-sm"><center>Prospecto</td>
                        <td class="border border-gray-300 font-semibold bg-slate-600 text-gray-200 p-1 text-sm"><center>Partner/Fabricante</td>
                        <td class="border border-gray-300 font-semibold bg-slate-600 text-gray-200 p-1 text-sm"><center>Producto</td>
                        <td class="border border-gray-300 font-semibold bg-slate-600 text-gray-200 p-1 text-sm"><center>Etapa</td>
                        <td class="border border-gray-300 font-semibold bg-slate-600 text-gray-200 p-1 text-sm"><center>Contacto</td>
                        <td class="border border-gray-300 font-semibold bg-slate-600 text-gray-200 p-1 text-sm"><center>Fecha</td>
                        <td class="border border-gray-300 font-semibold bg-slate-600 text-gray-200 p-1 text-sm" colspan=3></td>
                        
                    </tr>
                <?php
                    $color=false;
                    foreach($registros as $oportunidad)
                    {
                ?>
                    <tr class="">
                        <td class="border border-gray-300 font-light {{$color?'bg-lime-100':''}} text-gray-700 p-1 text-xs">{{$oportunidad->compania->nombre}}</td>
                        <td class="border border-gray-300 font-light {{$color?'bg-lime-100':''}} text-gray-700 p-1 text-xs">{{$oportunidad->user->name}}</td>
                        <td class="border border-gray-300 font-light {{$color?'bg-lime-100':''}} text-gray-700 p-1 text-xs">{{$oportunidad->linea_negocio->nombre}}</td>
                        <td class="border border-gray-300 font-light {{$color?'bg-lime-100':''}} text-gray-700 p-1 text-xs">{{$oportunidad->servicio->nombre}}</td>
                        <td class="border border-gray-300 font-light {{$color?'bg-lime-100':''}} text-gray-700 p-1 text-xs">{{$oportunidad->oportunidad}}</td>
                        <td class="border border-gray-300 font-light {{$color?'bg-lime-100':''}} text-gray-700 p-1 text-xs font-bold">{{$oportunidad->prospecto->razon_social}}</td>
                        <td class="border border-gray-300 font-light {{$color?'bg-lime-100':''}} text-gray-700 p-1 text-xs">{{$oportunidad->partner}}</td>
                        <td class="border border-gray-300 font-light {{$color?'bg-lime-100':''}} text-gray-700 p-1 text-xs">{{$oportunidad->producto}}</td>
                        <td class="border border-gray-300 font-light {{$color?'bg-lime-100':''}} text-gray-700 p-1 text-xs">{{$oportunidad->etapa->nombre}}</td>
                        <td class="border border-gray-300 font-light {{$color?'bg-lime-100':''}} text-gray-700 p-1 text-xs">{{$oportunidad->contacto->nombre}}</td>
                        <td nowrap class="border border-gray-300 font-light {{$color?'bg-lime-100':''}} text-gray-700 p-1 text-xs">{{$oportunidad->created_at}}</td>
                        <td class="border border-gray-300 font-light {{$color?'bg-lime-100':''}} text-gray-700 p-1 text-xs">
                        @livewire('oportunidad.update-oportunidad',['oportunidad_id'=>$oportunidad->id,key($oportunidad->id)])
                        </td>
                        <td class="border border-gray-300 font-light {{$color?'bg-lime-100':''}} text-gray-700 p-1 text-xs">
                        @livewire('oportunidad.avanzar-etapa-oportunidad',['oportunidad_id'=>$oportunidad->id,key($oportunidad->id)])
                        </td>
                        <td class="border border-gray-300 font-light {{$color?'bg-lime-100':''}} text-gray-700 p-1 text-xs">
                            @if($oportunidad->etapa_id=="4") 
                            <a href="{{route('cotizaciones',['id_oportunidad'=>$oportunidad->id])}}">
                                <i class="fas fa-dollar-sign text-xl text-red-400"></i>
                            </a>
                            @endif
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
