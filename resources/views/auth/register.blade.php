<x-guest-layout>
    <form method="POST" action="{{ route('register') }}">
        @csrf

        <!-- HINZUGEFÜGT: Zeigt eine Zusammenfassung aller Fehler an -->
        @if ($errors->any())
            <div class="mb-4">
                <div class="font-medium text-red-500">
                    {{ __('Ups! Da ist etwas schiefgelaufen.') }}
                </div>

                <ul class="mt-3 list-disc list-inside text-sm text-red-500">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <div>
            <x-input-label for="name" :value="__('Ihr Name')" />
            <x-text-input id="name" class="block mt-1 w-full" type="text" name="name" :value="old('name')" required autofocus autocomplete="name" />
            <x-input-error :messages="$errors->get('name')" class="mt-2" />
        </div>
        
        <div class="mt-4">
            <x-input-label for="restaurant_name" :value="__('Name des Restaurants')" />
            <x-text-input id="restaurant_name" class="block mt-1 w-full" type="text" name="restaurant_name" :value="old('restaurant_name')" required />
            <x-input-error :messages="$errors->get('restaurant_name')" class="mt-2" />
        </div>

        <div class="mt-4">
            <x-input-label for="email" :value="__('Email')" />
            <x-text-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')" required autocomplete="username" />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <div class="mt-4">
            <x-input-label for="password" :value="__('Passwort')" />

            <x-text-input id="password" class="block mt-1 w-full"
                            type="password"
                            name="password"
                            required autocomplete="new-password" />

            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <div class="mt-4">
            <x-input-label for="password_confirmation" :value="__('Passwort bestätigen')" />

            <x-text-input id="password_confirmation" class="block mt-1 w-full"
                            type="password"
                            name="password_confirmation" required autocomplete="new-password" />

            <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
        </div>

        <div class="flex items-center justify-end mt-4">
            <a class="underline text-sm text-gray-600 dark:text-gray-400 hover:text-gray-900 dark:hover:text-gray-100 rounded-md" href="{{ route('login') }}">
                {{ __('Bereits registriert?') }}
            </a>

            <x-primary-button class="ms-4">
                {{ __('Registrieren') }}
            </x-primary-button>
        </div>
    </form>
</x-guest-layout>