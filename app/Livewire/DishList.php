<?php

namespace App\Livewire;

use App\Models\Category;
use App\Models\Dish;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\Url; // VERBESSERUNG: Notwendig für die URL-Synchronisierung
use Livewire\Component;

class DishList extends Component
{
    // VERBESSERUNG 1: Filtert die Liste nach Typ ('food' oder 'drink').
    // #[Url] sorgt dafür, dass die Eigenschaft automatisch mit der URL synchronisiert wird.
    // Beispiel: your-page.com/dishes?type=drink
    #[Url(as: 'type', keep: true)]
    public string $type = 'food';

    public function render()
    {
        $restaurant = Auth::user()->restaurant;

        if (!$restaurant) {
            return view('livewire.dish-list', [
                'categories' => collect(),
                'restaurant' => null, // VERBESSERUNG: Restaurant an die Ansicht übergeben
            ]);
        }

        $categories = $restaurant->categories()
            ->where('type', $this->type) // VERBESSERUNG: Filtert Kategorien nach dem Typ.
            // KORREKTUR: Lade die Übersetzungen für die Kategorie UND für die Gerichte.
            ->with(['translations', 'dishes.translations'])
            ->get();

        return view('livewire.dish-list', [
            'categories' => $categories,
            'restaurant' => $restaurant, // VERBESSERUNG: Restaurant an die Ansicht übergeben
        ]);
    }

    public function toggleAvailability(Dish $dish)
    {
        // VERBESSERUNG 2: Sicherheits-Check!
        // Stellt sicher, dass nur Gerichte des eigenen Restaurants geändert werden können.
        if ($dish->category->restaurant_id !== Auth::user()->restaurant?->id) {
            abort(403, 'Zugriff verweigert.');
        }

        $dish->is_available = !$dish->is_available;
        $dish->save();
    }
}