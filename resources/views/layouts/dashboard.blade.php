@extends('layouts.admin')

@section('title', 'Dashboard')

@section('content')
    <h2 class="text-2xl font-bold text-white mb-6">Willkommen zurück!</h2>
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 mb-8">
        <div class="bg-gray-800 p-6 rounded-lg">
            <h3 class="font-semibold text-lg mb-4 text-blue-400">Schnell-Aktionen</h3>
            <div class="space-y-3">
                <button class="w-full text-left flex items-center p-3 bg-gray-700 hover:bg-gray-600 rounded-md transition-colors"><svg class="h-5 w-5 mr-3" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18.364 18.364A9 9 0 005.636 5.636m12.728 12.728A9 9 0 015.636 5.636m12.728 12.728L5.636 5.636"/></svg><span>Gericht als 'ausverkauft' markieren</span></button>
                <button class="w-full text-left flex items-center p-3 bg-gray-700 hover:bg-gray-600 rounded-md transition-colors"><svg class="h-5 w-5 mr-3" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg><span>Tagesangebot ändern</span></button>
            </div>
        </div>
        <div class="bg-gray-800 p-6 rounded-lg flex flex-col items-center justify-center">
             <h3 class="font-semibold text-lg mb-4 text-blue-400">Ihr QR-Code</h3>
             <img src="https://api.qrserver.com/v1/create-qr-code/?size=120x120&data=https://rombusz.tagsmenu.app" alt="QR Code" class="rounded-md">
             <a href="https://api.qrserver.com/v1/create-qr-code/?size=500x500&data=https://rombusz.tagsmenu.app" download="qr-code.png" class="mt-4 px-4 py-2 bg-blue-600 text-white text-sm rounded-md hover:bg-blue-700"><span>Herunterladen</span></a>
        </div>
    </div>
@endsection