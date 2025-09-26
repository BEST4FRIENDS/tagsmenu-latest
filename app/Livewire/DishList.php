<?php

namespace App\Livewire;

use App\Models\Category;
use App\Models\Dish;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class DishList extends Component
{
    // This re-fetches the data when the component is updated
    public function render()
    {
        $restaurant = Auth::user()->restaurant;
        $categories = $restaurant ? $restaurant->categories()->with('dishes.translations')->get() : collect();

        return view('livewire.dish-list', [
            'categories' => $categories,
        ]);
    }

    // This method is called when the toggle is clicked
    public function toggleAvailability(Dish $dish)
    {
        // Flips the boolean value and saves it to the database
        $dish->is_available = !$dish->is_available;
        $dish->save();
    }
}