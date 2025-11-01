<?php

namespace App\Http\Controllers;

use App\Models\Restaurant;
use Illuminate\Http\Request;
use Illuminate\View\View;

class HubController extends Controller
{
    public function show(Restaurant $restaurant): View
    {
        // Stellt sicher, dass nur öffentlich gelistete Restaurants aufgerufen werden können.
        if (!$restaurant->is_publicly_listed) {
            abort(404);
        }
        
        // Lädt die benötigten Beziehungen für die Anzeige
        $restaurant->load(['portalCategories', 'hashtags']);

        return view('hubs.show', compact('restaurant'));
    }
}