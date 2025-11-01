<?php

namespace App\Http\Controllers;

use App\Models\Restaurant;
use Illuminate\View\View;

class PublicMenuController extends Controller
{
    public function show(string $subdomain): View
    {
        // 1. Lade das Restaurant effizient und sortiert.
        $restaurant = Restaurant::where('subdomain', $subdomain)
            ->with([
                'categories' => function ($query) {
                    // WICHTIG: Sortierung nach 'position'
                    $query->orderBy('position')->with('translations');
                },
                'categories.dishes' => function ($query) {
                    // Nur verfügbare Gerichte laden
                    $query->where('is_available', true)->with('translations');
                }
            ])
            ->firstOrFail();

        // 2. Sicherheits-Check
        if ($restaurant->status === 'inactive') {
            return view('public.inactive', ['restaurantName' => $restaurant->name]);
        }

        // 3. Filtere leere Kategorien heraus
        $categoriesWithDishes = $restaurant->categories->filter(function ($category) {
            return $category->dishes->isNotEmpty();
        });

        // 4. Gruppiere nach Typ.
        $groupedCategories = $categoriesWithDishes->groupBy('type');
        $foodCategories = $groupedCategories->get('food', collect());
        $drinkCategories = $groupedCategories->get('drink', collect());

        // 5. Bestimme Sprachen.
        $availableLangs = $categoriesWithDishes->flatMap(fn($category) => $category->dishes)
                                               ->flatMap(fn($dish) => $dish->translations)
                                               ->pluck('locale')
                                               ->unique()
                                               ->sort()
                                               ->values();

        // 6. Übergib an die Ansicht.
        return view('public.menu', [
            'restaurant'      => $restaurant,
            'foodCategories'  => $foodCategories,
            'drinkCategories' => $drinkCategories,
            'availableLangs'  => $availableLangs,
        ]);
    }
}