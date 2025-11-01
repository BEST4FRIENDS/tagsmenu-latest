<!DOCTYPE html>
{{-- Dynamisches Sprachattribut --}}
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    {{-- Meta-Titel aus der Sprachdatei --}}
    <title>{{ __('plans.meta_title') }}</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600;700;800&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Poppins', sans-serif; }
        [x-cloak] { display: none !important; }
    </style>

    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>

</head>

<body class="bg-gray-950 text-white min-h-screen antialiased">

    <div class="py-12 px-4 sm:px-6 lg:px-8">

        <header class="text-center mb-12 pt-6">
            {{-- Header wurde angepasst, um Logo links und Umschalter rechts zu platzieren --}}
            <div class="flex justify-between items-center max-w-7xl mx-auto">
                <a href="/" class="text-3xl font-bold tracking-widest uppercase">TAGS.MENU</a>

                <div x-data="{ open: false }" class="relative inline-block text-left">
                    <div>
                        <button @click="open = !open" type="button" class="inline-flex justify-center w-full rounded-md border border-gray-600 shadow-sm px-4 py-2 bg-gray-800 text-sm font-medium text-gray-300 hover:bg-gray-700">
                            {{ strtoupper(app()->getLocale()) }}
                            <svg class="-mr-1 ml-2 h-5 w-5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                                <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 011.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                            </svg>
                        </button>
                    </div>

                    <div x-show="open" @click.away="open = false" x-transition x-cloak
                        class="origin-top-right absolute right-0 mt-2 w-40 rounded-md shadow-lg bg-gray-800 ring-1 ring-black ring-opacity-5 z-50">
                        <div class="py-1">
                            <a href="{{ route('language.switch', 'de') }}" class="text-gray-300 hover:bg-gray-700 hover:text-white block px-4 py-2 text-sm">Deutsch (DE)</a>
                            <a href="{{ route('language.switch', 'en') }}" class="text-gray-300 hover:bg-gray-700 hover:text-white block px-4 py-2 text-sm">English (EN)</a>
                            <a href="{{ route('language.switch', 'hu') }}" class="text-gray-300 hover:bg-gray-700 hover:text-white block px-4 py-2 text-sm">Magyar (HU)</a>
                            <a href="{{ route('language.switch', 'sk') }}" class="text-gray-300 hover:bg-gray-700 hover:text-white block px-4 py-2 text-sm">Slovenčina (SK)</a>
                        </div>
                    </div>
                </div>
                </div>
        </header>

        <div class="container mx-auto max-w-7xl">

            {{-- Anzeige von Fehlern oder Statusmeldungen --}}
            @if (session('error') || $errors->any())
                <div class="max-w-xl mx-auto mb-6 bg-red-800 border border-red-500 p-4 rounded-lg shadow-lg">
                    <p class="font-bold">{{ __('plans.status.error_title') }}</p>
                    @if (session('error'))
                        <p>{{ session('error') }}</p>
                    @endif
                    @if ($errors->any())
                        <ul class="list-disc list-inside mt-2 text-sm">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    @endif
                </div>
            @elseif (session('info'))
                 <div class="max-w-xl mx-auto mb-6 bg-blue-800 border border-blue-500 p-4 rounded-lg shadow-lg">
                    <p>{{ session('info') }}</p>
                </div>
            @endif
            {{-- Ende Fehleranzeige --}}

            <div class="text-center mb-16">
                <h1 class="text-4xl font-extrabold tracking-tight sm:text-5xl md:text-6xl">
                    {{ __('plans.title') }}
                </h1>
                <p class="mt-4 max-w-2xl mx-auto text-xl text-gray-400">
                    {{ __('plans.subtitle') }}
                </p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-10 items-stretch">

                {{-- Basis Tarif --}}
                <div class="bg-gray-800 rounded-2xl shadow-xl p-8 flex flex-col transform transition duration-300 border border-gray-700 hover:shadow-white/10">
                    <h3 class="text-2xl font-bold mb-4">{{ __('plans.basic.name') }}</h3>
                    <div class="flex items-baseline mb-6">
                        <span class="text-5xl font-extrabold tracking-tight">{{ __('plans.basic.price') }}€</span>
                        <span class="ml-2 text-xl text-gray-400">{{ __('plans.basic.interval') }}</span>
                    </div>
                    <ul class="text-left mb-8 space-y-4 text-gray-300 flex-grow">
                        <li class="flex items-center"><svg class="w-6 h-6 text-green-500 mr-3" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L9 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"></path></svg>{{ __('plans.basic.features.digital_menu') }}</li>
                        <li class="flex items-center"><svg class="w-6 h-6 text-green-500 mr-3" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L9 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"></path></svg>{{ __('plans.basic.features.qr_generator') }}</li>
                        <li class="flex items-center"><svg class="w-6 h-6 text-green-500 mr-3" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L9 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"></path></svg>{{ __('plans.basic.features.unlimited_dishes') }}</li>
                    </ul>
                    <a href="{{ route('subscribe.create', ['plan' => 'price_1S7yu2HZisIzMiCRgFU5d97U']) }}" class="mt-auto block w-full text-center bg-gray-600 font-bold py-3 px-6 rounded-lg hover:bg-gray-700 transition-colors duration-300">
                        {{ __('plans.basic.cta') }}
                    </a>
                </div>

                {{-- Premium AI --}}
                <div class="bg-gray-800 rounded-2xl shadow-2xl p-8 flex flex-col relative border-2 border-sky-500 transform transition duration-300 hover:shadow-sky-500/50">
                    <div class="absolute top-0 right-0 bg-sky-500 text-white px-4 py-1 text-sm font-semibold rounded-bl-lg rounded-tr-xl uppercase tracking-wider">
                        {{ __('plans.premium.badge') }}
                    </div>
                    <h3 class="text-2xl font-bold text-sky-500 mb-4">{{ __('plans.premium.name') }}</h3>
                    <div class="flex items-baseline mb-6">
                        <span class="text-5xl font-extrabold tracking-tight">{{ __('plans.premium.price') }}€</span>
                        <span class="ml-2 text-xl text-gray-400">{{ __('plans.premium.interval') }}</span>
                    </div>
                    <ul class="text-left mb-8 space-y-4 text-gray-300 flex-grow">
                        <li class="flex items-center"><svg class="w-6 h-6 text-sky-500 mr-3" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L9 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"></path></svg>{{ __('plans.premium.features.all_basic') }}</li>
                        <li class="flex items-center"><svg class="w-6 h-6 text-sky-500 mr-3" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L9 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"></path></svg>{{ __('plans.premium.features.ai_descriptions') }}</li>
                        <li class="flex items-center"><svg class="w-6 h-6 text-sky-500 mr-3" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L9 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"></path></svg>{{ __('plans.premium.features.advanced_designs') }}</li>
                    </ul>
                    <a href="{{ route('subscribe.create', ['plan' => 'price_1S7yw7HZisIzMiCR2mOAJ2iq']) }}" class="mt-auto block w-full text-center bg-sky-600 text-white font-bold py-3 px-6 rounded-lg hover:bg-sky-700 transition-colors duration-300">
                        {{ __('plans.premium.cta') }}
                    </a>
                </div>

                {{-- Concierge Tarif --}}
                <div class="bg-gray-800 rounded-2xl shadow-xl p-8 flex flex-col transform transition duration-300 border border-gray-700 hover:shadow-white/10">
                    <h3 class="text-2xl font-bold mb-4">{{ __('plans.concierge.name') }}</h3>
                    <div class="flex items-baseline mb-6">
                        <span class="text-5xl font-extrabold tracking-tight">{{ __('plans.concierge.price') }}€</span>
                        <span class="ml-2 text-xl text-gray-400">{{ __('plans.concierge.interval') }}</span>
                    </div>
                    <ul class="text-left mb-8 space-y-4 text-gray-300 flex-grow">
                        <li class="flex items-center"><svg class="w-6 h-6 text-green-500 mr-3" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L9 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"></path></svg>{{ __('plans.concierge.features.all_premium') }}</li>
                        <li class="flex items-center"><svg class="w-6 h-6 text-green-500 mr-3" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L9 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"></path></svg>{{ __('plans.concierge.features.onboarding') }}</li>
                        <li class="flex items-center"><svg class="w-6 h-6 text-green-500 mr-3" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L9 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"></path></svg>{{ __('plans.concierge.features.phone_support') }}</li>
                    </ul>
                    <a href="{{ route('subscribe.create', ['plan' => 'price_1S7z09HZisIzMiCRbrs4i4ql']) }}" class="mt-auto block w-full text-center bg-gray-600 font-bold py-3 px-6 rounded-lg hover:bg-gray-700 transition-colors duration-300">
                        {{ __('plans.concierge.cta') }}
                    </a>
                </div>

            </div>
        </div>
    </div>
</body>
</html>