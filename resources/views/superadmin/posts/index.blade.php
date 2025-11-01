@extends('layouts.admin') {{-- Annahme: Ihr Admin-Layout heißt layouts.admin --}}

@section('title', 'Blogbeiträge verwalten')

@section('content')
    <div class="flex justify-between items-center mb-6">
        <h2 class="text-2xl font-bold text-white">Blogbeiträge</h2>
        <a href="{{ route('superadmin.posts.create') }}" class="px-4 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700">
            Neuen Beitrag erstellen
        </a>
    </div>

    @if(session('success'))
        <div class="bg-green-500/20 text-green-300 p-4 rounded-lg mb-6">{{ session('success') }}</div>
    @endif

    <div class="bg-gray-800 rounded-lg overflow-hidden">
        <table class="w-full text-left text-gray-300">
            <thead class="bg-gray-700 uppercase text-xs">
                <tr>
                    <th class="px-6 py-3">Titel</th>
                    <th class="px-6 py-3">Status</th>
                    <th class="px-6 py-3">Veröffentlicht am</th>
                    <th class="px-6 py-3 text-right">Aktionen</th>
                </tr>
            </thead>
            <tbody>
                @forelse($posts as $post)
                    <tr class="border-b border-gray-700 hover:bg-gray-700/50">
                        <td class="px-6 py-4 font-medium">{{ Str::limit($post->title, 50) }}</td>
                        <td class="px-6 py-4">
                            @if($post->published_at)
                                <span class="px-2 py-1 text-xs font-semibold bg-green-500/20 text-green-300 rounded-full">Veröffentlicht</span>
                            @else
                                <span class="px-2 py-1 text-xs font-semibold bg-yellow-500/20 text-yellow-300 rounded-full">Entwurf</span>
                            @endif
                        </td>
                        <td class="px-6 py-4">{{ $post->published_at ? $post->published_at->format('d.m.Y H:i') : '---' }}</td>
                        <td class="px-6 py-4 text-right">
                            <a href="{{ route('superadmin.posts.edit', $post) }}" class="text-indigo-400 hover:text-indigo-300 mr-4">Bearbeiten</a>
                            <form action="{{ route('superadmin.posts.destroy', $post) }}" method="POST" class="inline-block" onsubmit="return confirm('Sind Sie sicher, dass Sie diesen Beitrag löschen möchten?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="text-red-500 hover:text-red-400">Löschen</button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="4" class="text-center py-8 text-gray-500">Es wurden noch keine Blogbeiträge erstellt.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="mt-6">
        {{ $posts->links() }}
    </div>
@endsection