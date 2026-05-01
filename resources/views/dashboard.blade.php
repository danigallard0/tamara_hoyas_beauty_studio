<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center gap-3">
            <img src="{{ asset('images/logo.png') }}"
                 alt="Logo"
                class="h-10 w-auto object-contain">

            <h2 class="font-semibold text-xl text-pink-600 leading-tight">
                Panel de cliente
            </h2>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    {{ __("You're logged in!") }}
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
