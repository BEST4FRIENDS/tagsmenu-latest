<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\View\View;
use App\Models\PortalCategory; // Wird vom Cache verwendet
use App\Models\Restaurant; // Wird vom Cache verwendet
use Illuminate\Support\Facades\Cache; // <-- WICHTIG: Cache importieren

class HomeController extends Controller
{
    public function index(): View
    {
        // --- NEUE "IDEE 5" LOGIK (DATENGETRIEBEN) ---

        // 1. Hole das "Top-Gericht des Tages" aus dem Cache.
        // (Der Job speichert das ganze Dish-Objekt)
        $topDish = Cache::get('trending.top_dish_of_the_day');

        // 2. Hole die "Trending Kategorien" aus dem Cache.
        // (Der Job speichert eine Collection von PortalCategory-Objekten)
        // Wir nennen es $popularCategories, da die Blade-Datei diesen Namen erwartet.
        $popularCategories = Cache::get('trending.categories');

        // Übergibt die NEUEN Variablen an die View
        return view('home', compact('popularCategories', 'topDish'));
    }
}