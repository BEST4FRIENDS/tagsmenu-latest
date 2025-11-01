<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}"> {{-- Dynamische Sprache für das HTML-Tag --}}
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Admin-Panel') - TAGS.MENU</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @livewireStyles
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Inter', sans-serif; }
        [x-cloak] { display: none !important; }
        .sidebar-link.active { background-color: #1F2937; color: #E5E7EB; }
    </style>
</head>
<body class="bg-gray-900 text-gray-200" x-data="{ isMobileMenuOpen: false }">
    <div class="flex h-screen">
        {{-- Desktop Sidebar --}}
        <div class="hidden md:flex flex-col w-64 bg-gray-800">
            <div class="flex items-center justify-center h-16 bg-gray-900">
                <span class="text-white font-bold text-xl">TAGS.MENU</span>
            </div>
            <div class="flex flex-col flex-1 overflow-y-auto">
                @include('layouts.partials.navigation')
            </div>
        </div>

        {{-- Mobile Sidebar --}}
        <div x-show="isMobileMenuOpen" @click.away="isMobileMenuOpen = false" class="fixed inset-0 flex z-40 md:hidden" x-cloak>
            <div x-show="isMobileMenuOpen" class="fixed inset-0 bg-black opacity-50"></div>
            <div x-show="isMobileMenuOpen" class="relative flex-1 flex flex-col max-w-xs w-full bg-gray-800">
                <div class="absolute top-0 right-0 -mr-12 pt-2">
                    <button @click="isMobileMenuOpen = false" type="button" class="ml-1 flex items-center justify-center h-10 w-10 rounded-full focus:outline-none">
                        <svg class="h-6 w-6 text-white" stroke="currentColor" fill="none" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                    </button>
                </div>
                <div class="flex items-center justify-center h-16 bg-gray-900">
                    <span class="text-white font-bold text-xl">TAGS.MENU</span>
                </div>
                <div class="flex flex-col flex-1 overflow-y-auto">
                    @include('layouts.partials.navigation')
                </div>
            </div>
        </div>

        {{-- Main Content Area --}}
        <div class="flex flex-col flex-1 overflow-y-auto">
            <header class="flex items-center justify-between h-16 bg-gray-800 border-b border-gray-700 px-4">
                <button @click="isMobileMenuOpen = true" class="md:hidden text-gray-400 hover:text-white">
                    <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path></svg>
                </button>
                <h1 class="text-white font-semibold text-lg hidden md:block">@yield('title', 'Dashboard')</h1>
                <div class="flex items-center space-x-4">
                    
                    {{-- HINZUGEFÜGT: Sprachumschalter (Language Switcher) --}}
                    {{-- Benötigt Alpine.js für das Dropdown-Verhalten --}}
                    <div x-data="{ open: false }" class="relative inline-block text-left">
                        <div>
                            <button @click="open = !open" type="button" class="inline-flex justify-center w-full rounded-md border border-gray-600 shadow-sm px-4 py-2 bg-gray-800 text-sm font-medium text-gray-300 hover:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-blue-500" aria-haspopup="true" aria-expanded="true">
                                {{-- Zeigt die aktuell aktive Sprache in Großbuchstaben an --}}
                                {{ strtoupper(app()->getLocale()) }}
                                {{-- Dropdown Icon --}}
                                <svg class="-mr-1 ml-2 h-5 w-5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                                    <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 011.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                                </svg>
                            </button>
                        </div>

                        {{-- Dropdown Menu Items --}}
                        <div x-show="open" @click.away="open = false" x-transition x-cloak
                            class="origin-top-right absolute right-0 mt-2 w-40 rounded-md shadow-lg bg-gray-800 ring-1 ring-black ring-opacity-5 focus:outline-none z-50" role="menu" aria-orientation="vertical" tabindex="-1">
                            <div class="py-1" role="none">
                                {{-- Die Links rufen die neue Route auf --}}
                                <a href="{{ route('language.switch', 'de') }}" class="text-gray-300 hover:bg-gray-700 hover:text-white block px-4 py-2 text-sm" role="menuitem">Deutsch (DE)</a>
                                <a href="{{ route('language.switch', 'en') }}" class="text-gray-300 hover:bg-gray-700 hover:text-white block px-4 py-2 text-sm" role="menuitem">English (EN)</a>
                                <a href="{{ route('language.switch', 'hu') }}" class="text-gray-300 hover:bg-gray-700 hover:text-white block px-4 py-2 text-sm" role="menuitem">Magyar (HU)</a>
                                <a href="{{ route('language.switch', 'sk') }}" class="text-gray-300 hover:bg-gray-700 hover:text-white block px-4 py-2 text-sm" role="menuitem">Slovenčina (SK)</a>
                            </div>
                        </div>
                    </div>
                    {{-- Ende Sprachumschalter --}}


                    <span class="text-white hidden sm:block">{{ Auth::user()->name }}</span>
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit" class="px-3 py-1 bg-red-600 text-white text-sm rounded-md hover:bg-red-700">Logout</button>
                    </form>
                </div>
            </header>

            {{-- Trial Period Banner (Neue Komponente) --}}
            <x-trial-banner />

            <main class="p-4 md:p-8">
                {{-- Livewire components or other content will be injected here --}}
                {{ $slot ?? '' }}
                @yield('content')
            </main>
        </div>
    </div>

    @livewireScripts {{-- IMPORTANT: Adds the necessary Livewire scripts --}}
    @stack('scripts') {{-- This is for page-specific scripts --}}

</body>
</html>