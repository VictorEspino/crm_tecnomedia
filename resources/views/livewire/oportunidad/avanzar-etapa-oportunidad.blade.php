<div>    
    <div class="w-full text-base flex flex-col">
        <div class="w-full">
            <i class="text-green-400 fas fa-forward" wire:click='edit_open' style="cursor: pointer;"></i>
        </div>
        <div class="text-xs w-full">
            
        </div>
    </div>
    <x-jet-dialog-modal wire:model="open" maxWidth="5xl">
        <x-slot name="title">
            <div class="w-full flex flex-row">
                <div class="w-full">
                    Detalles Lead
                </div>
            </div>
        </x-slot>
        <x-slot name="content">
            <div class="flex flex-col w-full">
                <div class="w-full mb-2 flex flex-row space-x-3">
                    <div class="w-1/2">
                        <x-jet-label class="text-xl font-bold" value="{{$razon_social}}" />
                    </div>
                    <div class="w-1/2 px-5">
                        <x-jet-label class="text-base font-bold" value="Contacto : {{$contacto}}" />
                        <x-jet-label class="text-base font-bold" value="Telefono : {{$telefono}}" />
                        <x-jet-label class="text-base font-bold" value="Correo : {{$correo}}" />
                        
                    </div>
                </div>
                <div class="w-full">
                    <div class="w-1/2 px-5">
                        <x-jet-label class="text-xl font-bold" value="Detalles" />
                    </div>                    
                </div>
                <div class="w-full mb-2 flex flex-row space-x-3 border-t border-b py-5">
                    <div class="w-1/2 px-5">
                        <x-jet-label class="text-base" value="Linea Negocio : {{$linea_negocio}}" />
                        <x-jet-label class="text-base" value="Servicio : {{$servicio}}" />
                        <x-jet-label class="text-base" value="Producto : {{$producto}}" />
                    </div>
                    <div class="w-1/2 px-5">
                        <x-jet-label class="text-xl font-bold" value="{{$oportunidad_text}}" />
                    </div>                    
                </div>
                <div class="w-full flex flex-col">
                    <div class="w-full bg-gray-100 px-5 flex flex-col">
                        <div class="w-full">
                            <x-jet-label class="text-gray-700 text-xl font-bold" value="Cambio de etapa" />
                        </div>
                    </div>
                    <div class="w-full px-5 flex flex-row space-x-10">
                        <div class="w-1/2 flex flex-col pt-3">
                            <div class="w-full bg-gray-200 px-3 rounded">
                                <x-jet-label class="text-xs" value="Actual:" />
                            </div>
                            <div class="w-full">
                                <x-jet-label class="text-base font-bold" value="{{$desc_etapa_actual->nombre}}" />
                            </div>
                            <div class="">
                                {{$desc_etapa_actual->mensaje}}
                            </div>
                            <div class="font-bold text-red-400 pt-4">
                                Si ha concluido o ejecutado con exito la accion actual puede avanzar escogiendo la opcion adecuada en la tabla siguiente:
                            </div>
                        </div>
                        <div class="w-1/2 flex flex-col pt-3">
                            <div class="w-full bg-gray-200 px-3 rounded">
                                <x-jet-label class="text-xs" value="Avanzar a:" />
                            </div>
                            <div class="w-full p-3">
                                <select class="text-xs w-full border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm py-1" wire:model="avanzar_a">
                                    <option value=""></option>
                                    @foreach($opciones_avance as $opcion)
                                    <option value={{$opcion['id']}}>{{$opcion['nombre']}}</option>
                                    @endforeach
                                </select>
                                @error('avanzar_a') <span class="text-xs text-red-400">{{ $message }}</span> @enderror    
                            </div>
                            <div class="px-3">
                                {{$mensaje_avance}}
                            </div>
                            <div class="font-bold font-bold pt-4 px-3">
                                {{$dias_dd}}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </x-slot>
        <x-slot name="footer">
            <x-jet-secondary-button wire:click="cancelar">CANCELAR</x-jet-secondary-button>
            <button {{$procesando==1?'disabled':''}} class='inline-flex items-center px-4 py-2 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 active:bg-gray-900 focus:outline-none focus:border-gray-900 focus:ring focus:ring-gray-300 disabled:opacity-25 transition' wire:click.prevent="guardar">GUARDAR</button>
        </x-slot>
    </x-jet-dialog-modal>
</div>
