@extends('layouts.public')

@section('content')
    {{-- HINZUGEFÜGT: pt-32 für den Abstand zum Header --}}
    <div class="container mx-auto px-6 py-12 pt-32">
        <h1 class="text-3xl font-bold mb-8">
            {{-- Zeigt den Suchbegriff an, falls vorhanden --}}
            @if($searchQuery)
                {{-- KORRIGIERT: Neuer Schlüssel 'search.results_for' wird verwendet --}}
                {!! __('portal.search.results_for', ['query' => '<span class="text-blue-600">'.e($searchQuery).'</span>']) !!}
            @else
                {{-- KORRIGIERT --}}
                {{ __('portal.search.title') }}
            @endif
        </h1>

        <div class="grid grid-cols-1 lg:grid-cols-4 gap-8">
            
            {{-- Seitenleiste für Filter (links) --}}
            <aside class="lg:col-span-1">
                <form action="{{ route('search.index') }}" method="GET">
                    <input type="hidden" name="query" value="{{ $searchQuery }}">

                    {{-- KORRIGIERT --}}
                    <h3 class="text-xl font-bold mb-4">{{ __('portal.search.filter_by_category') }}</h3>
                    <div class="space-y-3">
                        @foreach($allCategories as $category)
                            <label class="flex items-center">
                                <input type="checkbox" name="categories[]" value="{{ $category->name }}"
                                       @if(in_array($category->name, $selectedCategories)) checked @endif
                                       class="h-5 w-5 rounded border-gray-300 text-blue-600 focus:ring-blue-500">
                                {{-- Kategorie-Namen kommen aus der DB und werden (noch) nicht übersetzt --}}
                                <span class="ml-3 text-gray-700">{{ $category->name }}</span>
                            </label>
                        @endforeach
                    </div>
                    
                    {{-- KORRIGIERT --}}
                    <button type="submit" class="w-full mt-6 bg-blue-600 text-white font-bold py-2 px-4 rounded-lg hover:bg-blue-700 transition-colors">
                        {{ __('portal.search.apply_filters') }}
                    </button>
                </form>
            </aside>

            {{-- Ergebnisbereich (rechts) --}}
            <main class="lg:col-span-3">
                {{-- KORRIGIERT: Pluralisierung mit trans_choice --}}
                <p class="text-gray-600 mb-6">{{ trans_choice('portal.search.results_found', $results->total()) }}</p>

                @if($results->isNotEmpty())
                    <div class="grid grid-cols-1 sm:grid-cols-2 xl:grid-cols-3 gap-8">
                        @foreach($results as $restaurant)
                            <a href="{{ route('hubs.show', $restaurant) }}" class="bg-white rounded-lg shadow-md overflow-hidden group block">
                                <div class="h-48 bg-cover bg-center" style="background-image: url('{{ $restaurant->cover_image_path ? asset('storage/' . $restaurant->cover_image_path) : 'https://placehold.co/600x400' }}');"></div>
                                <div class="p-6">
                                    <h3 class="text-xl font-bold mb-1">{{ $restaurant->name }}</h3>
                                    <p class="text-gray-600 text-sm mb-4">{{ $restaurant->address }}</p>
                                    <div class="flex flex-wrap gap-2">
                                        @foreach($restaurant->portalCategories->take(3) as $category)
                                            <span class="bg-blue-100 text-blue-800 text-xs font-medium px-2.5 py-0.5 rounded-full">{{ $category->name }}</span>
                                        @endforeach
                                    </div>
                                </div>
                            </a>
                        @endforeach
                    </div>

                    <div class="mt-12">
                        {{ $results->links() }}
                    </div>
                @else
                    <div class="text-center py-16 border rounded-lg">
                        {{-- KORRIGIERT: Die Pluralisierungsregel oben zeigt bereits "Keine Ergebnisse gefunden" --}}
                        <p class="text-xl text-gray-700">{{ trans_choice('portal.search.results_found', 0) }}</p>
                        {{-- KORRIGIERT: Neuer Schlüssel 'search.no_results_hint' wird verwendet --}}
                        <p class="text-gray-500 mt-2">{{ __('portal.search.no_results_hint') }}</p>
                    </div>
                @endif
            </main>
        </div>
    </div>
@endsection