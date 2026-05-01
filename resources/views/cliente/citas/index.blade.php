<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Mis citas
        </h2>
    </x-slot>
    <div class="px-6 pt-6 mb-4">
        <a href="{{ route('cliente.dashboard') }}"
            class="inline-flex items-center px-4 py-2 border border-pink-600 text-pink-700 rounded-lg hover:bg-pink-50 focus:outline-none focus:ring-2 focus:ring-pink-500">
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
                            @if($cita->estado === 'confirmada')
                                <span class="inline-block px-3 py-1 text-sm font-semibold rounded-full bg-green-100 text-green-800">
                                    Confirmada
                                </span>
                            @elseif($cita->estado === 'pendiente')
                                <span class="inline-block px-3 py-1 text-sm font-semibold rounded-full bg-yellow-100 text-yellow-800">
                                    Pendiente de pago
                                </span>
                            @elseif($cita->estado === 'cancelada')
                                <span class="inline-block px-3 py-1 text-sm font-semibold rounded-full bg-red-100 text-red-800">
                                    Cancelada
                                </span>
                            @else
                                <span class="inline-block px-3 py-1 text-sm font-semibold rounded-full bg-gray-100 text-gray-800">
                                    {{ ucfirst($cita->estado) }}
                                </span>
                            @endif
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