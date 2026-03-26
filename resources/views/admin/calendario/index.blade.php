<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Calendario de citas
        </h2>
    </x-slot>

    <div class="p-6">
        <div class="mb-4">
            <a href="{{ route('admin.dashboard') }}"
               class="inline-block px-4 py-2 border rounded hover:bg-gray-50">
               Volver al panel de administración
            </a>
        </div>

        <div class="mb-4 bg-white shadow rounded p-4">
          <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
            <div>
              <label for="filtro_estado" class="block text-sm font-medium mb-1">Estado</label>
              <select id="filtro_estado" class="w-full border rounded p-2">
                  <option value="">Todas</option>
                  <option value="pendiente">Pendiente</option>
                  <option value="confirmada">Confirmada</option>
                  <option value="cancelada">Cancelada</option>
              </select>
            </div>

            <div>
              <label for="filtro_fecha" class="block text-sm font-medium mb-1">Fecha</label>
              <input type="date" id="filtro_fecha" class="w-full border rounded p-2">
            </div>

            <div class="flex items-end gap-2">
                <button id="aplicar_filtros"
                        class="px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700">
                    Aplicar filtros
                </button>

                <button id="limpiar_filtros"
                        class="px-4 py-2 border rounded hover:bg-gray-50">
                    Limpiar
                </button>
            </div>
          </div>
        </div>
        <div class="bg-white shadow rounded p-6">
            <div id="admin-calendar" style="min-height: 700px;"></div>
        </div>
    </div>

    <!-- FullCalendar CSS -->
    <link href="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.15/index.global.min.css" rel="stylesheet">


    <!-- FullCalendar JS -->
    <script src="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.15/index.global.min.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function () {

            // Contenedor donde se pintará el calendario
            const calendarEl = document.getElementById('admin-calendar');
          if(!calendarEl) {
            console.error('No existe el contenedor #admin-calendar');
            return;
          }

            // Creamos el calendario del admin
            const calendar = new FullCalendar.Calendar(calendarEl, {
                initialView: 'timeGridWeek',
                locale: 'es',
                firstDay: 1,

                // Mostramos fines de semana por si el centro abre sábados
                weekends: true,

                allDaySlot: false,

                //Mostrar la franja horario visible
                slotMinTime: '08:00:00',
                slotMaxTimr: '21:00:00',

                //Intervalos de media hora
                slotDuration: '00:30:00',

                //Formato limpio para la horas
                slotLabelFormat: {     
                    hour: '2-digit',
                    minute: '2-digit',
                    hour12: false
                  },

                //Cabecera del calendario
                headerToolBar: {
                  left: 'prev, next today',
                  center: 'title',
                  right: 'dayGridMonth, timeGridWeek, timeGridDay'
                },

                //Texto del botoón "today"
                buttonText: {
                  today: 'Hoy',
                  month: 'Mes',
                  week: 'Semana',
                  day: 'Día'
                },

                // Fuente de eventos: ruta que devuelve las citas en JSON
                events: function(fetchInfo, successCallback, failureCallback) {
                  //Leemos los filtros actuales
                  const estado = document.getElementById('filtro_estado').value;
                  const fecha = document.getElementById('filtro_fecha').value;

                  //Construimos la URL con query params
                  const url = new URL("{{ route('admin.calendario.eventos') }}", window.location.origin);

                  if (estado) {
                    url.searchParams.append('estado', estado)
                  }

                  if (fecha) {
                    irl.searchParams.append('fecha', fecha);
                  }

                  fetch(url)
                      .then(response => response.json())
                      .then(data => successCallback(data))
                      .catch(error => failureCallback(error));
                },
                 
                // Cuando el admin hace click en una cita
                eventClick: function(info) {
                  const event = info.event;
                  window.location.href = `{{ url('/admin/citas') }}/${event.id}/edit`;
                }
            });

            // Pintamos el calendario
            calendar.render();

            //Botones de filtros
            const aplicarFiltrosBtn = document.getElementById('aplicar_filtros');
            const limpiarFiltrosBtn = document.getElementById('limpiar_filtros');
            const filtroEstado = document.getElementById('filtro_estado');
            const filtroFecha = document.getElementById('filtro_fecha');

            //Aplicar filtros recargando eventos
            aplicarFiltrosBtn.addEventListener('click', function () {
              calendar.refetchEvents();
            });

            //Limpiar filtros y recargar
            limpiarFiltrosBtn.addEventListener('click', function () {
              filtroEstado.value = '';
              filtroFecha.value = '';
              calendar.refetchEvents();
            });

        });
    </script>
</x-app-layout>