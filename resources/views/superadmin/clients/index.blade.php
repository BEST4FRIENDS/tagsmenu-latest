@extends('layouts.admin')

@section('title', 'Kundenverwaltung')

@section('content')
    <div class="flex justify-between items-center mb-6">
        <h2 class="text-2xl font-bold text-white">Kundenverwaltung (Superadmin)</h2>
    </div>

    @if (session('success'))
        <div class="bg-green-500 text-white p-4 rounded-lg mb-6">
            {{ session('success') }}
        </div>
    @endif

    <div class="bg-gray-800 p-4 rounded-lg">
        <div class="overflow-x-auto">
            <table class="min-w-full">
                <thead>
                    <tr>
                        <th class="px-6 py-3 border-b-2 border-gray-700 text-left text-xs font-medium text-gray-400 uppercase">Restaurant & Besitzer</th>
                        <th class="px-6 py-3 border-b-2 border-gray-700 text-left text-xs font-medium text-gray-400 uppercase">Status</th>
                        <th class="px-6 py-3 border-b-2 border-gray-700 text-left text-xs font-medium text-gray-400 uppercase">Abonnement-Plan</th>
                        <th class="px-6 py-3 border-b-2 border-gray-700 text-left text-xs font-medium text-gray-400 uppercase">Abo-Status</th>
                        <th class="px-6 py-3 border-b-2 border-gray-700 text-left text-xs font-medium text-gray-400 uppercase">Registriert seit</th>
                        <th class="px-6 py-3 border-b-2 border-gray-700"></th>
                    </tr>
                </thead>
                <tbody class="bg-gray-800 text-white">
                    @forelse ($restaurants as $restaurant)
                        @php
                            $user = $restaurant->user;
                        @endphp
                        <tr>
                            <td class="px-6 py-4 whitespace-no-wrap border-b border-gray-700">
                                <div class="font-bold">{{ $restaurant->name }}</div>
                                <div class="text-sm text-gray-400">{{ $user->name ?? 'N/A' }} ({{ $user->email ?? 'N/A' }})</div>
                            </td>
                            <td class="px-6 py-4 whitespace-no-wrap border-b border-gray-700">
                                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full {{ $restaurant->status === 'active' ? 'bg-green-500 text-green-100' : 'bg-red-500 text-red-100' }}">
                                    {{ $restaurant->status === 'active' ? 'Aktiv' : 'Gesperrt' }}
                                </span>
                            </td>
                            <td class="px-6 py-4 whitespace-no-wrap border-b border-gray-700">
                                @if ($user && $user->subscribed('default'))
                                    <span class="font-semibold">{{ $user->getPlanName() }}</span>
                                @else
                                    <span class="text-gray-500">Kein Plan</span>
                                @endif
                            </td>
                            <td class="px-6 py-4 whitespace-no-wrap border-b border-gray-700">
                                @if ($user && $user->subscribed('default'))
                                    @php $subscription = $user->subscription('default'); @endphp
                                    <span class="font-semibold {{ $subscription->stripe_status === 'active' ? 'text-green-400' : 'text-red-400' }}">
                                        {{ ucfirst($subscription->stripe_status) }}
                                    </span>
                                @else
                                    <span class="text-gray-500">-</span>
                                @endif
                            </td>
                            <td class="px-6 py-4 whitespace-no-wrap border-b border-gray-700 text-sm text-gray-400">
                                {{ $restaurant->created_at->format('d.m.Y') }}
                            </td>
                            <td class="px-6 py-4 whitespace-no-wrap border-b border-gray-700 text-right text-sm font-medium">
                                <div class="flex items-center justify-end space-x-4">
                                    <a href="{{ route('superadmin.clients.edit', ['restaurant' => $restaurant]) }}" class="text-indigo-400 hover:text-indigo-300">Bearbeiten</a>
                                    
                                    {{-- Das "Löschen"-Formular --}}
                                    <form action="{{ route('superadmin.clients.destroy', ['restaurant' => $restaurant]) }}" method="POST" onsubmit="return confirm('Sind Sie sicher, dass Sie diesen Kunden endgültig löschen möchten? Alle seine Daten gehen verloren.');">
                                        @csrf
                                        @method('DELETE') {{-- DIES IST DER ENTSCHEIDENDE TEIL --}}
                                        <button type="submit" class="text-red-500 hover:text-red-400">Löschen</button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="px-6 py-4 text-center border-b border-gray-700 text-gray-400">
                                Es haben sich noch keine Kunden registriert.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
@endsection