<div>
    <x-jet-danger-button wire:click="nuevo">CREAR NUEVO CONTACTO</x-jet-danger-button>

    <x-jet-dialog-modal wire:model="open" maxWidth="5xl">
        <x-slot name="title">
            Crear nuevo contacto {{$empresa}}
        </x-slot>
        <x-slot name="content">
            <div class="flex flex-col w-full">
                <div class="w-full mb-2 flex flex-row space-x-3">
                    <div class="w-full">
                        <x-jet-label value="Nombre del contacto" />
                        <x-jet-input class="w-full text-sm" type="text"  wire:model.defer="rfc"/>
                        @error('rfc') <span class="text-xs text-red-400">{{ $message }}</span> @enderror
                    </div>
                </div>
                <div class="w-full mb-2 flex flex-row space-x-3">
                    <div class="w-1/3">
                        <x-jet-label value="Posicion en la organizacion" />
                        <x-jet-input class="w-full text-sm" type="text"  wire:model.defer="razon_social"/>
                        @error('razon_social') <span class="text-xs text-red-400">{{ $message }}</span> @enderror
                    </div>
                    <div class="w-1/3">
                        <x-jet-label value="Area" />
                        <select class="w-full text-sm border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm" type="text"  wire:model.defer="razon_social"/>
                            <option value="Sistemas"></option>
                            <option value="Sistemas">Sistemas</option>
                            <option value="Sistemas">Ventas</option>
                            <option value="Sistemas">Finanzas</option>
                            <option value="Sistemas">Operaciones de Red</option>
                            <option value="Sistemas">Servicio a Clientes</option>
                            <option value="Sistemas">Otros</option>
                        </select>
                        @error('razon_social') <span class="text-xs text-red-400">{{ $message }}</span> @enderror
                    </div>
                    <div class="w-1/3">
                        <x-jet-label value="Fecha de contacto" />
                        <x-jet-input class="w-full text-sm" type="date"  wire:model.defer="fecha_io"/>
                        @error('fecha_io') <span class="text-xs text-red-400">{{ $message }}</span> @enderror
                    </div>
                </div>
                <div class="w-full mb-2 flex flex-row space-x-3 pb-3">
                    <div class="w-1/3">
                        <x-jet-label value="Correo 1" />
                        <x-jet-input class="w-full text-sm" type="text"  wire:model.defer="terminos_pago"/>
                        @error('terminos_pago') <span class="text-xs text-red-400">{{ $message }}</span> @enderror
                    </div>
                    <div class="w-1/3">
                        <x-jet-label value="Correo 2" />
                        <x-jet-input class="w-full text-sm" type="text"  wire:model.defer="estatus"/>
                        @error('estatus') <span class="text-xs text-red-400">{{ $message }}</span> @enderror
                    </div>
                    <div class="w-1/3">
                        <x-jet-label value="Correo 3" />
                        <x-jet-input class="w-full text-sm" type="text"  wire:model.defer="estatus"/>
                        @error('estatus') <span class="text-xs text-red-400">{{ $message }}</span> @enderror
                    </div>
                </div>
                <div class="w-full mb-2 flex flex-row space-x-3 pb-3">
                    <div class="w-1/3">
                        <x-jet-label value="Telefono 1" />
                        <x-jet-input class="w-full text-sm" type="text"  wire:model.defer="terminos_pago"/>
                        @error('terminos_pago') <span class="text-xs text-red-400">{{ $message }}</span> @enderror
                    </div>
                    <div class="w-1/3">
                        <x-jet-label value="Telefono 2" />
                        <x-jet-input class="w-full text-sm" type="text"  wire:model.defer="estatus"/>
                        @error('estatus') <span class="text-xs text-red-400">{{ $message }}</span> @enderror
                    </div>
                    <div class="w-1/3">
                        <x-jet-label value="Telefono 3" />
                        <x-jet-input class="w-full text-sm" type="text"  wire:model.defer="estatus"/>
                        @error('estatus') <span class="text-xs text-red-400">{{ $message }}</span> @enderror
                    </div>
                </div>
                <div class="w-full mb-2 flex flex-row space-x-3">
                    <div class="w-full">
                        <x-jet-label value="Notas" />
                        <x-jet-input class="w-full text-sm" type="text"  wire:model.defer="direccion_calle"/>
                        @error('direccion_calle') <span class="text-xs text-red-400">{{ $message }}</span> @enderror
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