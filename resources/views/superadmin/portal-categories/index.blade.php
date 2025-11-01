@extends('layouts.admin')

@section('title', 'Portal-Kategorien verwalten')

@section('content')
    <div class="flex justify-between items-center mb-6">
        <h2 class="text-2xl font-bold text-white">Portal-Kategorien</h2>
        <a href="{{ route('superadmin.portal-categories.create') }}" class="px-4 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700">Neue Kategorie erstellen</a>
    </div>

    @if (session('success'))
        <div class="bg-green-500/20 border-l-4 border-green-500 text-green-300 p-4 rounded-lg mb-6" role="alert">
            <p>{{ session('success') }}</p>
        </div>
    @endif

    <div class="bg-gray-800 p-4 rounded-lg">
        <div class="overflow-x-auto">
            <table class="min-w-full">
                <thead>
                    <tr>
                        <th class="px-6 py-3 border-b-2 border-gray-700 text-left text-xs font-medium text-gray-400 uppercase">Name (Deutsch)</th>
                        <th class="px-6 py-3 border-b-2 border-gray-700 text-left text-xs font-medium text-gray-400 uppercase">Slug</th>
                        <th class="px-6 py-3 border-b-2 border-gray-700"></th>
                    </tr>
                </thead>
                <tbody class="bg-gray-800 text-white">
                    @forelse ($categories as $category)
                        <tr>
                            <td class="px-6 py-4 whitespace-no-wrap border-b border-gray-700">
                                <div class="font-bold">{{ $category->getTranslation('name', 'de') }}</div>
                                <div class="text-sm text-gray-400">
                                    @php
                                        // Holt alle Übersetzungen, entfernt die deutsche ('de'), filtert leere Werte.
                                        $otherTranslations = array_diff_key($category->getTranslations('name'), ['de' => '']);
                                    @endphp
                                    {{-- KORRIGIERT: Tippfehler im Variablennamen behoben --}}
                                    Andere Sprachen: {{ implode(', ', array_filter($otherTranslations)) }}
                                </div>
                            </td>
                            <td class="px-6 py-4 whitespace-no-wrap border-b border-gray-700 text-sm text-gray-400">
                                {{ $category->slug }}
                            </td>
                            <td class="px-6 py-4 whitespace-no-wrap border-b border-gray-700 text-right text-sm font-medium">
                                <div class="flex items-center justify-end space-x-4">
                                    <a href="{{ route('superadmin.portal-categories.edit', $category) }}" class="text-indigo-400 hover:text-indigo-300">Bearbeiten</a>
                                    
                                    <form action="{{ route('superadmin.portal-categories.destroy', $category) }}" method="POST" onsubmit="return confirm('Sind Sie sicher, dass Sie diese Kategorie löschen möchten?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="text-red-500 hover:text-red-400">Löschen</button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="3" class="px-6 py-4 text-center border-b border-gray-700 text-gray-400">
                                Es wurden noch keine Kategorien erstellt.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
@endsection