@extends('layouts.admin')

@section('title', __('dashboard.title'))

@section('content')
    <h2 class="text-2xl font-bold text-white mb-6">{{ __('dashboard.welcome_back') }}</h2>
    
    @php
        $restaurant = auth()->user()->restaurant;
    @endphp

    @if($restaurant)
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 mb-8">
            
            <livewire:quick-actions />

            {{-- QR Code Bereich --}}
            <div class="bg-gray-800 p-6 rounded-lg flex flex-col items-center justify-center">
                 <h3 class="font-semibold text-lg mb-4 text-blue-400">{{ __('dashboard.qr_code_title') }}</h3>
                 
                 @if($restaurant->subdomain)
                    @php
                        try {
                            $menuUrl = route('public.menu.show', ['subdomain' => $restaurant->subdomain]);
                        } catch (\Exception $e) {
                            $menuUrl = "http://{$restaurant->subdomain}.tagsmenu.app"; // Fallback
                        }
                        $qrApiUrl = "https://api.qrserver.com/v1/create-qr-code/?size=150x150&data=" . urlencode($menuUrl);
                        $qrDownloadUrl = "https://api.qrserver.com/v1/create-qr-code/?size=1000x1000&data=" . urlencode($menuUrl);
                    @endphp

                    <img src="{{ $qrApiUrl }}" alt="QR Code für {{ $restaurant->name }}" class="rounded-md shadow-lg bg-white p-1">
                    
                    <a href="{{ $qrDownloadUrl }}" download="qr-code-{{ $restaurant->subdomain }}.png" class="mt-4 px-4 py-2 bg-blue-600 text-white text-sm rounded-md hover:bg-blue-700">
                        <span>{{ __('dashboard.download_hq') }}</span>
                    </a>
                 @else
                    <p class="text-gray-500 text-sm">{{ __('dashboard.subdomain_not_set') }}</p>
                 @endif
            </div>
            
            {{-- Analytics Widget --}}
            <div class="bg-gray-800 p-6 rounded-lg">
                <h3 class="font-semibold text-lg mb-4 text-blue-400">{{ __('dashboard.analytics_title') }}</h3>
                <p class="text-gray-500">{{ __('dashboard.analytics_text') }}</p>
            </div>
        </div>
    @else
        <div class="bg-yellow-500/20 border-l-4 border-yellow-500 text-yellow-300 p-4 rounded-lg mb-6" role="alert">
            <p>{{ __('general.no_restaurant_warning') }}</p>
        </div>
    @endif
@endsection