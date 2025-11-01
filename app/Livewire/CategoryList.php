<?php

namespace App\Livewire;

use App\Models\Category;
use Illuminate\Support\Facades\Auth; // Import hinzugefügt
use Livewire\Component;

class CategoryList extends Component
{
    /**
     * Wird vom Plugin für die Speisen-Liste aufgerufen.
     */
    public function updateFoodCategoryOrder($list)
    {
        $this->updateOrder($list);
    }

    /**
     * Wird vom Plugin für die Getränke-Liste aufgerufen.
     */
    public function updateDrinkCategoryOrder($list)
    {
        $this->updateOrder($list);
    }

    /**
     * Hilfsmethode zum Aktualisieren der Positionen in der Datenbank.
     */
    private function updateOrder($list)
    {
        // Sicherheitsprüfung
        $restaurantId = Auth::user()->restaurant?->id;
        if (!$restaurantId) {
            return;
        }

        foreach ($list as $item) {
            // Das Plugin sendet die korrekte Reihenfolge (beginnt bei 1).
            // $item['value'] ist die ID, $item['order'] die neue Position.
            Category::where('id', $item['value'])
                    ->where('restaurant_id', $restaurantId) // Sicherheit: Auf das aktuelle Restaurant beschränken
                    ->update(['position' => $item['order']]);
        }
    }

    public function render()
    {
        $restaurantId = Auth::user()->restaurant?->id;

        if (!$restaurantId) {
            // Fall behandeln, wenn der Benutzer noch kein Restaurant hat
            return view('livewire.category-list', [
                'foodCategories' => collect(),
                'drinkCategories' => collect(),
            ]);
        }

        $categories = Category::where('restaurant_id', $restaurantId)
                                ->with('translations')
                                ->orderBy('position') // Sortiert nach der neuen Position-Spalte
                                ->get();

        return view('livewire.category-list', [
            'foodCategories' => $categories->where('type', 'food'),
            'drinkCategories' => $categories->where('type', 'drink'),
        ]);
    }
}