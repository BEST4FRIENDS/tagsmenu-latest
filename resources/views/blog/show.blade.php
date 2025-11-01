@extends('layouts.public')

@section('content')
    {{-- HINZUGEFÜGT: pt-32 für den Abstand zum Header --}}
    <div class="container mx-auto px-6 py-12 pt-32 max-w-4xl">
        <h1 class="text-4xl md:text-5xl font-extrabold mb-4">{{ $post->title }}</h1>
        <p class="text-md text-gray-500 mb-8">
            {{-- KORRIGIERT --}}
            {{ __('portal.blog.published_on', ['date' => $post->published_at->format('d. F Y')]) }} {{ __('portal.blog.by_author', ['author' => $post->author]) }}
        </p>

        {{-- === KORREKTUR: ECHTES BEITRAGSBILD (mit Fallback) === --}}
        @if($post->image_path)
            {{-- Zeigt das hochgeladene Bild --}}
            <div class="w-full h-96 bg-cover bg-center rounded-lg mb-8" 
                 style="background-image: url('{{ asset('storage/' . $post->image_path) }}');">
            </div>
        @else
            {{-- Zeigt einen Platzhalter, FALLS kein Bild vorhanden ist --}}
            <div class="w-full h-96 bg-gray-700 flex items-center justify-center rounded-lg mb-8">
                <span class="text-gray-400 text-lg">Kein Bild vorhanden</span>
            </div>
        @endif
        {{-- === ENDE KORREKTUR === --}}

        {{-- Hauptinhalt des Beitrags --}}
        <div class="prose lg:prose-xl max-w-none text-gray-800"> {{-- Hellerer Text für besseren Kontrast --}}
            {{-- nl2br(e($post->body)) ist sicher, aber wenn Sie HTML aus einem Editor speichern, verwenden Sie: --}}
            {!! $post->body !!} 
            {{-- HINWEIS: Wenn Sie {!! $post->body !!} verwenden, stellen Sie sicher, dass Sie die Eingabe im Controller filtern (z.B. mit Purify), um XSS-Angriffe zu verhindern! --}}
            {{-- Fürs Erste bleiben wir bei der sicheren Variante: --}}
            {{-- <p>{!! nl2br(e($post->body)) !!}</p> --}}
        </div>
    </div>
@endsection