<x-guest-layout>
    <div class="min-h-screen flex items-center justify-center bg-pink-50 px-4">
        <div class="w-full max-w-lg bg-white p-8 rounded-2xl shadow-lg">

            <h2 class="text-2xl font-bold text-center text-pink-700 mb-6">
                Crear cuenta
            </h2>

            <p class="text-center text-gray-500 mb-6">
                Regístrate para gestionar tus citas
            </p>

            <form method="POST" action="{{ route('register') }}" class="space-y-5">
                @csrf

                <!-- Nombre -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">
                        Nombre
                    </label>
                    <input type="text" name="name" required autofocus
                        class="w-full rounded-lg border-gray-300 focus:border-pink-500 focus:ring-pink-500">
                </div>

                <!-- Email -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">
                        Email
                    </label>
                    <input type="email" name="email" required
                        class="w-full rounded-lg border-gray-300 focus:border-pink-500 focus:ring-pink-500">
                </div>

                <!-- Password -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">
                        Contraseña
                    </label>
                    <input type="password" name="password" required
                        class="w-full rounded-lg border-gray-300 focus:border-pink-500 focus:ring-pink-500">
                </div>

                <!-- Confirm Password -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">
                        Confirmar contraseña
                    </label>
                    <input type="password" name="password_confirmation" required
                        class="w-full rounded-lg border-gray-300 focus:border-pink-500 focus:ring-pink-500">
                </div>

                <!-- Botón -->
                <button type="submit"
                    class="w-full bg-pink-600 text-white py-2 rounded-lg hover:bg-pink-700 transition">
                    Registrarse
                </button>

                <!-- Links -->
                <div class="text-center text-sm text-gray-600">
                    ¿Ya tienes cuenta?
                    <a href="{{ route('login') }}" class="text-pink-600 hover:underline">
                        Inicia sesión
                    </a>
                </div>

                <div class="text-center text-sm">
                    <a href="/" class="text-gray-500 hover:underline">
                        Volver al inicio
                    </a>
                </div>

            </form>
        </div>
    </div>
</x-guest-layout>