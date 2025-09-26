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
        
        // This is the corrected query.
        // It finds all dishes where the dish's category belongs to the current restaurant.
        $dishes = $restaurant 
            ? Dish::whereHas('category', function ($query) use ($restaurant) {
                $query->where('restaurant_id', $restaurant->id);
            })->with('translations')->latest()->get()
            : collect();

        return view('livewire.quick-actions', [
            'dishes' => $dishes,
        ]);
    }

    // This method is called when a toggle is clicked
    public function toggleAvailability(Dish $dish)
    {
        // Add a security check to ensure the user can only modify their own dishes
        if ($dish->category->restaurant_id == Auth::user()->restaurant->id) {
            $dish->is_available = !$dish->is_available;
            $dish->save();
        }
    }
}