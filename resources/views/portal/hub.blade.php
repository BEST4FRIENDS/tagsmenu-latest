@extends('layouts.portal')

{{-- Setzt den Titel dynamisch auf den Namen des Restaurants --}}
@section('title', $restaurant->name)

@section('content')
    <div class="bg-white rounded-lg shadow-xl overflow-hidden">
        {{-- Header-Bereich mit Bild-Platzhalter --}}
        <div class="h-64 bg-gray-200 flex items-center justify-center">
            <h1 class="text-5xl font-bold text-gray-500 tracking-wider uppercase">{{ $restaurant->name }}</h1>
        </div>

        {{-- Inhaltsbereich --}}
        <div class="p-6 md:p-10">
            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                
                {{-- Linke Spalte: Beschreibung und Call-to-Action --}}
                <div class="md:col-span-2">
                    <h2 class="text-3xl font-bold text-gray-800 mb-4">Willkommen im {{ $restaurant->name }}</h2>
                    <p class="text-gray-600 leading-relaxed">
                        {{ $restaurant->description ?: 'Dieses Restaurant hat noch keine Beschreibung hinterlegt.' }}
                    </p>

                    {{-- WICHTIG: Der Button, der zur Subdomain führt --}}
                    <div class="mt-8">
                        <a href="http://{{ $restaurant->subdomain }}.{{ config('app.domain_base') }}" 
                           target="_blank" {{-- Öffnet in neuem Tab --}}
                           class="inline-block bg-indigo-600 text-white font-bold text-lg px-8 py-4 rounded-lg shadow-md hover:bg-indigo-700 transition-transform transform hover:scale-105">
                            Zur digitalen Speisekarte
                        </a>
                    </div>
                </div>

                {{-- Rechte Spalte: Kontaktdetails --}}
                <div class="bg-gray-50 p-6 rounded-lg">
                    <h3 class="text-xl font-semibold text-gray-700 border-b pb-3 mb-4">Kontakt & Standort</h3>
                    <div class="space-y-4 text-gray-600">
                        <div class="flex items-start">
                             <svg class="w-5 h-5 text-indigo-500 mr-3 mt-1 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
                            <span>{{ $restaurant->address }}, {{ $restaurant->zip }} {{ $restaurant->city }}</span>
                        </div>
                        @if($restaurant->phone)
                        <div class="flex items-center">
                            <svg class="w-5 h-5 text-indigo-500 mr-3 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"></path></svg>
                            <span>{{ $restaurant->phone }}</span>
                        </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection