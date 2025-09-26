@extends('layouts.admin')

@section('title', 'Einstellungen')

@section('content')
    <h2 class="text-2xl font-bold text-white mb-6">Einstellungen</h2>

    @if (session('success'))
        <div class="bg-green-500 text-white p-4 rounded-lg mb-6">
            {{ session('success') }}
        </div>
    @endif

    {{-- Formular für die Restaurant-Details --}}
    <div class="bg-gray-800 p-6 rounded-lg mb-8">
        <form action="{{ route('settings.update') }}" method="POST">
            @csrf
            @method('PATCH')
            <div class="space-y-6">
                <div>
                    <label for="rest_name" class="block text-sm font-medium text-gray-400">Restaurant-Name</label>
                    <input type="text" id="rest_name" name="name" value="{{ old('name', $restaurant->name ?? '') }}" class="w-full px-4 py-2 mt-2 text-white bg-gray-700 border border-gray-600 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                </div>
                <div>
                    <label for="rest_logo" class="block text-sm font-medium text-gray-400">Logo URL</label>
                    <input type="text" id="rest_logo" name="logo_url" value="{{ old('logo_url', $restaurant->logo_url ?? '') }}" class="w-full px-4 py-2 mt-2 text-white bg-gray-700 border border-gray-600 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                </div>
                 <div>
                    <label for="subdomain" class="block text-sm font-medium text-gray-400">Ihre Subdomain</label>
                    <div class="flex items-center mt-2">
                        <input type="text" id="subdomain" name="subdomain" value="{{ old('subdomain', $restaurant->subdomain ?? '') }}" class="w-full bg-gray-700 border border-gray-600 rounded-l-md px-3 py-2 text-white focus:outline-none focus:ring-2 focus:ring-blue-500">
                        <span class="inline-flex items-center px-3 h-full rounded-r-md border border-l-0 border-gray-600 bg-gray-600 text-gray-300 text-sm">.tagsmenu.app</span>
                    </div>
                </div>
            </div>
            <div class="pt-6 flex justify-end">
                <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700">Änderungen speichern</button>
            </div>
        </form>
    </div>

    <!-- NEU: Abschnitt für Abonnement & Abrechnung -->
    <div class="bg-gray-800 p-6 rounded-lg">
        <h3 class="text-lg font-medium text-white mb-4">Abonnement & Abrechnung</h3>
        <p class="text-gray-400 mb-4">
            Hier können Sie Ihr Abonnement verwalten, Ihre Rechnungen einsehen oder Ihre Zahlungsmethode ändern. Sie werden sicher zum Stripe Billing Portal weitergeleitet.
        </p>
        <a href="{{ route('billing.portal') }}" class="inline-block px-4 py-2 text-white bg-blue-600 rounded-md hover:bg-blue-700">
            Abrechnung verwalten
        </a>
    </div>
@endsection