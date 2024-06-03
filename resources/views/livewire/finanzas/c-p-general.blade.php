<div>
    <x-slot name="header">  
        {{ __('Cuentas por Pagar') }}
    </x-slot>
    <div class="w-full px-5 pt-2 pb-5">
        <div>Proveedor</div>
        <select wire:model.defer="filtro_proveedor" class="text-sm border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm">
                <option value="0">Todos</option>
                @foreach($proveedores as $opcion)
                <option value="{{$opcion->id}}">{{$opcion->nombre}}</option>
                @endforeach
        </select>
        <x-jet-button class="text-xs" wire:click="nada">Buscar</x-jet-button>
    </div>

    <div class="w-full text-xl font-bold bg-orange-300 px-5 rounded-lg shadow-lg">Facturas Vencidas</div>
    <div class="w-full text-xs flex flex-col pt-5 pb-5">
        <div class="w-full flex flex-row">
            <div class="w-1/6 border border-gray-700 px-2 bg-gray-400 text-white">Proyecto</div>
            <div class="w-1/6 border border-gray-700 px-2 bg-gray-400 text-white">Emisor</div>
            <div class="w-1/6 border border-gray-700 px-2 bg-gray-400 text-white">Folio</div>
            <div class="w-1/6 border border-gray-700 px-2 bg-gray-400 text-white">Cantidad</div>
            <div class="w-1/6 border border-gray-700 px-2 bg-gray-400 text-white">Emision</div>
            <div class="w-1/6 border border-gray-700 px-2 bg-gray-400 text-white">Terminos</div>
            <div class="w-1/6 border border-gray-700 px-2 bg-gray-400 text-white">Vencimiento</div>
            <div class="w-1/6 border border-gray-700 px-2 bg-gray-400 text-white">Notas</div>
            <div class="w-1/6 border border-gray-700 px-2 bg-gray-400 text-white">Saldo</div>
        </div>
        @php
            $total=0;
        @endphp
        @foreach($facturas_vencidas as $doc)
        <div class="w-full flex flex-row">
            <div class="w-1/6 border border-gray-700 px-2 bg-white text-gray-700">{{$doc->proyecto->nombre}}</div>
            <div class="w-1/6 border border-gray-700 px-2 bg-white text-gray-700">{{$doc->partner->nombre}}</div>
            <div class="w-1/6 border border-gray-700 px-2 bg-white text-gray-700">{{$doc->folio_cfdi}}</div>
            <div class="w-1/6 border border-gray-700 px-2 bg-white text-gray-700">${{number_format($doc->cantidad,2)}} ({{$doc->moneda_documento->nombre}})</div>
            <div class="w-1/6 border border-gray-700 px-2 bg-white text-gray-700">{{$doc->fecha_emision}}</div>
            <div class="w-1/6 border border-gray-700 px-2 bg-white text-gray-700">{{$doc->dias_pago}}</div>
            <div class="w-1/6 border border-gray-700 px-2 bg-white text-gray-700">{{$doc->fecha_vencimiento}}</div>
            <div class="w-1/6 border border-gray-700 px-2 bg-white text-gray-700">{{$doc->notas}}</div>
            <div class="w-1/6 border border-gray-700 px-2 bg-white text-gray-700">${{number_format($doc->saldo,0)}} ({{$doc->moneda_documento->nombre}})</div>
        </div>
        @php
            $total=$total+$doc->cantidad;
        @endphp
        @endforeach
        <div class="w-full flex flex-row">
            <div class="w-1/6 border border-gray-700 px-2 bg-gray-700 text-gray-100"></div>
            <div class="w-1/6 border border-gray-700 px-2 bg-gray-700 text-gray-100"></div>
            <div class="w-1/6 border border-gray-700 px-2 bg-gray-700 text-gray-100">TOTAL</div>
            <div class="w-1/6 border border-gray-700 px-2 bg-gray-700 text-gray-100">${{number_format($total,2)}}</div>
            <div class="w-1/6 border border-gray-700 px-2 bg-gray-700 text-gray-100"></div>
            <div class="w-1/6 border border-gray-700 px-2 bg-gray-700 text-gray-100"></div>
            <div class="w-1/6 border border-gray-700 px-2 bg-gray-700 text-gray-100"></div>
            <div class="w-1/6 border border-gray-700 px-2 bg-gray-700 text-gray-100"></div>
            <div class="w-1/6 border border-gray-700 px-2 bg-gray-700 text-gray-100"></div>
        </div>
    </div>
    <div class="w-full text-xl font-bold bg-green-300 px-5 rounded-lg shadow-lg">Facturas Vigentes</div>
    <div class="w-full text-xs flex flex-col pt-5 pb-5">
        <div class="w-full flex flex-row">
            <div class="w-1/6 border border-gray-700 px-2 bg-gray-400 text-white">Proyecto</div>
            <div class="w-1/6 border border-gray-700 px-2 bg-gray-400 text-white">Emisor</div>
            <div class="w-1/6 border border-gray-700 px-2 bg-gray-400 text-white">Folio</div>
            <div class="w-1/6 border border-gray-700 px-2 bg-gray-400 text-white">Cantidad</div>
            <div class="w-1/6 border border-gray-700 px-2 bg-gray-400 text-white">Emision</div>
            <div class="w-1/6 border border-gray-700 px-2 bg-gray-400 text-white">Terminos</div>
            <div class="w-1/6 border border-gray-700 px-2 bg-gray-400 text-white">Vencimiento</div>
            <div class="w-1/6 border border-gray-700 px-2 bg-gray-400 text-white">Notas</div>
            <div class="w-1/6 border border-gray-700 px-2 bg-gray-400 text-white">Saldo</div>
        </div>
        @php
            $total=0;
        @endphp
        @foreach($facturas_vigentes as $doc)
        <div class="w-full flex flex-row">
            <div class="w-1/6 border border-gray-700 px-2 bg-white text-gray-700">{{$doc->proyecto->nombre}}</div>
            <div class="w-1/6 border border-gray-700 px-2 bg-white text-gray-700">{{$doc->partner->nombre}}</div>
            <div class="w-1/6 border border-gray-700 px-2 bg-white text-gray-700">{{$doc->folio_cfdi}}</div>
            <div class="w-1/6 border border-gray-700 px-2 bg-white text-gray-700">${{number_format($doc->cantidad,2)}} ({{$doc->moneda_documento->nombre}})</div>
            <div class="w-1/6 border border-gray-700 px-2 bg-white text-gray-700">{{$doc->fecha_emision}}</div>
            <div class="w-1/6 border border-gray-700 px-2 bg-white text-gray-700">{{$doc->dias_pago}}</div>
            <div class="w-1/6 border border-gray-700 px-2 bg-white text-gray-700">{{$doc->fecha_vencimiento}}</div>
            <div class="w-1/6 border border-gray-700 px-2 bg-white text-gray-700">{{$doc->notas}}</div>
            <div class="w-1/6 border border-gray-700 px-2 bg-white text-gray-700">${{number_format($doc->saldo,0)}} ({{$doc->moneda_documento->nombre}})</div>
        </div>
        @php
            $total=$total+$doc->cantidad;
        @endphp
        @endforeach
        <div class="w-full flex flex-row">
            <div class="w-1/6 border border-gray-700 px-2 bg-gray-700 text-gray-100"></div>
            <div class="w-1/6 border border-gray-700 px-2 bg-gray-700 text-gray-100"></div>
            <div class="w-1/6 border border-gray-700 px-2 bg-gray-700 text-gray-100">TOTAL</div>
            <div class="w-1/6 border border-gray-700 px-2 bg-gray-700 text-gray-100">${{number_format($total,2)}}</div>
            <div class="w-1/6 border border-gray-700 px-2 bg-gray-700 text-gray-100"></div>
            <div class="w-1/6 border border-gray-700 px-2 bg-gray-700 text-gray-100"></div>
            <div class="w-1/6 border border-gray-700 px-2 bg-gray-700 text-gray-100"></div>
            <div class="w-1/6 border border-gray-700 px-2 bg-gray-700 text-gray-100"></div>
            <div class="w-1/6 border border-gray-700 px-2 bg-gray-700 text-gray-100"></div>
        </div>
    </div>
</div>
