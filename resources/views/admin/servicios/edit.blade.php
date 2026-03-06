<x-app-layout>
  <x-slot name="header">
    <h2 class="font=semibold text-xl text-gray-800 leading-tight">
      Editar servicio
    </h2>
  </x-slot>

  <div class="p-6">
    <div class="bg-white shadow rounded p-6 max-w-2xl">
      <form method="POST" action="{{ route('admin.servicios.update', $servicio) }}">
        @csrf 
        @method('PUT')
        @include('admin.servicios._form', ['servicio' => $servicio])

        <div class="flex gap-2 mt-6">
          <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded">Guardar</button>
          <a href="{{ route('admin.servicios.index') }}" class="px-4 py-2 border rounded">Cancelar</a>
        </div>
      </form>
    </div>
  </div>
</x-app-layout>