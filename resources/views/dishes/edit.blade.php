@extends('layouts.admin')

@section('title', $type === 'food' ? __('dishes.edit_dish_title') : __('dishes.edit_drink_title'))

@section('content')
    <div x-data="aiFormHandler()">
        <h2 class="text-2xl font-bold text-white mb-6">{{ $type === 'food' ? __('dishes.edit_dish_title') : __('dishes.edit_drink_title') }}</h2>

        @if ($errors->any())
            <div class="bg-red-500/20 border-l-4 border-red-500 text-red-300 p-4 rounded-lg mb-6" role="alert">
                <p class="font-bold">{{ __('general.error_occurred') }}</p>
                <ul class="mt-2 list-disc list-inside">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <div class="bg-gray-800 p-6 rounded-lg">
            <form action="{{ route('dishes.update', $dish) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                <input type="hidden" name="type" value="{{ $type }}">

                <div class="space-y-6">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label for="category_id" class="block text-sm font-medium text-gray-400">{{ __('dishes.category') }}</label>
                            <select id="category_id" name="category_id" class="w-full mt-1 bg-gray-700 border border-gray-600 rounded-md px-3 py-2 text-white" required>
                                @foreach ($categories as $category)
                                    <option value="{{ $category->id }}" @if(old('category_id', $dish->category_id) == $category->id) selected @endif>
                                        {{ $category->translations->firstWhere('locale', app()->getLocale())?->name ?? __('dishes.unnamed_category', ['id' => $category->id]) }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div>
                            <label for="price" class="block text-sm font-medium text-gray-400">{{ __('dishes.price_in_eur') }}</label>
                            <input type="number" step="any" id="price" name="price" value="{{ old('price', $dish->price) }}" class="w-full mt-1 bg-gray-700 border border-gray-600 rounded-md px-3 py-2 text-white" required>
                        </div>
                    </div>

                    <div>
                        <label for="image" class="block text-sm font-medium text-gray-400">{{ __('dishes.change_image_optional') }}</label>
                        @if($dish->image_url)
                            <div class="my-2">
                                <img src="{{ asset('storage/' . $dish->image_url) }}" alt="Current Image" class="w-24 h-24 object-cover rounded-md">
                            </div>
                        @endif
                        <input type="file" id="image" name="image" class="w-full mt-1 text-gray-300 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-blue-600 file:text-white hover:file:bg-blue-700">
                    </div>

                    <div class="space-y-4">
                         @php
                            $plans = config('services.stripe.plans') ?? [];
                            $premiumPlanId = array_search('Premium AI - Tarif', $plans);
                            // KORREKTUR: Concierge Plan ID korrekt holen
                            $conciergePlanId = array_search('Concierge AI - Tarif', $plans);
                        @endphp

                        @foreach (app('translator')->get('languages') as $langCode => $langName)
                            @php $translation = $dish->translations->firstWhere('locale', $langCode); @endphp
                            <div class="bg-gray-700 p-4 rounded-md">
                                <label class="text-sm font-medium text-gray-300">{{ $langName }}</label>
                                <input type="text" id="name_{{ $langCode }}" name="name_{{ $langCode }}" value="{{ old('name_' . $langCode, $translation->name ?? '') }}" placeholder="{{ __('dishes.name') }}" class="w-full mt-1 bg-gray-600 border rounded-md px-3 py-2 text-white" {{ $langCode == 'de' ? 'required' : '' }}>
                                
                                <div class="relative">
                                    <textarea id="description_{{ $langCode }}" name="description_{{ $langCode }}" class="w-full mt-2 h-20 bg-gray-600 border rounded-md px-3 py-2 text-white text-sm pr-10" placeholder="{{ __('dishes.description') }}">{{ old('description_' . $langCode, $translation->description ?? '') }}</textarea>
                                    
                                    {{-- KORREKTUR: Concierge Plan in der Prüfung berücksichtigt --}}
                                    @php
                                        $user = auth()->user();
                                        $subscription = $user->subscription('default');
                                        $hasPremium = $subscription && $premiumPlanId && $subscription->hasPrice($premiumPlanId);
                                        $hasConcierge = $subscription && $conciergePlanId && $subscription->hasPrice($conciergePlanId);
                                        $isSuperAdmin = $user->role === 'superadmin';
                                    @endphp

                                    @if($hasPremium || $hasConcierge || $isSuperAdmin)
                                        <button type="button" @click="suggestDescription('{{ $langCode }}')" class="absolute top-2 right-2 p-1.5 text-gray-400 hover:text-cyan-400 rounded-full bg-gray-700" title="{{ __('dishes.improve_with_ai') }}">
                                            {{-- SVG Icons unverändert --}}
                                            <svg x-show="loading['{{ $langCode }}']" class="animate-spin h-5 w-5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path></svg>
                                            <svg x-show="!loading['{{ $langCode }}']" class="h-5 w-5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z" /></svg>
                                        </button>
                                    @endif
                                </div>
                            </div>
                        @endforeach
                    </div>

                    @if($type === 'food')
                    <div>
                        <label class="block text-sm font-medium text-gray-400">{{ __('dishes.tags') }}</label>
                        <div class="flex flex-wrap gap-x-6 gap-y-2 mt-2">
                            <label class="flex items-center">
                                <input type="checkbox" name="is_special" value="1" {{ old('is_special', $dish->is_special) ? 'checked' : '' }} class="h-4 w-4 rounded text-blue-500 bg-gray-600 border-gray-500">
                                <span class="ml-2 text-sm text-gray-300">{{ __('dishes.specialty') }}</span>
                            </label>
                            <label class="flex items-center">
                                <input type="checkbox" name="is_vegetarian" value="1" {{ old('is_vegetarian', $dish->is_vegetarian) ? 'checked' : '' }} class="h-4 w-4 rounded text-blue-500 bg-gray-600 border-gray-500">
                                <span class="ml-2 text-sm text-gray-300">{{ __('dishes.vegetarian') }}</span>
                            </label>
                        </div>
                    </div>

                    {{-- =================================== --}}
                    {{-- NEU: HASHTAGS INPUT-FELD           --}}
                    {{-- =================================== --}}
                    <div>
                        {{-- KORREKTUR: Zweiter Parameter entfernt --}}
                        <label for="hashtags_input" class="block text-sm font-medium text-gray-400">{{ __('dishes.hashtags') }}</label>
                        <input type="text" id="hashtags_input" name="hashtags_input" placeholder="#Vegan, #Scharf, #Glutenfrei"
                               {{-- $currentHashtagsString kommt vom Controller (Methode edit) --}}
                               value="{{ old('hashtags_input', $currentHashtagsString ?? '') }}"
                               class="w-full px-4 py-2 mt-2 text-white bg-gray-700 border border-gray-600 rounded-md focus:ring-blue-500 focus:border-blue-500">
                        {{-- KORREKTUR: Zweiter Parameter entfernt --}}
                        <p class="mt-1 text-xs text-gray-500">{{ __('dishes.hashtags_hint') }}</p>
                    </div>
                    @endif
                </div>

                <div class="pt-6 flex justify-end space-x-4">
                    <a href="{{ route('dishes.index', ['type' => $type]) }}" class="px-4 py-2 text-white bg-gray-600 rounded-md hover:bg-gray-500">{{ __('general.cancel') }}</a>
                    <button type="submit" class="px-4 py-2 text-white bg-blue-600 rounded-md hover:bg-blue-700">{{ __('general.save_changes') }}</button>
                </div>
            </form>
        </div>
    </div>

    @push('scripts')
    <script>
        function aiFormHandler() {
            return {
                loading: {},
                suggestDescription(langCode) {
                    const dishName = document.getElementById(`name_${langCode}`).value;
                    const descriptionTextarea = document.getElementById(`description_${langCode}`);
                    const currentDescription = descriptionTextarea.value; // Holt die aktuelle Beschreibung
                    
                    if (!dishName) {
                        alert('Bitte geben Sie zuerst einen Namen für das Gericht ein.');
                        return;
                    }

                    this.loading[langCode] = true;

                    // === KORREKTUR: Routenname korrigiert ===
                    fetch('{{ route("ai.suggest.description") }}', { 
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': '{{ csrf_token() }}'
                        },
                        body: JSON.stringify({
                            // KORREKTUR: Parameter an AiController angepasst
                            name: dishName, 
                            description: currentDescription // Sendet die aktuelle Beschreibung mit
                        })
                    })
                    .then(response => {
                        if (!response.ok) {
                             // Versucht, die Fehlermeldung vom Backend zu lesen
                            return response.json().then(errData => {
                                throw new Error(errData.error || 'Netzwerkantwort war nicht ok.');
                            });
                        }
                        return response.json();
                    })
                    .then(data => {
                        // KORREKTUR: Auf 'suggestion' prüfen (wie vom AiController zurückgegeben)
                        if (data.suggestion) { 
                            descriptionTextarea.value = data.suggestion;
                        } else if (data.error) {
                             alert('Fehler von der KI: ' + data.error);
                        }
                    })
                    .catch(error => {
                        console.error('Fehler:', error);
                        alert('Es gab ein Problem bei der Erstellung der Beschreibung: ' + error.message);
                    })
                    .finally(() => {
                        this.loading[langCode] = false;
                    });
                }
            }
        }
    </script>
    @endpush
@endsection