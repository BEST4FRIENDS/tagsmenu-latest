{{-- DESIGN-UPDATE: Kompletter Austausch durch "Was/Wo"-Suchleiste aus Crown Design --}}
<div class="relative max-w-4xl mx-auto">
    
    {{-- Suchformular-Wrapper (relative Position für das Dropdown) --}}
    <div class="relative">
        {{-- Das Formular selbst --}}
        <div class="bg-gray-100 dark:bg-dark-surface rounded-xl shadow-2xl p-2 flex flex-col md:flex-row items-center gap-2">
            
            {{-- "Was" Sektion --}}
            <div class="flex-grow w-full flex items-center">
                <svg class="w-5 h-5 text-gray-400 dark:text-gray-500 mx-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                <label for="search-what" class="sr-only">{{ __('portal.homepage.search_what') }}</label>
                <input 
                    id="search-what" 
                    type="text" 
                    wire:model.live.debounce.300ms="searchQuery"
                    wire:keydown.enter="performSearch"
                    placeholder="{{ __('portal.homepage.search_what') }}" 
                    class="w-full bg-transparent focus:outline-none text-gray-800 dark:text-gray-200 placeholder-gray-500 dark:placeholder-gray-400"
                >
                {{-- Lade-Spinner (wird nur während der Suche angezeigt) --}}
                <div wire:loading class="flex items-center h-full pr-4">
                     <svg class="animate-spin h-5 w-5 text-tags-red" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                        <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                    </svg>
                </div>
            </div>

            {{-- Trennlinie --}}
            <div class="w-full md:w-px h-px md:h-12 bg-gray-300 dark:bg-gray-600"></div>

            {{-- "Wo" Sektion --}}
            <div class="flex-grow w-full flex items-center">
                 <svg class="w-5 h-5 text-gray-400 dark:text-gray-500 mx-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
                 <label for="search-where" class="sr-only">{{ __('portal.homepage.search_where') }}</label>
                {{-- HINWEIS: Dieses Feld ist jetzt verbunden! --}}
                <input
                    id="search-where"
                    type="text"
                    {{-- NEU: Verbindet das Feld mit der Komponente --}}
                    wire:model.live.debounce.500ms="locationQuery"
                    wire:keydown.enter="performSearch"
                    placeholder="{{ __('portal.homepage.search_where') }}"
                    class="w-full bg-transparent focus:outline-none text-gray-800 dark:text-gray-200 placeholder-gray-500 dark:placeholder-gray-400"
                >
                 {{-- "In meiner Nähe" Button (bleibt ohne Funktion) --}}
                 <button type="button" class="p-2 text-crown-gold hover:opacity-80" aria-label="In meiner Nähe suchen" title="In meiner Nähe suchen">
                     <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 24 24"><path d="M12 2L4.5 20.29l.71.71L12 18l6.79 3 .71-.71z"></path></svg>
                </button>
            </div>

            {{-- Such-Button --}}
            <button 
                type="button" 
                wire:click="performSearch"
                class="w-full md:w-auto bg-tags-red text-white font-bold py-4 px-8 rounded-lg hover:bg-red-700 transition-colors duration-300 flex-shrink-0"
            >
                Suchen
            </button>
        </div>
    </div>

    {{-- Dropdown-Liste für Suchergebnisse (Logik bleibt gleich, Styling angepasst) --}}
    @if(strlen($searchQuery) >= 2)
        <div class="absolute w-full mt-2 bg-white dark:bg-dark-surface rounded-lg shadow-xl z-20">
            <ul class="max-h-80 overflow-y-auto">
                @forelse($results as $result)
                    <a href="{{ route('hubs.show', $result) }}" class="block px-6 py-3 hover:bg-gray-100 dark:hover:bg-dark-base border-b border-gray-200 dark:border-gray-700">
                        <p class="font-bold text-gray-800 dark:text-gray-100">{{ $result->name }}</p>
                        <p class="text-sm text-gray-600 dark:text-gray-400">{{ $result->address }}</p>
                    </a>
                @empty
                    {{-- Nachricht, wenn nichts gefunden wurde --}}
                    <li class="px-6 py-3 text-gray-600 dark:text-gray-400">{{ __('portal.homepage.no_results_for', ['query' => $searchQuery]) }}</li>
                @endforelse
            </ul>
        </div>
    @endif
</div>
