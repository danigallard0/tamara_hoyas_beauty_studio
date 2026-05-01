<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="icon" type="image/png" href="{{ asset('favicon.png') }}">
    <title>Tamara Hoyas Beauty Studio</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-pink-50 text-gray-800">

    <!-- Header -->
    <header class="bg-white shadow-sm sticky top-0 z-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex items-center justify-between py-4">
                <div class="flex items-center gap-3">
                    <img src="{{ asset('public/images/logo/logotransparente.PNG') }}"
                        alt="Tamara Hoyas Beauty Studio"
                        class="h-14 w-auto object-contain">

                    <div>
                        <h1 class="text-2xl font-bold text-pink-700">
                            Tamara Hoyas Beauty Studio
                        </h1>
                        <p class="text-sm text-gray-600">
                            Micropigmentación y maquillaje profesional
                        </p>
                    </div>
                </div>

                <nav class="hidden md:flex items-center gap-4 lg:gap-6 text-sm font-medium">
                    <a href="#inicio" class="hover:text-pink-700">Inicio</a>
                    <a href="{{ route('servicios.index') }}" class="hover:text-pink-700">Servicios</a>
                    <a href="#como-funciona" class="hover:text-pink-700">Cómo funciona</a>
                    <a href="#contacto" class="hover:text-pink-700">Contacto</a>
                </nav>

                <div class="flex items-center gap-3 ml-4 lg:ml-6">
                    @auth
                        @if(auth()->user()->role === 'admin')
                            <a href="{{ route('admin.dashboard') }}"
                               class="px-4 py-2 bg-pink-600 text-white rounded hover:bg-pink-700 focus:outline-none focus:ring-2 focus:ring-pink-500">
                                Panel admin
                            </a>
                        @else
                            <a href="{{ route('cliente.dashboard') }}"
                               class="px-4 py-2 bg-pink-600 text-white rounded hover:bg-pink-700 focus:outline-none focus:ring-2 focus:ring-pink-500">
                                Mi panel
                            </a>
                        @endif
                    @else
                        <a href="{{ route('login') }}"
                           class="px-4 py-2 border border-pink-600 text-pink-700 rounded hover:bg-pink-50 focus:outline-none focus:ring-2 focus:ring-pink-500">
                            Iniciar sesión
                        </a>

                        @if(Route::has('register'))
                            <a href="{{ route('register') }}"
                               class="hidden sm:inline-block px-4 py-2 bg-pink-600 text-white rounded hover:bg-pink-700 focus:outline-none focus:ring-2 focus:ring-pink-500">
                                Registrarse
                            </a>
                        @endif
                    @endauth
                </div>
            </div>
        </div>
    </header>

    <!-- Hero -->
    <section id="inicio" class="bg-gradient-to-r from-pink-100 to-rose-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-16 md:py-24">
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-10 items-center">
                <div>
                    <p class="text-sm uppercase tracking-widest text-pink-700 font-semibold mb-3">
                        Belleza profesional
                    </p>

                    <h2 class="text-4xl md:text-5xl font-bold leading-tight mb-6">
                        Reserva tu cita online de micropigmentación y maquillaje
                    </h2>

                    <p class="text-lg text-gray-600 mb-8">
                        Gestiona tus citas de forma cómoda, consulta horarios disponibles y confirma tu reserva con anticipo online.
                    </p>

                    <div class="flex flex-col sm:flex-row gap-4">
                        @auth
                            <a href="{{ route('cliente.citas.create') }}"
                               class="px-6 py-3 bg-pink-600 text-white rounded-lg hover:bg-pink-700 text-center focus:outline-none focus:ring-2 focus:ring-pink-500">
                                Reservar cita
                            </a>
                        @else
                            <a href="{{ route('register') }}"
                               class="px-6 py-3 bg-pink-600 text-white rounded-lg hover:bg-pink-700 text-center focus:outline-none focus:ring-2 focus:ring-pink-500">
                                Reservar cita
                            </a>
                        @endauth

                        <a href="{{ route('servicios.index') }}"
   class="px-6 py-3 border border-pink-600 text-pink-700 rounded-lg hover:bg-pink-50 text-center focus:outline-none focus:ring-2 focus:ring-pink-500">
    Ver servicios
</a>
                    </div>
                </div>

                <div class="bg-white rounded-2xl shadow-lg p-8">
                    <h3 class="text-2xl font-semibold mb-6 text-pink-700">¿Qué puedes hacer?</h3>
                    <ul class="space-y-4 text-gray-700">
                        <li>✔ Reservar citas online fácilmente</li>
                        <li>✔ Elegir fecha y hora disponible</li>
                        <li>✔ Pagar el 20% de anticipo para confirmar</li>
                        <li>✔ Consultar tus citas y su estado</li>
                    </ul>
                </div>
            </div>
        </div>
    </section>

    <!-- Servicios -->
    <section id="servicios" class="py-16 bg-white">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-12">
                <h3 class="text-3xl font-bold text-gray-900">Servicios</h3>
                <p class="text-gray-600 mt-3">Tratamientos profesionales adaptados a cada cliente</p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-3 gap-6">
                <a href="{{ route('servicios.cejas') }}" class="block bg-pink-50 rounded-xl p-6 shadow-sm hover:shadow-md transition">
                    <h4 class="text-xl font-semibold text-pink-700 mb-3">Micropigmentación de cejas</h4>
                    <p class="text-gray-600">Diseño y realce de cejas para conseguir un acabado natural y duradero.</p>
                </a>

                <a href="{{ route('servicios.ojos') }}" class="block bg-pink-50 rounded-xl p-6 shadow-sm hover:shadow-md transition">
                    <h4 class="text-xl font-semibold text-pink-700 mb-3">Micropigmentación de ojos</h4>
                    <p class="text-gray-600">Definición de la mirada con técnicas profesionales y resultados elegantes.</p>
                </a>

                <a href="{{ route('servicios.labios') }}" class="block bg-pink-50 rounded-xl p-6 shadow-sm hover:shadow-md transition">
                    <h4 class="text-xl font-semibold text-pink-700 mb-3">Micropigmentación de labios</h4>
                    <p class="text-gray-600">Color, definición y embellecimiento natural de los labios.</p>
                </a>

                <a href="{{ route('servicios.areolas') }}" class="block bg-pink-50 rounded-xl p-6 shadow-sm hover:shadow-md transition">
                    <h4 class="text-xl font-semibold text-pink-700 mb-3">Micropigmentación de areolas</h4>
                    <p class="text-gray-600">Tratamiento especializado orientado a la reconstrucción estética.</p>
                </a>

                <a href="{{ route('servicios.maquillaje') }}" class="block bg-pink-50 rounded-xl p-6 shadow-sm hover:shadow-md transition">
                    <h4 class="text-xl font-semibold text-pink-700 mb-3">Maquillaje profesional</h4>
                    <p class="text-gray-600">Maquillaje para eventos, celebraciones, sesiones y ocasiones especiales.</p>
                </a>
            </div>
        </div>
    </section>

    <section class="py-16 bg-white">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

        <div class="text-center mb-12">
            <h3 class="text-3xl font-bold text-gray-900">Galería</h3>
            <p class="text-gray-600 mt-3">Resultados reales de nuestros servicios</p>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-6">

            <img src="/images/servicios/1.jpg"
                 class="rounded-xl shadow-md hover:scale-105 transition">

            <img src="/images/servicios/micropigmentacion-eyeliner-1.jpeg"
                 class="rounded-xl shadow-md hover:scale-105 transition">

            <img src="/images/servicios/Servicio-Maquillaje.jpg"
                 class="rounded-xl shadow-md hover:scale-105 transition">

        </div>
    </div>
</section>

    <!-- Cómo funciona -->
    <section id="como-funciona" class="py-16 bg-rose-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-12">
                <h3 class="text-3xl font-bold text-gray-900">Cómo funciona la reserva</h3>
                <p class="text-gray-600 mt-3">Proceso sencillo y claro para el cliente</p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                <div class="bg-white rounded-xl p-6 shadow-sm">
                    <div class="text-pink-700 font-bold text-2xl mb-3">1</div>
                    <h4 class="font-semibold text-lg mb-2">Regístrate o inicia sesión</h4>
                    <p class="text-gray-600">Accede a tu cuenta para gestionar tus reservas de forma personalizada.</p>
                </div>

                <div class="bg-white rounded-xl p-6 shadow-sm">
                    <div class="text-pink-700 font-bold text-2xl mb-3">2</div>
                    <h4 class="font-semibold text-lg mb-2">Elige servicio, día y hora</h4>
                    <p class="text-gray-600">Consulta el calendario y selecciona un horario disponible para tu cita.</p>
                </div>

                <div class="bg-white rounded-xl p-6 shadow-sm">
                    <div class="text-pink-700 font-bold text-2xl mb-3">3</div>
                    <h4 class="font-semibold text-lg mb-2">Confirma con anticipo</h4>
                    <p class="text-gray-600">Realiza el pago simulado del 20% para dejar confirmada la reserva.</p>
                </div>
            </div>
        </div>
    </section>

    <!-- CTA -->
    <section class="py-16 bg-pink-700 text-white">
        <div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
            <h3 class="text-3xl md:text-4xl font-bold mb-4">
                Reserva tu cita de forma rápida y cómoda
            </h3>
            <p class="text-pink-100 text-lg mb-8">
                Accede al sistema y gestiona tu reserva online en pocos pasos.
            </p>

            @auth
                <a href="{{ route('cliente.citas.create') }}"
                   class="inline-block px-6 py-3 bg-white text-pink-700 rounded-lg font-semibold hover:bg-pink-50 focus:outline-none focus:ring-2 focus:ring-white">
                    Reservar ahora
                </a>
            @else
                <a href="{{ route('register') }}"
                   class="inline-block px-6 py-3 bg-white text-pink-700 rounded-lg font-semibold hover:bg-pink-50 focus:outline-none focus:ring-2 focus:ring-white">
                    Crear cuenta y reservar
                </a>
            @endauth
        </div>
    </section>

    <!-- Contacto -->
    <section id="contacto" class="py-16 bg-white">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-10">
                <div>
                    <h3 class="text-3xl font-bold mb-6 text-gray-900">Contacto</h3>
                    <div class="space-y-3 text-gray-600">
                        <p><strong>Centro:</strong> Tamara Hoyas Beauty Studio</p>
                        <p><strong>Teléfono:</strong> 639 432 404</p>
                        <p><strong>Email:</strong> tamarahoyas.micropigmentacion@gmail.com</p>
                        <p><strong>Horario:</strong> Lunes a Viernes de 10:00 a 14:00 y de 16:00 a 20:00 </p>
                    </div>
                </div>

                <div class="bg-pink-50 rounded-xl p-6">
                    <h4 class="text-xl font-semibold text-pink-700 mb-4">Acceso al sistema</h4>
                    <p class="text-gray-600 mb-6">
                        Desde aquí podrás reservar tus citas o acceder al panel de gestión si ya tienes cuenta.
                    </p>

                    <div class="flex flex-col sm:flex-row gap-3">
                        @auth
                            @if(auth()->user()->role === 'admin')
                                <a href="{{ route('admin.dashboard') }}"
                                   class="px-4 py-3 bg-pink-600 text-white rounded-lg hover:bg-pink-700 text-center focus:outline-none focus:ring-2 focus:ring-pink-500">
                                    Ir al panel admin
                                </a>
                            @else
                                <a href="{{ route('cliente.dashboard') }}"
                                   class="px-4 py-3 bg-pink-600 text-white rounded-lg hover:bg-pink-700 text-center focus:outline-none focus:ring-2 focus:ring-pink-500">
                                    Ir a mi panel
                                </a>
                            @endif
                        @else
                            <a href="{{ route('login') }}"
                               class="px-4 py-3 bg-pink-600 text-white rounded-lg hover:bg-pink-700 text-center focus:outline-none focus:ring-2 focus:ring-pink-500">
                                Iniciar sesión
                            </a>

                            @if(Route::has('register'))
                                <a href="{{ route('register') }}"
                                   class="px-4 py-3 border border-pink-600 text-pink-700 rounded-lg hover:bg-pink-50 text-center focus:outline-none focus:ring-2 focus:ring-pink-500">
                                    Registrarse
                                </a>
                            @endif
                        @endauth
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Footer -->
    <footer class="bg-gray-900 text-gray-300 py-8">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center text-sm">
            <p>&copy; {{ date('Y') }} Tamara Hoyas Beauty Studio. Todos los derechos reservados.</p>
        </div>
    </footer>

</body>
</html>