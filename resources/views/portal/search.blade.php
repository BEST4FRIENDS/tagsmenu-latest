@extends('layouts.portal')

@section('title', $query ? "Suche nach '{$query}'" : 'Suche')

@section('content')

    {{-- Überschrift, die den Suchbegriff anzeigt --}}
    <div class="mb-10">
        @if ($query)
            <h1 class="text-4xl font-bold text-gray-800">
                Suchergebnisse für <span class="text-indigo-600">"{{ $query }}"</span>
            </h1>
        @else
            <h1 class="text-4xl font-bold text-gray-800">Restaurantsuche</h1>
            <p class="mt-2 text-gray-500">Bitte geben Sie einen Suchbegriff in die Leiste oben ein.</p>
        @endif
    </div>

    {{-- Prüfen, ob Ergebnisse vorhanden sind --}}
    @if ($restaurants->isNotEmpty())
        {{-- Ergebnis-Grid (gleicher Stil wie auf der Homepage für Konsistenz) --}}
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-8">
            @foreach ($restaurants as $restaurant)
                <a href="{{ route('portal.hub', $restaurant->seo_slug) }}" class="group block bg-white rounded-xl shadow-lg hover:shadow-2xl transition-all duration-300 transform hover:-translate-y-1 overflow-hidden">
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

        {{-- Paginierungs-Links --}}
        <div class="mt-12">
            {{-- appends() sorgt dafür, dass der Suchparameter 'q' bei Seitenwechseln erhalten bleibt --}}
            {{ $restaurants->appends(request()->query())->links() }}
        </div>

    @elseif($query)
        {{-- Nachricht, wenn die Suche keine Ergebnisse lieferte --}}
        <div class="text-center py-16 px-4 bg-white rounded-lg shadow-md">
             <p class="text-xl font-semibold text-gray-700">Leider keine Treffer</p>
             <p class="text-lg text-gray-500 mt-2">Für Ihre Suche nach "{{ $query }}" konnten wir kein passendes Restaurant finden.</p>
             <p class="text-gray-500 mt-4">Versuchen Sie es mit einem anderen Begriff.</p>
        </div>
    @endif

@endsection