<div>
    <x-jet-danger-button wire:click="nuevo">CREAR NUEVO PROSPECTO</x-jet-danger-button>

    <x-jet-dialog-modal wire:model="open" maxWidth="5xl">
        <x-slot name="title">
            Crear nuevo prospecto
        </x-slot>
        <x-slot name="content">
            <div class="flex flex-col w-full">
                <div class="w-full mb-2 flex flex-row space-x-3">
                    <div class="w-1/2">
                        <x-jet-label value="RFC" />
                        <x-jet-input class="w-full text-sm" type="text"  wire:model.defer="rfc"/>
                        @error('rfc') <span class="text-xs text-red-400">{{ $message }}</span> @enderror
                    </div>
                    <div class="w-1/2">
                        <x-jet-label value="Regimen" />
                        <select wire:model.defer="regimen" class="w-full text-sm border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm">
                                <option value=""></option>
                                @foreach($regimenes as $registro)
                                    <option value="{{$registro->nombre}}">{{$registro->nombre}}</option>
                                @endforeach
                            </select>
                        @error('regimen') <span class="text-xs text-red-400">{{ $message }}</span> @enderror
                    </div>
                </div>
                <div class="w-full mb-2 flex flex-row space-x-3">
                    <div class="w-3/4">
                        <x-jet-label value="Razon Social" />
                        <x-jet-input class="w-full text-sm" type="text"  wire:model.defer="razon_social"/>
                        @error('razon_social') <span class="text-xs text-red-400">{{ $message }}</span> @enderror
                    </div>
                    <div class="w-1/4">
                        <x-jet-label value="Inicio Operaciones" />
                        <x-jet-input class="w-full text-sm" type="date"  wire:model.defer="fecha_io"/>
                        @error('fecha_io') <span class="text-xs text-red-400">{{ $message }}</span> @enderror
                    </div>
                </div>
                <div class="w-full mb-2 flex flex-row space-x-3 pb-3">
                    <div class="w-3/4">
                        <x-jet-label value="Terminos pago (dias de credito)" />
                        <x-jet-input class="w-full text-sm" type="text"  wire:model.defer="terminos_pago"/>
                        @error('terminos_pago') <span class="text-xs text-red-400">{{ $message }}</span> @enderror
                    </div>
                </div>
                <div class="w-full mb-2 flex flex-row space-x-3 pb-3 border-b">
                    <div class="w-full">
                        <x-jet-label class="font-bold text-red-400" value="Direccion" />
                    </div>
                </div>
                <div class="w-full mb-2 flex flex-row space-x-3">
                    <div class="w-1/2">
                        <x-jet-label value="Calle" />
                        <x-jet-input class="w-full text-sm" type="text"  wire:model.defer="calle"/>
                        @error('calle') <span class="text-xs text-red-400">{{ $message }}</span> @enderror
                    </div>
                    <div class="w-1/4">
                        <x-jet-label value="Numero Exterior" />
                        <x-jet-input class="w-full text-sm" type="text"  wire:model.defer="num_ext"/>
                        @error('num_ext') <span class="text-xs text-red-400">{{ $message }}</span> @enderror
                    </div>
                    <div class="w-1/4">
                        <x-jet-label value="Numero Interior" />
                        <x-jet-input class="w-full text-sm" type="text"  wire:model.defer="num_int"/>
                        @error('num_int') <span class="text-xs text-red-400">{{ $message }}</span> @enderror
                    </div>
                </div>
                <div class="w-full mb-2 flex flex-row space-x-3">
                <div class="w-1/2">
                        <x-jet-label value="Codigo Postal" />
                        <x-jet-input class="w-full text-sm" type="text"  wire:model="cp"/>
                        @error('cp') <span class="text-xs text-red-400">{{ $message }}</span> @enderror
                    </div>
                    <div class="w-1/2">
                        <x-jet-label value="Colonia" />
                        @if($opciones_colonia<=1)
                            <x-jet-input class="w-full text-sm" type="text"  wire:model.defer="colonia"/>
                        @else
                            <select wire:model.defer="colonia" class="w-full text-sm border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm">
                                @foreach($colonias as $index=>$opcion_colonia)
                                    <option value="{{$opcion_colonia['colonia']}}">{{$opcion_colonia['colonia']}}</option>
                                @endforeach
                            </select>  
                        @endif
                        @error('colonia') <span class="text-xs text-red-400">{{ $message }}</span> @enderror
                    </div>
                    
                </div>
                <div class="w-full mb-2 flex flex-row space-x-3">
                    <div class="w-1/3">
                        <x-jet-label value="Ciudad" />
                        <x-jet-input class="w-full text-sm" type="text"  wire:model.defer="ciudad"/>
                        @error('ciudad') <span class="text-xs text-red-400">{{ $message }}</span> @enderror
                    </div>
                    <div class="w-1/3">
                        <x-jet-label value="Estado" />
                        <x-jet-input class="w-full text-sm" type="text"  wire:model.defer="estado"/>
                        @error('estado') <span class="text-xs text-red-400">{{ $message }}</span> @enderror
                    </div>
                    <div class="w-1/3">
                        <x-jet-label value="Pais" />
                        <x-jet-input class="w-full text-sm" type="text"  wire:model.defer="pais"/>
                        @error('pais') <span class="text-xs text-red-400">{{ $message }}</span> @enderror
                    </div>
                </div>
            </div>
        </x-slot>
        <x-slot name="footer">
            <x-jet-secondary-button wire:click="cancelar">CANCELAR</x-jet-secondary-button>
            <button  class='inline-flex items-center px-4 py-2 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 active:bg-gray-900 focus:outline-none focus:border-gray-900 focus:ring focus:ring-gray-300 disabled:opacity-25 transition' wire:click.prevent="guardar">GUARDAR</button>
        </x-slot>
    </x-jet-dialog-modal>
</div>