@if($errors->any())
    <div class="bg-red-500/20 text-red-300 p-4 rounded-lg mb-6">
        <p><strong>Fehler:</strong> Bitte überprüfen Sie Ihre Eingaben.</p>
        <ul class="list-disc list-inside mt-2">
            @foreach($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

<div class="space-y-6">
    {{-- Titel --}}
    <div>
        <label for="title" class="block text-sm font-medium text-gray-400">Titel</label>
        <input type="text" id="title" name="title" value="{{ old('title', $post->title) }}" required class="w-full mt-1 bg-gray-700 border-gray-600 text-white p-2 rounded-md focus:ring-blue-500 focus:border-blue-500">
    </div>

    {{-- Kurzbeschreibung --}}
    <div>
        <label for="excerpt" class="block text-sm font-medium text-gray-400">Kurzbeschreibung (Excerpt)</label>
        <textarea id="excerpt" name="excerpt" rows="3" required class="w-full mt-1 bg-gray-700 border-gray-600 text-white p-2 rounded-md focus:ring-blue-500 focus:border-blue-500">{{ old('excerpt', $post->excerpt) }}</textarea>
    </div>

    {{-- Hauptinhalt --}}
    <div>
        <label for="body" class="block text-sm font-medium text-gray-400">Hauptinhalt</label>
        <textarea id="body" name="body" rows="10" required class="w-full mt-1 bg-gray-700 border-gray-600 text-white p-2 rounded-md focus:ring-blue-500 focus:border-blue-500">{{ old('body', $post->body) }}</textarea>
    </div>
    
    {{-- Autor --}}
    <div>
        <label for="author" class="block text-sm font-medium text-gray-400">Autor (Optional)</label>
        <input type="text" id="author" name="author" value="{{ old('author', $post->author) }}" class="w-full mt-1 bg-gray-700 border-gray-600 text-white p-2 rounded-md focus:ring-blue-500 focus:border-blue-500">
    </div>

    {{-- Bild-Upload --}}
    <div>
        <label for="image" class="block text-sm font-medium text-gray-400">Beitragsbild (Optional)</label>
        <input type="file" id="image" name="image" class="w-full mt-1 text-gray-400 file:mr-4 file:py-2 file:px-4 file:rounded-md file:border-0 file:text-sm file:font-semibold file:bg-blue-600 file:text-white hover:file:bg-blue-700">
        @if($post->image_path)
            <div class="mt-4">
                <p class="text-xs text-gray-500 mb-2">Aktuelles Bild:</p>
                <img src="{{ asset('storage/' . $post->image_path) }}" alt="Aktuelles Bild" class="max-h-40 rounded-md">
            </div>
        @endif
    </div>

    {{-- Veröffentlichen --}}
    <div class="flex items-center">
        <input type="checkbox" id="is_published" name="is_published" value="1" @if(old('is_published', $post->published_at)) checked @endif class="h-4 w-4 rounded border-gray-600 bg-gray-700 text-blue-600 focus:ring-blue-500">
        <label for="is_published" class="ml-2 block text-sm text-gray-300">Beitrag veröffentlichen</label>
    </div>
</div>

<div class="pt-8 flex justify-end">
    <a href="{{ route('superadmin.posts.index') }}" class="px-6 py-2 mr-4 bg-gray-600 text-white rounded-md hover:bg-gray-500">Abbrechen</a>
    <button type="submit" class="px-6 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700">
        {{ $post->exists ? 'Änderungen speichern' : 'Beitrag erstellen' }}
    </button>
</div>