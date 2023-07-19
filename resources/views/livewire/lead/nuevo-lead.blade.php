<div>
    <x-slot name="header">
        {{ __('Nuevo Lead') }}
    </x-slot>
    <div class="w-full flex flex-col px-5">
        <div class="w-full">
            <x-jet-section-title>
                <x-slot name="title">Nuevo Lead</x-slot>
                <x-slot name="description">Permite generar todos los datos necesarios para el registro de un nuevo LEAD</x-slot>
            </x-jet-section-title>
        </div>
    </div>
    <div class="p-10 flex flex-col w-full text-gray-700  px-2 md:px-8">
        <div class="w-full rounded-t-lg bg-slate-300 p-3 flex flex-col border-b border-gray-800"> <!--ENCABEZADO-->
            <div class="w-full text-lg font-semibold">Generar nuevo lead</div>
            <div class="w-full text-sm">({{Auth::user()->usuario}}) - {{Auth::user()->name}}</div>            
            <div class="w-full text-sm">{{App\Models\User::with('compania_desc')->find(Auth::user()->id)->compania_desc->nombre}}</div>            
        </div> <!--FIN ENCABEZADO-->
        <div class="w-full p-3 flex flex-col bg-white"> <!--CONTENIDO-->
            <div class="w-full flex flex-row space-x-2">
                <div class="w-full flex flex-row pb-2">
                    <div class="w-4/12">
                        <span class="text-xs text-ttds">Buscar Empresa (Nombre, RFC)</span><br>
                        <input class="w-full rounded p-1 border border-gray-300 bg-white" wire:model="buscar_empresa"> 
                    </div>
                    <div class="w-5/12 pl-3">
                        <x-jet-label value="Seleccione" />                    
                        <select name="empresa" wire:model="empresa" class="w-full text-xs border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded shadow-sm">
                            <option></option>
                        @foreach ($opcion_empresa as $emp)
                            <option value="{{$emp->id}}">{{$emp->razon_social}}</option>    
                        @endforeach
                        </select> 
                        @error('empresa') <span class="text-xs text-red-400">{{ $message }}</span> @enderror    
                    </div>
                    <div class="flex items-center justify-center px-6">
                     @livewire('prospecto.nuevo-prospecto')              
                    </div>
                </div>                
            </div>
            @if($ver_contacto==1)
            <div class="w-full flex flex-row space-x-2 pb-3">
                <div class="w-full flex flex-row">
                    <div class="w-4/12">
                        <span class="text-xs text-ttds">Buscar Contacto</span><br>
                        <input class="w-full rounded p-1 border border-gray-300 bg-white" wire:model="buscar_contacto"> 
                    </div>
                    <div class="w-5/12 pl-3">
                        <x-jet-label value="Seleccione" />                    
                        <select name="contacto" wire:model="contacto" class="w-full text-xs border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded shadow-sm">
                            <option></option>
                        @foreach ($opcion_contacto as $con)
                            <option value="{{$con->id}}">{{$con->nombre}} ( {{$con->posicion}} - {{$con->area}} )</option>    
                        @endforeach
                        </select> 
                        @error('contacto') <span class="text-xs text-red-400">{{ $message }}</span> @enderror    
                    </div>
                    <div class="flex items-center justify-center px-6">
                     @livewire('contacto.nuevo-contacto')              
                    </div>
                </div>                
            </div>
            @endif
            <div class="border-t py-2 border-b">
                <span class="text-red-700 font-bold">Datos del Lead</span>
            </div>
            <div class="w-full flex flex-row space-x-2 py-3">
                <div class="w-full flex flex-row space-x-3">
                    <div class="w-full">
                        <x-jet-label value="Compañia" />                    
                        <select name="compañia" wire:model.defer="compañia" class="w-full text-xs border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded shadow-sm">
                            <option></option>
                        @foreach ($compañias as $comp)
                            <option value="{{$comp->id}}">{{$comp->nombre}}</option>    
                        @endforeach
                        </select> 
                        @error('compañia') <span class="text-xs text-red-400">{{ $message }}</span> @enderror                        
                    </div>
                </div>                
            </div>
            <div class="w-full flex flex-row space-x-2 py-3">
                <div class="w-full flex flex-row space-x-3">
                    <div class="w-1/3">
                        <x-jet-label value="Fecha contacto" />                    
                        <input  type="date" class="w-full rounded p-1 border border-gray-300 bg-white" wire:model="fecha_contacto"> 
                        @error('fecha_contacto') <span class="text-xs text-red-400">{{ $message }}</span> @enderror    
                    </div>
                    <div class="w-1/3">
                        <x-jet-label value="Linea de negocio" />                    
                        <select name="linea_negocio" wire:model.defer="linea_negocio" class="w-full text-xs border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded shadow-sm">
                            <option></option>
                        @foreach ($lineas_negocio as $lin)
                            <option value="{{$lin->id}}">{{$lin->nombre}}</option>    
                        @endforeach
                        </select> 
                        @error('linea_negocio') <span class="text-xs text-red-400">{{ $message }}</span> @enderror    
                    </div>
                    <div class="w-1/3">
                        <x-jet-label value="Servicio" />                    
                        <select name="servicio" wire:model.defer="servicio" class="w-full text-xs border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded shadow-sm">
                            <option></option>
                        @foreach ($servicios as $serv)
                            <option value="{{$serv->id}}">{{$serv->nombre}}</option>    
                        @endforeach
                        </select> 
                        @error('servicio') <span class="text-xs text-red-400">{{ $message }}</span> @enderror    
                        
                    </div>
                </div>                
            </div>
            <div class="w-full flex flex-row space-x-2 py-3">
                <div class="w-full flex flex-row space-x-3">
                    <div class="w-1/3">
                        <span class="text-xs text-ttds">Oportunidad</span><br>
                        <input wire:model="oportunidad" class="w-full rounded p-1 border border-gray-300 bg-white"> 
                        @error('oportunidad') <span class="text-xs text-red-400">{{ $message }}</span> @enderror    
                    </div>
                    <div class="w-1/3">
                        <span class="text-xs text-ttds">Partner/Fabricante</span><br>
                        <input wire:model="partner" class="w-full rounded p-1 border border-gray-300 bg-white"> 
                        @error('partner') <span class="text-xs text-red-400">{{ $message }}</span> @enderror    
                    </div>
                    <div class="w-1/3">
                        <span class="text-xs text-ttds">Producto</span><br>
                        <input wire:model="producto" class="w-full rounded p-1 border border-gray-300 bg-white"> 
                        @error('producto') <span class="text-xs text-red-400">{{ $message }}</span> @enderror    
                    </div>
                </div>                
            </div>
            <div class="w-full flex flex-row space-x-2 py-3">
                <div class="w-full flex flex-row space-x-3">
                    <div class="w-1/3">
                        <span class="text-xs text-ttds">Etapa</span><br>
                        <select wire:model="etapa" class="w-full rounded p-1 border border-gray-300 bg-white"> 
                            <option value=""></option>
                            <option value="1">Contacto</option>
                        </select>
                    </div>
                    <div class="w-1/3">
                        <x-jet-label value="Origen de Lead" />                    
                        <select name="fuente" wire:model.defer="fuente" class="w-full text-xs border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded shadow-sm">
                            <option></option>
                        @foreach ($fuentes as $fue)
                            <option value="{{$fue->id}}">{{$fue->nombre}}</option>    
                        @endforeach
                        </select> 
                        @error('fuente') <span class="text-xs text-red-400">{{ $message }}</span> @enderror    
                    </div>
                    <div class="w-1/3">
                        <span class="text-xs text-ttds">Comentarios</span><br>
                        <input wire:model="comentarios" class="w-full rounded p-1 border border-gray-300 bg-white"> 
                    </div>

                </div>                
            </div>
        </div> <!--FIN CONTENIDO-->
        <div class="w-full flex justify-center py-4 shadow-lg bg-lime-100">
            <button wire:click="guardar" class="inline-flex items-center px-4 py-2 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 active:bg-gray-900 focus:outline-none focus:border-gray-900 focus:ring focus:ring-gray-300 disabled:opacity-25 transition'">GUARDAR</button>
        </div>
    </div>
</div>
