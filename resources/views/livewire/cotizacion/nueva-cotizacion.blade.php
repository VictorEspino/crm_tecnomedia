<div>
    <x-jet-danger-button wire:click="nuevo">NUEVA COTIZACION</x-jet-danger-button>

    <x-jet-dialog-modal wire:model="open" maxWidth="7xl">
        <x-slot name="title">
            Crear nueva cotizacion
        </x-slot>
        <x-slot name="content">
            <div class="flex flex-col w-full">
                <div class="w-full mb-2 flex flex-row space-x-3">
                    <div class="w-1/2">
                        <x-jet-label value="Fecha presentacion" />
                        <x-jet-input class="w-full text-xs" wire:model="fecha_presentacion" type="date" />
                        @error('fecha_presentacion') <span class="text-xs text-red-400">{{ $message }}</span> @enderror    
                    </div>
                    <div class="w-1/2">
                        <x-jet-label value="Años de servicio" />
                        <select wire:model="años" class="w-full text-xs border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded shadow-sm">
                            <option value=1>1</option>
                            <option value=2>2</option>
                            <option value=3>3</option>
                            <option value=4>4</option>
                            <option value=5>5</option>
                        </select>
                    </div>    
                </div>
                <div class="w-full mb-2 pb-4">
                    <x-jet-label value="Descripcion" />
                    <x-jet-input type=text class="p-2 w-full text-xs" wire:model="descripcion"/>
                    @error('descripcion') <span class="text-xs text-red-400">{{ $message }}</span> @enderror
                </div>
                <div class="w-full bg-gray-300 px-5 flex flex-row">
                    <div class="w-1/6 flex items-center justify-center">
                        <i class="text-2xl text-green-500 fas fa-plus" style="cursor: pointer" wire:click="agregar_seccion" cursor></i>
                    </div>
                    <div class="w-5/6">
                        <x-jet-label class="text-blue-400 text-base font-italic" value="<---- Agregue una seccion de servicios" />
                    </div>
                    
                </div>
                @foreach($secciones as $index=>$seccion)
                <div class="w-full">
                    <div class="w-full text-blue-400 bg-gray-200 p-2 flex flex-row">
                        <div class="w-1/12 flex justify-center">
                            <i class="fas fa-minus-circle text-red-400 text-2xl" style="cursor:pointer" wire:click='eliminar_seccion({{$index}})'></i>
                        </div>                    
                        <div class="w-9/12">
                            <x-jet-input class="p-2 w-full" wire:model='secciones.{{$index}}.nombre'/>
                            @error('secciones.'.$index.'.nombre') <span class="text-xs text-red-400">{{ $message }}</span> @enderror
                        </div>
                        <div class="w-1/6 flex items-center justify-center">
                            <i class="text-2xl text-green-500 fas fa-plus" style="cursor: pointer" wire:click="agregar_item({{$index}})" cursor></i>
                            &nbsp;&nbsp;&nbsp;<---Nuevo Item
                        </div>
                    </div>
                    <div class="flex flex-row bg-green-200 font-bold">
                        <div class="w-5/12 flex flex-row">
                            <div class="w-1/6">Cantidad
                            </div>
                            <div class="w-4/6">Descripcion
                            </div>
                            <div class="w-1/6">Unidad
                            </div>    
                        </div>
                        <div class="w-1/4 flex flex-row">
                            <div class="w-1/3">Unitario
                            </div>
                            <div class="w-1/3">Descuento
                            </div>
                            <div class="w-1/3">Precio Final
                            </div>    
                        </div>
                        <div class="w-1/3 flex flex-row">
                            <div class="{{$años==1?'w-full':'w-1/'.$años}}">Año 1
                            </div>
                            @if($años>1)
                            <div class="w-1/{{$años}}">Año 2
                            </div>
                            @endif
                            @if($años>2)
                            <div class="w-1/{{$años}}">Año 3
                            </div>    
                            @endif
                            @if($años>3)
                            <div class="w-1/{{$años}}">Año 4
                            </div>    
                            @endif
                            @if($años>4)
                            <div class="w-1/{{$años}}">Año 5
                            </div>   
                            @endif 
                            <div class="w-1/6">
                            </div>    
                        </div>
                    </div>
                    @foreach($secciones[$index]['items'] as $index2=>$item)
                    <div class="flex flex-row {{$secciones[$index]['items'][$index2]['cuadra']==1?'':'bg-red-400'}}">
                        <div class="w-5/12 flex flex-row">
                            <div class="pt-1 px-1 w-1/6">
                                <x-jet-input class="py-1 px-2 w-full text-xs border-gray-100 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded shadow-sm" type="number" wire:model="secciones.{{$index}}.items.{{$index2}}.cantidad" wire:change="actualiza_item({{$index}},{{$index2}})"/>
                                @error('secciones.'.$index.'.items.'.$index2.'.cantidad') <span class="text-xs text-red-400">{{ $message }}</span> @enderror
                            </div>
                            <div class="pt-1 px-1 w-4/6">
                                <x-jet-input class="pt-1 px2 w-full" wire:model="secciones.{{$index}}.items.{{$index2}}.descripcion"/>
                                @error('secciones.'.$index.'.items.'.$index2.'.descripcion') <span class="text-xs text-red-400">{{ $message }}</span> @enderror
                            </div>
                            <div class="pt-1 px-1 w-1/6">
                                <select wire:model="secciones.{{$index}}.items.{{$index2}}.unidad" class="py-1 px-2 w-full text-xs border-gray-100 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded shadow-sm">
                                    <option value=""></option>
                                    @foreach($unidades_servicio as $opcion)
                                    <option value="{{$opcion->nombre}}">{{$opcion->nombre}}</option>
                                    @endforeach
                                </select>
                                @error('secciones.'.$index.'.items.'.$index2.'.unidad') <span class="text-xs text-red-400">{{ $message }}</span> @enderror
                            </div>    
                        </div>
                        <div class="w-1/4 flex flex-row">
                            <div class="pt-1 px-1 w-1/3"><x-jet-input class="py-1 px-2 w-full text-xs border-gray-100 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded shadow-sm" type="number" wire:model="secciones.{{$index}}.items.{{$index2}}.unitario" wire:change="actualiza_item({{$index}},{{$index2}})"/>
                            @error('secciones.'.$index.'.items.'.$index2.'.unitario') <span class="text-xs text-red-400">{{ $message }}</span> @enderror
                            </div>
                            <div class="pt-1 px-1 w-1/3">
                                <select wire:model="secciones.{{$index}}.items.{{$index2}}.descuento" class="py-1 px-2 w-full text-xs border-gray-100 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded shadow-sm" wire:change="actualiza_item({{$index}},{{$index2}})">
                                    <option value=0>0%</option>
                                    <option value=1>1%</option>
                                    <option value=2>2%</option>
                                    <option value=3>3%</option>
                                    <option value=4>4%</option>
                                    <option value=5>5%</option>
                                    <option value=6>6%</option>
                                    <option value=7>7%</option>
                                    <option value=8>8%</option>
                                    <option value=9>9%</option>
                                    <option value=10>10%</option>
                                    <option value=11>11%</option>
                                    <option value=12>12%</option>
                                    <option value=13>13%</option>
                                    <option value=14>14%</option>
                                    <option value=15>15%</option>
                                    <option value=16>16%</option>
                                    <option value=17>17%</option>
                                    <option value=18>18%</option>
                                    <option value=19>19%</option>
                                    <option value=20>20%</option>
                                    <option value=21>21%</option>
                                    <option value=22>22%</option>
                                    <option value=23>23%</option>
                                    <option value=24>24%</option>
                                    <option value=25>25%</option>
                                    <option value=26>26%</option>
                                    <option value=27>27%</option>
                                    <option value=28>28%</option>
                                    <option value=29>29%</option>
                                    <option value=30>30%</option>
                                    <option value=31>31%</option>
                                    <option value=32>32%</option>
                                    <option value=33>33%</option>
                                    <option value=34>34%</option>
                                    <option value=35>35%</option>
                                    <option value=36>36%</option>
                                    <option value=37>37%</option>
                                    <option value=38>38%</option>
                                    <option value=39>39%</option>
                                    <option value=40>40%</option>
                                    <option value=41>41%</option>
                                    <option value=42>42%</option>
                                    <option value=43>43%</option>
                                    <option value=44>44%</option>
                                    <option value=45>45%</option>
                                    <option value=46>46%</option>
                                    <option value=47>47%</option>
                                    <option value=48>48%</option>
                                    <option value=49>49%</option>
                                    <option value=50>50%</option>
                                    <option value=51>51%</option>
                                    <option value=52>52%</option>
                                    <option value=53>53%</option>
                                    <option value=54>54%</option>
                                    <option value=55>55%</option>
                                    <option value=56>56%</option>
                                    <option value=57>57%</option>
                                    <option value=58>58%</option>
                                    <option value=59>59%</option>
                                    <option value=60>60%</option>
                                    <option value=61>61%</option>
                                    <option value=62>62%</option>
                                    <option value=63>63%</option>
                                    <option value=64>64%</option>
                                    <option value=65>65%</option>
                                    <option value=66>66%</option>
                                    <option value=67>67%</option>
                                    <option value=68>68%</option>
                                    <option value=69>69%</option>
                                    <option value=70>70%</option>
                                    <option value=71>71%</option>
                                    <option value=72>72%</option>
                                    <option value=73>73%</option>
                                    <option value=74>74%</option>
                                    <option value=75>75%</option>
                                    <option value=76>76%</option>
                                    <option value=77>77%</option>
                                    <option value=78>78%</option>
                                    <option value=79>79%</option>
                                    <option value=80>80%</option>
                                    <option value=81>81%</option>
                                    <option value=82>82%</option>
                                    <option value=83>83%</option>
                                    <option value=84>84%</option>
                                    <option value=85>85%</option>
                                    <option value=86>86%</option>
                                    <option value=87>87%</option>
                                    <option value=88>88%</option>
                                    <option value=89>89%</option>
                                    <option value=90>90%</option>
                                    <option value=91>91%</option>
                                    <option value=92>92%</option>
                                    <option value=93>93%</option>
                                    <option value=94>94%</option>
                                    <option value=95>95%</option>
                                    <option value=96>96%</option>
                                    <option value=97>97%</option>
                                    <option value=98>98%</option>
                                    <option value=99>99%</option>
                                    <option value=100>100%</option>
                                </select>
                               
                            </div>
                            <div class="pt-1 px-1 w-1/3"><x-jet-input class="py-1 px-2 w-full text-xs border-gray-100 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded shadow-sm" type="number" wire:model="secciones.{{$index}}.items.{{$index2}}.p_final" readonly/>
                            </div>    
                        </div>
                        <div class="w-1/3 flex flex-row">
                            <div class="pt-1 pb-1 px-1 {{$años==1?'w-full':'w-1/'.$años}}"><x-jet-input class="py-1 px-2 w-full text-xs border-gray-100 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded shadow-sm" type="number" wire:model="secciones.{{$index}}.items.{{$index2}}.a1" wire:change="verifica_cuadre({{$index}},{{$index2}})"/>
                            </div>
                            @if($años>1)
                            <div class="pt-1 px-1 w-1/{{$años}}"><x-jet-input class="py-1 px-2 w-full text-xs border-gray-100 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded shadow-sm" type="number" wire:model="secciones.{{$index}}.items.{{$index2}}.a2" wire:change="verifica_cuadre({{$index}},{{$index2}})"/>
                            </div>
                            @endif
                            @if($años>2)
                            <div class="pt-1 px-1 w-1/{{$años}}"><x-jet-input class="py-1 px-2 w-full text-xs border-gray-100 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded shadow-sm" type="number" wire:model="secciones.{{$index}}.items.{{$index2}}.a3" wire:change="verifica_cuadre({{$index}},{{$index2}})"/>
                            </div>  
                            @endif
                            @if($años>3)  
                            <div class="pt-1 px-1 w-1/{{$años}}"><x-jet-input class="py-1 px-2 w-full text-xs border-gray-100 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded shadow-sm" type="number" wire:model="secciones.{{$index}}.items.{{$index2}}.a4" wire:change="verifica_cuadre({{$index}},{{$index2}})"/>
                            </div>    
                            @endif
                            @if($años>4)
                            <div class="pt-1 px-1 w-1/{{$años}}"><x-jet-input class="py-1 px-2 w-full text-xs border-gray-100 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded shadow-sm" type="number" wire:model="secciones.{{$index}}.items.{{$index2}}.a5" wire:change="verifica_cuadre({{$index}},{{$index2}})"/>
                            </div>  
                            @endif  
                            <div class="pt-1 px-1 w-1/6">
                                <i class="fas fa-minus-circle text-red-400 text-xl" style="cursor:pointer" wire:click='eliminar_item({{$index}},{{$index2}})'></i>
                            </div>    
                        </div>
                    </div>
                    @endforeach

                    <div class="flex flex-row bg-green-200 font-bold">
                        <div class="w-8/12 flex justify-end px-10">
                            Total por año
                        </div>
                        <div class="w-1/3 flex flex-row">
                            <div class="flex justify-center {{$años==1?'w-full':'w-1/'.$años}}">${{number_format($secciones[$index]['t_a1'],2)}}
                            </div>
                            @if($años>1)
                            <div class="flex justify-center w-1/{{$años}}">${{number_format($secciones[$index]['t_a2'],2)}}
                            </div>
                            @endif
                            @if($años>2)
                            <div class="flex justify-center w-1/{{$años}}">${{number_format($secciones[$index]['t_a3'],2)}}
                            </div>    
                            @endif
                            @if($años>3)
                            <div class="flex justify-center w-1/{{$años}}">${{number_format($secciones[$index]['t_a4'],2)}}
                            </div>    
                            @endif
                            @if($años>4)
                            <div class="flex justify-center w-1/{{$años}}">${{number_format($secciones[$index]['t_a5'],2)}}
                            </div>   
                            @endif 
                            <div class="w-1/6">
                            </div>    
                        </div>
                    </div>
                    <div class="flex flex-row bg-blue-200 font-bold">
                        <div class="w-4/6 flex justify-end px-10">
                            Total
                        </div>
                        <div class="w-1/3 flex flex-row"> 
                            <div class="w-full flex  justify-center">
                                ${{number_format($secciones[$index]['total'],2)}}
                            </div>
                            <div class="w-1/6">
                            </div>
                        </div>
                        
                        
                    </div>

                </div>
                @endforeach
            </div>
        </x-slot>
        <x-slot name="footer">
            <x-jet-secondary-button wire:click="cancelar">CANCELAR</x-jet-secondary-button>
            <button {{$procesando==1?'disabled':''}} class='inline-flex items-center px-4 py-2 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 active:bg-gray-900 focus:outline-none focus:border-gray-900 focus:ring focus:ring-gray-300 disabled:opacity-25 transition' wire:click.prevent="guardar">GUARDAR</button>
        </x-slot>
    </x-jet-dialog-modal>
</div>