<x-app-layout>
  <x-slot name="header">
    <h2 class="font-semibold text-xl text-gray-800 leading-tight">
    </h2>
  </x-slot>

  <div class="p-6">
    <h3 class="text-lg font-bold">
      Bienvenida, {{auth()->user()->nombre ?? auth()->user()->name }}
    </h3>

    <p class="mt-2">
      Aquí gestionaremos las citas y el calendario.
    </p>
  </div>
</x-app-layout>