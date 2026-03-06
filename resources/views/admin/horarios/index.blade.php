<x-app-layout>
  <x-slot name="header">
    <h2 class="font-semibold text-xl">Horarios</h2>
  </x-slot>

  <div class="p-6">
    <a href="{{ route('admin.horarios.create') }}" class="mb-4 inline-block px-4 py-2 bg-blue-600 text-white rounded">Nuevo horario</a>

    @if(session('success'))
      <div class="mb-4 p-3 bg-green-100 text-green-800 rounded">
        {{ session('success') }}
      </div>
    @endif

    <table class="w-full border">
      <thead class="bg-gray-100">
        <tr>
          <th class="p-2">Día</th>
          <th class="p-2">Inicio</th>
          <th class="p-2">Fin</th>
          <th class="p-2">Activo</th>
          <th class="p-2">Acciones</th>
        </tr>
      </thead>

      <tbody>
        @foreach($horarios as $horario)
          <tr class="border-t">
            <td class="p-2">{{ $horario->dia_semana }}</td>
            <td class="p-2">{{ $horario->hora_inicio }}</td>
            <td class="p-2">{{ $horario->hora_fin }}</td>
            <td class="p-2">{{ $horario->activo ? 'Sí' : 'No' }}</td>

            <td class="p-2 flex gap-2">
              <a href="{{ route('admin.horarios.edit', $horario) }}" class="text-blue-600">Editar</a>
              <form method="POST" action="{{ route('admin.horarios.destroy', $horario) }}">
              @csrf 
              @method('DELETE')
              <button type="submit" class="text-red-600">Eliminar</button>
              </form>
            </td>
          </tr>
        @endforeach 
      </tbody>
    </table>
  </div>
</x-app-layout>
