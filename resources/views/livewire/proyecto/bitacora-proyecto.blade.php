<div>
    <div class="w-full text-base flex flex-col justify-center text-center">
        <div class="w-full px-2">
            <i class="text-indigo-400 fas fa-book" wire:click='cargar' style="cursor: pointer;"></i>
        </div>
        <div class="text-xs w-full">
            
        </div>
    </div>

    <x-jet-dialog-modal wire:model="open" maxWidth="2xl">
        <x-slot name="title">
            Nueva Bitacora
        </x-slot>
        <x-slot name="content">
            <div class="flex flex-col w-full pb-6">
                <div class="w-full text-xl font-bold">{!!$prospecto!!}</div>
                <div class="w-full text-sm pb-3 font-bold">Proyecto: {!!$nombre!!}</div>
                <div class="w-full text-sm font-bold">Horas presupuesto: {!!$presupuesto!!}</div>
                <div class="w-full text-sm font-bold">Horas devengadas: {!!$devengadas!!}</div>
                <div class="w-full text-sm font-bold">Horas disponibles: {!!$disponibles!!}</div>
                <div class="w-full pt-2">
                    <x-jet-label value="Consultor" />
                    <select wire:model.defer="consultor" class="w-full text-sm border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm">
                            <option value=""></option>
                            @foreach($consultores as $registro)
                                <option value="{{$registro->id}}">{{$registro->name}}</option>
                            @endforeach
                        </select>
                    @error('consultor') <span class="text-xs text-red-400">{{ $message }}</span> @enderror
                </div>
                <div class="w-full pt-2">
                    <x-jet-label value="Horas" />
                    <x-jet-input class="w-full text-xs" wire:model.defer="horas" type="text" />
                    @error('horas') <span class="text-xs text-red-400">{{ $message }}</span> @enderror    
                </div>
                <div class="w-full pt-2 flex flex-row space-x-3">
                    <div class="w-1/2">
                        <div class="w-full">
                            <x-jet-label value="Actividad" />
                            <x-jet-input class="w-full text-xs" wire:model.defer="actividad" type="text" />
                            @error('actividad') <span class="text-xs text-red-400">{{ $message }}</span> @enderror            
                        </div>
                    </div>
                    <div class="w-1/2">
                        <div class="w-full">
                            <x-jet-label value="Tipo de Actividad" />
                            <select wire:model.defer="tipo_actividad" class="w-full text-sm border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm">
                                <option value=""></option>
                                @foreach($tipos as $registro)
                                    <option value="{{$registro->id}}">{{$registro->nombre}}</option>
                                @endforeach
                            </select>
                            @error('tipo_actividad') <span class="text-xs text-red-400">{{ $message }}</span> @enderror            
                        </div>
                    </div>
                </div>
                <div class="w-full flex flex-col pt-4">
                    <div class="bg-gray-700 w-full text-gray-100 p-2 rounded text-base">Bitacoras de actividades</div>
                    <div class="w-full">
                        <table class="w-full flex flex1 flex-1">
                            <tr class="text-xs bg-lime-100 font-bold">
                                <td class="px-2 py-1">Consultor</td>
                                <td class="px-2 py-1">Actividad</td>
                                <td class="px-2 py-1">Tipo Actividad</td>
                                <td class="px-2 py-1">Horas</td>
                                <td class="px-2 py-1">Usuario Carga</td>
                                <td class="px-2 py-1">Fecha Carga</td>
                            </tr>
                            @foreach($bitacoras as $registro)
                            <tr class="text-xs pt-2 border-b font-thin">
                                <td class="px-2 py-1">{{$registro->consultor->name}}</td>
                                <td class="px-2 py-1">{{$registro->actividad}}</td>
                                <td class="px-2 py-1">{{$registro->tipo->nombre}}</td>
                                <td class="px-2 py-1">{{$registro->horas}}</td>
                                <td class="px-2 py-1">{{$registro->carga->name}}</td>
                                <td class="px-2 py-1">{{$registro->created_at}}</td>
                            </tr>
                            @endforeach
                        </table>
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