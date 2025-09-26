<x-guest-layout>
    <div class="py-12 bg-gray-900 min-h-screen flex items-center justify-center">
        <div class="max-w-md w-full mx-auto">
            <div class="bg-gray-800 shadow-md rounded-lg p-8">
                <h2 class="text-2xl font-bold text-center text-white mb-6">Erstellen Sie Ihr Restaurant</h2>
                <p class="text-center text-gray-400 mb-6">
                    Dies ist der letzte Schritt, bevor Sie Ihre Speisekarte einrichten können.
                </p>

                <!-- Block zur Anzeige von Validierungsfehlern -->
                @if ($errors->any())
                    <div class="mb-4 bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative" role="alert">
                        <ul class="list-disc list-inside">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form method="POST" action="{{ route('restaurant.store') }}">
                    @csrf

                    <!-- Restaurant Name -->
                    <div>
                        <label for="name" class="block font-medium text-sm text-gray-300">Restaurant-Name</label>
                        {{-- KORREKTUR: ':value' wurde durch 'value' ersetzt und old() korrekt verwendet --}}
                        <input id="name" class="block mt-1 w-full bg-gray-700 border-gray-600 text-white rounded-md shadow-sm focus:border-indigo-500 focus:ring focus:ring-indigo-200 focus:ring-opacity-50" 
                               type="text" name="name" value="{{ old('name') }}" required autofocus />
                    </div>

                    <!-- Subdomain -->
                    <div class="mt-4">
                        <label for="subdomain" class="block font-medium text-sm text-gray-300">Gewünschte Web-Adresse</label>
                        <div class="flex items-center mt-1">
                             {{-- KORREKTUR: ':value' wurde durch 'value' ersetzt und old() korrekt verwendet --}}
                             <input id="subdomain" class="block w-full bg-gray-700 border-gray-600 text-white rounded-l-md shadow-sm focus:border-indigo-500 focus:ring focus:ring-indigo-200 focus:ring-opacity-50" 
                                    type="text" name="subdomain" value="{{ old('subdomain') }}" required />
                             <span class="inline-flex items-center h-full px-3 rounded-r-md border border-l-0 border-gray-600 bg-gray-600 text-gray-300 text-sm">.tagsmenu.app</span>
                        </div>
                         <p class="mt-2 text-xs text-gray-500">Nur Kleinbuchstaben, Zahlen und Bindestriche erlaubt.</p>
                    </div>

                    <div class="flex items-center justify-end mt-6">
                        <button type="submit" class="w-full inline-flex items-center justify-center px-4 py-2 bg-blue-600 border border-transparent rounded-md font-semibold text-white uppercase tracking-widest hover:bg-blue-700 active:bg-blue-900 focus:outline-none focus:border-blue-900 focus:ring ring-blue-300 disabled:opacity-25 transition ease-in-out duration-150">
                            Weiter zur Planauswahl
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-guest-layout>