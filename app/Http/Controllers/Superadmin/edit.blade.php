@extends('layouts.admin')

@section('title', 'Kunden bearbeiten')

@section('content')
    <h2 class="text-2xl font-bold text-white mb-6">Kunden bearbeiten: {{ $restaurant->name }}</h2>

    <div class="bg-gray-800 p-6 rounded-lg max-w-lg">
        <form action="{{ route('superadmin.clients.update', $restaurant) }}" method="POST">
            @csrf
            @method('PATCH')
            <div class="space-y-4">
                <div>
                    <label for="name" class="block text-sm font-medium text-gray-400">Restaurant-Name</label>
                    <input type="text" id="name" name="name" value="{{ old('name', $restaurant->name) }}" class="w-full mt-1 bg-gray-700 border border-gray-600 rounded-md px-3 py-2 text-white">
                </div>
                <div>
                    <label for="subdomain" class="block text-sm font-medium text-gray-400">Subdomain</label>
                    <input type="text" id="subdomain" name="subdomain" value="{{ old('subdomain', $restaurant->subdomain) }}" class="w-full mt-1 bg-gray-700 border border-gray-600 rounded-md px-3 py-2 text-white">
                </div>
            </div>

            <div class="pt-6 flex justify-end space-x-4">
                <a href="{{ route('superadmin.clients.index') }}" class="px-4 py-2 text-white bg-gray-600 rounded-md hover:bg-gray-500">Abbrechen</a>
                <button type="submit" class="px-4 py-2 text-white bg-blue-600 rounded-md hover:bg-blue-700">Änderungen speichern</button>
            </div>
        </form>
    </div>
@endsection