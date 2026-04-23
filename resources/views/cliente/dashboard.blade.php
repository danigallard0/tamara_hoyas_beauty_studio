<x-app-layout>
    <x-slot name="header">
        <h2 class="text-2xl font-bold text-pink-700">
            Bienevenida/o {{ Auth::user()->name }}
        </h2>
    </x-slot>

    <div class="min-h-screen bg-pink-50">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <div class="bg-white rounded-2xl shadow-md p-8">
            <h3 class="text-2xl font-bold text-gray-900 mb-2">Gestiona tus citas</h3>
                <p class="text-gray-600 mb-8">
                    Reserva nuevas citas, consulta tus reservas y gestiona tu agenda de forma sencilla.
                </p>

            <div class="flex flex-col sm:flex-row gap-4">
                <a href="{{ route('cliente.citas.create') }}"
                   class="inline-block px-4 py-2 bg-pink-600 text-white rounded-lg hover:bg-pink-700 focus:outline-none focus:ring-2 focus:ring-pink-500 text-center">
                    Reservar cita
                </a>

                <a href="{{ route('cliente.citas.index') }}"
                   class="inline-block px-4 py-2 border border-pink-600 text-pink-700 rounded-lg hover:bg-pink-50 focus:outline-none focus:ring-2 focus:ring-pink-500 text-center">
                    Ver mis citas
                </a>
            </div>
        </div>
    </div>
    </div>
</x-app-layout>