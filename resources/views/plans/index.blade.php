<x-guest-layout>
    <div class="min-h-screen bg-slate-900 text-white py-12 px-4 sm:px-6 lg:px-8">
        <div class="container mx-auto">

            <!-- Überschrift -->
            <div class="text-center mb-16">
                <h1 class="text-4xl font-extrabold tracking-tight sm:text-5xl md:text-6xl">
                    Wählen Sie den perfekten Plan für Ihr Restaurant
                </h1>
                <p class="mt-4 max-w-2xl mx-auto text-xl text-slate-400">
                    Starten Sie heute und digitalisieren Sie Ihre Speisekarte in wenigen Minuten.
                </p>
            </div>

            <!-- Grid für die Preispläne -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-8 max-w-7xl mx-auto">

                <!-- Basis Tarif -->
                <div class="bg-slate-800 rounded-2xl shadow-xl p-8 flex flex-col transform hover:-translate-y-2 transition-transform duration-300">
                    <h3 class="text-2xl font-bold mb-4">Basis Tarif</h3>
                    <div class="flex items-baseline mb-6">
                        <span class="text-5xl font-extrabold tracking-tight">29€</span>
                        <span class="ml-2 text-xl text-slate-400">/Monat</span>
                    </div>
                    <ul class="text-left mb-8 space-y-4 text-slate-300 flex-grow">
                        <li class="flex items-center"><svg class="w-6 h-6 text-cyan-400 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>Digitale Speisekarte</li>
                        <li class="flex items-center"><svg class="w-6 h-6 text-cyan-400 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>QR-Code Generator</li>
                        <li class="flex items-center"><svg class="w-6 h-6 text-cyan-400 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>Unbegrenzte Gerichte</li>
                    </ul>
                    <a href="{{ route('subscribe.create', ['plan' => 'price_1S7yu2HZisIzMiCRgFU5d97U']) }}" class="mt-auto block w-full text-center bg-slate-700 font-bold py-3 px-6 rounded-lg hover:bg-slate-600 transition-colors duration-300">
                        Jetzt starten
                    </a>
                </div>

                <!-- Premium AI - Tarif (Hervorgehoben) -->
                <div class="bg-slate-800 rounded-2xl shadow-2xl p-8 flex flex-col ring-2 ring-cyan-400 relative transform hover:-translate-y-2 transition-transform duration-300">
                    <div class="absolute top-0 right-0 -mt-3 mr-3 bg-cyan-400 text-slate-900 text-xs font-bold px-3 py-1 rounded-full uppercase tracking-wider">Beliebtester Plan</div>
                    <h3 class="text-2xl font-bold text-cyan-400 mb-4">Premium AI</h3>
                    <div class="flex items-baseline mb-6">
                        <span class="text-5xl font-extrabold tracking-tight">99€</span>
                        <span class="ml-2 text-xl text-slate-400">/Monat</span>
                    </div>
                    <ul class="text-left mb-8 space-y-4 text-slate-300 flex-grow">
                        <li class="flex items-center"><svg class="w-6 h-6 text-cyan-400 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>Alle Features vom Basis Tarif</li>
                        <li class="flex items-center"><svg class="w-6 h-6 text-cyan-400 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>KI-gestützte Beschreibungen</li>
                        <li class="flex items-center"><svg class="w-6 h-6 text-cyan-400 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>Erweiterte Designs</li>
                    </ul>
                    <a href="{{ route('subscribe.create', ['plan' => 'price_1S7yw7HZisIzMiCR2mOAJ2iq']) }}" class="mt-auto block w-full text-center bg-cyan-400 text-slate-900 font-bold py-3 px-6 rounded-lg hover:bg-cyan-500 transition-colors duration-300">
                        Jetzt abonnieren
                    </a>
                </div>

                <!-- Concierge-Tarif -->
                <div class="bg-slate-800 rounded-2xl shadow-xl p-8 flex flex-col transform hover:-translate-y-2 transition-transform duration-300">
                    <h3 class="text-2xl font-bold mb-4">Concierge Tarif</h3>
                    <div class="flex items-baseline mb-6">
                        <span class="text-5xl font-extrabold tracking-tight">249€</span>
                        <span class="ml-2 text-xl text-slate-400">/Monat</span>
                    </div>
                    <ul class="text-left mb-8 space-y-4 text-slate-300 flex-grow">
                        <li class="flex items-center"><svg class="w-6 h-6 text-cyan-400 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>Alle Features vom Premium Tarif</li>
                        <li class="flex items-center"><svg class="w-6 h-6 text-cyan-400 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>Persönlicher Onboarding-Service</li>
                        <li class="flex items-center"><svg class="w-6 h-6 text-cyan-400 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>Telefon-Support</li>
                    </ul>
                    <a href="{{ route('subscribe.create', ['plan' => 'price_1S7z09HZisIzMiCRbrs4i4ql']) }}" class="mt-auto block w-full text-center bg-slate-700 font-bold py-3 px-6 rounded-lg hover:bg-slate-600 transition-colors duration-300">
                        Jetzt starten
                    </a>
                </div>

            </div>
        </div>
    </div>
</x-guest-layout>