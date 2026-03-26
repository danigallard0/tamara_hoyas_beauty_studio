<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Panel de cliente
        </h2>
    </x-slot>

    <div class="p-6">
        <div class="bg-white shadow rounded p-6">
            <h3 class="text-lg font-semibold mb-4">Bienvenido/a a tu panel</h3>

            <div class="flex gap-3">
                <a href="{{ route('cliente.citas.create') }}"
                   class="px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700">
                    Reservar cita
                </a>

                <a href="{{ route('cliente.citas.index') }}"
                   class="px-4 py-2 border rounded">
                    Ver mis citas
                </a>
            </div>
        </div>
    </div>
</x-app-layout>