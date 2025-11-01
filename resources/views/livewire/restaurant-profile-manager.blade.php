<div class="bg-gray-800 p-6 rounded-lg shadow-lg">
    <h2 class="text-2xl font-bold text-white mb-6 border-b border-gray-700 pb-3">
        {{ __('profile.portal_settings_title') }}
    </h2>

    @if (session()->has('message'))
        <div class="bg-green-500/20 border-l-4 border-green-500 text-green-300 p-4 rounded-lg mb-6" role="alert">
            <p>{{ session('message') }}</p>
        </div>
    @endif

    @if($restaurant)
    <form wire:submit.prevent="save" class="space-y-6">

        {{-- NEUE STRUKTUR: Grid für Sichtbarkeit und Adresse --}}
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            {{-- Sichtbarkeit --}}
            <div class="md:col-span-1">
                <label class="block text-sm font-medium text-gray-300 mb-2">
                    {{ __('profile.visibility') }}
                </label>
                <label class="relative inline-flex items-center cursor-pointer">
                    <input type="checkbox" wire:model.live="is_publicly_listed" id="is_publicly_listed" class="sr-only peer">
                    <div class="w-11 h-6 bg-gray-600 rounded-full peer peer-focus:ring-4 peer-focus:ring-blue-800 peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-0.5 after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-blue-600"></div>
                    <span class="ml-3 text-sm font-medium {{ $is_publicly_listed ? 'text-green-400' : 'text-gray-500' }}">
                        {{ $is_publicly_listed ? __('profile.listed') : __('profile.hidden') }}
                    </span>
                </label>
                <p class="text-xs text-gray-500 mt-1">{{ __('profile.visibility_hint') }}</p>
            </div>

            {{-- HINZUGEFÜGT: Adressfeld --}}
            <div class="md:col-span-2">
                <label for="address" class="block text-sm font-medium text-gray-300 mb-2">
                    {{ __('profile.address') }}
                </label>
                <input type="text" id="address" wire:model.defer="address"
                       class="w-full bg-gray-700 border border-gray-600 text-white p-2.5 rounded-lg focus:ring-blue-500 focus:border-blue-500">
                @error('address') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
            </div>
        </div>

        {{-- Über Uns --}}
        <div>
            <label for="about_us" class="block text-sm font-medium text-gray-300 mb-2">
                {{ __('profile.about_us') }}
            </label>
            <textarea id="about_us" wire:model.defer="about_us" rows="4"
                      class="w-full bg-gray-700 border border-gray-600 text-white p-2.5 rounded-lg focus:ring-blue-500 focus:border-blue-500"></textarea>
            @error('about_us') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
        </div>

        {{-- Cover Bild --}}
        <div>
            <label class="block text-sm font-medium text-gray-300 mb-2">
                {{ __('profile.cover_image') }}
            </label>
            <div class="flex items-center space-x-4">
                @if ($cover_image)
                    <img src="{{ $cover_image->temporaryUrl() }}" class="w-32 h-20 object-cover rounded-lg">
                @elseif ($restaurant->cover_image_path)
                    <img src="{{ asset('storage/' . $restaurant->cover_image_path) }}" class="w-32 h-20 object-cover rounded-lg">
                @endif

                <input type="file" wire:model="cover_image"
                       class="text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100">
            </div>
            <div wire:loading wire:target="cover_image" class="text-blue-500 text-sm mt-1">Wird hochgeladen...</div>
            @error('cover_image') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
        </div>

        {{-- Kategorien --}}
        <div>
            <label class="block text-sm font-medium text-gray-300 mb-2">
                {{ __('profile.categories') }}
            </label>
            <div class="grid grid-cols-2 md:grid-cols-4 gap-4 bg-gray-700 p-4 rounded-lg">
                @forelse ($allCategories as $category)
                    <div class="flex items-center">
                        <input id="cat-{{ $category->id }}" type="checkbox" value="{{ $category->id }}" wire:model.defer="selectedCategories"
                               class="w-4 h-4 text-blue-600 bg-gray-600 border-gray-500 rounded focus:ring-blue-500">
                        <label for="cat-{{ $category->id }}" class="ml-2 text-sm font-medium text-gray-300">{{ $category->name }}</label>
                    </div>
                @empty
                     <p class="text-gray-500 col-span-4">Keine Kategorien verfügbar.</p>
                @endforelse
            </div>
        </div>

        {{-- Hashtags --}}
        <div>
            <label for="hashtagsInput" class="block text-sm font-medium text-gray-300 mb-2">
                {{ __('profile.hashtags') }}
            </label>
            <input type="text" id="hashtagsInput" wire:model.defer="hashtagsInput" placeholder="#Terrasse, #LiveMusik, #Hundefreundlich"
                   class="w-full bg-gray-700 border border-gray-600 text-white p-2.5 rounded-lg focus:ring-blue-500 focus:border-blue-500">
            <p class="text-xs text-gray-500 mt-1">{{ __('profile.hashtags_hint') }}</p>
            @error('hashtagsInput') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
        </div>

        <div class="pt-4 flex justify-end">
            <button type="submit" class="px-6 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700 transition duration-150">
                {{ __('general.save_changes') }} (Portal)
            </button>
        </div>
    </form>
    @else
        <div class="text-yellow-500 p-4 bg-yellow-500/10 rounded-lg">
            {{ __('profile.please_create_restaurant_first') }}
        </div>
    @endif
</div>