<?php

namespace App\Http\Controllers\Portal;

use App\Http\Controllers\Controller;
use App\Models\Restaurant;
use Illuminate\Http\Request;
use Illuminate\View\View;

class HomeController extends Controller
{
    /**
     * Zeigt die Startseite des Portals an.
     * Lädt eine Auswahl an öffentlich gelisteten und aktiven Restaurants,
     * um sie auf der Homepage zu präsentieren.
     *
     * @return View
     */
    public function index(): View
    {
        // Hole bis zu 8 zufällige Restaurants, die aktiv und öffentlich sind.
        // inRandomOrder() ist gut für Abwechslung auf der Startseite.
        // Für eine "Neueste zuerst"-Liste, ersetze es mit latest().
        $featuredRestaurants = Restaurant::where('is_publicly_listed', true)
            ->where('status', 'active')
            ->inRandomOrder()
            ->limit(8)
            ->get();

        // Übergib die Daten an die Blade-View.
        // Sie müssen die View 'resources/views/portal/home.blade.php' erstellen.
        return view('portal.home', [
            'restaurants' => $featuredRestaurants,
        ]);
    }
}