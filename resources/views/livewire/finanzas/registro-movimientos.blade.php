<div>
    <x-slot name="header">
        {{ __('Finanzas') }}
    </x-slot>

    <div class="w-full flex flex-col">
        <div class="w-full px-10 pt-4 font-bold text-lg">
            {{$prospecto}}
        </div>
        <div class="w-full px-10 py-1 font-bold text-base">
            {{$nombre_proyecto}}
        </div>
        <div class="w-full px-10 pt-1 pb-3 font-bold text-sm">
            {{$linea_negocio}}  ({{$tipo}})
        </div>
        <div class="w-full px-6 py-1 font-bold text-base bg-gray-200">
            Etapas de vigencia
        </div>
    @foreach($secciones as $seccion)
        <div class="w-full flex flex-row space-x-3 text-sm font-bold bg-gray-700 text-white">
            <div class="w-1/2 px-1">{{$seccion->nombre}}</div>
            <div class="w-1/4 px-1">Inicio Vigencia: {{$seccion->f_inicio}}</div>
            <div class="w-1/4 px-1">Fin Vigencia: {{$seccion->f_inicio}}</div>
        </div>
        <div class="w-full flex flex-row space-x-3 text-xs font-bold bg-gray-300 text-gray-700">
            <div class="w-1/12 px-1">Tipo</div>
            <div class="w-3/12 px-1">Descripcion</div>
            <div class="w-2/12 px-1">Mayorista</div>
            <div class="w-1/12 px-1">Cantidad</div>
            
            <div class="w-1/12 px-1">Total Cliente</div>
            
            <div class="w-1/12 px-1">Total Tecnomedia</div>
            <div class="w-1/12 px-1">Margen</div>
        </div>
        @foreach($items_guardados as $item_despliegue)
            @if($item_despliegue->seccion_id==$seccion->id)
            <div class="w-full flex flex-row space-x-3 text-xs font-bold bg-white text-gray-700">
                <div class="w-1/12 px-1 py-1">{{$item_despliegue->tipo}}</div>
                <div class="w-3/12 px-1 py-1">{{$item_despliegue->descripcion}}</div>
                <div class="w-2/12 px-1 py-1">{{$item_despliegue->mayorista->nombre}}</div>
                <div class="w-1/12 px-1 py-1 flex justify-center">{{$item_despliegue->cantidad}}</div>
                
                <div class="w-1/12 px-1 py-1 flex justify-center">${{number_format($item_despliegue->total_cliente,2)}} ({{$seccion->i_tc>1?'USD':'MXP'}})</div>
                
                <div class="w-1/12 px-1 py-1 flex justify-center">${{number_format($item_despliegue->total_tecnomedia,2)}} ({{$seccion->c_tc>1?'USD':'MXP'}})</div>
                <div class="w-1/12 px-1 py-1 flex justify-center">{{100*$item_despliegue->porcentaje_margen}}%</div>
            </div>
            @endif
        @endforeach
        <div class="w-full px-6 pt-1 flex flex-row">
            <div class="w-1/2 flex justify-center items-center px-3 font-bold text-green-700">
                Registrar Factura por Cobrar&nbsp;&nbsp;
                <i class="text-green-400 fas fa-money-check-alt" wire:click='agregar_documento_cliente({{$seccion->id}},{{$seccion->i_tc}})' style="cursor: pointer;"></i>
            </div>
            <div class="w-1/2 flex justify-center items-center px-3 font-bold text-red-500">
                Registrar Factura por Pagar&nbsp;&nbsp;
                <i class="text-red-400 fas fa-money-check-alt" wire:click='agregar_documento_proveedor({{$seccion->id}},"","CP",0)' style="cursor: pointer;"></i>
            </div>
        </div>
        <div class="w-full px-6 pt-1 flex flex-row text-sm">
            <div class="w-1/2 flex justify-center px-3 py-2  text-gray-700">
                <div class="w-full flex flex-col">
                    <div class="w-full flex flex-row">
                        <div class="w-1/4"></div>
                        <div class="w-1/4">Facturado</div>
                        <div class="w-1/4">${{number_format($seccion->i_facturado,2)}}</div>
                    </div>
                    <div class="w-full flex flex-row">
                        <div class="w-1/4"></div>
                        <div class="w-1/4">Pagos recibidos</div>
                        <div class="w-1/4">${{number_format($seccion->i_pagos,2)}}</div>
                    </div>
                    <div class="w-full flex flex-row">
                        <div class="w-1/4"></div>
                        <div class="w-1/4">Notas de credito</div>
                        <div class="w-1/4">${{number_format($seccion->i_nc,2)}}</div>
                    </div>
                    <div class="w-full flex flex-row">
                        <div class="w-1/4"></div>
                        <div class="w-1/4">Pendiente por facturar</div>
                        <div class="w-1/4">${{number_format($seccion->total_ingreso-$seccion->i_facturado,2)}}</div>
                    </div>
                    <div class="w-full text-xs flex flex-col pt-5">
                        <div class="w-full flex flex-row">
                            <div class="w-1/6 border border-gray-700 px-2 bg-gray-400 text-white">Folio</div>
                            <div class="w-1/6 border border-gray-700 px-2 bg-gray-400 text-white">Cantidad</div>
                            <div class="w-1/6 border border-gray-700 px-2 bg-gray-400 text-white">Emision</div>
                            <div class="w-1/6 border border-gray-700 px-2 bg-gray-400 text-white">Terminos</div>
                            <div class="w-1/6 border border-gray-700 px-2 bg-gray-400 text-white">Vencimiento</div>
                            <div class="w-1/6 border border-gray-700 px-2 bg-gray-400 text-white">Saldo</div>
                            <div class="w-1/6 border border-gray-700 px-2 bg-gray-400 text-white">Notas</div>
                            <div class="w-1/12 border border-gray-700 px-2 bg-gray-400 text-white">$</div>
                        </div>
                        @foreach($documentos as $doc)
                        @if($doc->seccion_id==$seccion->id)
                        <div class="w-full flex flex-row">
                            <div class="w-1/6 border border-gray-700 px-2 bg-white text-gray-700">{{$doc->folio_cfdi}}</div>
                            <div class="w-1/6 border border-gray-700 px-2 bg-white text-gray-700">${{number_format($doc->cantidad_si,0)}} ({{$doc->moneda_documento->nombre}})</div>
                            <div class="w-1/6 border border-gray-700 px-2 bg-white text-gray-700">{{$doc->fecha_emision}}</div>
                            <div class="w-1/6 border border-gray-700 px-2 bg-white text-gray-700">{{$doc->dias_pago}}</div>
                            <div class="w-1/6 border border-gray-700 px-2 bg-white text-gray-700">{{$doc->fecha_vencimiento}}</div>
                            <div class="w-1/6 border border-gray-700 px-2 bg-white text-gray-700">${{number_format($doc->saldo,0)}}</div>
                            <div class="w-1/6 border border-gray-700 px-2 bg-white text-gray-700">{{$doc->notas}}</div>
                            <div class="w-1/12 border border-gray-700 px-2 bg-white text-gray-700">
                                @livewire('finanzas.registro-pago-cliente',['id_factura'=>$doc->id,key($doc->id)])
                                @livewire('finanzas.registro-nota-credito-cliente',['id_factura'=>$doc->id,key(5000+$doc->id)])
                            </div>
                        </div>
                        @endif
                        @endforeach
                    </div>
                </div>
            </div>
            <div class="w-1/2 flex justify-center px-3 py-2  text-gray-700">
            <div class="w-full flex flex-col">
                    <div class="w-full flex flex-row">
                        <div class="w-1/4"></div>
                        <div class="w-1/4">Facturas recibidas</div>
                        <div class="w-1/4">${{number_format($seccion->c_facturado,2)}}</div>
                    </div>
                    <div class="w-full flex flex-row">
                        <div class="w-1/4"></div>
                        <div class="w-1/4">Pagos realizados</div>
                        <div class="w-1/4">${{number_format($seccion->c_pagos,2)}}</div>
                    </div>
                    <div class="w-full flex flex-row">
                        <div class="w-1/4"></div>
                        <div class="w-1/4">Notas de credito</div>
                        <div class="w-1/4">${{number_format($seccion->c_nc,2)}}</div>
                    </div>
                    <div class="w-full flex flex-row">
                        <div class="w-1/4"></div>
                        <div class="w-1/4">Facturacion pendiente</div>
                        <div class="w-1/4">${{number_format($seccion->total_costo-$seccion->c_facturado,2)}}</div>
                    </div>
                    <div class="w-full text-xs flex flex-col pt-5">
                        <div class="w-full flex flex-row">
                            <div class="w-1/6 border border-gray-700 px-2 bg-gray-400 text-white">Folio</div>
                            <div class="w-1/6 border border-gray-700 px-2 bg-gray-400 text-white">Cantidad</div>
                            <div class="w-1/6 border border-gray-700 px-2 bg-gray-400 text-white">Emision</div>
                            <div class="w-1/6 border border-gray-700 px-2 bg-gray-400 text-white">Terminos</div>
                            <div class="w-1/6 border border-gray-700 px-2 bg-gray-400 text-white">Vencimiento</div>
                            <div class="w-1/6 border border-gray-700 px-2 bg-gray-400 text-white">Saldo</div>
                            <div class="w-1/6 border border-gray-700 px-2 bg-gray-400 text-white">Notas</div>
                        </div>
                        @foreach($documentos_proveedor as $doc)
                        @if($doc->seccion_id==$seccion->id)
                        <div class="w-full flex flex-row">
                            <div class="w-1/6 border border-gray-700 px-2 bg-white text-gray-700">{{$doc->folio_cfdi}} - {{$doc->partner->nombre}}</div>
                            <div class="w-1/6 border border-gray-700 px-2 bg-white text-gray-700">${{number_format($doc->cantidad_si,0)}} ({{$doc->moneda_documento->nombre}})</div>
                            <div class="w-1/6 border border-gray-700 px-2 bg-white text-gray-700">{{$doc->fecha_emision}}</div>
                            <div class="w-1/6 border border-gray-700 px-2 bg-white text-gray-700">{{$doc->dias_pago}}</div>
                            <div class="w-1/6 border border-gray-700 px-2 bg-white text-gray-700">{{$doc->fecha_vencimiento}}</div>
                            <div class="w-1/6 border border-gray-700 px-2 bg-white text-gray-700">${{number_format($doc->saldo,0)}}</div>
                            <div class="w-1/6 border border-gray-700 px-2 bg-white text-gray-700">{{$doc->notas}}</div>
                        </div>
                        @endif
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    @endforeach
    <x-jet-dialog-modal wire:model="open_cliente" maxWidth="2xl">
        <x-slot name="title">
            Registro de factura al cliente
        </x-slot>
        <x-slot name="content">
            <div class="flex flex-col w-full">
                <div class="w-full">
                    <x-jet-label value="Folio del documento" />
                    <x-jet-input class="w-full text-3xl" type="text"  wire:model.defer="folio_documento"/>
                    @error('folio_documento') <span class="text-xs text-red-400">{{ $message }}</span> @enderror
                </div>
                <div class="w-full">
                    <x-jet-label value="Cantidad (Antes de impuestos)" />
                    <x-jet-input class="w-full text-3xl" type="number"  wire:model="cantidad_si"/>
                    @error('cantidad_si') <span class="text-xs text-red-400">{{ $message }}</span> @enderror
                </div>
                <div class="w-full flex flex-row space-x-3">
                    <div class="w-1/2">
                        <x-jet-label value="Moneda" />
                        <select wire:model="moneda_documento" class="w-full text-sm border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm">
                            <option value="" disabled></option>
                            @foreach($monedas as $opcion)
                            <option value="{{$opcion->id}}" disabled>{{$opcion->nombre}}</option>
                            @endforeach
                        </select>
                        @error('moneda_documento') <span class="text-xs text-red-400">{{ $message }}</span> @enderror
                    </div>
                    @if($solicitar_tc)
                    <div class="w-1/2">
                        <x-jet-label value="Tipo de cambio" />
                        <x-jet-input class="w-full" type="number"  wire:model.defer="tipo_cambio_documento"/>
                        @error('tipo_cambio_documento') <span class="text-xs text-red-400">{{ $message }}</span> @enderror
                    </div>
                    @endif
                </div>
                <div class="w-full flex flex-row space-x-3">
                    <div class="w-1/2">
                        <x-jet-label value="Impuestos trasladados" />
                        <x-jet-input class="w-full" type="number"  wire:model="impuestos_trasladados"/>
                        @error('impuestos_trasladados') <span class="text-xs text-red-400">{{ $message }}</span> @enderror
                    </div>
                    <div class="w-1/2">
                        <x-jet-label value="Impuestos retenidos" />
                        <x-jet-input class="w-full" type="number"  wire:model="impuestos_retenidos"/>
                        @error('impuestos_retenidos') <span class="text-xs text-red-400">{{ $message }}</span> @enderror
                    </div>
                </div>
                <div class="w-full">
                    <x-jet-label value="Cantidad Final" />
                    <x-jet-input class="w-full text-3xl" type="text"  wire:model.defer="cantidad_ci" READONLY/>
                    @error('cantidad_ci') <span class="text-xs text-red-400">{{ $message }}</span> @enderror
                </div>
                <div class="w-full">
                    <x-jet-label value="Fecha emision" />
                    <x-jet-input class="w-full text-sm" wire:model.defer="f_emision" type="date"/>
                    @error('f_emision') <span class="text-xs text-red-400">{{ $message }}</span> @enderror
                </div>
                <div class="w-full">
                    <x-jet-label value="Nota" />
                    <x-jet-input class="w-full text-sm" type="text"  wire:model.defer="notas"/>
                    @error('notas') <span class="text-xs text-red-400">{{ $message }}</span> @enderror
                </div>
                <div class="w-full flex flex-row space-x-3">
                    <div class="w-1/2">
                        <x-jet-label value="Cuenta contable" />
                        <x-jet-input class="w-full" type="text"  wire:model.defer="cuenta_contable"/>
                        @error('cuenta_contable') <span class="text-xs text-red-400">{{ $message }}</span> @enderror
                    </div>
                    <div class="w-1/2">
                        <x-jet-label value="Orden de compra" />
                        <x-jet-input class="w-full" type="text"  wire:model.defer="orden_compra"/>
                        @error('orden_compra') <span class="text-xs text-red-400">{{ $message }}</span> @enderror
                    </div>
                </div>
                <div class="w-full pt-4 border-t border-gray-300 text-orange-200">
                    <x-jet-label value="Terminos de pago : {{$dias_prospecto}} dias" />
                </div>
            </div>
        </x-slot>
        <x-slot name="footer">
            <x-jet-secondary-button wire:click="cancelar_cliente">CANCELAR</x-jet-secondary-button>
            <button  class='inline-flex items-center px-4 py-2 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 active:bg-gray-900 focus:outline-none focus:border-gray-900 focus:ring focus:ring-gray-300 disabled:opacity-25 transition' wire:click.prevent="guardar_cliente">GUARDAR</button>
        </x-slot>
    </x-jet-dialog-modal>
    <x-jet-dialog-modal wire:model="open_proveedor" maxWidth="2xl">
        <x-slot name="title">
            Registro de factura del proveedor
        </x-slot>
        <x-slot name="content">
            <div class="flex flex-col w-full">
                <div class="w-full">
                    <x-jet-label value="Partner" />
                    <select wire:model="partner" class="w-full text-sm border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm">
                        <option value=""></option>
                        @foreach($partners_seccion as $opcion)
                        <option value="{{$opcion->id}}">{{$opcion->nombre}}</option>
                        @endforeach
                    </select>
                    
                    @error('partner') <span class="text-xs text-red-400">{{ $message }}</span> @enderror
                </div>
                <div class="w-full">
                    <x-jet-label value="Folio del documento" />
                    <x-jet-input class="w-full text-3xl" type="text"  wire:model.defer="folio_documento"/>
                    @error('folio_documento') <span class="text-xs text-red-400">{{ $message }}</span> @enderror
                </div>
                <div class="w-full">
                    <x-jet-label value="Cantidad (Antes de impuestos)" />
                    <x-jet-input class="w-full text-3xl" type="number"  wire:model="cantidad_si"/>
                    @error('cantidad_si') <span class="text-xs text-red-400">{{ $message }}</span> @enderror
                </div>
                <div class="w-full flex flex-row space-x-3">
                    <div class="w-1/2">
                        <x-jet-label value="Moneda" />
                        <select wire:model="moneda_documento" class="w-full text-sm border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm">
                            <option value=""></option>
                            @foreach($monedas as $opcion)
                            <option value="{{$opcion->id}}">{{$opcion->nombre}}</option>
                            @endforeach
                        </select>
                        @error('moneda_documento') <span class="text-xs text-red-400">{{ $message }}</span> @enderror
                    </div>
                    @if($solicitar_tc)
                    <div class="w-1/2">
                        <x-jet-label value="Tipo de cambio" />
                        <x-jet-input class="w-full" type="number"  wire:model.defer="tipo_cambio_documento"/>
                        @error('tipo_cambio_documento') <span class="text-xs text-red-400">{{ $message }}</span> @enderror
                    </div>
                    @endif
                </div>
                <div class="w-full flex flex-row space-x-3">
                    <div class="w-1/2">
                        <x-jet-label value="Impuestos trasladados" />
                        <x-jet-input class="w-full" type="number"  wire:model="impuestos_trasladados"/>
                        @error('impuestos_trasladados') <span class="text-xs text-red-400">{{ $message }}</span> @enderror
                    </div>
                    <div class="w-1/2">
                        <x-jet-label value="Impuestos retenidos" />
                        <x-jet-input class="w-full" type="number"  wire:model="impuestos_retenidos"/>
                        @error('impuestos_retenidos') <span class="text-xs text-red-400">{{ $message }}</span> @enderror
                    </div>
                </div>
                <div class="w-full">
                    <x-jet-label value="Cantidad Final" />
                    <x-jet-input class="w-full text-3xl" type="text"  wire:model.defer="cantidad_ci" READONLY/>
                    @error('cantidad_ci') <span class="text-xs text-red-400">{{ $message }}</span> @enderror
                </div>
                <div class="w-full">
                    <x-jet-label value="Fecha emision" />
                    <x-jet-input class="w-full text-sm" wire:model.defer="f_emision" type="date"/>
                    @error('f_emision') <span class="text-xs text-red-400">{{ $message }}</span> @enderror
                </div>
                <div class="w-full">
                    <x-jet-label value="Nota" />
                    <x-jet-input class="w-full text-sm" type="text"  wire:model.defer="notas"/>
                    @error('notas') <span class="text-xs text-red-400">{{ $message }}</span> @enderror
                </div>
                <div class="w-full flex flex-row space-x-3">
                    <div class="w-1/2">
                        <x-jet-label value="Cuenta contable" />
                        <x-jet-input class="w-full" type="text"  wire:model.defer="cuenta_contable"/>
                        @error('cuenta_contable') <span class="text-xs text-red-400">{{ $message }}</span> @enderror
                    </div>
                    <div class="w-1/2">
                        <x-jet-label value="Orden de compra" />
                        <x-jet-input class="w-full" type="text"  wire:model.defer="orden_compra"/>
                        @error('orden_compra') <span class="text-xs text-red-400">{{ $message }}</span> @enderror
                    </div>
                </div>
                <div class="w-full pt-4 border-t border-gray-300 text-orange-200">
                    <x-jet-label value="Terminos de pago : {{$dias_credito_partner}} dias" />
                </div>
            </div>
        </x-slot>
        <x-slot name="footer">
            <x-jet-secondary-button wire:click="cancelar_proveedor">CANCELAR</x-jet-secondary-button>
            <button  class='inline-flex items-center px-4 py-2 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 active:bg-gray-900 focus:outline-none focus:border-gray-900 focus:ring focus:ring-gray-300 disabled:opacity-25 transition' wire:click.prevent="guardar_proveedor">GUARDAR</button>
        </x-slot>
    </x-jet-dialog-modal>        
</div>
