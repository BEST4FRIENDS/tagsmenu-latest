<?php

namespace App\Livewire;

use App\Models\Dish;
use App\Models\Restaurant;
use Livewire\Component;

class StaffInterface extends Component
{
    public Restaurant $restaurant;
    public string $token;

    /**
     * Wird beim Initialisieren der Komponente aufgerufen. Authentifiziert via Token.
     */
    public function mount(string $token)
    {
        $this->token = $token;

        // Validiert den Token und lädt das Restaurant.
        $this->restaurant = Restaurant::where('staff_access_token', $token)
                                      ->where('status', 'active')
                                      ->firstOrFail(); // 404 wenn ungültig
    }

    /**
     * Schaltet die Verfügbarkeit eines Gerichts um.
     */
    public function toggleAvailability(Dish $dish)
    {
        // WICHTIGE Sicherheitsprüfung: Stellt sicher, dass das Gericht zum authentifizierten Restaurant gehört.
        // Wir prüfen dies anhand der restaurant_id der zugehörigen Kategorie.

        // Stellt sicher, dass die 'category' Relation geladen ist (sollte durch Eager Loading im render() passieren, aber zur Sicherheit prüfen wir).
        if (!$dish->relationLoaded('category')) {
            $dish->load('category:id,restaurant_id');
        }

        if ($dish->category->restaurant_id !== $this->restaurant->id) {
            Log::warning("Unautorisierter Umschaltversuch bei Gericht {$dish->id} durch Restaurant {$this->restaurant->id}");
            // Zugriff verweigert. Keine Aktion durchführen.
            return;
        }

        $dish->is_available = !$dish->is_available;
        $dish->save();

        // Livewire aktualisiert die Ansicht automatisch.
    }

    public function render()
    {
        // Lädt die Daten für die Ansicht.
        $categories = $this->restaurant->categories()
            ->with([
                'translations:id,category_id,locale,name',
                'dishes' => function ($query) {
                    $query->select('id', 'category_id', 'is_available')
                          // Wichtig: Lädt 'category' mit für die Sicherheitsprüfung in toggleAvailability
                          ->with(['translations:id,dish_id,locale,name', 'category:id,restaurant_id']);
                          // Wenn Gerichte sortierbar sind, fügen Sie hier ->orderBy('position', 'asc') hinzu
                }
            ])
            // WICHTIG: Basierend auf Ihrer CategoryList.php verwenden wir 'position' zur Sortierung.
            ->orderBy('position', 'asc')
            ->get();

        // WICHTIG: Wir verwenden ein eigenes Layout 'layouts.staff'
        return view('livewire.staff-interface', [
            'categories' => $categories,
        ])->layout('layouts.staff');
    }
}