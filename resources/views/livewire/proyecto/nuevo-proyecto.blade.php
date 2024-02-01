<div> 
    <div class="w-full text-base flex flex-col justify-center text-center">
        <div class="w-full px-2">
            <i class="text-indigo-400 fas fa-plus-circle" wire:click='cargar' style="cursor: pointer;"></i>
        </div>
        <div class="text-xs w-full">
            
        </div>
    </div>

    <x-jet-dialog-modal wire:model="open" maxWidth="2xl">
        <x-slot name="title">
            Nuevo proyecto
        </x-slot>
        <x-slot name="content">
            <div class="flex flex-col w-full pb-6">
                <div class="w-full text-xl pb-3 font-bold">{!!$prospecto!!}</div>
                <div class="w-full pt-2 flex flex-row space-x-3">
                    <div class="w-3/4">
                        <div class="w-full">
                            <x-jet-label value="Nombre Proyecto" />
                            <x-jet-input class="w-full text-xs" wire:model.defer="nombre" type="text" />
                            @error('nombre') <span class="text-xs text-red-400">{{ $message }}</span> @enderror    
                        </div>
                    </div>
                    <div class="w-1/4">
                        <div class="w-full">
                            <x-jet-label value="Tipo" />
                            <select wire:model.defer="tipo_proyecto" class="w-full text-sm border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm">
                                <option value=""></option>
                            @foreach($tipos as $registro)
                                <option value="{{$registro->id}}">{{$registro->nombre}}</option>
                            @endforeach
                            </select>
                            @error('tipo_proyecto') <span class="text-xs text-red-400">{{ $message }}</span> @enderror            
                        </div>
                    </div>
                </div>
                <div class="w-full pt-2">
                    <x-jet-label value="Descripcion proyecto" />
                    <x-jet-input class="w-full text-xs" wire:model.defer="descripcion" type="text" />
                    @error('descripcion') <span class="text-xs text-red-400">{{ $message }}</span> @enderror    
                </div>
                <div class="w-full pt-2">
                    <x-jet-label value="Linea de Negocio" />
                    <select wire:model.defer="negocio" class="w-full text-sm border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm">
                            <option value=""></option>
                            @foreach($negocios as $registro)
                                <option value="{{$registro->id}}">{{$registro->nombre}}</option>
                            @endforeach
                        </select>
                    @error('negocio') <span class="text-xs text-red-400">{{ $message }}</span> @enderror
                </div>
                <div class="w-full pt-2">
                    <x-jet-label value="Responsable proyecto" />
                    <select wire:model.defer="responsable" class="w-full text-sm border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm">
                            <option value=""></option>
                            @foreach($responsables as $registro)
                                <option value="{{$registro->id}}">{{$registro->name}}</option>
                            @endforeach
                        </select>
                    @error('responsable') <span class="text-xs text-red-400">{{ $message }}</span> @enderror
                </div>
                <div class="w-full pt-2">
                    <x-jet-label value="Presupuesto (horas)" />
                    <x-jet-input class="w-full text-xs" wire:model.defer="presupuesto" type="text" />
                    @error('presupuesto') <span class="text-xs text-red-400">{{ $message }}</span> @enderror    
                </div>
                <div class="w-full pt-2 flex flex-row space-x-3">
                    <div class="w-1/2">
                        <div class="w-full">
                            <x-jet-label value="Precio Costo" />
                            <x-jet-input class="w-full text-xs" wire:model.defer="precio_costo" type="text" />
                            @error('precio_costo') <span class="text-xs text-red-400">{{ $message }}</span> @enderror            
                        </div>
                    </div>
                    <div class="w-1/2">
                        <div class="w-full">
                            <x-jet-label value="Precio Venta" />
                            <x-jet-input class="w-full text-xs" wire:model.defer="precio_venta" type="text" />
                            @error('precio_venta') <span class="text-xs text-red-400">{{ $message }}</span> @enderror            
                        </div>
                    </div>
                </div>
                <div class="w-full pt-2 flex flex-row space-x-3">
                    <div class="w-1/2">
                        <div class="w-full">
                            <x-jet-label value="Fecha Inicio" />
                            <x-jet-input class="w-full text-xs" wire:model.defer="fecha_inicio" type="date" />
                            @error('fecha_inicio') <span class="text-xs text-red-400">{{ $message }}</span> @enderror            
                        </div>
                    </div>
                    <div class="w-1/2">
                        <div class="w-full">
                            <x-jet-label value="Fecha Fin" />
                            <x-jet-input class="w-full text-xs" wire:model.defer="fecha_fin" type="date" />
                            @error('fecha_fin') <span class="text-xs text-red-400">{{ $message }}</span> @enderror            
                        </div>
                    </div>
                </div>
            </div>
        </x-slot>
        <x-slot name="footer">
            <x-jet-secondary-button wire:click="cancelar">CANCELAR</x-jet-secondary-button>&nbsp;&nbsp;
            <button {{$procesando==1?'disabled':''}} class='inline-flex items-center px-4 py-2 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 active:bg-gray-900 focus:outline-none focus:border-gray-900 focus:ring focus:ring-gray-300 disabled:opacity-25 transition' wire:click.prevent="guardar">GUARDAR</button>&nbsp;&nbsp;
        </x-slot>
    </x-jet-dialog-modal>
</div>