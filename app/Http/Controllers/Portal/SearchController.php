<?php

namespace App\Http\Controllers\Portal;

use App\Http\Controllers\Controller;
use App\Models\Restaurant;
use Illuminate\Http\Request;
use Illuminate\View\View;

class SearchController extends Controller
{
    /**
     * Führt eine Suche nach Restaurants durch und zeigt die Ergebnisse an.
     *
     * @param Request $request Das Request-Objekt, das den Suchbegriff enthält.
     * @return View
     */
    public function search(Request $request): View
    {
        // Validiere die Eingabe. 'q' ist der übliche Name für einen Suchparameter.
        $request->validate([
            'q' => 'nullable|string|max:100',
        ]);

        $query = $request->input('q');
        $restaurants = collect(); // Standardmäßig ein leeres Ergebnis

        if ($query) {
            // Führe die Suche nur durch, wenn ein Suchbegriff vorhanden ist.
            // Die Suche erfolgt nur bei aktiven und öffentlichen Restaurants.
            $restaurants = Restaurant::where('is_publicly_listed', true)
                ->where('status', 'active')
                ->where(function ($dbQuery) use ($query) {
                    // Suche in mehreren relevanten Feldern
                    $dbQuery->where('name', 'LIKE', "%{$query}%")
                            ->orWhere('description', 'LIKE', "%{$query}%")
                            ->orWhere('city', 'LIKE', "%{$query}%");
                })
                ->paginate(12); // Paginierung ist bei Suchergebnissen wichtig!
        }

        // Übergib die Ergebnisse und den ursprünglichen Suchbegriff an die View.
        // Sie müssen die View 'resources/views/portal/search.blade.php' erstellen.
        return view('portal.search', [
            'restaurants' => $restaurants,
            'query'       => $query, // Um z.B. "Ergebnisse für 'Pizza'" anzuzeigen
        ]);
    }
}