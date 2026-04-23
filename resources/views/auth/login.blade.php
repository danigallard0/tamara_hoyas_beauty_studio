<x-guest-layout>
    <div class="min-h-screen flex items-center justify-center bg-pink-50 px-4">
        <div class="w-full max-w-md bg-white p-8 rounded-2xl shadow-lg">

            <div class="mb-6 text-center">
                <a href="{{ url('/') }}" class="text-2xl font-bold text-pink-700">
                    Tamara Hoyas Beauty Studio
                </a>
                <h2 class="mt-3 text-2xl font-bold text-gray-800">
                    Iniciar sesión
                </h2>
                <p class="mt-2 text-sm text-gray-500">
                    Accede a tu cuenta para gestionar tus citas
                </p>
            </div>

            @if ($errors->any())
                <div class="mb-4 rounded-lg bg-red-50 border border-red-200 p-3 text-sm text-red-700">
                    <ul class="list-disc pl-5">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form method="POST" action="{{ route('login') }}" class="space-y-5">
                @csrf

                <div>
                    <label for="email" class="block text-sm font-medium text-gray-700 mb-1">
                        Email
                    </label>
                    <input
                        id="email"
                        type="email"
                        name="email"
                        value="{{ old('email') }}"
                        required
                        autofocus
                        class="w-full rounded-lg border-gray-300 focus:border-pink-500 focus:ring-pink-500"
                    >
                </div>

                <div>
                    <label for="password" class="block text-sm font-medium text-gray-700 mb-1">
                        Contraseña
                    </label>
                    <input
                        id="password"
                        type="password"
                        name="password"
                        required
                        class="w-full rounded-lg border-gray-300 focus:border-pink-500 focus:ring-pink-500"
                    >
                </div>

                <div class="flex items-center justify-between gap-4">
                    <label for="remember" class="flex items-center">
                        <input
                            id="remember"
                            type="checkbox"
                            name="remember"
                            class="rounded border-gray-300 text-pink-600 focus:ring-pink-500"
                        >
                        <span class="ml-2 text-sm text-gray-600">Recordarme</span>
                    </label>

                    @if (Route::has('password.request'))
                        <a href="{{ route('password.request') }}" class="text-sm text-pink-600 hover:underline">
                            ¿Olvidaste tu contraseña?
                        </a>
                    @endif
                </div>

                <button
                    type="submit"
                    class="w-full bg-pink-600 text-white py-2 rounded-lg hover:bg-pink-700 focus:outline-none focus:ring-2 focus:ring-pink-500"
                >
                    Entrar
                </button>

                <div class="flex flex-col sm:flex-row items-center justify-between gap-3 text-sm">
                    <a href="{{ url('/') }}" class="text-gray-600 hover:text-pink-700">
                        Volver al inicio
                    </a>

                    <p class="text-gray-600">
                        ¿No tienes cuenta?
                        <a href="{{ route('register') }}" class="text-pink-600 hover:underline">
                            Regístrate
                        </a>
                    </p>
                </div>
            </form>
        </div>
    </div>
</x-guest-layout>