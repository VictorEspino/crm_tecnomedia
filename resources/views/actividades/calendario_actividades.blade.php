<x-app-layout>
    <x-slot name="header">
        {{ __('Calendario Actividades') }}
    </x-slot>
    <div class="w-full">
        <div class="flex flex-col w-full text-gray-700 shadow-lg rounded-lg px-5">
        <div class="w-full rounded-t-lg bg-gray-200 p-3 flex flex-col border-b border-gray-800"> <!--ENCABEZADO-->
            <div class="w-full text-lg font-semibold">Calendario de Actividades</div>
            <div class="w-full text-sm">({{Auth::user()->usuario}}) - {{Auth::user()->name}}</div>            
            <div class="w-full text-sm">{{App\Models\User::with('compania_desc')->find(Auth::user()->id)->compania_desc->nombre}}</div>                      
        </div> <!--FIN ENCABEZADO-->
        
        <div class="w-full rounded-b-lg bg-white p-3 flex flex-col"> <!--CONTENIDO-->
            <div class="w-full pl-56">
                <div id='calendar'></div>
            </div>
            
        </div> <!-- FIN DEL CONTENIDO -->
    </div> <!--DIV PRINCIPAL-->

        <script>
            document.addEventListener('DOMContentLoaded', function() {
              var calendarEl = document.getElementById('calendar');
          
              var calendar = new FullCalendar.Calendar(calendarEl, {
                headerToolbar: {
                  left: 'prev,next today',
                  center: 'title',
                  right: 'dayGridMonth,timeGridWeek,timeGridDay'
                },
                initialDate: '2023-06-14',
                navLinks: true, // can click day/week names to navigate views
                selectable: false,
                selectMirror: false,
                
                eventClick: function(arg) {
                  detalles(arg.event.id);
                },
                editable: true,
                dayMaxEvents: true, // allow "more" link when too many events
                events: [{"id":3850,"title":"OTRO PROSPECTO","start":"2022-12-21","backgroundColor":"#FF0000"},{"id":3848,"title":"Victor Ignacio Espino Monta\u00f1o","start":"2022-11-02","backgroundColor":"#FF0000"},{"id":3846,"title":"Victor Ignacio Espino Monta\u00f1o","start":"2022-07-30","backgroundColor":"#FF0000"}],
                locale: 'es',
                slotDuration: '24:00'
              });
          
              calendar.render();
            });
          
          </script>
</x-app-layout>
