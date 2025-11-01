@extends('layouts.public')

@section('content')
    {{-- Hero-Bereich mit Cover-Bild --}}
    <div class="relative h-[450px] bg-cover bg-center flex items-center justify-center text-white" style="background-image: url('{{ asset('storage/' . $restaurant->cover_image_path) }}');">
        <div class="absolute inset-0 bg-black opacity-50"></div>
        <div class="relative z-10 text-center flex flex-col items-center">
            @if($restaurant->logo_url)
                <div class="bg-white rounded-full p-2 mb-4">
                    <img src="{{ asset('storage/' . $restaurant->logo_url) }}" alt="Logo for {{ $restaurant->name }}" class="h-24 w-24 rounded-full object-cover">
                </div>
            @endif
            <h1 class="text-5xl font-extrabold">{{ $restaurant->name }}</h1>
            <p class="mt-2 text-lg">{{ $restaurant->address }}</p>
        </div>
    </div>

    <div class="bg-gray-50 py-4">
        <div class="container mx-auto text-center">
            <a href="{{ $restaurant->subdomain_url }}" target="_blank" class="inline-block bg-yellow-500 text-gray-800 font-bold px-8 py-3 rounded-lg hover:bg-yellow-600 transition-colors">
                Zur Speisekarte
            </a>
        </div>
    </div>

    {{-- Inhaltsbereich --}}
    <div class="container mx-auto px-6 py-12">
        <div class="grid grid-cols-1 md:grid-cols-3 gap-12">
            {{-- Linke Spalte: Über Uns --}}
            <div class="md:col-span-2">
                <h2 class="text-2xl font-bold mb-4">Über Uns</h2>
                <p class="text-gray-700 leading-relaxed">
                    {!! nl2br(e($restaurant->about_us)) !!}
                </p>
            </div>

            {{-- Rechte Spalte: Details & Merkmale --}}
            <div>
                <div class="bg-gray-100 p-6 rounded-lg">
                    <h3 class="text-xl font-bold mb-4">Details & Merkmale</h3>
                    
                    {{-- Kategorien --}}
                    <div class="mb-4">
                        <h4 class="font-semibold text-gray-700 mb-2">Kategorien</h4>
                        <div class="flex flex-wrap gap-2">
                            @foreach($restaurant->portalCategories as $category)
                                <span class="bg-blue-100 text-blue-800 text-sm font-medium px-3 py-1 rounded-full">{{ $category->name }}</span>
                            @endforeach
                        </div>
                    </div>
                    
                    {{-- Hashtags --}}
                    <div>
                        <h4 class="font-semibold text-gray-700 mb-2">#Hashtags</h4>
                        <div class="flex flex-wrap gap-2">
                            @foreach($restaurant->hashtags as $hashtag)
                                <span class="bg-green-100 text-green-800 text-sm font-medium px-3 py-1 rounded-full">#{{ $hashtag->name }}</span>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection