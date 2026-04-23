<x-app-layout>
    <x-slot name="header">
        <h2 class="text-2xl font-bold text-pink-700">
            Calendario de citas
        </h2>
    </x-slot>

    <div class="min-h-screen bg-pink-50">
      <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <div class="mb-4">
            <a href="{{ route('admin.dashboard') }}"
               class="inline-block px-4 py-2 border border-pink-600 text-pink-700 rounded-lg hover:bg-pink-50 focus:outline-none focus:ring-2 focus:ring-pink-500">
               Volver al panel de administración
            </a>
        </div>

        <div class="mb-6 bg-white rounded-2xl shadow-md p-6">
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
                        class="px-4 py-2 bg-pink-600 text-white rounded-lg hover:bg-pink-700 focus:outline-none focus:ring-2 focus:ring-pink-500">
                    Aplicar filtros
                </button>

                <button id="limpiar_filtros"
                        class="px-4 py-2 border border-pink-600 text-pink-700 rounded-lg hover:bg-pink-50 focus:outline-none focus:ring-2 focus:ring-pink-500">
                    Limpiar
                </button>
            </div>
          </div>
        </div>
        <div class="bg-white rounded-2xl shadow-md p-4 md:p-6">
            <div id="admin-calendar"></div>
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
                slotMinTime: '10:00:00',
                slotMaxTime: '21:00:00',

                //Intervalos de media hora
                slotDuration: '00:30:00',

                scrollTime:'10:00:00',

                height: 'auto',
                contentHeight: 'auto',
                expandRows:false,

                //Formato limpio para la horas
                slotLabelFormat: {     
                    hour: '2-digit',
                    minute: '2-digit',
                    hour12: false
                  },

                //Cabecera del calendario
                headerToolbar: {
                  left: 'prev,next today',
                  center: 'title',
                  right: 'dayGridMonth,timeGridWeek,timeGridDay'
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
                    url.searchParams.append('fecha', fecha);
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
                },

                eventDidMount: function(info) {
                  info.el.style.cursor = 'pointer';
                },

                datesSet: function(){
                  traducirTooltipsCalendario();
                }
            });

            // Pintamos el calendario
            calendar.render();

            function traducirTooltipsCalendario() {
              const btnPrev = document.querySelector('.fc-prev-button');
              const btnNext = document.querySelector('.fc-next-button');
              const btnToday = document.querySelector('.fc-today-button');
              const btnMonth = document.querySelector('.fc-dayGridMonth-button');
              const btnWeek = document.querySelector('.fc-timeGridWeek-button');
              const btnDay = document.querySelector('.fc-timeGridDay-button');

              if (btnPrev) btnPrev.setAttribute('title', 'Semana anterior');
              if (btnNext) btnNext.setAttribute('title', 'Semana siguiente');
              if (btnToday) btnToday.setAttribute('title', 'Ir a hoy');
              if (btnMonth) btnMonth.setAttribute('title', 'Vista mensual');
              if (btnWeek) btnWeek.setAttribute('title', 'Vista semanal');
              if (btnDay) btnDay.setAttribute('title', 'Vista diaria');
          }

          traducirTooltipsCalendario();

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

    <style>
    .fc {
        font-family: inherit;
    }

    .fc .fc-toolbar-title {
        font-size: 1.5rem;
        font-weight: 700;
        color: #111827;
    }

    .fc .fc-button {
        background-color: #db2777 !important;
        border-color: #db2777 !important;
        border-radius: 0.5rem !important;
        padding: 0.5rem 0.75rem !important;
    }

    .fc .fc-button:hover {
        background-color: #be185d !important;
        border-color: #be185d !important;
    }

    .fc .fc-button:disabled {
        opacity: 0.7;
    }

    .fc .fc-scrollgrid {
        border-radius: 1rem;
        overflow: hidden;
    }

    .fc .fc-col-header-cell {
        background-color: #fdf2f8;
    }

    .fc .fc-daygrid-day-frame,
    .fc .fc-timegrid-slot {
        background-color: #ffffff;
    }
    
    .fc .fc-toolbar {
        gap: 1rem;
        align-items: center;
    }

    .fc .fc-toolbar-chunk {
        display: flex;
        align-items: center;
        gap: 0.5rem;
    }

    .fc .fc-button-group {
      gap: 0.35rem;
    }

    .fc .fc-button-group > .fc-button {
      border-radius: 0.5rem !important;
    }
    </style>
</x-app-layout>