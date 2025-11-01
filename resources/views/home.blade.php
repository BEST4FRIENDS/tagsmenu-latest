@extends('layouts.public')

@section('content')
    {{-- Hero-Sektion (Design-Anpassungen) --}}
    <div class="relative bg-cover bg-center min-h-[60vh] text-white flex items-center justify-center" style="background-image: url('https://images.unsplash.com/photo-1555396273-367ea4eb4db5?q=80&w=1974&auto-format&fit=crop');">
        {{-- Overlay an Crown Design angepasst --}}
        <div class="absolute inset-0 bg-dark-base opacity-70"></div>
        <div class="relative z-10 text-center px-4">
            {{-- Text-Stile an Crown Design angepasst --}}
            <h1 class="text-4xl sm:text-5xl lg:text-6xl font-extrabold mb-4">{{ __('portal.homepage.hero_title') }}</h1>
            <p class="mt-4 text-lg sm:text-xl max-w-3xl mx-auto text-gray-300">{{ __('portal.homepage.hero_subtitle') }}</p>
            
            {{-- Die Suchleiste wird jetzt durch die neue Blade-Datei gerendert --}}
            <div class="mt-10">
                <livewire:restaurant-search />
            </div>
        </div>
    </div>

    {{-- Sektion "Beliebte Kategorien" (Design-Anpassungen) --}}
    <div class="py-16 sm:py-24 bg-white dark:bg-dark-bg">
        <div class="container mx-auto px-6 py-16">
            <h2 class="text-3xl sm:text-4xl font-bold text-center mb-10 text-gray-800 dark:text-white">{{ __('portal.homepage.popular_categories') }}</h2>
            
            @if($popularCategories && $popularCategories->isNotEmpty())
                {{-- Grid-Gap an Crown Design angepasst --}}
                <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-4 gap-8">
                    
                    @foreach($popularCategories as $category)
                        {{-- DESIGN-UPDATE: Kachel-Stil an Crown Design angepasst --}}
                        <a href="{{ route('search.index', ['categories' => [$category->slug]]) }}" 
                           class="category-card relative h-48 rounded-xl overflow-hidden group block"
                           {{-- Placeholder-Bild, da Logik für Kategorie-Bilder fehlt --}}
                           style="background-image: url('https://placehold.co/600x400/7f1d1d/ffffff?text={{ urlencode($category->name) }}')">
                           
                            <div class="absolute inset-0 bg-black bg-opacity-40 group-hover:bg-opacity-50 transition-all duration-300"></div>
                            <h3 class="absolute inset-0 flex items-center justify-center text-2xl font-bold text-white p-4 text-center">{{ $category->name }}</h3>
                        </a>
                    @endforeach

                    {{-- DESIGN-UPDATE: "Weitere"-Kachel an Crown Design angepasst --}}
                    <a href="{{ route('search.index') }}" class="relative h-48 rounded-xl overflow-hidden group block bg-tags-red">
                        <div class="absolute inset-0 bg-black bg-opacity-20 group-hover:bg-opacity-30 transition-all duration-300"></div>
                        <h3 class="absolute inset-0 flex items-center justify-center text-2xl font-bold text-white text-center">
                            {!! __('portal.homepage.discover_all') !!}
                        </h3>
                    </div>
                </div>
            @else
                <p class="text-center text-gray-600 dark:text-gray-400">Trends werden gerade berechnet...</p>
            @endif
        </div>
    </div>

    {{-- === "Tages-Hit"-Sektion (Design-Anpassungen) === --}}
    {{-- Hintergrund an Crown Design angepasst (Highlights Section) --}}
    <div class="bg-gray-50 dark:bg-dark-surface">
        <div class="container mx-auto px-6 py-16 sm:py-24">
            
            @if($topDish)
                {{-- Textfarben an Dark Mode angepasst --}}
                <h2 class="text-3xl sm:text-4xl font-bold text-center mb-2 text-gray-800 dark:text-white">{{ __('portal.homepage.dish_of_the_day') }}</h2>
                <p class="text-gray-600 dark:text-gray-400 text-center text-lg mb-10">{{ __('portal.homepage.dish_of_the_day_subtitle') }}</p>

                {{-- Große Karte für das Top-Gericht (Design-Anpassungen) --}}
                <div class="max-w-4xl mx-auto bg-white dark:bg-dark-bg rounded-lg shadow-xl overflow-hidden md:flex">
                    {{-- Bild --}}
                    <div class="md:w-1/2">
                        <img class="h-64 w-full object-cover md:h-full" 
                             src="{{ $topDish->image_url ? $topDish->image_url : 'https://placehold.co/600x400' }}" 
                             alt="{{ $topDish->name }}">
                    </div>
                    {{-- Text --}}
                    <div class="md:w-1/2 p-8">
                        <h3 class="text-2xl font-bold text-gray-900 dark:text-white mb-2">{{ $topDish->name }}</h3>
                        
                        @if($topDish->restaurant)
                            <p class="text-md text-gray-600 dark:text-gray-400 mb-4">
                                Gesehen bei 
                                {{-- Link-Farbe an Crown Design angepasst --}}
                                <a href="{{ route('hubs.show', $topDish->restaurant->seo_slug) }}" class="font-semibold text-crown-gold hover:underline">
                                    {{ $topDish->restaurant->name }}
                                </a>
                            </p>
                        @endif
                        
                        <p class="text-gray-700 dark:text-gray-300 mb-6">{{ $topDish->description }}</p>
                        
                        {{-- Button-Farbe an Crown Design (tags-red) angepasst --}}
                        <a href="{{ $topDish->restaurant ? route('hubs.show', $topDish->restaurant->seo_slug) : '#' }}" 
                           class="inline-block bg-tags-red text-white font-bold py-3 px-6 rounded-lg hover:bg-red-700 transition-colors">
                           Zur Speisekarte
                        </a>
                    </div>
                </div>
            @else
                {{-- Fallback (Textfarben an Dark Mode angepasst) --}}
                <h2 class="text-3xl sm:text-4xl font-bold text-center mb-2 text-gray-800 dark:text-white">Entdecke bald die Top-Gerichte!</h2>
                <p class="text-gray-600 dark:text-gray-400 text-center text-lg mb-10">Unsere Community stimmt gerade ab...</p>
            @endif
        </div>
    </div>
    {{-- === ENDE "Tages-Hit"-Sektion === --}}


    {{-- "Sie können sich nicht entscheiden?"-Sektion (Design-Anpassungen) --}}
    <div class="bg-white dark:bg-dark-bg">
        <div class="container mx-auto px-6 py-16 sm:py-24">
            {{-- Styling-Anpassungen erfolgen in der 'ai-recommender.blade.php' Datei --}}
            <livewire:ai-recommender />
        </div>
    </div>
@endsection
