<div>
    <x-jet-danger-button wire:click="nuevo">CREAR NUEVO CONTACTO</x-jet-danger-button>

    <x-jet-dialog-modal wire:model="open" maxWidth="5xl">
        <x-slot name="title">
            Crear nuevo contacto
        </x-slot>
        <x-slot name="content">
            <div class="flex flex-col w-full">
                <div class="w-full mb-2 flex flex-row space-x-3">
                    <div class="w-full">
                        <x-jet-label value="Nombre del contacto" />
                        <x-jet-input class="w-full text-sm" type="text"  wire:model.defer="nombre"/>
                        @error('nombre') <span class="text-xs text-red-400">{{ $message }}</span> @enderror
                    </div>
                </div>
                <div class="w-full mb-2 flex flex-row space-x-3">
                    <div class="w-1/3">
                        <x-jet-label value="Posicion en la organizacion" />
                        <x-jet-input class="w-full text-sm" type="text"  wire:model.defer="posicion"/>
                        @error('posicion') <span class="text-xs text-red-400">{{ $message }}</span> @enderror
                    </div>
                    <div class="w-2/3">
                        <x-jet-label value="Area" />
                        <select class="w-full text-sm border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm" type="text"  wire:model.defer="area">
                            <option value=""></option>
                            <option value="Compras">Compras</option>
                            <option value="Sistemas">Sistemas</option>
                            <option value="Ventas">Ventas</option>
                            <option value="Finanzas">Finanzas</option>
                            <option value="Operaciones de Red">Operaciones de Red</option>
                            <option value="Servicio a Clientes">Servicio a Clientes</option>
                            <option value="Otros">Otros</option>
                        </select>
                        @error('area') <span class="text-xs text-red-400">{{ $message }}</span> @enderror
                    </div>
                </div>
                <div class="w-full mb-2 flex flex-row space-x-3 pb-3">
                    <div class="w-1/3">
                        <x-jet-label value="Correo 1" />
                        <x-jet-input class="w-full text-sm" type="text"  wire:model.defer="correo1"/>
                        @error('correo1') <span class="text-xs text-red-400">{{ $message }}</span> @enderror
                    </div>
                    <div class="w-1/3">
                        <x-jet-label value="Correo 2" />
                        <x-jet-input class="w-full text-sm" type="text"  wire:model.defer="correo2"/>
                        @error('correo2') <span class="text-xs text-red-400">{{ $message }}</span> @enderror
                    </div>
                    <div class="w-1/3">
                        <x-jet-label value="Correo 3" />
                        <x-jet-input class="w-full text-sm" type="text"  wire:model.defer="correo3"/>
                        @error('correo3') <span class="text-xs text-red-400">{{ $message }}</span> @enderror
                    </div>
                </div>
                <div class="w-full mb-2 flex flex-row space-x-3 pb-3">
                    <div class="w-1/3">
                        <x-jet-label value="Telefono 1" />
                        <x-jet-input class="w-full text-sm" type="text"  wire:model.defer="telefono1"/>
                        @error('telefono1') <span class="text-xs text-red-400">{{ $message }}</span> @enderror
                    </div>
                    <div class="w-1/3">
                        <x-jet-label value="Telefono 2" />
                        <x-jet-input class="w-full text-sm" type="text"  wire:model.defer="telefono2"/>
                        @error('telefono2') <span class="text-xs text-red-400">{{ $message }}</span> @enderror
                    </div>
                    <div class="w-1/3">
                        <x-jet-label value="Telefono 3" />
                        <x-jet-input class="w-full text-sm" type="text"  wire:model.defer="telefono3"/>
                        @error('telefono3') <span class="text-xs text-red-400">{{ $message }}</span> @enderror
                    </div>
                </div>
                <div class="w-full mb-2 flex flex-row space-x-3">
                    <div class="w-full">
                        <x-jet-label value="Notas" />
                        <x-jet-input class="w-full text-sm" type="text"  wire:model.defer="notas"/>
                        @error('notas') <span class="text-xs text-red-400">{{ $message }}</span> @enderror
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