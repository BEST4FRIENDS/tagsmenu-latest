<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Restaurant;
use App\Models\Dish;
use Illuminate\View\View;
use Illuminate\Http\JsonResponse;

class StaffInterfaceController extends Controller
{
    /**
     * Zeigt die Mitarbeiter-Oberfläche an. Authentifizierung via Token.
     */
    public function index(string $token): View
    {
        // Findet das Restaurant anhand des Tokens.
        $restaurant = Restaurant::where('staff_access_token', $token)
                                ->where('status', 'active')
                                ->firstOrFail(); // Bricht ab (404), wenn nicht gefunden oder inaktiv.

        // Lädt die Daten nach Kategorie sortiert.
        $categories = $restaurant->categories()
                                ->with([
                                    // KORREKTUR: Lädt die Übersetzungen der Kategorie direkt mit (Eager Loading).
                                    // Wir geben die Spalten an, um die Abfrage schlank zu halten.
                                    'translations:id,category_id,locale,name', 

                                    'dishes' => function ($query) {
                                        // Lädt nur die notwendigen Felder und Übersetzungen der Gerichte
                                        $query->select('id', 'category_id', 'is_available')
                                              ->with('translations:id,dish_id,locale,name');
                                    }
                                ])
                                // Annahme: Sie haben Option 2 (Migration) gewählt, daher 'order'
                                ->orderBy('order', 'asc')
                                ->get();

        // Annahme: Mitarbeiter verwenden die Standardsprache (z.B. Deutsch)
        $locale = 'de';

        return view('staff.index', compact('restaurant', 'categories', 'token', 'locale'));
    }

    /**
     * Schaltet die Verfügbarkeit eines Gerichts um (AJAX-Aufruf).
     */
    public function toggleAvailability(Request $request, string $token): JsonResponse
    {
        $request->validate(['dish_id' => 'required|integer']);
        $restaurant = Restaurant::where('staff_access_token', $token)->firstOrFail();

        // WICHTIGE Sicherheitsprüfung: Stellt sicher, dass das Gericht zum Restaurant gehört.
        $dish = Dish::where('id', $request->input('dish_id'))
                    ->whereHas('category', function ($query) use ($restaurant) {
                        $query->where('restaurant_id', $restaurant->id);
                    })
                    ->first();

        if (!$dish) {
            return response()->json(['success' => false, 'message' => 'Gericht nicht gefunden oder Zugriff verweigert.'], 404);
        }

        // Status umschalten
        $dish->is_available = !$dish->is_available;
        $dish->save();

        return response()->json([
            'success' => true,
            'is_available' => $dish->is_available,
        ]);
    }
}