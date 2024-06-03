<div>
    <div class="w-full text-base flex flex-col justify-center text-center">
        <div class="w-full px-2">
            <i class="text-blue-400 fas fa-money-check-alt" wire:click='cargar' style="cursor: pointer;"></i>
        </div>
    </div>

    <x-jet-dialog-modal wire:model="open" maxWidth="5xl">
        <x-slot name="title">
            Documentacion de Ingresos y Costos
        </x-slot>
        <x-slot name="content">
            <div class="flex flex-col w-full pb-6">
                <div class="w-full text-xl font-bold">{!!$prospecto!!}</div>
                <div class="w-full text-base font-bold pb-3">{!!$nombre!!}</div>
                <div class="w-full text-sm bg-gray-700 text-gray-100 px-3 py-1 rounded">Nuevo Documento</div>                
                <form action="{{route('nuevo_doc_proyecto')}}" method="POST" enctype="multipart/form-data" id="nuevo_doc_proyecto">
                @csrf
                <input type="hidden" name="id_proyecto" value="{{$id_proyecto}}">
                <div class="w-full pt-2 flex flex-row space-x-5 pb-2">
                    <div class="w-1/4">
                        <x-jet-label value="Tipo" />
                        <select wire:model.defer="tipo" name="tipo" class="w-full text-xs border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm">    
                            <option value=""></option>
                            <option value="FACTURA_PROVEEDOR">FACTURA PROVEEDOR</option>
                            <option value="FACTURA_CLIENTE">FACTURA CLIENTE</option>
                        </select>
                        @error('tipo') <span class="text-xs text-red-400">{{ $message }}</span> @enderror
                    </div>
                    <div class="w-1/4">
                        <x-jet-label value="Etapa" />
                        <select wire:model.defer="seccion" name="seccion" class="w-full text-xs border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm">    
                            <option value=""></option>
                            @foreach($secciones as $opcion)
                            <option value="{{$opcion->id}}">{{$opcion->nombre}}</option>
                            @endforeach
                        </select>
                        @error('seccion') <span class="text-xs text-red-400">{{ $message }}</span> @enderror
                    </div>
                    <div class="w-1/4">
                        <x-jet-label value="Monto Factura (s/IVA)" />
                        <x-jet-input wire:model.defer="monto" name='monto' type='text'/>
                        @error('monto') <span class="text-xs text-red-400">{{ $message }}</span> @enderror
                    </div>
                    <div class="w-1/4 pb-3">
                        <x-jet-label value="Archivo" />
                        <input class="w-full text-xs py-2" type="file" name='archivo' wire:change="archivo_seleccionado($event.target.value)"/>                        
                        <input type="hidden" wire:model="archivo_valor">
                        @error('archivo_valor') <span class="text-xs text-red-400">{{ $message }}</span> @enderror
                    </div>
                </div>
                <div class="w-full px-3 py-1 rounded flex justify-center pb-3">
                    <button {{$procesando==1?'disabled':''}} class='inline-flex items-center px-4 py-2 bg-green-400 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-green-700 active:bg-green-900 focus:outline-none focus:border-gray-900 focus:ring focus:ring-gray-300 disabled:opacity-25 transition' wire:click.prevent="guardar">GUARDAR</button>
                </div>
                </form>
                <div class="w-full text-sm bg-gray-700 text-gray-100 px-3 py-1 rounded">Bitacora de documentos</div>
                @foreach($secciones as $opcion)
                <div class="w-full text-sm bg-blue-400 text-white px-3 py-1 rounded font-bold">{{$opcion->nombre}}</div>
                <div class="w-full flex flex-row">
                    <div class="w-1/2 flex flex-col">
                        <div class="w-full px-3 py-2 bg-lime-100"><span class="font-bold">Facturas al cliente</span> <br> Total Facturado $7,000 - Faltante por Facturar $1300</div>
                        <div class="w-full px-5 py-1">Documento 1 - $1,000 <i class="text-red-400 font-bold text-xl fas fa-download"></i></div>
                        <div class="w-full px-5 py-1">Documento 2 - $2,000 <i class="text-red-400 font-bold text-xl fas fa-download"></i></div>
                        <div class="w-full px-5 py-1">Documento 3 - $4,000 <i class="text-red-400 font-bold text-xl fas fa-download"></i></div>
                    </div>    
                    <div class="w-1/2 flex flex-col">
                        <div class="w-full px-3 py-2 bg-orange-100"><span class="font-bold">Facturas del mayorista</span> <br> Total Facturado $5,600 - Faltante por Facturar $900</div>
                        <div class="w-full px-5 py-1">Documento 1 - $800 <i class="text-red-400 font-bold text-xl fas fa-download"></i></div>
                        <div class="w-full px-5 py-1">Documento 2 - $1600 <i class="text-red-400 font-bold text-xl fas fa-download"></i></div>
                        <div class="w-full px-5 py-1">Documento 3 - $3200 <i class="text-red-400 font-bold text-xl fas fa-download"></i></div>
                    </div> 
                </div>    
                @endforeach

                
                
                
            </div>
        </x-slot>
        <x-slot name="footer">
            <x-jet-secondary-button wire:click="cancelar">CANCELAR</x-jet-secondary-button>&nbsp;&nbsp;
        </x-slot>
    </x-jet-dialog-modal>
</div>