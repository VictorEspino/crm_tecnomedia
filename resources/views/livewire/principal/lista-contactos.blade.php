<div>
<div class="w-full text-base flex flex-col">
        <div class="w-full px-2">
            <i class="text-orange-400 fas fa-users" wire:click='cargar' style="cursor: pointer;"></i>
        </div>
        <div class="text-xs w-full">
            
        </div>
    </div>

    <x-jet-dialog-modal wire:model="open" maxWidth="2xl">
        <x-slot name="title">
            Lista contactos
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
            <div class="w-full text-bold text-indigo-500 text-xl border-t border-b">Contactos</div>
            <div class="flex flex-col md:space-x-5 md:space-y-0 items-start md:flex-row text-sm">
                <div class="w-full md:w-full flex flex-col justify-center md:p-5 p-3">
                    <div class="w-full flex flex-col border rounded-b-lg shadow-lg pb-5">  
                        @foreach ($contactos as $contacto)
                        <div class="w-full p-3 flex flex-col border">
                            <div class="flex flex-row">
                                <div class="w-3/4 text-base font-bold text-orange-600">
                                    {{$contacto->nombre}}
                                </div>
                                <div class="w-1/4 font-bold font-bold text-green-500">
                                    {{$contacto->area}}
                                </div>    
                            </div>
                            <div class="flex flex-col">
                                <div class="w-3/4 text-sm font-bold text-indigo-400">
                                    {{$contacto->posicion}}
                                </div>
                            </div>
                            <div class="flex flex-row space-x-3 py-2">
                                <div class="w-1/3">
                                    Telefono 1 <br><span class="font-bold">{{$contacto->telefono1}}</span>
                                </div>
                                <div class="w-1/3">
                                    Telefono 2 <br><span class="font-bold">{{$contacto->telefono2}}</span>
                                </div>
                                <div class="w-1/3">
                                    Telefono 3 <br><span class="font-bold">{{$contacto->telefono3}}</span>
                                </div>
                            </div>
                            <div class="flex flex-row space-x-3 py-2">
                                <div class="w-1/3">
                                    Correo 1 <br><span class="font-bold">{{$contacto->correo1}}</span>
                                </div>
                                <div class="w-1/3">
                                    Correo 2 <br><span class="font-bold">{{$contacto->correo2}}</span>
                                </div>
                                <div class="w-1/3">
                                    Correo 3 <br><span class="font-bold">{{$contacto->correo3}}</span>
                                </div>
                            </div>
                            <div class="flex flex-col py-2">
                                <div class="w-full text-xs">
                                    Observaciones <br><span class="text-gray-600">{{$contacto->notas}}</span>
                                </div>
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </x-slot>
        <x-slot name="footer">
            <x-jet-secondary-button wire:click="cancelar">CANCELAR</x-jet-secondary-button>&nbsp;&nbsp;
        </x-slot>
    </x-jet-dialog-modal>
</div>