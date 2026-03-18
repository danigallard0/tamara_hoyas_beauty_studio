<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Reservar cita
        </h2>
    </x-slot>

    <div class="p-6 max-w-3xl">
        @if(session('success'))
            <div class="mb-4 p-3 bg-green-100 text-green-800 rounded">
                {{ session('success') }}
            </div>
        @endif

        <div class="bg-white shadow rounded p-6">
            <form method="POST" action="{{ route('cliente.citas.store') }}">
                @csrf

                <div class="space-y-4">
                    <div>
                        <label class="block font-medium mb-1">Servicio</label>
                        <select name="servicio_id" id="servicio_id" class="w-full border rounded p-2" required>
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
                        <label class="block font-medium mb-1">Fecha</label>
                        <input
                            type="date"
                            name="fecha_cita"
                            id="fecha_cita"
                            value="{{ old('fecha_cita') }}"
                            class="w-full border rounded p-2"
                            required
                        >
                        @error('fecha_cita')
                            <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label class="block font-medium mb-1">Hora disponible</label>
                        <select name="hora_inicio" id="hora_inicio" class="w-full border rounded p-2" required disabled>
                            <option value="">Primero selecciona servicio y fecha</option>
                        </select>
                        @error('hora_inicio')
                            <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label class="block font-medium mb-1">Observaciones</label>
                        <textarea
                            name="mensaje_cliente"
                            rows="4"
                            class="w-full border rounded p-2"
                        >{{ old('mensaje_cliente') }}</textarea>
                        @error('mensaje_cliente')
                            <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="flex gap-2 pt-4">
                        <button
                            type="submit"
                            class="px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700"
                        >
                            Reservar cita
                        </button>

                        <a
                            href="{{ route('cliente.citas.index') }}"
                            class="px-4 py-2 border rounded"
                        >
                            Cancelar
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

        servicioSelect.addEventListener('change', cargarHorasDisponibles);
        fechaInput.addEventListener('change', cargarHorasDisponibles);
    </script>
</x-app-layout>
