<!DOCTYPE html>
{{-- Setzt die Sprache dynamisch basierend auf der Session (durch Middleware) und initialisiert Alpine.js (x-data) für den Switcher --}}
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" x-data>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    {{-- Verwendet den übersetzten Titel --}}
    <title>{{ __('staff.title') }} - {{ $restaurant->name ?? 'TAGS.MENU' }}</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600;700&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Poppins', sans-serif; }
        [x-cloak] { display: none !important; } /* Wichtig für Alpine Dropdown */
    </style>
    @livewireStyles
</head>
<body class="bg-gray-900 text-white">

    {{-- NEU: Header mit Sprachumschalter --}}
    <header class="bg-gray-800 shadow-md">
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-4 flex justify-between items-center">
            <h1 class="text-xl font-semibold">{{ $restaurant->name ?? 'TAGS.MENU' }}</h1>

            {{-- Sprachumschalter (Identisch zum Dashboard) --}}
            <div x-data="{ openLang: false }" class="relative inline-block text-left">
                <div>
                    <button @click="openLang = !openLang" type="button" class="inline-flex justify-center w-full rounded-md border border-gray-600 shadow-sm px-4 py-2 bg-gray-700 text-sm font-medium text-gray-300 hover:bg-gray-600 focus:outline-none focus:ring-2 focus:ring-blue-500" aria-haspopup="true" aria-expanded="true">
                        {{ strtoupper(app()->getLocale()) }}
                        <svg class="-mr-1 ml-2 h-5 w-5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                            <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 011.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                        </svg>
                    </button>
                </div>

                <div x-show="openLang" @click.away="openLang = false" x-transition x-cloak
                     class="origin-top-right absolute right-0 mt-2 w-40 rounded-md shadow-lg bg-gray-800 ring-1 ring-black ring-opacity-5 focus:outline-none z-50">
                    <div class="py-1" role="none">
                        {{-- Die Links nutzen die bestehende Route (language.switch), die die Session aktualisiert und zurückleitet --}}
                        <a href="{{ route('language.switch', 'de') }}" class="text-gray-300 hover:bg-gray-700 hover:text-white block px-4 py-2 text-sm">Deutsch (DE)</a>
                        <a href="{{ route('language.switch', 'en') }}" class="text-gray-300 hover:bg-gray-700 hover:text-white block px-4 py-2 text-sm">English (EN)</a>
                        <a href="{{ route('language.switch', 'hu') }}" class="text-gray-300 hover:bg-gray-700 hover:text-white block px-4 py-2 text-sm">Magyar (HU)</a>
                        <a href="{{ route('language.switch', 'sk') }}" class="text-gray-300 hover:bg-gray-700 hover:text-white block px-4 py-2 text-sm">Slovenčina (SK)</a>
                    </div>
                </div>
            </div>
        </div>
    </header>

    <div class="max-w-4xl mx-auto p-4 md:p-8">
        {{ $slot }}
    </div>

    @livewireScripts
</body>
</html>