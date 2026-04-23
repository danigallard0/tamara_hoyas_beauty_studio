<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Pago de reserva
        </h2>
    </x-slot>

    <div class="p-6 max-w-3xl">
        <div class="bg-white shadow rounded p-6">
            <h3 class="text-lg font-semibold mb-4">Resumen de la reserva</h3>

            <p><strong>Fecha:</strong> {{ $cita->fecha_cita }}</p>
            <p>
                <strong>Hora:</strong>
                {{ \Carbon\Carbon::createFromFormat('H:i:s', $cita->hora_inicio)->format('H:i') }}
                -
                {{ \Carbon\Carbon::createFromFormat('H:i:s', $cita->hora_fin)->format('H:i') }}
            </p>
            <p>
                <strong>Servicio:</strong>
                {{ $cita->servicios->pluck('nombre')->join(', ') }}
            </p>

            <div class="mt-4 p-4 bg-gray-50 rounded">
                <p><strong>Base imponible:</strong> {{ number_format($cita->factura->base_imponible, 2) }} €</p>
                <p><strong>IVA:</strong> {{ number_format($cita->factura->iva_importe, 2) }} €</p>
                <p><strong>Total factura:</strong> {{ number_format($cita->factura->total, 2) }} €</p>
                <p class="text-lg font-bold mt-2">
                    Anticipo obligatorio (20%): {{ number_format($anticipo, 2) }} €
                </p>
            </div>

            <form method="POST" action="{{ route('cliente.citas.pagar', $cita) }}" class="mt-6">
                @csrf

                <div class="mb-4">
                    <label for="metodo" class="block font-medium mb-1">Método de pago</label>
                    <select name="metodo" id="metodo" class="w-full border rounded p-2" required>
                        <option value="">Selecciona un método</option>
                        <option value="tarjeta">Tarjeta</option>
                        <option value="bizum">Bizum</option>
                        <option value="transferencia">Transferencia</option>
                    </select>

                    @error('metodo')
                        <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div class="flex gap-2">
                    <button type="submit"
                            onclick="return confirm('¿Deseas simular el pago del anticipo para confirmar la reserva?')"
                            class="px-4 py-2 bg-green-600 text-white rounded hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-green-500">
                        Pagar ahora
                    </button>

                    <a href="{{ route('cliente.citas.index') }}"
                       class="px-4 py-2 border rounded hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-blue-500">
                        Volver a mis citas
                    </a>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>