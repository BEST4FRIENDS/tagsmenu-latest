@extends('layouts.admin')

@section('title', 'Dashboard')

@section('content')
    <div x-data="{ isQrModalOpen: false }">
        <h2 class="text-2xl font-bold text-white mb-6">Willkommen zurück!</h2>

        @if (session('success'))
            <div class="mb-6 bg-green-100 border-l-4 border-green-500 text-green-700 p-4 rounded-lg" role="alert">
                <p class="font-bold">Erfolg!</p>
                <p>{{ session('success') }}</p>
            </div>
        @endif

        @if (session('error'))
            <div class="mb-6 bg-red-100 border-l-4 border-red-500 text-red-700 p-4 rounded-lg" role="alert">
                <p class="font-bold">Fehler</p>
                <p>{{ session('error') }}</p>
            </div>
        @endif

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 mb-8">
            
            <livewire:quick-actions />

            <div class="bg-gray-800 p-6 rounded-lg flex flex-col items-center justify-center">
                 <h3 class="font-semibold text-lg mb-4 text-blue-400">Ihr QR-Code</h3>
                 
                 @if ($restaurant && $restaurant->subdomain)
                    <img src="https://api.qrserver.com/v1/create-qr-code/?size=120x120&data=https://{{ $restaurant->subdomain }}.tagsmenu.app" alt="QR Code" class="rounded-md">
                    
                    <!-- Container für die Buttons -->
                    <div class="mt-4 flex space-x-3">
                        <button @click="isQrModalOpen = true" class="px-4 py-2 bg-blue-600 text-white text-sm rounded-md hover:bg-blue-700">
                            <span>Vergrößern</span>
                        </button>
                        
                        <!-- NEU: Download-Button -->
                        <a href="{{ route('qr_code.download') }}" class="px-4 py-2 bg-green-600 text-white text-sm rounded-md hover:bg-green-700">
                            <span>Herunterladen</span>
                        </a>
                    </div>
                 @else
                    <p class="text-gray-400 text-sm text-center">Bitte legen Sie in den Einstellungen eine Subdomain fest, um Ihren QR-Code zu sehen.</p>
                 @endif
            </div>

        </div>

        {{-- QR-Code Modal --}}
        @if ($restaurant && $restaurant->subdomain)
            <div x-show="isQrModalOpen" 
                 x-transition:enter="ease-out duration-300"
                 x-transition:enter-start="opacity-0"
                 x-transition:enter-end="opacity-100"
                 x-transition:leave="ease-in duration-200"
                 x-transition:leave-start="opacity-100"
                 x-transition:leave-end="opacity-0"
                 class="fixed inset-0 z-50 flex items-center justify-center bg-black bg-opacity-75" 
                 x-cloak>
                
                <div @click.away="isQrModalOpen = false" class="bg-white p-8 rounded-lg text-center">
                    <h3 class="font-bold text-lg text-gray-800 mb-4">{{ $restaurant->name }}</h3>
                    <img src="https://api.qrserver.com/v1/create-qr-code/?size=300x300&data=https://{{ $restaurant->subdomain }}.tagsmenu.app" alt="QR Code Groß" class="rounded-md">
                    
                    <!-- Container für die Buttons im Modal -->
                    <div class="mt-6 flex justify-center space-x-4">
                        <button @click="isQrModalOpen = false" class="px-4 py-2 bg-gray-600 text-white text-sm rounded-md hover:bg-gray-500">
                            Schließen
                        </button>
                        <!-- NEU: Download-Button im Modal -->
                        <a href="{{ route('qr_code.download') }}" class="px-4 py-2 bg-green-600 text-white text-sm rounded-md hover:bg-green-700">
                            Herunterladen (500px)
                        </a>
                    </div>
                </div>
            </div>
        @endif
    </div>
@endsection