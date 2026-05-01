<x-app-layout>
    <x-slot name="header">
        <h2 class="text-2xl font-bold text-pink-700">
            Pago de reserva
        </h2>
    </x-slot>

    <div class="min-h-screen bg-pink-50">
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
            <div class="bg-white rounded-2xl shadow-md p-6 md:p-8">
                <div class="flex items-center gap-3 mb-6">
                    <img src="{{ asset('public/images/logo/logotransparente.PNG') }}"
                        alt="Tamara Hoyas Beauty Studio"
                        class="h-12 w-auto object-contain">

                    <div>
                        <h3 class="text-2xl font-bold text-gray-900">
                            Resumen de la reserva
                        </h3>
                        <p class="text-gray-600">
                            Revisa los datos de tu cita y confirma la reserva abonando el anticipo obligatorio.
                        </p>
                    </div>
                </div>

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

            <div class="mt-6 p-5 bg-pink-50 border border-pink-100 rounded-2xl">
                <p><strong>Base imponible:</strong> {{ number_format($cita->factura->base_imponible, 2) }} €</p>
                <p><strong>IVA:</strong> {{ number_format($cita->factura->iva_importe, 2) }} €</p>
                <p><strong>Total factura:</strong> {{ number_format($cita->factura->total, 2) }} €</p>
                <p class="text-xl font-bold text-pink-700 mt-3">
                    Anticipo obligatorio (20%): {{ number_format($anticipo, 2) }} €
                </p>
            </div>

            <form method="POST" action="{{ route('cliente.citas.pagar', $cita) }}" class="mt-6">
                @csrf

                <div class="mb-4">
                    <label for="metodo" class="block font-medium mb-1">Método de pago</label>
                    <select name="metodo" id="metodo" class="w-full border border-pink-200 rounded-lg p-2.5 focus:border-pink-500 focus:ring-pink-500" required>
                        <option value="">Selecciona un método</option>
                        <option value="tarjeta">Tarjeta</option>
                        <option value="bizum">Bizum</option>
                        <option value="transferencia">Transferencia</option>
                    </select>

                    @error('metodo')
                        <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div class="flex flex-col sm:flex-row gap-3">
                    <button type="submit"
                            onclick="return confirm('¿Deseas simular el pago del anticipo para confirmar la reserva?')"
                            class="px-4 py-2 bg-pink-600 text-white rounded-lg hover:bg-pink-700 focus:outline-none focus:ring-2 focus:ring-pink-500">
                        Pagar ahora
                    </button>

                    <a href="{{ route('cliente.citas.index') }}"
                       class="px-4 py-2 border border-pink-600 text-pink-700 rounded-lg hover:bg-pink-50 focus:outline-none focus:ring-2 focus:ring-pink-500 text-center">
                        Volver a mis citas
                    </a>
                </div>
            </form>
            </div>
        </div>
    </div>
</x-app-layout>