<div>
    <x-jet-danger-button class="bg-blue-500 hover:bg-blue-400" wire:click="nuevo">DUPLICAR COTIZACION</x-jet-danger-button>

    <x-jet-dialog-modal wire:model="open" maxWidth="2xl">
        <x-slot name="title">
            Duplicar Cotizacion
        </x-slot>
        <x-slot name="content">
            <div class="flex flex-col w-full">
                <div class="w-full mb-2 flex flex-row space-x-3">
                    <x-jet-label value="Folio a duplicar" />
                    <x-jet-input class="w-full text-xs" wire:model="folio" type="text" />
                    @error('folio') <span class="text-xs text-red-400">{{ $message }}</span> @enderror    
                </div>
                <div class="w-full pt-5 pb-4 {{$valido==1?'text-green-500':'text-red-500'}}">
                    {{$leyenda}}
                </div>
            </div>
        </x-slot>
        <x-slot name="footer">
            <x-jet-secondary-button wire:click="cancelar">CANCELAR</x-jet-secondary-button>&nbsp;&nbsp;
            @if($valido==1)
            <button {{$procesando==1?'disabled':''}} class='inline-flex items-center px-4 py-2 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 active:bg-gray-900 focus:outline-none focus:border-gray-900 focus:ring focus:ring-gray-300 disabled:opacity-25 transition' wire:click.prevent="duplicar">DUPLICAR</button>&nbsp;&nbsp;
            @endif
        </x-slot>
    </x-jet-dialog-modal>
</div>