{{-- DESIGN-UPDATE: Komplette Sektion an Crown Design angepasst --}}
<div class="mt-12 text-center">
    <h3 class="text-3xl sm:text-4xl font-bold mb-4 text-gray-800 dark:text-white">{{ __('portal.ai.title') }}</h3>
    <p class="mt-4 max-w-2xl mx-auto text-lg text-gray-600 dark:text-gray-300 mb-8">{{ __('portal.ai.subtitle') }}</p>

    <form wire:submit.prevent="getRecommendation" class="max-w-2xl mx-auto">
        {{-- Textarea-Stil an Crown Design angepasst --}}
        <textarea
            wire:model.defer="prompt"
            class="w-full p-4 rounded-xl border-2 border-gray-200 dark:border-gray-700 bg-gray-50 dark:bg-dark-surface focus:outline-none focus:ring-2 focus:ring-crown-gold dark:text-gray-200"
            rows="3"
            placeholder="{{ __('portal.ai.placeholder') }}"
        ></textarea>
        @error('prompt') <p class="text-red-500 text-sm mt-1">{{ $message }}</p @enderror

        {{-- Button-Stil an Crown Design angepasst (crown-gold) --}}
        <button type="submit" wire:loading.attr="disabled" class="mt-4 w-full md:w-auto bg-crown-gold text-white font-bold py-4 px-8 rounded-lg hover:opacity-90 transition-opacity duration-300 flex-shrink-0 flex items-center justify-center gap-2 disabled:opacity-50">
            
            {{-- Lade-Zustand mit Crown Design Spinner --}}
            <span wire:loading class="flex items-center justify-center">
                {{-- Spinner (border-white, da Button-Hintergrund gold ist) --}}
                <svg class="spinner w-5 h-5 mr-2 border-2 border-white border-t-transparent rounded-full" viewBox="0 0 24 24"></svg>
                {{ __('portal.ai.loading') }}
            </span>
            
            {{-- Normal-Zustand --}}
            <span wire:loading.remove>{{ __('portal.ai.button') }} ✨</span>
        </button>
    </form>
    
    @if(session()->has('ai_error'))
        <p class="text-red-500 mt-4">{{ __('portal.ai.error') }}</p>
    @endif
</div>
