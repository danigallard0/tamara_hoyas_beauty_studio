<x-app-layout>
  <x-slot name="header">
    <h2 class="font-semibold text-xl text-gray-800 leading-tight">
      Panel de administración
    </h2>
  </x-slot>

  <div class="p-6">
    <div class="bg-white shadow rounded p-6">
      <h3 class="text-lg font-semibold mb-2">
      Bienvenido/a, administrador/a
    </h3>
    <p class="text-gray-600 mb-6">
      Desde aquí podrás gestionar los servicios, los horarios, las citas y el calendario del centro.
    </p>
    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
      <a href="{{ route('admin.servicios.index') }}"
         class="block p-4 border rounded hover:bg-gray-50">
            <h4 class="font-semibold">Gestionar servicios</h4>
            <p class="text-sm text-gray-600">Crear, editar y desactivar servicios.</p>
      </a>
      
      <a href="{{ route('admin.horarios.index') }}"
         class="block p-4 border rounded hover:bg-gray-50">
            <h4 class="font-semibold">Gestionar horarios</h4>
            <p class="text-sm text-gray-600">Crear y editar los horarios del centro.</p>
      </a>

      <a href="{{ route('admin.calendario.index') }}" 
         class="block p-4 border rounded hover:bg-gray-50">
            <h4 class="font-semibold">Calendario</h4>
            <p class="text-sm text-gray-600">Visualiza las citas el centro en el calendario.</p>
      </a>
    </div>
    </div>
  </div>
</x-app-layout>