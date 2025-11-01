<div class="bg-gray-800 p-6 rounded-lg">
    {{-- Der Titel wird jetzt übersetzt --}}
    <h3 class="font-semibold text-lg mb-4 text-blue-400">{{ __('dashboard.quick_actions_title') }}</h3>
    
    <div class="space-y-3 max-h-64 overflow-y-auto pr-2">
        @forelse ($dishes as $dish)
            <div wire:key="quick-action-{{ $dish->id }}" class="flex items-center justify-between p-2 bg-gray-700 rounded-md">
                <span class="text-sm font-medium {{ !$dish->is_available ? 'opacity-50' : '' }}">
                    {{-- Dynamischer Text, keine Änderung nötig --}}
                    {{ $dish->translations->firstWhere('locale', app()->getLocale())?->name ?? $dish->translations->first()?->name ?? 'Gericht ohne Namen' }}
                </span>
                <div class="flex items-center space-x-2">
                    {{-- Wiederverwendung der Übersetzungsschlüssel aus staff.php für Konsistenz --}}
                    <span class="text-xs font-semibold {{ $dish->is_available ? 'text-green-400' : 'text-red-400' }}">
                        {{ $dish->is_available ? __('staff.available') : __('staff.sold_out') }}
                    </span>
                    <label class="relative inline-flex items-center cursor-pointer">
                      <input type="checkbox" @if($dish->is_available) checked @endif wire:click="toggleAvailability({{ $dish->id }})" class="sr-only peer">
                      <div class="w-9 h-5 bg-gray-600 rounded-full peer peer-focus:ring-2 peer-focus:ring-blue-800 peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-0.5 after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-4 after:w-4 after:transition-all peer-checked:bg-blue-600"></div>
                    </label>
                </div>
            </div>
        @empty
            {{-- Die "Keine Gerichte"-Nachricht wird jetzt übersetzt --}}
            <p class="text-gray-500 text-sm">{{ __('dashboard.no_dishes_yet') }}</p>
        @endforelse
    </div>
</div>