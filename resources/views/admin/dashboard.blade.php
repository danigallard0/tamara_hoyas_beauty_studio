<x-app-layout>
  <x-slot name="header">
    <h2 class="text-2xl font-bold text-pink-700">
      Panel de administración
    </h2>
  </x-slot>

  <div class="min-h-screen bg-pink-50">
  <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">

    <div class="bg-white rounded-2xl shadow-md p-8">
      <h3 class="text-2xl font-bold text-gray-900 mb-2">
      Bienvenido/a, administrador/a
    </h3>
    <p class="text-gray-600 mb-8">
      Desde aquí podrás gestionar los servicios, los horarios, las citas y el calendario del centro.
    </p>
    <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-3 gap-6">
      <a href="{{ route('admin.servicios.index') }}"
         class="block p-6 bg-white rounded-2xl shadow-md hover:shadow-lg transition">
            <h4 class="text-lg font-semibold text-pink-700 mb-1">Gestionar servicios</h4>
            <p class="text-sm text-gray-600">Crear, editar y desactivar servicios.</p>
      </a>
      
      <a href="{{ route('admin.horarios.index') }}"
         class="block p-6 bg-white rounded-2xl shadow-md hover:shadow-lg transition">
            <h4 class="text-lg font-semibold text-pink-700 mb-1">Gestionar horarios</h4>
            <p class="text-sm text-gray-600">Crear y editar los horarios del centro.</p>
      </a>

      <a href="{{ route('admin.calendario.index') }}" 
         class="block p-6 bg-white rounded-2xl shadow-md hover:shadow-lg transition">
            <h4 class="text-lg font-semibold text-pink-700 mb-1">Calendario</h4>
            <p class="text-sm text-gray-600">Visualiza las citas el centro en el calendario.</p>
      </a>
    </div>
  </div>
  </div>

  </div>
</x-app-layout>