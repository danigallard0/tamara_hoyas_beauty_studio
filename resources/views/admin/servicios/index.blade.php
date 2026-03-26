<x-app-layout>
  <x-slot name="header">
    <div class="flex items-center justify-between">
      <h2 class="font-semibold text-xl text-gray-800 leading-tight">
      Servicios
      </h2>

      <a href="{{ route('admin.servicios.create') }}"
        class="px-4 py-2 bg-black text-white rounded">
        + Nuevo servicio
      </a>
    </div>
  </x-slot>

  <div class="mb-4">
      <a href="{{ route('admin.dashboard') }}"
         class="inline-block px-4 py-2 border rounded hover:bg-gray-50">
          ← Volver al panel de administración
      </a>
  </div>

  <div class="p-6 space-y-4">
    @if(session('success'))
      <div class="mb-4 p-3 bg-green-100 text-grenn-800 rounded">
        {{ session('success') }}
      </div>
    @endif 

    <div class="bg-white shadow rounded p-4 overflow-x-auto">
      <table class="min-w-full text-sm">
        <thead>
        <tr class="text-left border-b">
          <th class="py-2">Nombre</th>
          <th class="py-2">Tipo</th>
          <th class="py-2">Duración</th>
          <th class="py-2">Precio</th>
          <th class="py-2">Activo</th>
          <th class="py-2 text-right">Acciones</th>
        </tr>
        </thead>

        <tbody>
        @forelse($servicios as $s)
          <tr class="border-b align-top">
            <td class="py-2 font-medium">{{ $s->nombre }}</td>
            <td class="py-2">{{ $s->tipo_servicio === 'micropigmentacion' ? 'Micropigmentación' : 'Maquillaje' }}</td>
            <td class="py-2">{{ $s->duracion_min }} min</td>
            <td class="py-2">{{ number_format((float)$s->precio, 2) }} €</td>
            <td class="py-2">
              @if($s->activo)
                <span class="px-2 py-1 rounded bg-green-100">Sí</span> 
              @else
                <span class="px-2 py-1 rounded bg-gray-200">No</span>
              @endif
            </td>
            <td class="py-2 text-right space-x-2 whitespace-nowrap">
              <a class="underline" href="{{ route('admin.servicios.edit', $s) }}">editar</a>

              @if($s->activo)
                <form action="{{ route('admin.servicios.destroy', $s) }}"
                   method="POST" class="inline">
                  @csrf 
                  @method('DELETE')
                  <button class="underline text-red-600" onlick="return confirm('¿Desactivar este servicio?'">Desactivar</button>
                </form>
              @endif 
            </td>
          </tr>
        @empty
          <tr>
            <td class="py-3" colspan="6">No hay servicios.</td>
          </tr>
        @endforelse
        </thbody>
      </table>
    </div>
  </div>
</x-app-layout>