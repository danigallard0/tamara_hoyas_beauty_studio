<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" type="image/png" href="{{ asset('favicon-app.png') }}?v=2">
    <title>Servicios - Tamara Hoyas Beauty Studio</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-pink-50 text-gray-800">

    <header class="bg-white shadow-sm">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-4 flex justify-between items-center">
            <a href="{{ url('/') }}" class="text-2xl font-bold text-pink-700">
                Tamara Hoyas Beauty Studio
            </a>

            <a href="{{ url('/') }}"
               class="px-4 py-2 border border-pink-600 text-pink-700 rounded hover:bg-pink-50">
                Volver al inicio
            </a>
        </div>
    </header>

    <main class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-16">
        <div class="text-center mb-12">
            <h1 class="text-4xl font-bold text-gray-900">Nuestros servicios</h1>
            <p class="text-gray-600 mt-3">Descubre cada tratamiento y consulta su galería</p>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">

            <a href="{{ route('servicios.cejas') }}"
               class="bg-white rounded-2xl shadow-md overflow-hidden hover:shadow-lg transition">
                <img src="{{ asset('images/servicios/1.jpg') }}"
                     alt="Micropigmentación de cejas"
                     class="w-full h-72 object-cover">
                <div class="p-6">
                    <h2 class="text-xl font-semibold text-pink-700 mb-2">Micropigmentación de cejas</h2>
                    <p class="text-gray-600">Diseño y armonización de cejas con acabado natural.</p>
                </div>
            </a>

            <a href="{{ route('servicios.ojos') }}"
               class="bg-white rounded-2xl shadow-md overflow-hidden hover:shadow-lg transition">
                <img src="{{ asset('images/servicios/micropigmentacion-eyeliner-1.jpeg') }}"
                     alt="Micropigmentación de ojos"
                     class="w-full h-72 object-cover">
                <div class="p-6">
                    <h2 class="text-xl font-semibold text-pink-700 mb-2">Micropigmentación de ojos</h2>
                    <p class="text-gray-600">Definición de la mirada con resultados elegantes y duraderos.</p>
                </div>
            </a>

            <a href="{{ route('servicios.labios') }}"
               class="bg-white rounded-2xl shadow-md overflow-hidden hover:shadow-lg transition">
                <img src="{{ asset('images/servicios/Micropigmentacion-de-labios-1.png') }}"
                     alt="Micropigmentación de labios"
                     class="w-full h-72 object-cover">
                <div class="p-6">
                  <h2 class="text-xl font-semibold text-pink-700 mb-2">Micropigmentación de labios</h2>
                  <p class="text-gray-600">Color, definición y embellecimiento natural de los labios.</p>
                </div>
            </a>

            <a href="{{ route('servicios.areolas') }}"
               class="bg-white rounded-2xl shadow-md overflow-hidden hover:shadow-lg transition">
                <img src="{{ asset('images/servicios/05-Micropigmentacion-de-areolas-y-pezones.jpg') }}"
                     alt="Micropigmentación de areolas"
                     class="w-full h-72 object-cover">
                <div class="p-6">
                  <h2 class="text-xl font-semibold text-pink-700 mb-2">Micropigmentación de areolas</h2>
                  <p class="text-gray-600">Tratamiento especializado orientado a la reconstrucción estética.</p>
                </div>
            </a>

            <a href="{{ route('servicios.maquillaje') }}"
               class="bg-white rounded-2xl shadow-md overflow-hidden hover:shadow-lg transition">
                <img src="{{ asset('images/servicios/maquillaje-profesional-en-o-porriño-mv.jpg') }}"
                     alt="Maquillaje profesional"
                     class="w-full h-72 object-cover">
                <div class="p-6">
                    <h2 class="text-xl font-semibold text-pink-700 mb-2">Maquillaje profesional</h2>
                    <p class="text-gray-600">Maquillaje para eventos, sesiones y ocasiones especiales.</p>
                </div>
            </a>

        </div>
    </main>
</body>
</html>