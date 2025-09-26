<x-guest-layout>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <h2 class="text-2xl font-bold text-center mb-8">Wählen Sie Ihren Plan</h2>

                    <div class="grid grid-cols-1 md:grid-cols-3 gap-8">

                        <!-- Basis Tarif -->
                        <div class="border-2 border-gray-200 rounded-lg p-6 text-center flex flex-col">
                            <h3 class="text-xl font-semibold mb-4">Basis Tarif</h3>
                            <div class="text-4xl font-bold mb-4">29€<span class="text-lg font-normal">/Monat</span></div>
                            <ul class="text-left mb-6 space-y-2 flex-grow">
                                <li>✓ Digitale Speisekarte</li>
                                <li>✓ QR-Code Generator</li>
                                <li>✓ Unbegrenzte Gerichte</li>
                            </ul>
                            <a href="{{ route('subscribe.create', ['plan' => 'price_IHRE_BASIS_PLAN_ID']) }}" class="mt-auto w-full bg-blue-600 text-white py-2 px-4 rounded hover:bg-blue-700">
                                Jetzt abonnieren
                            </a>
                        </div>

                        <!-- Premium AI - Tarif -->
                        <div class="border-2 border-blue-600 rounded-lg p-6 text-center flex flex-col ring-4 ring-blue-200">
                            <h3 class="text-xl font-semibold mb-4">Premium AI - Tarif</h3>
                            <div class="text-4xl font-bold mb-4">99€<span class="text-lg font-normal">/Monat</span></div>
                            <ul class="text-left mb-6 space-y-2 flex-grow">
                                <li>✓ Alle Features vom Basis Tarif</li>
                                <li>✓ KI-gestützte Beschreibungen</li>
                                <li>✓ Erweiterte Designs</li>
                            </ul>
                            <a href="{{ route('subscribe.create', ['plan' => 'price_IHRE_PREMIUM_PLAN_ID']) }}" class="mt-auto w-full bg-blue-600 text-white py-2 px-4 rounded hover:bg-blue-700">
                                Jetzt abonnieren
                            </a>
                        </div>

                        <!-- Concierge-Tarif -->
                        <div class="border-2 border-gray-200 rounded-lg p-6 text-center flex flex-col">
                            <h3 class="text-xl font-semibold mb-4">Concierge-Tarif</h3>
                            <div class="text-4xl font-bold mb-4">249€<span class="text-lg font-normal">/Monat</span></div>
                            <ul class="text-left mb-6 space-y-2 flex-grow">
                                <li>✓ Alle Features vom Premium Tarif</li>
                                <li>✓ Persönlicher Onboarding-Service</li>
                                <li>✓ Telefon-Support</li>
                            </ul>
                            <a href="{{ route('subscribe.create', ['plan' => 'price_IHRE_CONCIERGE_PLAN_ID']) }}" class="mt-auto w-full bg-blue-600 text-white py-2 px-4 rounded hover:bg-blue-700">
                                Jetzt abonnieren
                            </a>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
</x-guest-layout>