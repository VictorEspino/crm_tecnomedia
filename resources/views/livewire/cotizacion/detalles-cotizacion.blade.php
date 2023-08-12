<div>    
    <div class="w-full text-base flex flex-col">
        <div class="w-full">
            <i class="text-blue-400 fas fa-edit" wire:click='edit_open' style="cursor: pointer;"></i>
        </div>
        <div class="text-xs w-full">
            
        </div>
    </div>
    <x-jet-dialog-modal wire:model="open" maxWidth="5xl">
        <x-slot name="title">
            <div class="w-full flex flex-row">
                <div class="w-full">
                    Detalles Cotizacion
                </div>
            </div>
        </x-slot>
        <x-slot name="content">
            <div class="flex flex-col w-full">
                <div class="w-full mb-2 flex flex-row space-x-3">
                    <div class="w-1/2">
                        <x-jet-label class="text-xl font-bold" value="" />
                    </div>
                    <div class="w-1/2 px-5">
                        <x-jet-label class="text-base font-bold" value="Contacto : " />
                        <x-jet-label class="text-base font-bold" value="Telefono : " />
                        <x-jet-label class="text-base font-bold" value="Correo : " />
                        
                    </div>
                </div>
                <div class="w-full">
                    <div class="w-1/2 px-5">
                        <x-jet-label class="text-xl font-bold" value="Detalles" />
                    </div>                    
                </div>
                <div class="w-full mb-2 flex flex-row space-x-3 border-t border-b py-5">
                    <div class="w-1/2 px-5">
                        <x-jet-label class="text-base" value="Linea Negocio : " />
                        <x-jet-label class="text-base" value="Servicio : " />
                        <x-jet-label class="text-base" value="Producto : " />
                    </div>
                    <div class="w-1/2 px-5">
                        <x-jet-label class="text-xl font-bold" value="" />
                    </div>                    
                </div>
                <div class="w-full">
                    <div class="w-full bg-gray-700 px-5 flex flex-row">
                        <div class="w-5/6">
                            <x-jet-label class="text-gray-100 text-xl font-bold" value="Bitacora de actividad" />
                        </div>
                        <div class="w-1/6 flex items-center justify-end">
                            <i class="text-2xl text-green-500 fas fa-plus" style="cursor: pointer" wire:click="agregar_bitacora" cursor></i>
                        </div>
                    </div>
                    <div class="w-full px-5 pt-3">

                    </div>  
                    <div class="w-full px-5 pt-3 flex flex-col">
                        <div class="w-full pt-3 px-5 flex flex-row text-blue-500 text-base">
                            Nuevas Bitacoras
                        </div>
                        @foreach($nuevas_bitacoras as $index=>$bita)
                        <div class="w-full pt-3 px-5 flex flex-row space-x-2">
                            <div class="w-1/6 px-2">
                                <x-jet-label value="Tipo" />
                                <select wire:model="nuevas_bitacoras.{{$index}}.tipo" class="text-xs w-full py-1 px-3 border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded shadow-sm">
                                    <option value=""></option>
                                    @foreach($tipos as $tipo_opcion)
                                    <option value="{{$tipo_opcion->id}}">{{$tipo_opcion->nombre}}</option>
                                    @endforeach
                                </select>
                                @error('nuevas_bitacoras.'.$index.'.tipo') <span class="text-xs text-red-400">{{ $message }}</span> @enderror    
                            </div>
                            <div class="w-2/6 px-2">
                                <x-jet-label value="Detalles" />
                                <x-jet-input wire:model="nuevas_bitacoras.{{$index}}.detalles" class="border border-gray-300 w-full py-1 px-3 text-xs  focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded shadow-sm"/>
                                @error('nuevas_bitacoras.'.$index.'.detalles') <span class="text-xs text-red-400">{{ $message }}</span> @enderror    
                            </div>
                            <div class="w-1/6 px-2">
                                <x-jet-label value="Gasto" />
                                <x-jet-input wire:model="nuevas_bitacoras.{{$index}}.gasto" class="border border-gray-300 w-full py-1 px-3 text-xs  focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded shadow-sm"/>
                                @error('nuevas_bitacoras.'.$index.'.gasto') <span class="text-xs text-red-400">{{ $message }}</span> @enderror    
                            </div>
                            <div class="w-1/6 px-2">
                                <x-jet-label value="Concepto Gasto" />
                                <x-jet-input wire:model="nuevas_bitacoras.{{$index}}.concepto_gasto" class="border border-gray-300 w-full py-1 px-3 text-xs  focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded shadow-sm"/>
                                @error('nuevas_bitacoras.'.$index.'.concepto_gasto') <span class="text-xs text-red-400">{{ $message }}</span> @enderror    
                            </div>
                            <div class="w-1/6 px-2">
                                <x-jet-label value="Due date" />
                                <x-jet-input type="date" wire:model="nuevas_bitacoras.{{$index}}.due_date" class="border border-gray-300 w-full py-1 px-3 text-xs  focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded shadow-sm"/>
                                @error('nuevas_bitacoras.'.$index.'.due_date') <span class="text-xs text-red-400">{{ $message }}</span> @enderror    
                            </div>
                            <div class="w-1/12 px-2">
                                <i class="fas fa-minus-circle text-red-400 text-2xl" style="cursor:pointer" wire:click='eliminar_bitacora({{$index}})'></i>
                            </div>
                            
                        </div>
                        @endforeach
                    </div>                      
                </div>
            </div>
        </x-slot>
        <x-slot name="footer">
            <x-jet-secondary-button wire:click="cancelar">CANCELAR</x-jet-secondary-button>
            <button {{$procesando==1?'disabled':''}} class='inline-flex items-center px-4 py-2 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 active:bg-gray-900 focus:outline-none focus:border-gray-900 focus:ring focus:ring-gray-300 disabled:opacity-25 transition' wire:click.prevent="guardar_bitacoras">GUARDAR</button>
        </x-slot>
    </x-jet-dialog-modal>
</div>