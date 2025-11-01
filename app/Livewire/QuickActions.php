<?php

namespace App\Livewire;

use App\Models\Dish;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class QuickActions extends Component
{
    public function render()
    {
        $restaurant = Auth::user()->restaurant;
        
        // VERBESSERUNG: Lade 'category' explizit mit, um die Sicherheitsprüfung robuster zu machen.
        $dishes = $restaurant 
            ? Dish::whereHas('category', function ($query) use ($restaurant) {
                $query->where('restaurant_id', $restaurant->id);
            })->with('category', 'translations')->latest()->get()
            : collect();

        return view('livewire.quick-actions', [
            'dishes' => $dishes,
        ]);
    }

    public function toggleAvailability(Dish $dish)
    {
        // KORREKTUR: Robustere Sicherheitsprüfung
        $userRestaurantId = Auth::user()->restaurant?->id;

        // Prüfen, ob der Benutzer ein Restaurant hat UND das Gericht (über die geladene Kategorie) zu diesem Restaurant gehört
        if ($userRestaurantId && $dish->category && $dish->category->restaurant_id == $userRestaurantId) {
            $dish->is_available = !$dish->is_available;
            $dish->save();
        }
        // Optional: Hier könnte ein Fehler-Event ausgelöst werden, wenn die Berechtigung fehlt.
    }
}