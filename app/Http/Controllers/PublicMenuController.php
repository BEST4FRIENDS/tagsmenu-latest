<?php

namespace App\Http\Controllers;

use App\Models\Restaurant;
use Illuminate\Http\Request;

class PublicMenuController extends Controller
{
    /**
     * Display the specified restaurant's public menu.
     */
    public function show(string $subdomain)
    {
        $restaurant = Restaurant::where('subdomain', $subdomain)
            ->with(['categories.translations', 'categories.dishes.translations'])
            ->firstOrFail();

        // NEUER SICHERHEITS-CHECK
        if ($restaurant->status !== 'active') {
            abort(403, 'Dieses Restaurant ist zurzeit nicht verfügbar.');
        }

        return view('public.menu', [
            'restaurant' => $restaurant,
        ]);
    }
}