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

        <form class="w-full" action="" class="">
            <input type="hidden" name="filtro" value="ACTIVE"> 
            <div class="w-full flex flex-row space-x-2 bg-slate-400 py-3 px-3">
                    <div class="w-5/6">
                        <x-jet-label class="text-white text-sm">Buscar</x-jet-label>
                        <x-jet-input class="text-xs w-full border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm py-1" type="text" name="query" value=""></x-jet-input> 
                    </div>
                    <div class="w-1/6 flex justify-center">
                        <x-jet-button>Buscar</x-jet-button>
                    </div>
                </form>
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
                    <tr class="">
                        <td class="border border-gray-300 font-light bg-lime-100 text-gray-700 p-1 text-xs">#00000000001</td>
                        <td class="border border-gray-300 font-light bg-lime-100 text-gray-700 p-1 text-xs">AT&T</td>
                        <td class="border border-gray-300 font-light bg-lime-100 text-gray-700 p-1 text-xs">XXX998877AA1</td>
                        <td class="border border-gray-300 font-light bg-lime-100 text-gray-700 p-1 text-xs">2014-11-07</td>
                        <td class="border border-gray-300 font-light bg-lime-100 text-gray-700 p-1 text-xs">
                            Activo
                        </td>
                        <td class="border border-gray-300 font-light bg-lime-100 text-gray-700 p-1 text-xs">
                            @livewire('servicios.detalle-cliente')              
                        </td>
                    </tr>
                    <tr class="">
                        <td class="border border-gray-300 font-light text-gray-700 p-1 text-xs">#00000000002</td>
                        <td class="border border-gray-300 font-light text-gray-700 p-1 text-xs">AXTEL</td>
                        <td class="border border-gray-300 font-light text-gray-700 p-1 text-xs">YYY998877AA1</td>
                        <td class="border border-gray-300 font-light text-gray-700 p-1 text-xs">2001-02-16</td>
                        <td class="border border-gray-300 font-light text-gray-700 p-1 text-xs">
                            Activo
                        </td>
                        <td class="border border-gray-300 font-light text-gray-700 p-1 text-xs">
                            @livewire('servicios.detalle-cliente')              
                        </td>
                    </tr>
                    <tr class="">
                        <td class="border border-gray-300 font-light bg-lime-100 text-gray-700 p-1 text-xs">#00000000003</td>
                        <td class="border border-gray-300 font-light bg-lime-100 text-gray-700 p-1 text-xs">CORPORATIVO MEXICANO DE MERCADO DE VALORES</td>
                        <td class="border border-gray-300 font-light bg-lime-100 text-gray-700 p-1 text-xs">ABC998877AA1</td>
                        <td class="border border-gray-300 font-light bg-lime-100 text-gray-700 p-1 text-xs">1996-01-09</td>
                        <td class="border border-gray-300 font-light bg-lime-100 text-gray-700 p-1 text-xs">
                            Activo
                        </td>
                        <td class="border border-gray-300 font-light bg-lime-100 text-gray-700 p-1 text-xs">
                            @livewire('servicios.detalle-cliente')              
                        </td>
                    </tr>
                    <tr class="">
                        <td class="border border-gray-300 font-light text-gray-700 p-1 text-xs">#00000000004</td>
                        <td class="border border-gray-300 font-light text-gray-700 p-1 text-xs">ESTAFETA</td>
                        <td class="border border-gray-300 font-light text-gray-700 p-1 text-xs">RLM998877AA1</td>
                        <td class="border border-gray-300 font-light text-gray-700 p-1 text-xs">1992-02-16</td>
                        <td class="border border-gray-300 font-light text-gray-700 p-1 text-xs">
                            Activo
                        </td>
                        <td class="border border-gray-300 font-light text-gray-700 p-1 text-xs">
                            @livewire('servicios.detalle-cliente')              
                        </td>
                    </tr>
                </table>
                </div>
            </div><!--FIN DE TABLA -->

        </div> <!-- FIN DEL CONTENIDO -->
    </div> <!--DIV PRINCIPAL -->
</x-app-layout>
