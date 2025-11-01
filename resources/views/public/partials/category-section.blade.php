{{-- resources/views/public/partials/category-section.blade.php --}}

<section id="category-{{ $category->id }}" class="mb-20 scroll-mt-40">

    {{-- Category Title (Unverändert) --}}
    <h2 class="text-2xl md:text-3xl font-bold mb-8 text-sky-600 dark:text-sky-500"
        x-text="getTrans({{ json_encode($category->translations->pluck('name', 'locale')->all()) }})">
    </h2>

    {{-- Dish Grid (2 Columns) --}}
    <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
        @foreach($category->dishes as $dish)

            {{-- WICHTIG: Daten für JavaScript vorbereiten --}}
            @php
                $dishData = [
                    'id' => $dish->id,
                    'image_url' => $dish->image_url ? asset('storage/' . $dish->image_url) : null,
                    'price_formatted' => number_format($dish->price, 0, ',', '.') . ' ' . $restaurant->currency,
                    'translations' => [
                        'name' => $dish->translations->pluck('name', 'locale')->all(),
                        'description' => $dish->translations->pluck('description', 'locale')->all(),
                    ]
                ];
            @endphp

            {{-- Dish Card --}}
            <div id="dish-{{ $dish->id }}"
                 {{-- KORREKTUR: Click-Handler (Modal öffnen) nur, wenn verfügbar --}}
                 @if($dish->is_available)
                    @click="openModal({{ json_encode($dishData) }})"
                 @endif
                 class="bg-white dark:bg-dark-card rounded-xl shadow-2xl overflow-hidden transition-transform duration-300 flex flex-col h-full
                        {{-- KORREKTUR: Styling basierend auf Verfügbarkeit --}}
                        @if($dish->is_available)
                            hover:scale-105 cursor-pointer
                        @else
                            {{-- Wenn nicht verfügbar: Deckkraft reduzieren und Graustufenfilter --}}
                            opacity-60 grayscale cursor-default
                        @endif
                        ">

                {{-- Bildbereich --}}
                <div class="relative h-48">
                    {{-- NEU: Overlay "Ausverkauft" --}}
                    @if(!$dish->is_available)
                        <div class="absolute inset-0 bg-black bg-opacity-50 flex items-center justify-center z-20">
                            <span class="text-white text-2xl font-bold bg-red-600 px-4 py-2 rounded transform -rotate-12 shadow-lg">
                                Ausverkauft
                            </span>
                        </div>
                    @endif

                    {{-- Icons Overlay (Nur anzeigen, wenn verfügbar) --}}
                    @if($dish->is_available && $category->type === 'food')
                    <div class="absolute top-2 right-2 flex flex-col gap-2 z-10">
                        @if($dish->is_special)
                            <div class="bg-accent p-1.5 rounded-full shadow-lg" title="Spezialität des Hauses">
                                <svg class="w-5 h-5 text-white" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor"><path d="M12.0006 18.26L4.94715 22.2082L6.52248 14.2799L0.587891 8.7918L8.61493 7.84006L12.0006 0.5L15.3862 7.84006L23.4132 8.7918L17.4787 14.2799L19.054 22.2082L12.0006 18.26Z"></path></svg>
                            </div>
                        @endif
                        @if($dish->is_vegetarian)
                            <div class="bg-green-600 p-1.5 rounded-full shadow-lg" title="Vegetarisch">
                               <svg class="w-5 h-5 text-white" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor"><path d="M17 8C18.5 8 20.5 9.5 20.5 12C20.5 15.5 18 18.5 13.5 18.5C13.5 19.5 12 20 12 20C12 20 12 19 11 18.5C5.5 18 4.5 13 3.5 12C2.5 11 3 8.5 4.5 8.5C4.5 8.5 5 8 6.5 7.5C6.5 7.5 3.5 4 7 3.5C11 3 13 6 13 6C13.5 6 15 4 17 3.5C18.5 3 19 4 19 5C17 5.5 17 8 17 8ZM13.5 17C17 17 19 15 19 12C19 10 17.5 9.5 16.5 9.5C16.5 9.5 16 8 15.5 8C15.5 8 16 6.5 15.5 6C14 6 13 7.5 12 8C11 8.5 9.5 7 8.5 6.5C8 6.5 5.5 8.5 5.5 12C5.5 16 10 17 11.5 17C12 17 13 17 13.5 17Z"></path></svg>
                            </div>
                        @endif
                    </div>
                    @endif

                    {{-- Dish Image --}}
                    @if($dish->image_url)
                        <img src="{{ asset('storage/' . $dish->image_url) }}" alt="Bild des Gerichts" class="w-full h-full object-cover">
                    @else
                        <div class="w-full h-full bg-gray-200 dark:bg-gray-700 flex items-center justify-center">
                            <span class="text-gray-500">Kein Bild</span>
                        </div>
                    @endif
                </div>

                {{-- Dish Details --}}
                <div class="p-6 flex flex-col flex-grow">
                    <div class="flex justify-between items-baseline mb-3">
                        <h3 class="font-bold text-xl text-gray-900 dark:text-white"
                            x-text="getTrans({{ json_encode($dish->translations->pluck('name', 'locale')->all()) }})">
                        </h3>
                        <div class="font-bold text-lg whitespace-nowrap pl-4
                            {{-- KORREKTUR: Preis durchstreichen und grau, wenn ausverkauft --}}
                            @if($dish->is_available)
                                text-accent
                            @else
                                text-gray-500 dark:text-gray-600 line-through
                            @endif
                            ">
                            {{ number_format($dish->price, 0, ',', '.') }} {{ $restaurant->currency }}
                        </div>
                    </div>

                    <p class="text-gray-600 dark:text-gray-400 text-sm leading-relaxed flex-grow"
                       x-text="getTrans({{ json_encode($dish->translations->pluck('description', 'locale')->all()) }})">
                    </p>

                    {{-- Like & Share Buttons --}}
                    {{-- KORREKTUR: Buttons ausblenden, wenn ausverkauft --}}
                    @if($dish->is_available)
                    <div class="flex items-center justify-between mt-auto pt-4 border-t border-gray-200 dark:border-gray-700">

                        {{-- Like Button --}}
                        <button @click.stop="likeDish($event.currentTarget, {{ $dish->id }})"
                                class="flex items-center text-gray-500 dark:text-gray-400 hover:text-red-500 transition group focus:outline-none">
                            <svg class="w-5 h-5 mr-2 transition" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z" />
                            </svg>
                            <span id="likes-count-{{ $dish->id }}">{{ $dish->likes_count }}</span>
                        </button>

                        {{-- Share Button --}}
                        <button @click.stop="shareDish(getTrans({{ json_encode($dish->translations->pluck('name', 'locale')->all()) }}), '{{ url()->current() }}#dish-{{ $dish->id }}')"
                                class="flex items-center text-gray-500 dark:text-gray-400 hover:text-blue-500 transition focus:outline-none">
                            <svg class="w-5 h-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8.684 13.342C8.886 12.938 9 12.482 9 12c0-.482-.114-.938-.316-1.342m0 2.684a3 3 0 110-2.684m0 2.684l6.632 3.316m-6.632-6l6.632-3.316m0 0a3 3 0 105.367-2.684 3 3 0 00-5.367 2.684zm0 9.316a3 3 0 105.368 2.684 3 3 0 00-5.368-2.684z" />
                            </svg>
                            Teilen
                        </button>
                    </div>
                    @endif
                </div>
            </div>
        @endforeach
    </div>
</section>