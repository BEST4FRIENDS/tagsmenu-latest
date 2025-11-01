@extends('layouts.public')

@section('content')
    {{-- HINZUGEFÜGT: pt-32 für den Abstand zum Header --}}
    <div class="container mx-auto px-6 py-12 pt-32">
        <div class="text-center mb-12">
            {{-- KORRIGIERT --}}
            <h1 class="text-4xl md:text-5xl font-extrabold">{{ __('portal.blog.title') }}</h1>
            <p class="text-lg text-gray-600 mt-2">{{ __('portal.blog.subtitle') }}</p>
        </div>

        @if($posts->isNotEmpty())
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                @foreach($posts as $post)
                    <a href="{{ route('blog.show', $post) }}" class="bg-white rounded-lg shadow-md overflow-hidden group block">
                        
                        {{-- === KORREKTUR: ECHTES BEITRAGSBILD (mit Fallback) === --}}
                        @if($post->image_path)
                            <div class="h-56 bg-cover bg-center" 
                                 style="background-image: url('{{ asset('storage/' . $post->image_path) }}');">
                            </div>
                        @else
                            <div class="h-56 bg-gray-700 flex items-center justify-center">
                                <span class="text-gray-400 text-sm">Kein Bild</span>
                            </div>
                        @endif
                        {{-- === ENDE KORREKTUR === --}}

                        <div class="p-6">
                            <h3 class="text-xl font-bold mb-2 group-hover:text-blue-600 transition-colors">{{ $post->title }}</h3>
                            <p class="text-gray-700 text-sm mb-4">{{ $post->excerpt }}</p>
                            {{-- KORRIGIERT --}}
                            <p class="text-xs text-gray-500">{{ $post->published_at->format('d. F Y') }} • {{ __('portal.blog.by_author', ['author' => $post->author]) }}</p>
                        </div>
                    </a>
                @endforeach
            </div>

            {{-- Pagination Links --}}
            <div class="mt-12">
                {{ $posts->links() }}
            </div>
        @else
            {{-- KORRIGIERT (Neuer Schlüssel wird benötigt) --}}
            <p class="text-center text-gray-600">{{ __('portal.blog.no_posts_found') }}</p>
        @endif
    </div>
@endsection