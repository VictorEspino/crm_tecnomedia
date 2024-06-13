<div>
<div class="w-full text-base flex flex-col">
        <div class="w-full px-3">
            <i class="text-blue-400 fas fa-info" wire:click='cargar' style="cursor: pointer;"></i>
        </div>
        <div class="text-xs w-full">
            
        </div>
    </div>

    <x-jet-dialog-modal wire:model="open" maxWidth="7xl">
        <x-slot name="title">
            Ficha de cliente
        </x-slot>
        <x-slot name="content">
            <div class="flex flex-col w-full pb-6">
                <div class="w-full mb-2 flex flex-row space-x-3">
                    <div class="w-1/2 flex justify-center flex flex-col">
                        <div class="w-full text-xl font-bold">{{$razon_social}} {{$regimen}}</div>
                        <div class="w-full text-base">{{$calle}} #{{$num_ext}} ({{$num_int}})</div>
                        <div class="w-full text-base">Col. {{$colonia}}, CP {{$cp}}</div>
                        <div class="w-full text-base">{{$ciudad}}, {{$pais}}</div>
                    </div>
                    <div class="w-1/2 flex flex-col">
                        <div class="w-full">
                            <span class="text-sm font-thin">RFC : {{$rfc}}</span>
                        </div>
                        <div class="w-full">
                            <span class="text-sm font-thin">Inicio de Operaciones :  {{$fecha_io}}</span>
                        </div>
                        <div class="w-full">
                            <span class="text-sm font-thin">Dias pago :  {{$terminos_pago}}</span>
                        </div>
                    </div>
                </div>
            </div>
            <div class="w-full text-bold text-indigo-500 text-xl border-t border-b">Proyectos Activos</div>
            @foreach($proyectos_activos as $proy)
            <div class="w-full text-gray-700 text-sm px-3 py-2 flex flex-col"> <!-- Encabezado -->
                    <div class="w-full text-2xl font-bold text-blue-400">{{$proy['nombre']}}</div> 
                    <div class="w-full text-base font-bold text-orange-400">{{$proy['negocio']}}</div>
            </div><!-- FIN Encabezado -->
            <div class="flex flex-col md:space-x-5 md:space-y-0 items-start md:flex-row text-sm">
                <div class="w-full md:w-1/2 flex flex-col justify-center md:p-5 p-3">
                    <div class="w-full bg-gray-200 flex flex-col p-2 rounded-t-lg">Etapas activas</div>
                    <div class="w-full flex flex-col border rounded-b-lg shadow-lg pb-5">  
                        @foreach ($proy['secciones_activas'] as $seccion)
                        <div class="w-full p-3 flex flex-col">
                            <div class="flex flex-row">
                                <div class="w-full text-base font-bold text-blue-600">
                                    {{$seccion['nombre']}}
                                </div>
                            </div>
                            <div class="w-full flex flex-row space-x-3">
                                <div class="w-1/4">
                                    Inicio Vigencia <br><span class="font-bold">{{$seccion['f_inicio']}}</span>
                                </div>
                                <div class="w-1/4">
                                    Fin Vigencia <br><span class="font-bold">{{$seccion['f_fin']}}</span>
                                </div>
                                <div class="w-1/4">
                                    Precio sin IVA <br><span class="font-bold"> ${{number_format($seccion['total_ingreso'],0)}} ({{$seccion['i_tc']=='1'?'MXP':'USD'}})</span>
                                </div>
                                <div class="w-1/4">
                                    Margen <br><span class="font-bold"> {{number_format(100*$seccion['porcentaje_margen'],0)}}%</span>
                                </div>
                            </div>
                            <div class="flex flex-col py-3 px-3 justify-center">
                                @foreach($seccion['items'] as $item)
                                <div class="w-full flex flex-col flex border rounded shadow-lg"> <!--FICHA-->
                                    <div class="w-full flex flex-row pt-3">
                                            <div class="w-3/4 flex justify-center"><span class="font-bold text-sm">{{$item['descripcion']}}</span></div>
                                            <div class="w-1/4"><span class="font-bold">({{$item['cantidad']}})</div>
                                    </div>
                                    <div class="w-full flex flex-row py-2">
                                            <div class="w-3/4 text-sm px-5">
                                                Partner: {{$item['mayorista']}} <br/>
                                                Fabricante : {{$item['fabricante']}}
                                            </div>
                                            <div class="w-3/4 text-sm px-5">
                                                <span class="text-orange-500 font-bold">Total: ${{number_format($item['total_cliente'],0)}} ({{$seccion['i_tc']=='1'?'MXP':'USD'}})</span><br/>
                                                <span class="text-green-500 font-bold">Margen : {{100*$item['porcentaje_margen']}}%</span>
                                            </div>
                                    </div>
                                </div><!--FICHA-->
                                @endforeach
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>
                <div class="w-full md:w-1/2 flex flex-col justify-center md:p-5 p-3">
                    <div class="w-full bg-gray-200 flex flex-col p-2 rounded-t-lg">Previas y Siguientes</div>
                    @if(count($proy['secciones_previas'])>=1)
                    <div class="w-full bg-lime-200 flex flex-col p-2 flex justify-center text-center">-------------Etapas previas -------------</div>
                    @endif
                    <div class="w-full flex flex-col border-l border-r pb-5 text-xs">  
                        <!--SERVICIO-->

                        @foreach ($proy['secciones_previas'] as $seccion)
                        <div class="w-full p-3 flex flex-col">
                            <div class="flex flex-row">
                                <div class="w-full text-base font-bold text-blue-600">
                                    {{$seccion['nombre']}}
                                </div>
                            </div>
                            <div class="w-full flex flex-row space-x-3">
                                <div class="w-1/4">
                                    Inicio Vigencia <br><span class="font-bold">{{$seccion['f_inicio']}}</span>
                                </div>
                                <div class="w-1/4">
                                    Fin Vigencia <br><span class="font-bold">{{$seccion['f_fin']}}</span>
                                </div>
                                <div class="w-1/4">
                                    Precio sin IVA <br><span class="font-bold"> ${{number_format($seccion['total_ingreso'],0)}} ({{$seccion['i_tc']=='1'?'MXP':'USD'}})</span>
                                </div>
                                <div class="w-1/4">
                                    Margen <br><span class="font-bold"> {{number_format(100*$seccion['porcentaje_margen'],0)}}%</span>
                                </div>
                            </div>
                            <div class="flex flex-col py-3 px-3 justify-center">
                                @foreach($seccion['items'] as $item)
                                <div class="w-full flex flex-col flex border rounded shadow-lg"> <!--FICHA-->
                                    <div class="w-full flex flex-row pt-3">
                                            <div class="w-1/3 flex justify-center"><span class="font-bold text-xs">{{$item['descripcion']}}({{$item['cantidad']}})</span></div>
                                            <div class="w-1/3 text-xs px-5">
                                                Partner: {{$item['mayorista']}} <br/>
                                                Fabricante : {{$item['fabricante']}}
                                            </div>
                                            <div class="w-1/3 text-xs px-5">
                                                <span class="text-orange-500 font-bold">Total: ${{number_format($item['total_cliente'],0)}} ({{$seccion['i_tc']=='1'?'MXP':'USD'}})</span><br/>
                                                <span class="text-green-500 font-bold">Margen : {{100*$item['porcentaje_margen']}}%</span>
                                            </div>
                                            
                                    </div>

                                </div><!--FICHA-->
                                @endforeach
                            </div>
                        </div>
                        @endforeach
 
                        <!--SERVICIO-->
                    </div>

                    @if(count($proy['secciones_siguientes'])>=1)
                    <div class="w-full bg-blue-200 flex flex-col p-2 flex justify-center text-center">-------------Etapas siguientes -------------</div>
                    @endif
                    <div class="w-full flex flex-col border-b border-l border-r shadow-l rounded-b-lg  pb-5 text-xs">  
                        <!--SERVICIO-->
                        @foreach ($proy['secciones_siguientes'] as $seccion)
                        <div class="w-full p-3 flex flex-col">
                            <div class="flex flex-row">
                                <div class="w-full text-base font-bold text-blue-600">
                                    {{$seccion['nombre']}}
                                </div>
                            </div>
                            <div class="w-full flex flex-row space-x-3">
                                <div class="w-1/4">
                                    Inicio Vigencia <br><span class="font-bold">{{$seccion['f_inicio']}}</span>
                                </div>
                                <div class="w-1/4">
                                    Fin Vigencia <br><span class="font-bold">{{$seccion['f_fin']}}</span>
                                </div>
                                <div class="w-1/4">
                                    Precio sin IVA <br><span class="font-bold"> ${{number_format($seccion['total_ingreso'],0)}} ({{$seccion['i_tc']=='1'?'MXP':'USD'}})</span>
                                </div>
                                <div class="w-1/4">
                                    Margen <br><span class="font-bold"> {{number_format(100*$seccion['porcentaje_margen'],0)}}%</span>
                                </div>
                            </div>
                            <div class="flex flex-col py-3 px-3 justify-center">
                                @foreach($seccion['items'] as $item)
                                <div class="w-full flex flex-col flex border rounded shadow-lg"> <!--FICHA-->
                                    <div class="w-full flex flex-row pt-3">
                                            <div class="w-1/3 flex justify-center"><span class="font-bold text-xs">{{$item['descripcion']}}({{$item['cantidad']}})</span></div>
                                            <div class="w-1/3 text-xs px-5">
                                                Partner: {{$item['mayorista']}} <br/>
                                                Fabricante : {{$item['fabricante']}}
                                            </div>
                                            <div class="w-1/3 text-xs px-5">
                                                <span class="text-orange-500 font-bold">Total: ${{number_format($item['total_cliente'],0)}} ({{$seccion['i_tc']=='1'?'MXP':'USD'}})</span><br/>
                                                <span class="text-green-500 font-bold">Margen : {{100*$item['porcentaje_margen']}}%</span>
                                            </div>
                                            
                                    </div>

                                </div><!--FICHA-->
                                @endforeach
                            </div>
                        </div>
                        @endforeach
 
                        <!--SERVICIO-->
                    </div>

                </div>
            </div>
            @endforeach
        </x-slot>
        <x-slot name="footer">
            <x-jet-secondary-button wire:click="cancelar">CANCELAR</x-jet-secondary-button>&nbsp;&nbsp;
        </x-slot>
    </x-jet-dialog-modal>
</div>