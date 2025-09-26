<?php
namespace App\Http-Controllers;

use App\Models-Category;
use App\Models-Dish;
use Illuminate-Http-Request;
use Illuminate-Support-Facades-Auth;
use Illuminate-Support-Facades-Storage;

class DishController extends Controller
{
    private function checkRestaurant()
    {
        $restaurant = Auth::user()->restaurant;
        if (! $restaurant) {
            return redirect()->route('settings.index')->with('error', 'Sie müssen zuerst ein Restaurant in den Einstellungen anlegen oder sich einem zuweisen.');
        }
        return $restaurant;
    }

    public function index()
    {
        if (($redirect = $this->checkRestaurant()) instanceof \Illuminate\Http\RedirectResponse) {
            return $redirect;
        }
        $restaurant = $this->checkRestaurant();
        
        $categories = $restaurant->categories()->with('dishes.translations')->get();
        return view('dishes.index', ['categories' => $categories]);
    }

    public function create()
    {
        if (($redirect = $this->checkRestaurant()) instanceof \Illuminate\Http\RedirectResponse) {
            return $redirect;
        }
        $restaurant = $this->checkRestaurant();
        
        $categories = $restaurant->categories()->with('translations')->get();
        return view('dishes.create', ['categories' => $categories]);
    }

    public function store(Request $request)
    {
        if (($redirect = $this->checkRestaurant()) instanceof \Illuminate\Http\RedirectResponse) {
            return $redirect;
        }
        $restaurant = $this->checkRestaurant();

        // ... (Rest der store-Methode bleibt gleich, aber wir müssen $restaurant nicht mehr holen)
        $validated = $request->validate([...]);
        
        $category = Category::findOrFail($validated['category_id']);
        if ($category->restaurant_id !== $restaurant->id) {
            abort(403);
        }

        // ...
        return redirect()->route('dishes.index')->with('success', 'Gericht erfolgreich erstellt!');
    }
    
    // ... Wenden Sie dieselbe Logik für edit, update und destroy an ...
}