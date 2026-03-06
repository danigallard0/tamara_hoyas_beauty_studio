<x-app-layout>
  <x-slot name="header">
    <h2 class="font-semibold text-xl">Editar horario</h2>
  </x-slot>

  <div class="p-6">
    <div class="bg-white shadow rounded p-6 mex-w-xl">
      <form method="POST" action="{{ route('admin.horarios.update', $horario) }}">
        @csrf 
        @method('PUT')
        @include('admin.horarios._form')

        <div class="mt-6 flex gap-2">
          <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700">Guardar</button>
          <a href="{{ route('admin.horarios.index') }}" class="px-4 py-2 border rounded">Cancelar</a>
        </div>
      </form>
    </div>
  </div>
</x-app-layout>