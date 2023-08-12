<x-app-layout>
    <x-slot name="header">
            {{ __('Cotizaciones') }}
    </x-slot>

    <div class="flex flex-col w-full text-gray-700 px-2 md:px-8">
        <div class="w-full rounded-t-lg bg-slate-300 p-3 flex flex-col border-b border-gray-800"> <!--ENCABEZADO-->
            <div class="w-full text-lg font-semibold">Cotizaciones</div>
            <div class="w-full text-sm">({{Auth::user()->usuario}}) - {{Auth::user()->name}}</div>            
            <div class="w-full text-sm">{{App\Models\User::with('compania_desc')->find(Auth::user()->id)->compania_desc->nombre}}</div>            
        </div> <!--FIN ENCABEZADO-->
        
        <div class="w-full rounded-b-lg bg-white p-3 flex flex-col"> <!--CONTENIDO-->
            <div class="flex justify-end text-xs pt-2">
                
            </div>
            <div class="w-full flex justify-center pt-5 flex-col"> <!--TABLA DE CONTENIDO-->
                <div class="w-full flex justify-center pb-3"><span class="font-semibold text-sm text-gray-700">Registros de Ventas</span></div>
                <div class="w-full flex justify-center">
                <table>
                    <tr class="">
                        <td class="border border-gray-300 font-semibold bg-slate-600 text-gray-200 p-1 text-sm"><center>Fecha de Presentacion</td>
                        <td class="border border-gray-300 font-semibold bg-slate-600 text-gray-200 p-1 text-sm"><center>Descripcion</td>
                        <td class="border border-gray-300 font-semibold bg-slate-600 text-gray-200 p-1 text-sm"><center>Total Propuesta</td>
                        <td class="border border-gray-300 font-semibold bg-slate-600 text-gray-200 p-1 text-sm" colspan=3></td>
                        
                    </tr>
                <?php
                    $color=false;
                    foreach($registros as $cotizacion)
                    {
                ?>
                    <tr class="">
                        <td class="border border-gray-300 font-light {{$color?'bg-lime-100':''}} text-gray-700 p-1 text-xs">{{$cotizacion->fecha_presentacion}}</td>
                        <td class="border border-gray-300 font-light {{$color?'bg-lime-100':''}} text-gray-700 p-1 text-xs">{{$cotizacion->descripcion}}</td>
                        <td class="border border-gray-300 font-light {{$color?'bg-lime-100':''}} text-gray-700 p-1 text-xs">${{number_format($cotizacion->total_propuesta,2)}}</td>
                        <td class="border border-gray-300 font-light {{$color?'bg-lime-100':''}} text-gray-700 p-1 text-xs"> @livewire('cotizacion.detalles-cotizacion', ['id_oportunidad' => $id_oportunidad], key($cotizacion->id))</td>
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
