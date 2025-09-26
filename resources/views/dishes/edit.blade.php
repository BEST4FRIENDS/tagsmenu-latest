@extends('layouts.admin')

@section('title', 'Gericht bearbeiten')

@section('content')
    <div x-data="aiFormHandler()">
        <h2 class="text-2xl font-bold text-white mb-6">Gericht bearbeiten</h2>

        @if ($errors->any())
            <div class="mb-4 bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative" role="alert">
                <strong class="font-bold">Hoppla!</strong> <span class="block sm:inline">Es gab einige Probleme mit Ihrer Eingabe.</span>
                <ul class="mt-3 list-disc list-inside">
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
                <div class="space-y-6">

                    {{-- Kategorie & Preis --}}
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label for="category_id" class="block text-sm font-medium text-gray-400">Kategorie</label>
                            <select id="category_id" name="category_id" class="w-full mt-1 bg-gray-700 border border-gray-600 rounded-md px-3 py-2 text-white" required>
                                @foreach ($categories as $category)
                                    <option value="{{ $category->id }}" @if(old('category_id', $dish->category_id) == $category->id) selected @endif>
                                        {{ $category->translations->firstWhere('locale', 'de')->name ?? "Kategorie #{$category->id}" }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div>
                            <label for="price" class="block text-sm font-medium text-gray-400">Preis (in Ft)</label>
                            <input type="number" step="any" id="price" name="price" value="{{ old('price', $dish->price) }}" class="w-full mt-1 bg-gray-700 border border-gray-600 rounded-md px-3 py-2 text-white" required>
                        </div>
                    </div>

                    {{-- Bild-Upload --}}
                    <div>
                        <label for="image" class="block text-sm font-medium text-gray-400">Bild ändern (optional)</label>
                        @if($dish->image_url)
                            <div class="my-2">
                                <img src="{{ asset('storage/' . $dish->image_url) }}" alt="Current Image" class="w-24 h-24 object-cover rounded-md">
                            </div>
                        @endif
                        <input type="file" id="image" name="image" class="w-full mt-1 text-gray-300 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-blue-600 file:text-white hover:file:bg-blue-700">
                    </div>

                    {{-- Übersetzungen mit KI-Button --}}
                    <div class="space-y-4">
                         @php
                            $langs = [['code' => 'de', 'name' => 'Deutsch'], ['code' => 'en', 'name' => 'English'], ['code' => 'hu', 'name' => 'Magyar'], ['code' => 'sk', 'name' => 'Slovenčina']];
                            $premiumPlanId = array_search('Premium AI - Tarif', config('services.stripe.plans'));
                        @endphp

                        @foreach ($langs as $lang)
                            @php $translation = $dish->translations->firstWhere('locale', $lang['code']); @endphp
                            <div class="bg-gray-700 p-4 rounded-md">
                                <label class="text-sm font-medium text-gray-300">{{ $lang['name'] }}</label>
                                <input type="text" id="name_{{ $lang['code'] }}" name="name_{{ $lang['code'] }}" value="{{ old('name_' . $lang['code'], $translation->name ?? '') }}" class="w-full mt-1 bg-gray-600 border rounded-md px-3 py-2 text-white" {{ $lang['code'] == 'de' ? 'required' : '' }}>
                                
                                <div class="relative">
                                    <textarea id="description_{{ $lang['code'] }}" name="description_{{ $lang['code'] }}" class="w-full mt-2 h-20 bg-gray-600 border rounded-md px-3 py-2 text-white text-sm pr-10" placeholder="Beschreibung des Gerichts">{{ old('description_' . $lang['code'], $translation->description ?? '') }}</textarea>
                                    
                                    @if(auth()->user()->subscription('default')?->hasPrice($premiumPlanId) || auth()->user()->role === 'superadmin')
                                    <button type="button" @click="suggestDescription('{{ $lang['code'] }}')" class="absolute top-2 right-2 p-1.5 text-gray-400 hover:text-cyan-400 rounded-full bg-gray-700" title="Beschreibung mit KI verbessern">
                                        <svg x-show="loading['{{ $lang['code'] }}']" class="animate-spin h-5 w-5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path></svg>
                                        <svg x-show="!loading['{{ $lang['code'] }}']" class="h-5 w-5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z" /></svg>
                                    </button>
                                    @endif
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>

                <div class="pt-6 flex justify-end space-x-4">
                    <a href="{{ route('dishes.index') }}" class="px-4 py-2 text-white bg-gray-600 rounded-md hover:bg-gray-500">Abbrechen</a>
                    <button type="submit" class="px-4 py-2 text-white bg-blue-600 rounded-md hover:bg-blue-700">Änderungen speichern</button>
                </div>
            </form>
        </div>
    </div>

    @push('scripts')
    <script>
        function aiFormHandler() {
            return {
                loading: { de: false, en: false, hu: false, sk: false },
                async suggestDescription(langCode) {
                    const nameInput = document.getElementById(`name_${langCode}`);
                    const descriptionTextarea = document.getElementById(`description_${langCode}`);

                    this.loading[langCode] = true;
                    descriptionTextarea.disabled = true;

                    try {
                        const response = await fetch('{{ route("ai.suggest.description") }}', {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/json',
                                'X-CSRF-TOKEN': '{{ csrf_token() }}'
                            },
                            body: JSON.stringify({
                                name: nameInput.value,
                                description: descriptionTextarea.value
                            })
                        });

                        if (!response.ok) {
                            const errorText = await response.text();
                            throw new Error(errorText);
                        }

                        const data = await response.json();
                        descriptionTextarea.value = data.suggestion;

                    } catch (error) {
                        console.error('AI Suggestion Error:', error);
                        alert('Server-Fehler: ' + error.message);
                    } finally {
                        this.loading[langCode] = false;
                        descriptionTextarea.disabled = false;
                    }
                }
            }
        }
    </script>
    @endpush
@endsection