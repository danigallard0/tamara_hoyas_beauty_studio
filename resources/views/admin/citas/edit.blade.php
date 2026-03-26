<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Editar cita
        </h2>
    </x-slot>

    <div class="p-6">
        <div class="bg-white shadow rounded p-6 max-w-xl">

            <!-- Formulario -->
            <form method="POST" action="{{ route('admin.citas.update', $cita) }}">
                @csrf
                @method('PUT')

                <!-- SERVICIO -->
                <div class="mb-4">
                    <label class="block mb-1">Servicio</label>
                    <select name="servicio_id" class="w-full border rounded p-2">
                        @foreach($servicios as $servicio)
                            <option value="{{ $servicio->id }}"
                                {{ $cita->servicios->contains($servicio->id) ? 'selected' : '' }}>
                                {{ $servicio->nombre }} ({{ $servicio->precio }}€)
                            </option>
                        @endforeach
                    </select>
                </div>

                <!-- FECHA -->
                <div class="mb-4">
                    <label class="block mb-1">Fecha</label>
                    <input type="date"
                           name="fecha_cita"
                           value="{{ $cita->fecha_cita }}"
                           class="w-full border rounded p-2">
                </div>

                <!-- HORA INICIO -->
                <div class="mb-4">
                    <label class="block mb-1">Hora inicio</label>
                    <input type="time"
                           name="hora_inicio"
                           value="{{ substr($cita->hora_inicio, 0, 5) }}"
                           class="w-full border rounded p-2">
                </div>

                <!-- HORA FIN -->
                <div class="mb-4">
                    <label class="block mb-1">Hora fin</label>
                    <input type="time"
                           name="hora_fin"
                           value="{{ substr($cita->hora_fin, 0, 5) }}"
                           class="w-full border rounded p-2">
                </div>

                <!-- ESTADO -->
                <div class="mb-4">
                    <label class="block mb-1">Estado</label>
                    <select name="estado" class="w-full border rounded p-2">
                        <option value="pendiente" {{ $cita->estado == 'pendiente' ? 'selected' : '' }}>Pendiente</option>
                        <option value="confirmada" {{ $cita->estado == 'confirmada' ? 'selected' : '' }}>Confirmada</option>
                        <option value="cancelada" {{ $cita->estado == 'cancelada' ? 'selected' : '' }}>Cancelada</option>
                    </select>
                </div>

                <!-- MENSAJE -->
                <div class="mb-4">
                    <label class="block mb-1">Observaciones</label>
                    <textarea name="mensaje_cliente"
                              class="w-full border rounded p-2">{{ $cita->mensaje_cliente }}</textarea>
                </div>

                <!-- BOTONES -->
                <div class="flex gap-2">
                    <button type="submit"
                            class="bg-blue-600 text-white px-4 py-2 rounded">
                        Actualizar cita
                    </button>

                    <a href="{{ route('admin.calendario.index') }}"
                       class="px-4 py-2 border rounded">
                        Volver
                    </a>
                </div>

            </form>

        </div>
    </div>
</x-app-layout>