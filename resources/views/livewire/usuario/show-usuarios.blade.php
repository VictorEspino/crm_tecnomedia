<div>
    <x-slot name="header">
        {{ __('Usuarios') }}
    </x-slot>
    <div class="w-full flex flex-col px-5">
        <div class="w-full">
            <x-jet-section-title>
                <x-slot name="title">Administracion Usuarios</x-slot>
                <x-slot name="description">Permite visualizar y dar mantenimiento a los usuarios del sistema</x-slot>
            </x-jet-section-title>
        </div>
    </div>
    <div class="w-full px-5 pt-6">
        <div class="w-full flex items-center text-sm text-gray-600">
            <div class="px-5">
                <span>Mostrar </span>
                <select wire:model="elementos" class="text-sm border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm">
                    <option value=5>5</option>
                    <option value=10>10</option>
                    <option value=20>20</option>
                    <option value=30>30</option>
                    <option value=50>50</option>
                </select>  
                <span> registros</span> 
            </div>
            <div class="flex flex-1 px-5">
                <x-jet-input class="flex-1 text-sm mr-5" type="text"  wire:model="filtro" placeholder="¿Que desea buscar?"/>
                @livewire('usuario.nuevo-usuario')
            </div>
            
        </div>
    </div>
    <div class="w-full px-5 pt-6">
        {{$users->links()}}
    </div>
    <div class="w-full flex flex-col space-y-3 py-5 px-5">
        @php
        $registros=0;   
        @endphp
        @foreach ($users as $user_listado)
            @php
            $registros=$registros+1;   
            @endphp
            <div class="w-full flex flex-row bg-white rounded-lg shadow-lg p-3 border border-blue-200">
                <div class="w-1/3 text-gray-700 font-semibold text-xl px-3">{{$user_listado->name}}<br/><span class="text-xs">({{$user_listado->user}})</span></div>
                <div class="w-1/6 text-gray-700 text-xs px-2">{{$user_listado->puesto_desc->puesto}}</div>
                <div class="w-1/6 text-gray-700 text-xs px-2">Compania: {{$user_listado->compania_desc->nombre}}</div>
                <div class="w-1/6 text-gray-700 text-3xl flex justify-center flex flex-col text-center">
                    @if($user_listado->estatus=="1")
                        <i class="text-green-600 fas fa-check-circle"></i>
                        <span class="text-xs">Activo</span>
                    @else
                        <i class="text-red-400 fas fa-times-circle"></i>
                        <span class="text-xs">Inactivo</span>
                    @endif
                </div>
                <div class="w-1/6">
                    @livewire('usuario.update-usuario',['id_user'=>$user_listado->id,key($user_listado->id)])
                </div>
            </div>
        @endforeach
        @if($registros==0)
            No se encontraron registros
        @endif
    </div>
</div>