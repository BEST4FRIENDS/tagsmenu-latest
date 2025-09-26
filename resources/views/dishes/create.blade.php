@extends('layouts.admin')

@section('title', 'Neues Gericht erstellen')

@section('content')
    <h2 class="text-2xl font-bold text-white mb-6">Neues Gericht erstellen</h2>

    <!-- Block zur Anzeige von Validierungsfehlern (jetzt an der richtigen Stelle) -->
    @if ($errors->any())
        <div class="mb-4 bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative" role="alert">
            <strong class="font-bold">Hoppla!</strong>
            <span class="block sm:inline">Es gab einige Probleme mit Ihrer Eingabe.</span>
            <ul class="mt-3 list-disc list-inside">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div class="bg-gray-800 p-6 rounded-lg">
        {{-- Das enctype-Attribut ist jetzt am richtigen Formular --}}
        <form action="{{ route('dishes.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="space-y-6">

                {{-- Main Details --}}
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label for="category_id" class="block text-sm font-medium text-gray-400">Kategorie</label>
                        <select id="category_id" name="category_id" class="w-full mt-1 bg-gray-700 border border-gray-600 rounded-md px-3 py-2 text-white focus:outline-none focus:ring-2 focus:ring-blue-500" required>
                            <option value="">Bitte wählen...</option>
                            @foreach ($categories as $category)
                                <option value="{{ $category->id }}" {{ old('category_id') == $category->id ? 'selected' : '' }}>
                                    {{ $category->translations->firstWhere('locale', 'de')->name ?? "Kategorie #{$category->id}" }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div>
                        <label for="price" class="block text-sm font-medium text-gray-400">Preis (in Ft)</label>
                        <input type="number" step="any" id="price" name="price" value="{{ old('price') }}" class="w-full mt-1 bg-gray-700 border border-gray-600 rounded-md px-3 py-2 text-white focus:outline-none focus:ring-2 focus:ring-blue-500" required>
                    </div>
                </div>

                {{-- Image Upload --}}
                <div>
                    <label for="image" class="block text-sm font-medium text-gray-400">Bild</label>
                    <input type="file" id="image" name="image" class="w-full mt-1 text-gray-300 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-blue-600 file:text-white hover:file:bg-blue-700">
                </div>

                {{-- Translations --}}
                <div class="space-y-4">
                    @php
                        $langs = [['code' => 'de', 'name' => 'Deutsch'], ['code' => 'en', 'name' => 'English'], ['code' => 'hu', 'name' => 'Magyar'], ['code' => 'sk', 'name' => 'Slovenčina']];
                    @endphp

                    @foreach ($langs as $lang)
                        <div class="bg-gray-700 p-4 rounded-md">
                            <label class="text-sm font-medium text-gray-300">{{ $lang['name'] }}</label>
                            <input type="text" name="name_{{ $lang['code'] }}" value="{{ old('name_' . $lang['code']) }}" placeholder="Name des Gerichts" class="w-full mt-1 bg-gray-600 border border-gray-500 rounded-md px-3 py-2 text-white" {{ $lang['code'] == 'de' ? 'required' : '' }}>
                            <textarea name="description_{{ $lang['code'] }}" placeholder="Beschreibung des Gerichts" class="w-full mt-2 h-20 bg-gray-600 border border-gray-500 rounded-md px-3 py-2 text-white text-sm">{{ old('description_' . $lang['code']) }}</textarea>
                        </div>
                    @endforeach
                </div>
                
                {{-- Tags --}}
                <div>
                    <label class="block text-sm font-medium text-gray-400">Tags</label>
                    <div class="flex space-x-6 mt-2">
                        <label class="flex items-center">
                            <input type="checkbox" name="is_special" value="1" {{ old('is_special') ? 'checked' : '' }} class="h-4 w-4 rounded text-blue-500 bg-gray-600 border-gray-500">
                            <span class="ml-2 text-sm text-gray-300">Spezialität</span>
                        </label>
                        <label class="flex items-center">
                            <input type="checkbox" name="is_vegetarian" value="1" {{ old('is_vegetarian') ? 'checked' : '' }} class="h-4 w-4 rounded text-blue-500 bg-gray-600 border-gray-500">
                            <span class="ml-2 text-sm text-gray-300">Vegetarisch</span>
                        </label>
                    </div>
                </div>

            </div>

            <div class="pt-6 flex justify-end space-x-4">
                <a href="{{ route('dishes.index') }}" class="px-4 py-2 text-white bg-gray-600 rounded-md hover:bg-gray-500">Abbrechen</a>
                <button type="submit" class="px-4 py-2 text-white bg-blue-600 rounded-md hover:bg-blue-700">Gericht speichern</button>
            </div>
        </form>
    </div>
@endsection