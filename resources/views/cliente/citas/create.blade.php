<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Reservar cita
        </h2>
    </x-slot>

    <div class="p-6 max-w-3xl">
        
        {{-- Mensaje de éxito --}}
        @if(session('success'))
            <div class="mb-4 p-3 bg-green-100 text-green-800 rounded">
                {{ session('success') }}
            </div>
        @endif

        <div class="bg-white shadow rounded p-6">

            <form method="POST" action="{{ route('cliente.citas.store') }}">
                @csrf

                <div class="space-y-4">

                    {{-- SERVICIO --}}
                    <div>
                        <label class="block font-medium mb-1">Servicio</label>

                        <select name="servicio_id" class="w-full border rounded p-2" required>
                            <option value="">Selecciona un servicio</option>

                            @foreach($servicios as $servicio)
                                <option value="{{ $servicio->id }}" @selected(old('servicio_id') == $servicio->id)>
                                    {{ $servicio->nombre }} ({{ $servicio->precio }}€)
                                </option>
                            @endforeach

                        </select>

                        @error('servicio_id')
                            <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>


                    {{-- HORARIO --}}
                    <div>
                        <label class="block font-medium mb-1">Horario</label>

                        <select name="horario_id" class="w-full border rounded p-2" required>

                            <option value="">Selecciona un horario</option>

                            @foreach($horarios as $horario)
    @php
        $dias = [
            1 => 'Lunes',
            2 => 'Martes',
            3 => 'Miércoles',
            4 => 'Jueves',
            5 => 'Viernes',
            6 => 'Sábado',
            7 => 'Domingo',
        ];
    @endphp

    <option value="{{ $horario->id }}" @selected(old('horario_id') == $horario->id)>
        {{ $dias[$horario->dia_semana] ?? 'Día '.$horario->dia_semana }}
        | {{ \Carbon\Carbon::parse($horario->hora_inicio)->format('H:i') }}
        - {{ \Carbon\Carbon::parse($horario->hora_fin)->format('H:i') }}
    </option>
@endforeach

                        </select>

                        @error('horario_id')
                            <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>


                    {{-- FECHA --}}
                    <div>
                        <label class="block font-medium mb-1">Fecha de la cita</label>

                        <input
                            type="date"
                            name="fecha_cita"
                            value="{{ old('fecha_cita') }}"
                            class="w-full border rounded p-2"
                            required
                        >

                        @error('fecha_cita')
                            <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>


                    {{-- MENSAJE CLIENTE --}}
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


                    {{-- BOTONES --}}
                    <div class="flex gap-2 pt-4">

                        <button
                            type="submit"
                            class="px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700"
                        >
                            Reservar cita
                        </button>

                        <a
                            href="{{ route('dashboard') }}"
                            class="px-4 py-2 border rounded"
                        >
                            Cancelar
                        </a>

                    </div>

                </div>

            </form>

        </div>

    </div>

</x-app-layout>
