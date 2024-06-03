<div>
    <span wire:click="abrir" style="cursor:pointer" class="w-full text-xl font-bold text-blue-400">
        <i class="fas fa-file-invoice-dollar"></i>
    </span>

    <x-jet-dialog-modal wire:model="open" maxWidth="2xl">
        <x-slot name="title">
            Registrar Pago<br />
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
                @if($moneda>1)
                <div class="w-full flex flex-row space-x-3">
                    <div class="w-1/2">
                        <x-jet-label value="Tipo cambio pago" />
                        <x-jet-input class="w-full text-sm" type="text"  wire:model.defer="tipo_cambio_pago"/>
                        @error('tipo_cambio_pago') <span class="text-xs text-red-400">{{ $message }}</span> @enderror
                    </div>
                    <div class="w-1/2">
                        <x-jet-label value="Tipo cambio efectivo" />
                        <x-jet-input class="w-full text-sm" type="text"  wire:model.defer="tipo_cambio_efectivo"/>
                        @error('tipo_cambio_efectivo') <span class="text-xs text-red-400">{{ $message }}</span> @enderror
                    </div>
                </div>    
                @endif                    
                <div class="w-full">
                    <x-jet-label value="Cantidad" />
                    <x-jet-input class="w-full text-sm" type="text"  wire:model.defer="cantidad_pago"/>
                    @error('cantidad_pago') <span class="text-xs text-red-400">{{ $message }}</span> @enderror
                </div>
                <div class="w-full">
                    <x-jet-label value="Folio complemento pago" />
                    <x-jet-input class="w-full text-sm" type="text"  wire:model.defer="complemento_pago"/>
                    @error('complemento_pago') <span class="text-xs text-red-400">{{ $message }}</span> @enderror
                </div>
                <div class="w-full">
                    <x-jet-label value="Banco receptor pago" />
                    <x-jet-input class="w-full text-sm" type="text"  wire:model.defer="banco_pago"/>
                    @error('complemento_pago') <span class="text-xs text-red-400">{{ $message }}</span> @enderror
                </div>
                <div class="w-full">
                    <x-jet-label value="Tipo pago" />
                    <x-jet-input class="w-full text-sm" type="text"  wire:model.defer="tipo_pago"/>
                    @error('tipo_pago') <span class="text-xs text-red-400">{{ $message }}</span> @enderror
                </div>
                <div class="w-full">
                    <x-jet-label value="Fecha pago" />
                    <x-jet-input class="w-full text-sm" type="date"  wire:model.defer="fecha_pago"/>
                    @error('fecha_pago') <span class="text-xs text-red-400">{{ $message }}</span> @enderror
                </div>
            </div>
        </x-slot>
        <x-slot name="footer">
            <x-jet-secondary-button wire:click="cancelar">CANCELAR</x-jet-secondary-button>
            <button  class='inline-flex items-center px-4 py-2 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 active:bg-gray-900 focus:outline-none focus:border-gray-900 focus:ring focus:ring-gray-300 disabled:opacity-25 transition' wire:click.prevent="guardar">GUARDAR</button>
        </x-slot>
    </x-jet-dialog-modal>
</div>