<x-guest-layout>
    <div class="w-full max-w-md p-8 space-y-6 bg-gray-800 rounded-lg shadow-lg">
        <div>
            <h2 class="text-3xl font-bold text-center text-white">TAGS.MENU</h2>
            <p class="text-center text-gray-400">Admin-Panel Login</p>
        </div>

        <x-auth-session-status class="mb-4" :status="session('status')" />

        <form method="POST" action="{{ route('login') }}">
            @csrf

            <div>
                <x-input-label for="email" value="Email" class="text-gray-400" />
                <x-text-input id="email" class="block mt-1 w-full text-white bg-gray-700 border-gray-600" type="email" name="email" :value="old('email')" required autofocus autocomplete="username" />
                <x-input-error :messages="$errors->get('email')" class="mt-2" />
            </div>

            <div class="mt-4">
                <x-input-label for="password" value="Passwort" class="text-gray-400" />
                <x-text-input id="password" class="block mt-1 w-full text-white bg-gray-700 border-gray-600"
                                type="password"
                                name="password"
                                required autocomplete="current-password" />
                <x-input-error :messages="$errors->get('password')" class="mt-2" />
            </div>

            <div class="block mt-4">
                <label for="remember_me" class="inline-flex items-center">
                    <input id="remember_me" type="checkbox" class="rounded dark:bg-gray-900 border-gray-300 dark:border-gray-700 text-indigo-600 shadow-sm focus:ring-indigo-500 dark:focus:ring-indigo-600 dark:focus:ring-offset-gray-800" name="remember">
                    <span class="ms-2 text-sm text-gray-400">{{ __('Angemeldet bleiben') }}</span>
                </label>
            </div>

            <div class="flex items-center justify-end mt-4">
                @if (Route::has('password.request'))
                    <a class="underline text-sm text-gray-400 hover:text-gray-100 rounded-md focus:outline-none" href="{{ route('password.request') }}">
                        {{ __('Passwort vergessen?') }}
                    </a>
                @endif

                <x-primary-button class="ms-4">
                    {{ __('Einloggen') }}
                </x-primary-button>
            </div>
        </form>

        <div class="text-center mt-6">
            <p class="text-sm text-gray-400">
                Noch kein Konto?
                <a href="{{ route('register') }}" class="font-medium text-blue-500 hover:underline">
                    Jetzt registrieren
                </a>
            </p>
        </div>
    </div>
</x-guest-layout>