<div>
    <div class="w-full text-base flex flex-col justify-center text-center">
        <div class="w-full px-2">
            <i class="text-indigo-400 fas fa-folder-open" wire:click='cargar' style="cursor: pointer;"></i>
        </div>
    </div>

    <x-jet-dialog-modal wire:model="open" maxWidth="5xl">
        <x-slot name="title">
            Documentacion de Cliente
        </x-slot>
        <x-slot name="content">
            <div class="flex flex-col w-full pb-6">
                <div class="w-full text-xl font-bold pb-3">{!!$prospecto!!}</div>
                <div class="w-full text-sm bg-gray-700 text-gray-100 px-3 py-1 rounded">Nuevo Documento</div>                
                <form action="{{route('nuevo_doc_cliente')}}" method="POST" enctype="multipart/form-data" id="nuevo_doc_cliente">
                @csrf
                <input type="hidden" name="id_prospecto" value="{{$id_prospecto}}">
                <div class="w-full pt-2 flex flex-row space-x-5 pb-2">
                    <div class="w-1/4">
                        <x-jet-label value="Tipo" />
                        <select wire:model="tipo" name="tipo" class="w-full text-xs border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm">    
                            <option value=""></option>
                            <option value="SITUACION_FISCAL">SITUACION FISCAL</option>
                            <option value="NDA">NDA</option>
                            <option value="CONTRATO_MARCO">CONTRATO MARCO</option>
                        </select>
                        @error('tipo') <span class="text-xs text-red-400">{{ $message }}</span> @enderror
                    </div>
                    <div class="w-1/4">
                        <x-jet-label value="Vigencia" />
                        <x-jet-input class="w-full text-xs" type="date" name='vigencia' wire:model='vigencia'/>
                        @error('vigencia') <span class="text-xs text-red-400">{{ $message }}</span> @enderror
                    </div>
                    <div class="w-1/2 pb-3">
                        <x-jet-label value="Archivo" />
                        <input class="w-full text-xs py-2" type="file" name="archivo" wire:change="archivo_seleccionado($event.target.value)"/>                        
                        <input type="hidden" wire:model="archivo_valor" />
                        <input type='file' name='archivo2'>
                        @error('archivo_valor') <span class="text-xs text-red-400">{{ $message }}</span> @enderror
                    </div>
                </div>
                <div class="w-full px-3 py-1 rounded flex justify-center pb-3">
                    <button {{$procesando==1?'disabled':''}} class='inline-flex items-center px-4 py-2 bg-green-400 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-green-700 active:bg-green-900 focus:outline-none focus:border-gray-900 focus:ring focus:ring-gray-300 disabled:opacity-25 transition' wire:click.prevent="guardar">GUARDAR</button>
                </div>
                </form>
                <div class="w-full text-sm bg-gray-700 text-gray-100 px-3 py-1 rounded">Bitacora de documentos</div>
                
                <div class="w-full px-5 flex flex-col pt-2">
                    @php
                    $tipo_actual="";    
                    @endphp
                    @foreach($historico as $registro)
                        @if($tipo_actual!=$registro->tipo)
                        <div class="w-full rounded bg-blue-400 py-1 px-3 text-white font-bold">{{$registro->tipo}}</div>
                        <div class="w-full flex flex-row font-bold">
                            <div class="w-1/4 flex justify-center py-2 px-1">Vigencia</div>
                            <div class="w-1/4 flex justify-center py-2 px-1">Fecha Carga</div>
                            <div class="w-1/4 flex justify-center py-2 px-1">Usuario</div>
                            <div class="w-1/4 flex justify-center py-2 px-1">Documento</div>
                        </div> 
                        @endif
                        <div class="w-full flex flex-row pb-1">
                            <div class="w-1/4 flex justify-center">{{$registro->vigencia}}</div>
                            <div class="w-1/4 flex justify-center">{{$registro->created_at}}</div>
                            <div class="w-1/4 flex justify-center">{{$registro->user->name}}</div>
                            <div class="w-1/4 flex justify-center"><a target="_blank" href="/archivos/{{$registro->documento}}"><i class="text-red-400 font-bold text-xl fas fa-download"></i></a></div>
                        </div>    
                            
                        @php
                         $tipo_actual=$registro->tipo;
                        @endphp
                    @endforeach
                </div>
                
            </div>
        </x-slot>
        <x-slot name="footer">
            <x-jet-secondary-button wire:click="cancelar">CANCELAR</x-jet-secondary-button>&nbsp;&nbsp;
        </x-slot>
    </x-jet-dialog-modal>
</div>