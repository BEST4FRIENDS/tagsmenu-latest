<div>
    <div class="flex flex-col md:flex-row md:space-x-6">

        <div class="w-full md:w-1/2">
            <h3 class="text-xl font-semibold text-white mb-4 border-b border-gray-700 pb-2">
                {{ __('categories.food') }}
            </h3>
            <div wire:sortable="updateFoodCategoryOrder" id="food-list" class="space-y-3 min-h-[100px]">
                @forelse ($foodCategories as $category)
                    <div wire:key="category-{{ $category->id }}" wire:sortable.item="{{ $category->id }}" class="bg-gray-800 p-4 rounded-lg flex justify-between items-center">
                        <div class="flex items-center">
                            <svg wire:sortable.handle class="w-5 h-5 text-gray-500 mr-3 cursor-move" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16m-7 6h7"/></svg>
                            
                            {{-- Holt den Namen in der aktuell ausgewählten Sprache --}}
                            <span class="text-gray-200">{{ $category->translations->firstWhere('locale', app()->getLocale())?->name ?? __('categories.unnamed') }}</span>
                        </div>
                        <div class="flex items-center space-x-3">
                            <a href="{{ route('categories.edit', $category) }}" class="text-blue-400 hover:text-blue-300">{{ __('categories.edit') }}</a>
                        </div>
                    </div>
                @empty
                    <p class="text-gray-500">{{ __('categories.no_food_categories_yet') }}</p>
                @endforelse
            </div>
        </div>

        <div class="w-full md:w-1/2 mt-8 md:mt-0">
            <h3 class="text-xl font-semibold text-white mb-4 border-b border-gray-700 pb-2">
                {{ __('categories.drinks') }}
            </h3>
            <div wire:sortable="updateDrinkCategoryOrder" id="drink-list" class="space-y-3 min-h-[100px]">
                @forelse ($drinkCategories as $category)
                    <div wire:key="category-{{ $category->id }}" wire:sortable.item="{{ $category->id }}" class="bg-gray-800 p-4 rounded-lg flex justify-between items-center">
                         <div class="flex items-center">
                            <svg wire:sortable.handle class="w-5 h-5 text-gray-500 mr-3 cursor-move" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16m-7 6h7"/></svg>
                            <span class="text-gray-200">{{ $category->translations->firstWhere('locale', app()->getLocale())?->name ?? __('categories.unnamed') }}</span>
                        </div>
                         <div class="flex items-center space-x-3">
                            <a href="{{ route('categories.edit', $category) }}" class="text-blue-400 hover:text-blue-300">{{ __('categories.edit') }}</a>
                        </div>
                    </div>
                @empty
                    <p class="text-gray-500">{{ __('categories.no_drink_categories_yet') }}</p>
                @endforelse
            </div>
        </div>
    </div>

    @push('scripts')
    <script src="https://cdn.jsdelivr.net/gh/livewire/sortable@v1.x.x/dist/livewire-sortable.js"></script>
    @endpush
</div>