<div>
    <span wire:click="abrir" style="cursor:pointer" class="w-full text-xl font-bold text-red-400">
        NC
    </span>

    <x-jet-dialog-modal wire:model="open" maxWidth="2xl">
        <x-slot name="title">
            Registrar Nota de Credito<br />
            <span class="text-sm py-0">Total Factura: ${{number_format($total_factura,0)}} ({{$moneda_nombre}})</span>
            <br />
            <span class="text-sm">Saldo: ${{number_format($saldo_factura,0)}} ({{$moneda_nombre}})</span>
            <br />
            <span class="text-sm">Vencimiento: {{$vencimiento_factura}}</span>
            <br />
            <span class="text-sm">Notas: {{$nota_factura}}</span>
        </x-slot>
        <x-slot name="content">
            <div class="flex flex-col w-full">                  
                <div class="w-full">
                    <x-jet-label value="Cantidad" />
                    <x-jet-input class="w-full text-sm" type="text"  wire:model.defer="cantidad_nota"/>
                    @error('cantidad_nota') <span class="text-xs text-red-400">{{ $message }}</span> @enderror
                </div>
                <div class="w-full">
                    <x-jet-label value="Folio" />
                    <x-jet-input class="w-full text-sm" type="text"  wire:model.defer="folio"/>
                    @error('folio') <span class="text-xs text-red-400">{{ $message }}</span> @enderror
                </div>
                <div class="w-full">
                    <x-jet-label value="Fecha emision" />
                    <x-jet-input class="w-full text-sm" type="date"  wire:model.defer="fecha_emision"/>
                    @error('fecha_emision') <span class="text-xs text-red-400">{{ $message }}</span> @enderror
                </div>
                <div class="w-full">
                    <x-jet-label value="Notas" />
                    <x-jet-input class="w-full text-sm" type="text"  wire:model.defer="notas"/>
                    @error('notas') <span class="text-xs text-red-400">{{ $message }}</span> @enderror
                </div>
            </div>
        </x-slot>
        <x-slot name="footer">
            <x-jet-secondary-button wire:click="cancelar">CANCELAR</x-jet-secondary-button>
            <button  class='inline-flex items-center px-4 py-2 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 active:bg-gray-900 focus:outline-none focus:border-gray-900 focus:ring focus:ring-gray-300 disabled:opacity-25 transition' wire:click.prevent="guardar">GUARDAR</button>
        </x-slot>
    </x-jet-dialog-modal>
</div>