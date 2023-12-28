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
            <div class="w-full text-bold text-indigo-500 text-xl border-t border-b">Servicios Activos</div>
            <div class="flex flex-col md:space-x-5 md:space-y-0 items-start md:flex-row text-sm">
                <div class="w-full md:w-1/2 flex flex-col justify-center md:p-5 p-3">
                    <div class="w-full bg-gray-200 flex flex-col p-2 rounded-t-lg">Licenciamiento</div>
                    <div class="w-full flex flex-col border rounded-b-lg shadow-lg pb-5">  
                        @foreach ($licencias as $licencia)
                        <div class="w-full p-3 flex flex-col border">
                            <div class="flex flex-row">
                                <div class="w-3/4 text-base font-bold text-blue-600">
                                    {{$licencia->producto}}
                                </div>
                                <div class="w-1/4 font-bold">
                                    {{$licencia->licencias}} Licencias
                                </div>    
                            </div>
                            <div class="flex flex-col">
                                <div class="w-3/4 text-base font-bold text-orange-400">
                                    {{$licencia->linea_negocio->nombre}}
                                </div>
                            </div>
                            <div class="w-full p-2 font-bold">
                                {{$licencia->servicio}}
                            </div>
                            <div class="flex flex-row space-x-3">
                                <div class="w-1/3">
                                    Inicio Vigencia <br><span class="font-bold">{{$licencia->inicio_vigencia}}</span>
                                </div>
                                <div class="w-1/3">
                                    Fin Vigencia <br><span class="font-bold">{{$licencia->fin_vigencia}}</span>
                                </div>
                                <div class="w-1/3 font-bold text-green-500">
                                    Al Corriente
                                </div>
                            </div>
                            <div class="flex flex-row space-x-3 py-3 justify-center">
                                <div class="w-1/2 flex justify-center">
                                    Precio sin IVA : <span class="font-bold"> ${{number_format($licencia->precio_sin_iva,0)}} ({{$licencia->moneda->nombre}})</span>
                                </div>
                                <div class="w-1/2 flex justify-center">
                                    Años Contrato : <span class="font-bold">  {{$licencia->años_contrato}}</span>
                                </div>
                            </div>
                            <div class="flex flex-row space-x-3">
                                <div class="w-full">
                                    Observaciones <br><span class="font-bold">{{$licencia->observaciones}}</span>
                                </div>
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>
                <div class="w-full md:w-1/2 flex flex-col justify-center md:p-5 p-3">
                    <div class="w-full bg-gray-200 flex flex-col p-2 rounded-t-lg">Servicios</div>
                    <div class="w-full flex flex-col border rounded-b-lg shadow-lg pb-5">  
                        <!--SERVICIO-->
                        <!--
                        <div class="w-full p-3 flex flex-col">
                            <div class="flex flex-row">
                                <div class="w-3/4 text-base font-bold text-blue-600">
                                    Producto asociado: CA Broadcom
                                </div>
                                <div class="w-1/4">
                                    Alcance fijo
                                </div>    
                            </div>
                            <div class="w-full p-2">
                            Consultoría API para Implementación de Gateway distribuido,
Migración de Portal & adecuaciones al portal (35 Jornadas)
                            </div>
                            <div class="flex flex-row space-x-3 p-2">
                                <div class="w-1/2">
                                    Unidad <br><span class="font-bold">Jornadas</span>
                                </div>
                                <div class="w-1/3">
                                     Cantidad<br><span class="font-bold">35</span>
                                </div>
                            </div>
                            <div class="flex flex-row space-x-3 px-2">
                                <div class="w-1/3">
                                    Inicio Vigencia <br><span class="font-bold">2024-01-31</span>
                                </div>
                                <div class="w-1/3">
                                    Fin Vigencia <br><span class="font-bold">2025-01-30</span>
                                </div>
                                <div class="w-1/3 font-bold text-green-500">
                                    Al Corriente
                                </div>
                            </div>
                        </div>
                        -->
                        <!--SERVICIO-->
                    </div>
                </div>
            </div>
        <!--
            <div class="w-full text-bold text-indigo-500 text-xl border-t border-b">Prospeccion Actual</div>
            <div class="flex flex-col md:space-x-5 md:space-y-0 items-start md:flex-row text-sm">
                <div class="w-full md:w-full flex flex-col justify-center md:p-5 p-3">
                    <div class="w-full bg-gray-200 flex flex-col p-2 rounded-t-lg">Oportunidades</div>
                    <div class="w-full flex flex-row border rounded-b-lg shadow-lg pb-5">  
                        
                        <div class="w-full p-3 flex flex-col">
                            <div class="flex flex-row">
                                <div class="w-3/4 text-base font-bold text-blue-600">
                                    Monitoreo de locaciones fisicas del datacenter
                                </div>
                                <div class="w-1/4">
                                    #0000000234
                                </div>    
                            </div>
                            <div class="w-full p-2">
                                Seguimiento Renovación de Mantenimiento de Licencia Perpetua
                            </div>
                            <div class="flex flex-row space-x-3">
                                <div class="w-1/3">
                                     Linea de Negocio<br><span class="font-bold">CIBERSEGURIDAD</span>
                                </div>
                                <div class="w-1/3">
                                    Servicio <br><span class="font-bold">Mantenimiento de Licencias Perpetuas ( nuevas versiones)</span>
                                </div>
                                <div class="w-1/3 font-bold text-green-500">
                                    Netscout Systems, Inc
                                </div>
                            </div>
                            <div class="w-full p-2">
                                Etapa : <span class="text-base font-bold text-red-400">Negociación</span>
                            </div>
                        </div>
                        
                    </div>
                </div>
            </div>
        -->



        </x-slot>
        <x-slot name="footer">
            <x-jet-secondary-button wire:click="cancelar">CANCELAR</x-jet-secondary-button>&nbsp;&nbsp;
        </x-slot>
    </x-jet-dialog-modal>
</div>