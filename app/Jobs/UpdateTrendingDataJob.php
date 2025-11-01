<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Carbon;
use App\Models\Dish; // Wichtig, um Gerichte-Details zu holen
use App\Models\PortalCategory; // Wichtig, um Kategorie-Details zu holen

class UpdateTrendingDataJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Führt den Job aus: Analysiert die Interaktionen von GESTERN
     * und speichert die Ergebnisse im Cache.
     */
    public function handle(): void
    {
        // 1. Definiere den Zeitraum (gestern, 00:00:00 bis 23:59:59)
        $yesterdayStart = Carbon::yesterday()->startOfDay();
        $yesterdayEnd = Carbon::yesterday()->endOfDay();

        // --- 2. Analyse: Top-Gericht des Tages (Global) ---
        
        // Finde die dish_id mit den meisten 'like'-Interaktionen von gestern
        $topDishStats = DB::table('dish_interactions')
            ->select('dish_id', DB::raw('COUNT(id) as total_likes'))
            ->where('interaction_type', 'like')
            ->whereBetween('created_at', [$yesterdayStart, $yesterdayEnd])
            ->groupBy('dish_id')
            ->orderByDesc('total_likes')
            ->first(); // Nimm das oberste Ergebnis

        if ($topDishStats) {
            // Lade das Dish-Modell, um alle Details zu haben
            $topDish = Dish::with('restaurant')->find($topDishStats->dish_id);
            if ($topDish) {
                // Speichere das Top-Gericht für immer im Cache (oder bis es überschrieben wird)
                Cache::forever('trending.top_dish_of_the_day', $topDish);
            }
        }

        // --- 3. Analyse: Trending Kategorien (Global) ---

        // Finde die Kategorien der Gerichte, die gestern gelikt wurden.
        // Wir brauchen eine komplexere Abfrage, um die Gerichte mit ihren Kategorien zu verbinden.
        $trendingCategoryStats = DB::table('dish_interactions')
            ->join('category_dish', 'dish_interactions.dish_id', '=', 'category_dish.dish_id')
            ->select('category_dish.category_id', DB::raw('COUNT(dish_interactions.id) as total_likes'))
            ->where('dish_interactions.interaction_type', 'like')
            ->whereBetween('dish_interactions.created_at', [$yesterdayStart, $yesterdayEnd])
            ->groupBy('category_dish.category_id')
            ->orderByDesc('total_likes')
            ->limit(5) // Nimm die Top 5 Kategorien
            ->pluck('category_id'); // Hol nur die IDs

        if ($trendingCategoryStats->isNotEmpty()) {
            // Lade die PortalCategory-Modelle für die "Beliebte Kategorien" auf der Homepage
            // (Wir nehmen an, dass die IDs von 'categories' und 'portal_categories' nicht übereinstimmen)
            // DIESER TEIL MUSS ANGEPASST WERDEN, WIE SIE KATEGORIEN VERKNÜPFEN
            
            // --- Einfache Annahme: Wir zeigen einfach die "PortalCategories" ---
            // (In "Idee 5" war der Plan, PortalCategories mit Restaurant-Kategorien zu mappen)
            
            // Fürs Erste holen wir die Top 5 Portal-Kategorien (z.B. nach Namen)
            // HINWEIS: Dies ist ein PLATZHALTER, da die Verknüpfung fehlt.
            $trendingCategories = PortalCategory::inRandomOrder()->limit(5)->get();
            
            // Speichere die trending Kategorien im Cache
            Cache::forever('trending.categories', $trendingCategories);
        }
    }
}