<div>
    {{-- Der Haupt-Header ist jetzt im Layout. Wir fügen hier einen Sub-Header für den Kontext hinzu. --}}
    <header class="text-center py-6 mb-8 bg-gray-800 shadow-xl rounded-lg mt-4">
        {{-- ÜBERSETZUNG --}}
        <h1 class="text-3xl font-bold">{{ __('staff.title') }}</h1>
        <p class="text-gray-400 mt-1">{{ __('staff.description') }}</p>
    </header>

    <main>
        {{-- Wir ermitteln die aktuelle Sprache dynamisch für das Laden der Übersetzungen aus der Collection --}}
        @php $locale = app()->getLocale(); @endphp

        @forelse ($categories as $category)
            <div class="mb-10" wire:key="category-{{ $category->id }}">
                <h2 class="text-2xl font-semibold mb-4 border-b-2 border-gray-700 pb-2">
                    {{-- Nutzt die aktuelle Sprache für den Kategorienamen --}}
                    {{ $category->translations->firstWhere('locale', $locale)?->name ?? $category->name }}
                </h2>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    @foreach ($category->dishes as $dish)
                        <div wire:key="staff-dish-{{ $dish->id }}"
                             class="flex items-center justify-between p-4 rounded-lg shadow-md transition-all duration-200 bg-gray-800 hover:bg-gray-700">

                            {{-- Nutzt die aktuelle Sprache für den Gerichtnamen --}}
                            <span class="font-medium pr-4 @if(!$dish->is_available) opacity-50 @endif">
                                {{ $dish->translations->firstWhere('locale', $locale)?->name ?? 'N/A' }}
                            </span>

                            {{-- Schieberegler-Implementierung --}}
                            <div class="flex items-center space-x-4">
                                {{-- Status Text (Übersetzt) --}}
                                <span class="text-sm font-medium {{ $dish->is_available ? 'text-green-500' : 'text-red-500' }}">
                                     {{ $dish->is_available ? __('staff.available') : __('staff.sold_out') }}
                                </span>

                                {{-- Der Schieberegler --}}
                                <label class="relative inline-flex items-center cursor-pointer">
                                    <input type="checkbox" @if($dish->is_available) checked @endif wire:click="toggleAvailability({{ $dish->id }})" class="sr-only peer">
                                    <div class="w-11 h-6 bg-gray-600 rounded-full peer peer-focus:ring-4 peer-focus:ring-blue-800 peer-checked:after:translate-x-full rtl:peer-checked:after:-translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-0.5 after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-blue-600"></div>
                                </label>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        @empty
            <div class="bg-gray-800 p-6 rounded-lg text-center">
                {{-- ÜBERSETZUNG --}}
                <p class="text-gray-400">{{ __('staff.no_dishes') }}</p>
            </div>
        @endforelse
    </main>
</div>