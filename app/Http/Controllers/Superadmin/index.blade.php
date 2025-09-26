@extends('layouts.admin')

@section('title', 'Kundenverwaltung')

@section('content')
    <div class="flex justify-between items-center mb-6">
        <h2 class="text-2xl font-bold text-white">Kundenverwaltung (Superadmin)</h2>
    </div>

    <div class="bg-gray-800 p-4 rounded-lg">
        <div class="overflow-x-auto">
            <table class="min-w-full">
                <thead>
                    <tr>
                        <th class="px-6 py-3 border-b-2 border-gray-700 text-left text-xs leading-4 font-medium text-gray-400 uppercase tracking-wider">Restaurant Name</th>
                        <th class="px-6 py-3 border-b-2 border-gray-700 text-left text-xs leading-4 font-medium text-gray-400 uppercase tracking-wider">Subdomain</th>
                        <th class="px-6 py-3 border-b-2 border-gray-700 text-left text-xs leading-4 font-medium text-gray-400 uppercase tracking-wider">Besitzer</th>
                        <th class="px-6 py-3 border-b-2 border-gray-700 text-left text-xs leading-4 font-medium text-gray-400 uppercase tracking-wider">Registriert am</th>
                    </tr>
                </thead>
                <tbody class="bg-gray-800">
                    @forelse ($restaurants as $restaurant)
                        <tr>
                            <td class="px-6 py-4 whitespace-no-wrap border-b border-gray-700">{{ $restaurant->name }}</td>
                            <td class="px-6 py-4 whitespace-no-wrap border-b border-gray-700">{{ $restaurant->subdomain }}</td>
                            <td class="px-6 py-4 whitespace-no-wrap border-b border-gray-700">{{ $restaurant->user->name }} ({{ $restaurant->user->email }})</td>
                            <td class="px-6 py-4 whitespace-no-wrap border-b border-gray-700">{{ $restaurant->created_at->format('d.m.Y') }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="px-6 py-4 whitespace-no-wrap border-b border-gray-700 text-center text-gray-400">
                                Es haben sich noch keine Kunden registriert.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
@endsection