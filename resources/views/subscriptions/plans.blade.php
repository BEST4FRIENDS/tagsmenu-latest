@extends('layouts.admin')

@section('title', 'Tarif wählen')

@section('content')
<div class="max-w-6xl mx-auto py-10 sm:px-6 lg:px-8">
    <div class="text-center mb-12">
        <h2 class="text-3xl font-extrabold text-white">Wählen Sie Ihren Tarif</h2>
        <p class="text-gray-400 mt-2">Aktivieren Sie Ihr Konto, um alle Funktionen von TAGS.MENU zu nutzen.</p>
    </div>

    {{-- Feedback bei Abbruch der Zahlung --}}
    @if (request()->get('payment') == 'cancelled')
        <div class="bg-yellow-500/20 border-l-4 border-yellow-500 text-yellow-300 p-4 rounded-lg mb-6 max-w-3xl mx-auto" role="alert">
            <p>Zahlung abgebrochen. Sie können es erneut versuchen.</p>
        </div>
    @endif

    {{-- Feedback durch Middleware (CheckSubscribed) --}}
    @if (session('info'))
        <div class="bg-blue-500/20 border-l-4 border-blue-500 text-blue-300 p-4 rounded-lg mb-6 max-w-3xl mx-auto" role="alert">
            <p>{{ session('info') }}</p>
        </div>
    @endif

    <div class="flex flex-wrap justify-center gap-8">
        @foreach($plans as $key => $plan)
            {{-- Prüft, ob eine Stripe ID in der .env hinterlegt ist --}}
            @if($plan['stripe_price_id'])
            <div class="bg-gray-800 rounded-lg shadow-xl p-8 w-full md:w-80 {{ $plan['highlighted'] ?? false ? 'border-2 border-blue-500 ring-4 ring-blue-500/30' : 'border border-gray-700' }}">
                
                <h3 class="text-2xl font-bold text-white">{{ $plan['name'] }}</h3>
                <p class="mt-4 text-4xl font-extrabold text-white">{{ $plan['price'] }}</p>

                <ul class="mt-6 space-y-4">
                    @foreach($plan['features'] as $feature)
                        <li class="flex items-center text-gray-300">
                            <x-heroicon-o-check-circle class="w-5 h-5 text-green-400 mr-3 flex-shrink-0"/>
                            <span class="text-sm">{{ $feature }}</span>
                        </li>
                    @endforeach
                </ul>

                <form action="{{ route('subscription.create') }}" method="POST" class="mt-8">
                    @csrf
                    <input type="hidden" name="plan_id" value="{{ $plan['stripe_price_id'] }}">
                    <button type="submit" class="w-full px-6 py-3 text-white font-semibold rounded-md transition {{ $plan['highlighted'] ?? false ? 'bg-blue-600 hover:bg-blue-700' : 'bg-gray-600 hover:bg-gray-500' }}">
                        Jetzt abonnieren
                    </button>
                </form>
            </div>
            @else
            {{-- Fallback, wenn die Stripe ID fehlt --}}
             <div class="bg-gray-800 rounded-lg shadow-xl p-8 w-full md:w-80 border border-gray-700 opacity-50">
                <h3 class="text-2xl font-bold text-white">{{ $plan['name'] }}</h3>
                <p class="mt-4 text-gray-400">Konfiguration fehlt (Stripe ID).</p>
             </div>
            @endif
        @endforeach
    </div>
</div>
@endsection