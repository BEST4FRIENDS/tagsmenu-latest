<div>
    <div class="flex justify-between items-center mb-6">
        <h2 class="text-2xl font-bold text-white">Speisekarten-Verwaltung</h2>
        <a href="{{ route('dishes.create') }}" class="px-4 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700 flex items-center">
            <svg class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"/></svg>
            <span>Neues Gericht</span>
        </a>
    </div>

    @if (session('success'))
        <div class="bg-green-500 text-white p-4 rounded-lg mb-6">
            {{ session('success') }}
        </div>
    @endif

    @forelse ($categories as $category)
        <div class="bg-gray-800 p-4 rounded-lg mb-6">
            <h3 class="text-xl font-semibold mb-4 border-b border-gray-700 pb-2">
                {{ $category->translations->firstWhere('locale', 'de')->name ?? "Kategorie #{$category->id}" }}
            </h3>
            <div class="space-y-2">
                @forelse ($category->dishes as $dish)
                    <div class="flex items-center justify-between p-3 bg-gray-700 rounded-md @if(!$dish->is_available) opacity-50 @endif">
                        <div class="flex items-center">
                            <svg class="w-5 h-5 text-gray-500 mr-3 cursor-move" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16m-7 6h7"/></svg>
                            <span class="font-medium">
                                {{ $dish->translations->firstWhere('locale', 'de')->name ?? 'Gericht ohne Namen' }}
                            </span>
                        </div>
                        <div class="flex items-center space-x-4">
                            <span class="text-sm font-semibold {{ $dish->is_available ? 'text-green-400' : 'text-red-400' }}">
                                {{ $dish->is_available ? 'Verfügbar' : 'Ausverkauft' }}
                            </span>
                            
                            <label class="relative inline-flex items-center cursor-pointer">
                              <input type="checkbox" @if($dish->is_available) checked @endif wire:click="toggleAvailability({{ $dish->id }})" class="sr-only peer">
                              <div class="w-11 h-6 bg-gray-600 rounded-full peer peer-focus:ring-4 peer-focus:ring-blue-800 peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-0.5 after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-blue-600"></div>
                            </label>
                            <a href="{{ route('dishes.edit', $dish) }}" class="text-gray-400 hover:text-white" title="Bearbeiten">
                                <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.5L14.732 3.732z"/></svg>
                            </a>
                            <form action="{{ route('dishes.destroy', $dish) }}" method="POST" onsubmit="return confirm('Sind Sie sicher?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="text-red-500 hover:text-red-400" title="Löschen">
                                    <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" /></svg>
                                </button>
                            </form>
                        </div>
                    </div>
                @empty
                    <p class="text-gray-400">Noch keine Gerichte in dieser Kategorie.</p>
                @endforelse
            </div>
        </div>
    @empty
         <div class="bg-gray-800 p-6 rounded-lg text-center">
            <p class="text-gray-400">Es wurden noch keine Kategorien erstellt.</p>
        </div>
    @endforelse
</div>