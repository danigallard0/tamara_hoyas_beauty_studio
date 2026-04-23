<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Micropigmentación de cejas</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-pink-50 text-gray-800">

    <header class="bg-white shadow-sm">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-4 flex justify-between items-center">
            <a href="{{ url('/') }}" class="text-2xl font-bold text-pink-700">
                Tamara Hoyas Beauty Studio
            </a>

            <div class="flex gap-2">
                <a href="{{ route('servicios.index') }}"
                   class="px-4 py-2 border border-pink-600 text-pink-700 rounded hover:bg-pink-50">
                    Volver a servicios
                </a>

                @auth
                    <a href="{{ route('cliente.citas.create') }}"
                       class="px-4 py-2 bg-pink-600 text-white rounded hover:bg-pink-700">
                        Reservar cita
                    </a>
                @else
                    <a href="{{ route('register') }}"
                       class="px-4 py-2 bg-pink-600 text-white rounded hover:bg-pink-700">
                        Reservar cita
                    </a>
                @endauth
            </div>
        </div>
    </header>

    <main class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-16">
        <div class="mb-10">
            <h1 class="text-4xl font-bold text-gray-900 mb-4">Micropigmentación de cejas</h1>
            <p class="text-gray-600 max-w-3xl">
                Tratamiento orientado a definir, corregir y realzar la forma de las cejas,
                consiguiendo un resultado armónico, natural y duradero.
            </p>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
            <img src="{{ asset('images/servicios/1.jpg') }}" alt="Cejas 1"
                 class="lightbox-image w-full h-80 object-cover rounded-2xl shadow-md cursor-pointer hover:scale-[1.02] transition">

            <img src="{{ asset('images/servicios/micropigmentacion-cejas-003.jpg') }}" alt="Cejas 2"
                 class="lightbox-image w-full h-80 object-cover rounded-2xl shadow-md cursor-pointer hover:scale-[1.02] transition">

            <img src="{{ asset('images/servicios/Micropigmentacion-Cejas-Carolina-de-la-Rosa-web-low-2.jpg') }}" alt="Cejas 3"
                 class="lightbox-image w-full h-80 object-cover rounded-2xl shadow-md cursor-pointer hover:scale-[1.02] transition">
        </div>
    </main>

    <!-- Lightbox -->
    <div id="lightbox"
         class="fixed inset-0 bg-black/80 hidden items-center justify-center z-50 p-4">
        <button id="cerrarLightbox"
                class="absolute top-4 right-4 text-white text-4xl leading-none">
            &times;
        </button>

        <img id="lightboxImg"
             src=""
             alt="Imagen ampliada"
             class="max-w-full max-h-[90vh] rounded-xl shadow-2xl">
    </div>

    <script>
        const imagenes = document.querySelectorAll('.lightbox-image');
        const lightbox = document.getElementById('lightbox');
        const lightboxImg = document.getElementById('lightboxImg');
        const cerrarLightbox = document.getElementById('cerrarLightbox');

        imagenes.forEach(img => {
            img.addEventListener('click', function () {
                lightboxImg.src = this.src;
                lightbox.classList.remove('hidden');
                lightbox.classList.add('flex');
            });
        });

        cerrarLightbox.addEventListener('click', function () {
            lightbox.classList.add('hidden');
            lightbox.classList.remove('flex');
        });

        lightbox.addEventListener('click', function (e) {
            if (e.target === lightbox) {
                lightbox.classList.add('hidden');
                lightbox.classList.remove('flex');
            }
        });
    </script>
</body>
</html>