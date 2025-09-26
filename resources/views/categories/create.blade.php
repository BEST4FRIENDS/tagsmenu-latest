@extends('layouts.admin')

@section('title', 'Neue Kategorie erstellen')

@section('content')
    <h2 class="text-2xl font-bold text-white mb-6">Neue Kategorie erstellen</h2>

    <div class="bg-gray-800 p-6 rounded-lg">
        <form action="{{ route('categories.store') }}" method="POST">
            @csrf
            <div class="space-y-4">

                {{-- German --}}
                <div>
                    <label for="name_de" class="block text-sm font-medium text-gray-400">Name (Deutsch)</label>
                    <input type="text" id="name_de" name="name_de" class="w-full mt-1 bg-gray-700 border border-gray-600 rounded-md px-3 py-2 text-white focus:outline-none focus:ring-2 focus:ring-blue-500" required>
                </div>

                {{-- English --}}
                <div>
                    <label for="name_en" class="block text-sm font-medium text-gray-400">Name (English)</label>
                    <input type="text" id="name_en" name="name_en" class="w-full mt-1 bg-gray-700 border border-gray-600 rounded-md px-3 py-2 text-white focus:outline-none focus:ring-2 focus:ring-blue-500">
                </div>

                {{-- Hungarian --}}
                <div>
                    <label for="name_hu" class="block text-sm font-medium text-gray-400">Name (Magyar)</label>
                    <input type="text" id="name_hu" name="name_hu" class="w-full mt-1 bg-gray-700 border border-gray-600 rounded-md px-3 py-2 text-white focus:outline-none focus:ring-2 focus:ring-blue-500">
                </div>

                {{-- Slovak --}}
                <div>
                    <label for="name_sk" class="block text-sm font-medium text-gray-400">Name (Slovenčina)</label>
                    <input type="text" id="name_sk" name="name_sk" class="w-full mt-1 bg-gray-700 border border-gray-600 rounded-md px-3 py-2 text-white focus:outline-none focus:ring-2 focus:ring-blue-500">
                </div>

            </div>

            <div class="pt-6 flex justify-end space-x-4">
                <a href="{{ route('categories.index') }}" class="px-4 py-2 text-white bg-gray-600 rounded-md hover:bg-gray-500">Abbrechen</a>
                <button type="submit" class="px-4 py-2 text-white bg-blue-600 rounded-md hover:bg-blue-700">Kategorie speichern</button>
            </div>
        </form>
    </div>
@endsection