<!DOCTYPE html>
<html lang="de" class="scroll-smooth">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $restaurant->name }} - Speisekarte</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Inter', sans-serif; }
    </style>
</head>
<body class="bg-[#100F0F] text-gray-200" x-data="{ currentLang: 'de', activeFilter: 'all' }">

    <div class="max-w-4xl mx-auto">

        <header class="text-center p-6 bg-[#181717] rounded-b-xl shadow-lg">
            @if($restaurant->logo_url)
                <img src="{{ $restaurant->logo_url }}" alt="{{ $restaurant->name }} Logo" class="mx-auto h-24 w-auto mb-4">
            @else
                <h1 class="text-4xl font-bold text-white">{{ $restaurant->name }}</h1>
            @endif
        </header>

        <div class="p-4">
            {{-- Filter Buttons & Language Switcher --}}
            <div class="flex justify-between items-center my-6">
                <div class="flex space-x-2">
                    <button @click="activeFilter = 'all'" class="px-3 py-1.5 rounded-full text-sm font-semibold transition-colors" :class="{'bg-white text-gray-900': activeFilter === 'all', 'bg-gray-700 text-gray-300 hover:bg-gray-600': activeFilter !== 'all'}">Alle</button>
                    <button @click="activeFilter = 'food'" class="px-3 py-1.5 rounded-full text-sm font-semibold transition-colors" :class="{'bg-white text-gray-900': activeFilter === 'food', 'bg-gray-700 text-gray-300 hover:bg-gray-600': activeFilter !== 'food'}">Speisen</button>
                    <button @click="activeFilter = 'drinks'" class="px-3 py-1.5 rounded-full text-sm font-semibold transition-colors" :class="{'bg-white text-gray-900': activeFilter === 'drinks', 'bg-gray-700 text-gray-300 hover:bg-gray-600': activeFilter !== 'drinks'}">Getränke</button>
                </div>
                <div class="flex items-center bg-gray-700 rounded-full p-1 text-sm">
                    @php
                        $availableLangs = $restaurant->categories->flatMap(fn($category) => $category->translations)->pluck('locale')->unique()->sort();
                    @endphp
                    @foreach($availableLangs as $lang)
                        <button @click="currentLang = '{{ $lang }}'" 
                                class="px-3 py-1 rounded-full font-semibold transition-colors duration-200" 
                                :class="{ 'bg-white text-gray-900 shadow': currentLang === '{{ $lang }}', 'text-gray-400': currentLang !== '{{ $lang }}' }">
                            {{ strtoupper($lang) }}
                        </button>
                    @endforeach
                </div>
            </div>

            {{-- Category Navigation --}}
            <nav class="flex flex-wrap justify-center gap-2 mb-10">
                @foreach($restaurant->categories as $category)
                    <a href="#category-{{ $category->id }}" class="px-4 py-2 bg-gray-700 text-gray-300 rounded-full text-sm font-semibold hover:bg-gray-600">
                        <span x-text="{{ json_encode($category->translations->pluck('name', 'locale')->all()) }}[currentLang] || '{{ $category->translations->firstWhere('locale', 'de')->name ?? '' }}'"></span>
                    </a>
                @endforeach
            </nav>

            <main>
                @foreach($restaurant->categories as $category)
                    @php
                        $isDrinkCategory = Str::contains(strtolower($category->translations->firstWhere('locale', 'de')->name ?? ''), ['getränke', 'drinks', 'beverages', 'softdrinks', 'wein', 'bier']);
                    @endphp
                    <section x-show="activeFilter === 'all' || (activeFilter === 'food' && !{{ $isDrinkCategory ? 'true' : 'false' }}) || (activeFilter === 'drinks' && {{ $isDrinkCategory ? 'true' : 'false' }})" id="category-{{ $category->id }}" class="mb-10">
                        <h2 class="text-3xl font-bold text-center mb-6 text-white"
                            x-text="{{ json_encode($category->translations->pluck('name', 'locale')->all()) }}[currentLang] || '{{ $category->translations->firstWhere('locale', 'de')->name ?? '' }}'">
                        </h2>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            @foreach($category->dishes as $dish)
                                @if($dish->is_available)
                                    <div class="bg-[#181717] rounded-xl shadow-lg overflow-hidden">
                                        @if($dish->image_url)
                                            <img src="{{ asset('storage/' . $dish->image_url) }}" alt="Bild von {{ $dish->translations->firstWhere('locale', 'de')->name }}" class="w-full h-48 object-cover">
                                        @endif
                                        <div class="p-4">
                                            <div class="flex justify-between items-start">
                                                <h3 class="font-bold text-lg text-white"
                                                    x-text="{{ json_encode($dish->translations->pluck('name', 'locale')->all()) }}[currentLang] || '{{ $dish->translations->firstWhere('locale', 'de')->name ?? '' }}'">
                                                </h3>
                                                <div class="font-bold text-lg whitespace-nowrap pl-4 text-gray-300">
                                                    {{ number_format($dish->price, 0, ',', '.') }} Ft
                                                </div>
                                            </div>
                                            <p class="text-gray-400 text-sm mt-1"
                                               x-text="{{ json_encode($dish->translations->pluck('description', 'locale')->all()) }}[currentLang] || '{{ $dish->translations->firstWhere('locale', 'de')->description ?? '' }}'">
                                            </p>
                                        </div>
                                    </div>
                                @endif
                            @endforeach
                        </div>
                    </section>
                @endforeach
            </main>
        </div>
    </div>
</body>
</html>