<div class="w-full bg-gray-200 flex flex-row border-b border-gray-400 shaddow">
    <div class="p-3 flex items-center">
        <i class="text-4xl text-amber-500 fas fa-file-invoice"></i>
        <span class="ml-5 font-semibold text-gray-600 text-2xl">ACTIVIDADES</span>
    </div>
    <div class="border-l-4 border-gray-300 flex items-center px-5 text-gray-600 {{request()->routeIs('tickets')?'bg-blue-200':''}}">
        <a href="{{route('tickets')}}">Tablero</a>
    </div>
    @if(Auth::user()->area!="5")
    <div class="border-l-4 border-gray-300 flex items-center px-5 text-gray-600 {{request()->routeIs('tickets_abiertos')?'bg-blue-200':''}}">
        <a href="{{route('tickets_abiertos')}}">Actividades Abiertas</a>
    </div>
    <div class="border-l-4 border-gray-300 flex items-center px-5 text-gray-600 {{request()->routeIs('tickets_cerrados')?'bg-blue-200':''}}">
        <a href="{{route('tickets_cerrados')}}">Actividades Cerradas</a>
    </div>
    <div class="border-l-4 border-gray-300 flex items-center px-5 text-gray-600 {{request()->routeIs('reportes')?'bg-blue-200':''}}">
        <a href="{{route('reportes')}}">Reportes</a>
    </div>
    @endif
    <div class="flex-1 justify-end border-l-4 border-r-4 border-gray-300 flex items-center px-5 text-gray-600">
        @livewire('ticket.nuevo-ticket')
    </div>
</div>