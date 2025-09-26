<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;

class DashboardController extends Controller
{
    public function index()
    {
        $restaurant = Auth::user()->restaurant;
        return view('dashboard', ['restaurant' => $restaurant]);
    }

    public function downloadQrCode()
    {
        $restaurant = Auth::user()->restaurant;

        if (!$restaurant || !$restaurant->subdomain) {
            return redirect()->route('dashboard')->with('error', 'Keine Subdomain für QR-Code gefunden.');
        }

        $url = "https://api.qrserver.com/v1/create-qr-code/?size=500x500&data=https://{$restaurant->subdomain}.tagsmenu.app";

        $response = Http::get($url);

        if ($response->successful()) {
            return response($response->body())
                ->header('Content-Type', $response->header('Content-Type'))
                ->header('Content-Disposition', 'attachment; filename="qr-code-'.$restaurant->subdomain.'.png"');
        }

        return redirect()->route('dashboard')->with('error', 'QR-Code konnte nicht heruntergeladen werden.');
    }
}