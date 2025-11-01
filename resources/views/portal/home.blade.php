@extends('layouts.portal')

{{-- Setzt den Titel für diese spezifische Seite --}}
@section('title', 'Startseite')

{{-- Definiert den Hauptinhalt der Seite --}}
@section('content')

    {{-- Hero-Sektion / Willkommens-Banner --}}
    <div class="text-center mb-16">
        <h1 class="text-4xl font-bold tracking-tight text-gray-900 sm:text-5xl md:text-6xl">
            <span class="block">Finde deine nächste</span>
            <span class="block text-indigo-600">Lieblings-Speisekarte</span>
        </h1>
        <p class="mt-4 max-w-md mx-auto text-base text-gray-500 sm:text-lg md:mt-6 md:text-xl md:max-w-3xl">
            Durchsuche hunderte von digitalen Speisekarten in deiner Nähe. Einfach, schnell und immer aktuell.
        </p>
    </div>

    {{-- Raster für empfohlene Restaurants --}}
    <div>
        <h2 class="text-3xl font-bold mb-8 text-center text-gray-800">Entdecke unsere Restaurants</h2>

        @if($restaurants->isNotEmpty())
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-8">
                {{-- Loop durch die vom HomeController übergebenen Restaurants --}}
                @foreach ($restaurants as $restaurant)
                    <a href="{{ route('portal.hub', $restaurant->seo_slug) }}" class="group block bg-white rounded-xl shadow-lg hover:shadow-2xl transition-all duration-300 transform hover:-translate-y-1 overflow-hidden">
                        {{-- Bild-Platzhalter --}}
                        <div class="h-48 bg-indigo-200 flex items-center justify-center">
                            <svg class="w-12 h-12 text-indigo-400" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0v-4a2 2 0 012-2h6a2 2 0 012 2v4m-6 0h-2"></path></svg>
                        </div>
                        <div class="p-5">
                            <h3 class="font-bold text-xl text-gray-900 group-hover:text-indigo-600 transition-colors">{{ $restaurant->name }}</h3>
                            <p class="text-sm text-gray-500 mt-1">{{ $restaurant->city }}</p>
                        </div>
                    </a>
                @endforeach
            </div>
        @else
            <div class="text-center py-12 px-4 bg-white rounded-lg shadow-md">
                 <p class="text-lg text-gray-500">Zurzeit sind keine Restaurants öffentlich gelistet.</p>
            </div>
        @endif
    </div>

@endsection