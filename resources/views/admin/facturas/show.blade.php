<x-app-layout>
    <x-slot name="header">
        <h2 class="text-2xl font-bold text-pink-700">
            Factura {{ $factura->numero_factura }}
        </h2>
    </x-slot>

    <div class="min-h-screen bg-pink-50">
    <div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8 py-8">

        <div class="bg-white rounded-2xl shadow-md p-6 md:p-8">
            <div class="mb-8 p-5 bg-pink-50 border border-pink-100 rounded-2xl">
                <h3 class="text-xl font-semibold text-pink-700 mb-2">
                    Datos fiscales del centro
                </h3>

                <p><strong>Nombre:</strong> Tamara Hoyas Beauty Studio</p>
                <p><strong>Dirección:</strong> C/ Ejemplo 10, Mérida</p>
                <p><strong>CIF/NIF:</strong> 12345678A</p>
                <p><strong>Email:</strong> tamarahoyas.micropigmentacion@gmail.com</p>
                <p><strong>Teléfono:</strong> 639432404</p>
            </div>
            <div class="mb-6">
                <h3 class="text-xl font-semibold text-pink-700 mb-2">Datos de la factura</h3>
                <p><strong>Número:</strong> {{ $factura->numero_factura }}</p>
                <p><strong>Fecha de emisión:</strong> {{ $factura->fecha_emision }}</p>
                <p><strong>Estado:</strong> {{ ucfirst($factura->estado_factura) }}</p>
            </div>

            <div class="mb-6">
                <h3 class="text-xl font-semibold text-pink-700 mb-2">Cliente</>
                <p><strong>Nombre:</strong> {{ $factura->cita->user->name ?? 'Sin nombre' }}</p>
                <p><strong>Email:</strong> {{ $factura->cita->user->email ?? 'Sin email' }}</p>
            </div>

            <div class="mb-6">
                <h3 class="text-xl font-semibold text-pink-700 mb-2">Servicios</h3>
                <ul class="list-disc pl-6">
                    @foreach($factura->cita->servicios as $servicio)
                        <li>
                            {{ $servicio->nombre }} -
                            {{ number_format($servicio->pivot->precio_aplicado, 2) }} €
                        </li>
                    @endforeach
                </ul>
            </div>

            <div class="border-t border-pink-100 pt-6 space-y-1">
                <p><strong>Base imponible:</strong> {{ number_format($factura->base_imponible, 2) }} €</p>
                <p><strong>IVA ({{ number_format($factura->iva_porcentaje, 2) }}%):</strong> {{ number_format($factura->iva_importe, 2) }} €</p>
                <p class="text-lg font-bold"><strong>Total:</strong> {{ number_format($factura->total, 2) }} €</p>
                <p><strong>Total pagado:</strong> {{ number_format($factura->total_pagado, 2) }} €</p>
                <p><strong>Pendiente:</strong> {{ number_format($factura->total - $factura->total_pagado, 2) }} €</p>
                <p><strong>Estado de cobro:</strong> {{ ucfirst($factura->estado_cobro) }}</p>
            </div>

           <div class="mt-8 border-t border-pink-100 pt-6">
            <h3 class="text-xl font-semibold text-pink-700 mb-4">Registrar pago</h3>

    @if($factura->estado_cobro !== 'pagado')
        <form method="POST" action="{{ route('admin.pagos.store', $factura) }}" class="space-y-4">
            @csrf

            <div>
                <label for="metodo" class="block font-medium mb-1">Método de pago</label>
                <select name="metodo" id="metodo" class="w-full border border-pink-200 rounded-lg p-2.5 focus:border-pink-500 focus:ring-pink-500" required>
                    <option value="">Selecciona un método</option>
                    <option value="efectivo">Efectivo</option>
                    <option value="tarjeta">Tarjeta</option>
                    <option value="bizum">Bizum</option>
                    <option value="transferencia">Transferencia</option>
                </select>

                @error('metodo')
                    <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label for="importe" class="block font-medium mb-1">Importe</label>
                <input type="number"
                       name="importe"
                       id="importe"
                       step="0.01"
                       min="0.01"
                       class="w-full border border-pink-200 rounded-lg p-2.5 focus:border-pink-500 focus:ring-pink-500"
                       required>

                @error('importe')
                    <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label for="referencia" class="block font-medium mb-1">Referencia</label>
                <input type="text"
                       name="referencia"
                       id="referencia"
                       class="w-full border border-pink-200 rounded-lg p-2.5 focus:border-pink-500 focus:ring-pink-500">

                @error('referencia')
                    <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <button type="submit"
                    onclick="return confirm('¿Deseas registrar este pago?')"
                    class="px-4 py-2 bg-pink-600 text-white rounded-lg hover:bg-pink-700 focus:outline-none focus:ring-2 focus:ring-pink-500">
                Registrar pago
            </button>
        </form>
    @else
        <div class="p-3 bg-green-100 text-green-800 rounded">
            Esta factura ya está completamente pagada.
        </div>
    @endif
</div>

            <div class="mt-8 border-t border-pink-100 pt-6">
                <h3 class="text-xl font-semibold text-pink-700 mb-4">Pagos registrados</h3>

                @if($factura->pagos->isEmpty())
                    <p class="text-gray-600">Todavía no hay pagos registrados para esta factura.</p>
                @else
                    <div class="space-y-3">
                        @foreach($factura->pagos as $pago)
                            <div class="p-4 border border-pink-100 rounded-xl bg-pink-50">
                                <p><strong>Importe:</strong> {{ number_format($pago->importe, 2) }} €</p>
                                <p><strong>Método:</strong> {{ ucfirst($pago->metodo) }}</p>
                                <p><strong>Estado:</strong> {{ ucfirst($pago->estado) }}</p>
                                <p><strong>Fecha de pago:</strong> {{ $pago->fecha_pago }}</p>
                                <p><strong>Referencia:</strong> {{ $pago->referencia ?: 'Sin referencia' }}</p>
                            </div>
                        @endforeach
                    </div>
                @endif
            </div>

            <div class="mt-6 flex gap-2">
                <a href="{{ route('admin.facturas.imprimir', $factura) }}"
                   target="_blank"
                   class="inline-block px-4 py-2 bg-pink-600 text-white rounded-lg hover:bg-pink-700 focus:outline-none focus:ring-2 focus:ring-pink-500">
                    Imprimir factura
                </a>
                <a href="{{ route('admin.calendario.index') }}"
                   class="inline-block px-4 py-2 border border-pink-600 text-pink-700 rounded-lg hover:bg-pink-50 focus:outline-none focus:ring-2 focus:ring-pink-500">
                    Volver al calendario
                </a>
            </div>
        </div>
    </div>
</x-app-layout>