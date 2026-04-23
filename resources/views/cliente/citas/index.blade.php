<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Mis citas
        </h2>
    </x-slot>
    <div class="mb-4">
        <a href="{{ route('cliente.dashboard') }}"
          class="inline-block px-4 py-2 border rounded hover:bg-gray-50">
          ← Volver al panel cliente
        </a>
    </div>

    <div class="p-6 max-w-5xl">
        
        <div class="bg-white shadow rounded p-6">
            @forelse($citas as $cita)
                <div class="border-b py-4 flex justify-between items-start">
                    <div>
                        <p><strong>Fecha:</strong> {{ $cita->fecha_cita }}</p>
                        <p>
                            <strong>Hora:</strong>
                            {{ \Carbon\Carbon::parse($cita->hora_inicio)->format('H:i') }}
                            -
                            {{ \Carbon\Carbon::parse($cita->hora_fin)->format('H:i') }}
                        </p>
                        <p>
                            <strong>Servicio:</strong>
                            {{ $cita->servicios->pluck('nombre')->join(', ') }}
                        </p>
                        <p>
                            <strong>Estado:</strong>
                            <span class="{{ $cita->estado === 'cancelada' ? 'text-red-600' : 'text-green-600' }}">
                                {{ ucfirst($cita->estado) }}
                            </span>
                        </p>
                    </div>

                    @if($cita->estado !== 'cancelada')
                        <form method="POST" action="{{ route('cliente.citas.destroy', $cita) }}">
                            @csrf
                            @method('DELETE')

                            <button
                                type="submit"
                                class="px-3 py-2 text-red-600 border border-red-600 rounded hover:bg-red-50"
                                onclick="return confirm('¿Seguro que quieres cancelar esta cita?')"
                            >
                                Cancelar cita
                            </button>
                        </form>
                    @endif
                </div>
            @empty
                <p>No tienes citas registradas.</p>
            @endforelse
        </div>
    </div>
</x-app-layout>