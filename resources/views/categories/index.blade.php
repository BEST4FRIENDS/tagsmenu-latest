@extends('layouts.admin')

@section('title', 'Kategorien-Verwaltung')

@section('content')
    <div class="flex justify-between items-center mb-6">
        <h2 class="text-2xl font-bold text-white">Kategorien-Verwaltung</h2>
        <a href="{{ route('categories.create') }}" class="px-4 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700 flex items-center">
            <svg class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"/></svg>
            <span>Neue Kategorie</span>
        </a>
    </div>

    @if (session('success'))
        <div class="bg-green-500 text-white p-4 rounded-lg mb-6">
            {{ session('success') }}
        </div>
    @endif

    <div class="bg-gray-800 p-4 rounded-lg">
        <div class="space-y-2">
            @forelse ($categories as $category)
                <div class="flex items-center justify-between p-3 bg-gray-700 rounded-md">
                    <div class="flex items-center">
                        <svg class="w-5 h-5 text-gray-500 mr-3 cursor-move" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16m-7 6h7"/></svg>
                        <span class="font-medium">
                            {{ $category->translations->firstWhere('locale', 'de')->name ?? 'Kategorie ohne Namen' }}
                        </span>
                    </div>
                    <div class="flex items-center space-x-4">
                        <a href="{{ route('categories.edit', $category) }}" class="text-gray-400 hover:text-white" title="Bearbeiten">
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.5L14.732 3.732z" />
                            </svg>
                        </a>
                        
                        <form action="{{ route('categories.destroy', $category) }}" method="POST" onsubmit="return confirm('Sind Sie sicher, dass Sie diese Kategorie löschen möchten?');">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="text-red-500 hover:text-red-400" title="Löschen">
                                <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                </svg>
                            </button>
                        </form>
                    </div>
                </div>
            @empty
                <p class="text-gray-400 text-center py-4">Sie haben noch keine Kategorien erstellt.</p>
            @endforelse
        </div>
    </div>
@endsection