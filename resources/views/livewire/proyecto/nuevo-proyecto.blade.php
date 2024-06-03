<div> 
    <div class="w-full text-base flex flex-col justify-center text-center">
        <div class="w-full px-2">
            <i class="text-indigo-400 fas fa-plus-circle" wire:click='cargar' style="cursor: pointer;"></i>
        </div>
        <div class="text-xs w-full">
            
        </div>
    </div>

    <x-jet-dialog-modal wire:model="open" maxWidth="7xl">
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
                            <select wire:model="tipo_proyecto" wire:change="aplica_tipo()" class="w-full text-sm border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm">
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
                <div class="w-full pt-2 {{$tipo_proyecto==2?'pb-5':''}}">
                    <x-jet-label value="Responsable proyecto" />
                    <select wire:model.defer="responsable" class="w-full text-sm border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm">
                            <option value=""></option>
                            @foreach($responsables as $registro)
                                <option value="{{$registro->id}}">{{$registro->name}}</option>
                            @endforeach
                        </select>
                    @error('responsable') <span class="text-xs text-red-400">{{ $message }}</span> @enderror
                </div>
                @if($tipo_proyecto!=2)
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
                @endif
                @if($tipo_proyecto==2)
                <div class="w-full bg-gray-300 px-5 flex flex-row">
                    <div class="w-1/6 flex items-center justify-center">
                        <i class="text-2xl text-green-500 fas fa-plus" style="cursor: pointer" wire:click="agregar_seccion" cursor></i>
                    </div>
                    <div class="w-5/6">
                        <x-jet-label class="text-blue-400 text-base font-italic" value="<---- Agregue una seccion para agrupar vigencias" />
                    </div>                    
                </div>
                    @foreach($secciones as $index=>$seccion)

                <div class="w-full">
                    <div class="w-full text-blue-400 bg-gray-200 p-2 flex flex-row space-x-3">
                        <div class="w-1/12 flex justify-center">
                            <i class="fas fa-minus-circle text-red-400 text-2xl" style="cursor:pointer" wire:click='eliminar_seccion({{$index}})'></i>
                        </div>                    
                        <div class="w-5/12">
                            <x-jet-label value="Descripcion" />
                            <x-jet-input class="p-2 w-full text-gray-700" wire:model='secciones.{{$index}}.nombre'/>
                            @error('secciones.'.$index.'.nombre') <span class="text-xs text-red-400">{{ $message }}</span> @enderror
                        </div>
                        <div class="w-2/12">
                            <x-jet-label value="Inicio Vigencia" />
                            <x-jet-input class="p-2 w-full text-xs text-gray-700" wire:model='secciones.{{$index}}.f_inicio' type="date"/>
                            @error('secciones.'.$index.'.f_inicio') <span class="text-xs text-red-400">{{ $message }}</span> @enderror
                        </div>
                        <div class="w-2/12">
                            <x-jet-label value="Fin Vigencia" />
                            <x-jet-input class="p-2 w-full text-xs text-gray-700" wire:model='secciones.{{$index}}.f_fin' type="date"/>
                            @error('secciones.'.$index.'.f_fin') <span class="text-xs text-red-400">{{ $message }}</span> @enderror
                        </div>
                        <div class="w-1/6 flex items-center justify-center">
                            <i class="text-2xl text-green-500 fas fa-plus" style="cursor: pointer" wire:click="agregar_item({{$index}})" cursor></i>
                            &nbsp;&nbsp;&nbsp;<---Nuevo Item
                        </div>
                    </div>
                    <div class="flex flex-row bg-green-200 font-bold w-full">
                        <div class="w-full flex flex-row">
                            <div class="w-1/12 flex justify-center">Tipo
                            </div>
                            <div class="w-4/12 flex justify-center">Descripcion
                            </div>
                            <div class="w-2/12 flex justify-center">Mayorista
                            </div>
                            <div class="w-1/12 flex justify-center">Cantidad
                            </div>   
                            <div class="w-1/12 flex justify-center">Unitario
                            </div>    
                            <div class="w-1/12 flex justify-center">Total
                            </div> 
                            <div class="w-1/12 flex justify-center bg-red-300">Costo Unitario
                            </div>    
                            <div class="w-1/12 flex justify-center bg-red-300">Costo Total
                            </div> 
                        </div>                        
                    </div>
                    @foreach($secciones[$index]['items'] as $index2=>$item)
                    <div class="flex flex-row w-full">
                        <div class="w-full flex flex-row">
                            <div class="pt-1 px-1 w-1/12">
                                <select wire:model="secciones.{{$index}}.items.{{$index2}}.tipo" class="py-1 px-2 w-full text-xs border-gray-100 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded shadow-sm">
                                    <option value=""></option>                                   
                                    <option value="On Premise">On Premise</option>                                   
                                    <option value="Suscripcion">Suscripcion</option>                                   
                                    <option value="Perpetuas">Perpetuas</option>                                   
                                </select>
                                @error('secciones.'.$index.'.items.'.$index2.'.tipo') <span class="text-xs text-red-400">{{ $message }}</span> @enderror
                            </div>
                            <div class="pt-1 px-1 w-4/12">
                                <x-jet-input class="pt-1 px-2 w-full" wire:model="secciones.{{$index}}.items.{{$index2}}.descripcion"/>
                                @error('secciones.'.$index.'.items.'.$index2.'.descripcion') <span class="text-xs text-red-400">{{ $message }}</span> @enderror
                            </div>
                            <div class="pt-1 px-1 w-2/12">
                                <select wire:model="secciones.{{$index}}.items.{{$index2}}.partner" class="py-1 px-2 w-full text-xs border-gray-100 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded shadow-sm">
                                    <option value=""></option>
                                    @foreach($partners as $opcion)
                                    <option value="{{$opcion->id}}">{{$opcion->nombre}}</option>
                                    @endforeach
                                </select>
                                @error('secciones.'.$index.'.items.'.$index2.'.partner') <span class="text-xs text-red-400">{{ $message }}</span> @enderror
                            </div>
                            <div class="pt-1 px-1 w-1/12">
                                <x-jet-input class="pt-1 px-2 w-full" wire:model="secciones.{{$index}}.items.{{$index2}}.cantidad" wire:change="actualiza_item({{$index}},{{$index2}})"/>
                                @error('secciones.'.$index.'.items.'.$index2.'.cantidad') <span class="text-xs text-red-400">{{ $message }}</span> @enderror
                            </div>  
                            <div class="pt-1 px-1 w-1/12">
                                <x-jet-input class="pt-1 px-2 w-full" wire:model="secciones.{{$index}}.items.{{$index2}}.unitario_cliente" wire:change="actualiza_item({{$index}},{{$index2}})"/>
                                @error('secciones.'.$index.'.items.'.$index2.'.unitario_cliente') <span class="text-xs text-red-400">{{ $message }}</span> @enderror
                            </div>  
                            <div class="pt-1 px-1 w-1/12">
                                <x-jet-input class="pt-1 px-2 w-full" wire:model="secciones.{{$index}}.items.{{$index2}}.total_cliente" wire:change="actualiza_item({{$index}},{{$index2}})"/>
                                @error('secciones.'.$index.'.items.'.$index2.'.total_cliente') <span class="text-xs text-red-400">{{ $message }}</span> @enderror
                            </div>
                            <div class="pt-1 px-1 w-1/12">
                                <x-jet-input class="pt-1 px-2 w-full" wire:model="secciones.{{$index}}.items.{{$index2}}.unitario_tecnomedia" wire:change="actualiza_item({{$index}},{{$index2}})"/>
                                @error('secciones.'.$index.'.items.'.$index2.'.unitario_tecnomedia') <span class="text-xs text-red-400">{{ $message }}</span> @enderror
                            </div>  
                            <div class="pt-1 px-1 w-1/12">
                                <x-jet-input class="pt-1 px-2 w-full" wire:model="secciones.{{$index}}.items.{{$index2}}.total_tecnomedia" wire:change="actualiza_item({{$index}},{{$index2}})"/>
                                @error('secciones.'.$index.'.items.'.$index2.'.total_tecnomedia') <span class="text-xs text-red-400">{{ $message }}</span> @enderror
                            </div>  
                        </div>                        
                    </div>
                    @endforeach
                    <div class="flex flex-row bg-blue-200 font-bold">
                        <div class="w-full flex justify-end px-10">
                            Total
                        </div>
                    </div>
                </div>
                    @endforeach
                @endif
            </div>
        </x-slot>
        <x-slot name="footer">
            <x-jet-secondary-button wire:click="cancelar">CANCELAR</x-jet-secondary-button>&nbsp;&nbsp;
            <button {{$procesando==1?'disabled':''}} class='inline-flex items-center px-4 py-2 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 active:bg-gray-900 focus:outline-none focus:border-gray-900 focus:ring focus:ring-gray-300 disabled:opacity-25 transition' wire:click.prevent="guardar">GUARDAR</button>&nbsp;&nbsp;
        </x-slot>
    </x-jet-dialog-modal>
</div>