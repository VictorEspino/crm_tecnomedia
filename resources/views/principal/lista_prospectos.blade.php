<x-app-layout>
    <x-slot name="header">
            {{ __('Clientes') }}
    </x-slot>

    <div class="flex flex-col w-full text-gray-700 px-2 md:px-8">
        <div class="w-full rounded-t-lg bg-slate-300 p-3 flex flex-col border-b border-gray-800"> <!--ENCABEZADO-->
            <div class="w-full text-lg font-semibold">Prospectos</div>
            <div class="w-full text-sm">({{Auth::user()->user}}) - {{Auth::user()->name}}</div>            
            <div class="w-full text-sm">{{App\Models\User::with('compania_desc')->find(Auth::user()->id)->compania_desc->nombre}}</div>            
        </div> <!--FIN ENCABEZADO-->

        <form class="w-full" action="{{route('principal')}}" class="">
            <input type="hidden" name="filtro" value="ACTIVE"> 
            <div class="w-full flex flex-row space-x-2 bg-slate-400 py-3 px-3">
                    <div class="w-5/6">
                        <x-jet-label class="text-white text-sm">Buscar</x-jet-label>
                        <x-jet-input class="text-xs w-full border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm py-1" type="text" name="query" value="{{$query}}"></x-jet-input> 
                    </div>
                    <div class="w-1/6 flex justify-center">
                        <x-jet-button>Buscar</x-jet-button>
                    </div>
                </form>
            </div>
            <div class="flex justify-end text-xs pt-2">
                {{$registros->links()}}
            </div>

        
        <div class="w-full rounded-b-lg bg-white p-3 flex flex-col"> <!--CONTENIDO-->            
            <div class="flex justify-end text-xs pt-2">
            </div>
            <div class="w-full flex justify-center pt-5 flex-col"> <!--TABLA DE CONTENIDO-->
                <div class="w-full flex justify-center pb-3"><span class="font-semibold text-sm text-gray-700">Registros de Clientes</span></div>
                <div class="w-full flex justify-center">
                <table>
                    <tr class="">
                        <td class="border border-gray-300 font-semibold bg-slate-600 text-gray-200 p-1 text-sm"><center>Folio</td>
                        <td class="border border-gray-300 font-semibold bg-slate-600 text-gray-200 p-1 text-sm"><center>Razon Social</td>
                        <td class="border border-gray-300 font-semibold bg-slate-600 text-gray-200 p-1 text-sm"><center>RFC</td>
                        <td class="border border-gray-300 font-semibold bg-slate-600 text-gray-200 p-1 text-sm"><center>Inicio de Operaciones</td>
                        <td class="border border-gray-300 font-semibold bg-slate-600 text-gray-200 p-1 text-sm"><center>Estatus</td>
                        <td class="border border-gray-300 font-semibold bg-slate-600 text-gray-200 p-1 text-sm" colspan=3></td>
                        
                    </tr>
                    @php
                        $color=true;
                    @endphp
                    @foreach($registros as $registro)
                    <tr class="">
                        <td class="border border-gray-300 font-light {{$color?'':'bg-lime-100'}} text-gray-700 p-1 text-xs">{{folio($registro->id)}}</td>
                        <td class="border border-gray-300 font-light {{$color?'':'bg-lime-100'}} text-gray-700 p-1 text-xs">{{$registro->razon_social}}</td>
                        <td class="border border-gray-300 font-light {{$color?'':'bg-lime-100'}} text-gray-700 p-1 text-xs">{{$registro->rfc}}</td>
                        <td class="border border-gray-300 font-light {{$color?'':'bg-lime-100'}} text-gray-700 p-1 text-xs">{{$registro->fecha_io}}</td>
                        <td class="border border-gray-300 font-light {{$color?'':'bg-lime-100'}} text-gray-700 p-1 text-xs">
                            Activo
                        </td>
                        <td class="border border-gray-300 font-light {{$color?'':'bg-lime-100'}} text-gray-700 p-1 text-xs">
                            @livewire('principal.detalle-cliente',['id_prospecto'=>$registro->id,'key'=>$registro->id])              
                        </td>
                        <td class="border border-gray-300 font-light {{$color?'':'bg-lime-100'}} text-gray-700 p-1 text-xs">
                            @livewire('principal.lista-contactos',['id_prospecto'=>$registro->id,'key'=>1000+$registro->id])              
                        </td>
                    </tr>
                    @php
                        $color=!$color;
                    @endphp
                    @endforeach                    
                </table>
                </div>
            </div><!--FIN DE TABLA -->

        </div> <!-- FIN DEL CONTENIDO -->
    </div> <!--DIV PRINCIPAL -->
</x-app-layout>
