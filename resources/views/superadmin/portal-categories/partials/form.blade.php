{{-- Zeigt Fehler an, falls vorhanden --}}
@if($errors->any())
    <div class="bg-red-500/20 text-red-300 p-4 rounded-lg mb-6">
        <ul class="list-disc list-inside">
            @foreach($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

{{-- Nur noch die Namensfelder --}}
<div class="space-y-4">
    <div>
        <label for="name_de" class="block text-sm font-medium text-gray-400">Name (Deutsch)</label>
        <input type="text" id="name_de" name="name[de]" value="{{ old('name.de', $category->getTranslation('name', 'de')) }}" required class="w-full mt-1 bg-gray-700 border-gray-600 text-white p-2 rounded-md">
    </div>
    <div>
        <label for="name_en" class="block text-sm font-medium text-gray-400">Name (English)</label>
        <input type="text" id="name_en" name="name[en]" value="{{ old('name.en', $category->getTranslation('name', 'en')) }}" class="w-full mt-1 bg-gray-700 border-gray-600 text-white p-2 rounded-md">
    </div>
    <div>
        <label for="name_hu" class="block text-sm font-medium text-gray-400">Name (Magyar)</label>
        <input type="text" id="name_hu" name="name[hu]" value="{{ old('name.hu', $category->getTranslation('name', 'hu')) }}" class="w-full mt-1 bg-gray-700 border-gray-600 text-white p-2 rounded-md">
    </div>
    <div>
        <label for="name_sk" class="block text-sm font-medium text-gray-400">Name (Slovenčina)</label>
        <input type="text" id="name_sk" name="name[sk]" value="{{ old('name.sk', $category->getTranslation('name', 'sk')) }}" class="w-full mt-1 bg-gray-700 border-gray-600 text-white p-2 rounded-md">
    </div>
</div>

{{-- Buttons (unverändert) --}}
<div class="pt-8 flex justify-end">
    <a href="{{ route('superadmin.portal-categories.index') }}" class="px-6 py-2 mr-4 bg-gray-600 text-white rounded-md hover:bg-gray-500">Abbrechen</a>
    <button type="submit" class="px-6 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700">
        {{ $category->exists ? 'Änderungen speichern' : 'Kategorie erstellen' }}
    </button>
</div>