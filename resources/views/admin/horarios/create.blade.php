<x-app-layout>
  <x-slot name="header">
    <h2 class="font-semibold text-xl">Crear horario</h2>
  </x-slot>

  <div class="p-6">
    <div class="bg-white shadow rounded p-6 max-w-xl">
      <form method="POST" action="{{ route('admin.horarios.store') }}">
        @csrf
        @include('admin.horarios._form')
        <div class="mt-6 flex gap-2">
          <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700">Crear</button>

          <a href="{{ route('admin.horarios.index') }}" class="px-4 py-2 border rounded">Cancelar</a>
        </div>
      </form>
    </div>
  </div>
</x-app-layout>