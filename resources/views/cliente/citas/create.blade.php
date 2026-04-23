<x-app-layout>
    <x-slot name="header">
        <h2 class="text-2xl font-bold text-pink-700">
            Reservar cita
        </h2>
    </x-slot>

    <div class="min-h-screen bg-pink-50">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        @if(session('success'))
            <div class="mb-4 p-3 bg-green-100 text-green-800 rounded">
                {{ session('success') }}
            </div>
        @endif

        <div class="bg-white rounded-2xl shadow-md p-6 md:p-8">
            <div class="mb-6">
                <h3 class="text-2xl font-bold text-gray-900 mb-2">Selecciona tu cita</h3>
                <p class="text-gray-600">
                    Elige el servicio, la fecha y la hora disponible para confirmar tu reserva.
                </p>
        </div>
            <form method="POST" action="{{ route('cliente.citas.store') }}">
                @csrf

                <div class="space-y-4">
                    <div>
                        <label class="block font-medium text-gray-700 mb-1">Servicio</label>
                        <select name="servicio_id" id="servicio_id" class="w-full border border-pink-200 rounded-lg p-2.5 focus:border-pink-500 focus:ring-pink-500" required>
                            <option value="">Selecciona un servicio</option>
                            @foreach($servicios as $servicio)
                                <option value="{{ $servicio->id }}" @selected(old('servicio_id') == $servicio->id)>
                                    {{ $servicio->nombre }} ({{ number_format($servicio->precio, 2) }} €)
                                </option>
                            @endforeach
                        </select>
                        @error('servicio_id')
                            <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label class="block font-medium text-gray-700 mb-1">Fecha</label>
                        <div>
                            <label class="block font-medium text-gray-700 mb-1">Selecciona un día</label>

                            <!-- Calendario visual -->
                            <div id="calendar" class="bg-white rounded-2xl shadow-sm p-4 border border-pink-100"></div>

                            <!-- Texto informativo con el día seleccionado -->
                            <p id="fecha_seleccionada_texto" class="mt-2 text-sm text-gray-600">
                                No has seleccionado ningún día.
                            </p>

                            <!-- Campo oculto que se envía al backend -->
                            <input type="hidden" name="fecha_cita" id="fecha_cita">

                            @error('fecha_cita')
                                <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                        @error('fecha_cita')
                            <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label class="block font-medium text-gray-700 mb-1">Hora disponible</label>
                        <select name="hora_inicio" id="hora_inicio" class="w-full border border-pink-200 rounded-lg p-2.5 focus:border-pink-500 focus:ring-pink-500" required disabled>
                            <option value="">Primero selecciona servicio y fecha</option>
                        </select>
                        @error('hora_inicio')
                            <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label class="block font-medium text-gray-700 mb-1">Observaciones</label>
                        <textarea
                            name="mensaje_cliente"
                            rows="4"
                            class="w-full border border-pink-200 rounded-lg p-2.5 focus:border-pink-500 focus:ring-pink-500"
                        >{{ old('mensaje_cliente') }}</textarea>
                        <p id="aviso_maquillaje" class="text-sm text-yellow-600 mt-1 hidden">
                            ⚠️ Las observaciones son obligatorias para servicios de maquillaje.
                        </p>
                        @error('mensaje_cliente')
                            <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="flex flex-col sm:flex-row gap-3 pt-4">
                        <button
                            type="submit"
                            class="px-4 py-2 bg-pink-600 text-white rounded-lg hover:bg-pink-700 focus:outline-none focus:ring-2 focus:ring-pink-500"
                        >
                            Reservar cita
                        </button>

                        <a
                            href="{{ route('cliente.citas.index') }}"
                            class="px-4 py-2 border border-pink-600 text-pink-700 rounded-lg hover:bg-pink-50 focus:outline-none focus:ring-2 focus:ring-pink-500"
                        >
                            Ver mis citas
                        </a>
                        <a
                            href="{{ route('cliente.dashboard') }}"
                            class="px-4 py-2 border border-pink-600 text-pink-700 rounded-lg hover:bg-pink-50 focus:outline-none focus:ring-2 focus:ring-pink-500"
                        >
                            Volver a la pantalla principal
                        </a>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <script>
        const servicioSelect = document.getElementById('servicio_id');
        const fechaInput = document.getElementById('fecha_cita');
        const horaSelect = document.getElementById('hora_inicio');

        async function cargarHorasDisponibles() {
            const servicioId = servicioSelect.value;
            const fecha = fechaInput.value;

            horaSelect.innerHTML = '<option value="">Cargando horas...</option>';
            horaSelect.disabled = true;

            if (!servicioId || !fecha) {
                horaSelect.innerHTML = '<option value="">Primero selecciona servicio y fecha</option>';
                return;
            }

            const url = `{{ route('cliente.citas.horas-disponibles') }}?servicio_id=${servicioId}&fecha_cita=${fecha}`;

            try {
                const response = await fetch(url);
                const horas = await response.json();

                horaSelect.innerHTML = '';

                if (horas.length === 0) {
                    horaSelect.innerHTML = '<option value="">No hay horas disponibles</option>';
                    return;
                }

                horaSelect.innerHTML = '<option value="">Selecciona una hora</option>';

                horas.forEach(hora => {
                    const option = document.createElement('option');
                    option.value = hora.value;
                    option.textContent = hora.label;
                    horaSelect.appendChild(option);
                });

                horaSelect.disabled = false;
            } catch (error) {
                horaSelect.innerHTML = '<option value="">Error al cargar horas</option>';
            }
        }

        servicioSelect.addEventListener('change', function () {
            fechaInput.value = '';
            document.getElementById('fecha_seleccionada_texto').textContent = 'No has seleccionado ningún día.';

            horaSelect.innerHTML = '<option value="">Primero selecciona servicio y fecha</option>';
            horaSelect.disabled = true;

            if (window.calendarCliente) {
                window.calendarCliente.refetchEvents();
            }
        });

        fechaInput.addEventListener('change', cargarHorasDisponibles);
    </script>

    <!-- FullCalendar CSS -->
    <link href="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.15/index.global.min.css" rel="stylesheet">

    <!-- FullCalendar JS -->
    <script src="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.15/index.global.min.js"></script>

    <script>
    document.addEventListener('DOMContentLoaded', function () {

        // Seleccionamos el contenedor
        const calendarEl = document.getElementById('calendar');

        // Seleccionamos el input oculto
        const fechaInput = document.getElementById('fecha_cita');

        //Texto que muestra a usuario el día seleccionado
        const fechaTexto = document.getElementById('fecha_seleccionada_texto');

        // Creamos el calendario
        window.calendarCliente = new FullCalendar.Calendar(calendarEl, {

            titleFormat: { month: 'long' },

            initialView: 'dayGridMonth',
            locale: 'es',

            firstDay: 1,

            buttonText: {
                today: 'Hoy'
            },

            //Bloqueamos días anteriores a hoy
            validRange: {
                start: new Date().toISOString().split('T')[0]
            },

            events: function(fetchInfo, successCallback, failureCallback) {
                const servicioId = document.getElementById('servicio_id').value;

                if (!servicioId) {
                    successCallback([]);
                    return;
                }

                const url = new URL("{{ route('cliente.citas.fechas-disponibles') }}", window.location.origin);
                url.searchParams.append('servicio_id', servicioId);

                fetch(url)
                    .then(response => response.json())
                    .then(data => successCallback(data))
                    .catch(error => failureCallback(error));
            },

            datesSet: function(){
                personalizarTituloCalendarioCliente();
            },

            // Cuando haces click en un día
            dateClick: function(info) {

                const eventosDisponibles = window.calendarCliente.getEvents().map(event => event.startStr);

                if (!eventosDisponibles.includes(info.dateStr)) {
                    fechaTexto.textContent = 'Ese día no tiene disponibilidad para el servicio seleccionado.';
                    return;
                }

                // Guardamos la fecha seleccionada
                fechaInput.value = info.dateStr;

                // Disparamos el evento para cargar horas
                fechaInput.dispatchEvent(new Event('change'));

                // Resaltamos el día seleccionado
                document.querySelectorAll('.fc-daygrid-day').forEach(el => {
                    el.classList.remove('bg-pink-100', 'ring', 'ring-pink-400');
                });

                info.dayEl.classList.add('bg-pink-100', 'ring', 'ring-pink-400');

                //Mostramos la fecha seleccionada
                const fechaBonita = new Date(info.dateStr).toLocaleDateString('es-ES', {
                    weekday: 'long',
                    year: 'numeric',
                    month: 'long',
                    day: 'numeric'
                });

                fechaTexto.textContent = 'Día seleccionado: ' + fechaBonita;
            }

        });

        //Pintamos el calendario
        window.calendarCliente.render();

        function personalizarTituloCalendarioCliente() {
            const titulo = document.querySelector('#calendar .fc-toolbar-title');
            if (titulo) {
                titulo.textContent = titulo.textContent.toUpperCase().split(' DE ')[0];
            }
        }

personalizarTituloCalendarioCliente();
    });
    </script>

    <style>
    .fc {
        font-family: inherit;
    }

    .fc .fc-toolbar-title {
        font-size: 1.4rem;
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

    .fc .fc-scrollgrid,
    .fc .fc-theme-standard td,
    .fc .fc-theme-standard th {
        border-color: #f3d4e4;
    }

    .fc .fc-col-header-cell {
        background-color: #fdf2f8;
    }

    .fc .fc-daygrid-day.fc-day-today {
        background-color: #fce7f3 !important;
    }

    .fc .fc-toolbar {
        gap: 1rem;
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
