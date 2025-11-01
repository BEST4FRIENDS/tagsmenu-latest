<?php

namespace App\Http\Controllers;

// KORRIGIERT: Backslashes anstatt Bindestriche
use App\Models\Restaurant;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class RestaurantController extends Controller
{
    /**
     * Show the form for creating a new restaurant.
     */
    public function create(): View|RedirectResponse
    {
        // Redirects to dashboard if a restaurant already exists
        if (Auth::user()->restaurant) {
            return redirect()->route('dashboard')->with('info', 'Du hast bereits ein Restaurant erstellt.');
        }

        return view('restaurant.create');
    }

    /**
     * Store a newly created restaurant in storage.
     */
    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255|unique:restaurants,name',
            // Add other restaurant fields here if you have them, e.g., 'address', 'phone', etc.
        ]);

        // Automatically generate a subdomain from the restaurant name
        $validated['subdomain'] = Str::slug($validated['name']);
        
        // Add the user_id to the validated data
        $validated['user_id'] = Auth::id();

        // Create the restaurant
        $restaurant = Restaurant::create($validated);

        return redirect()->route('dashboard')->with('success', 'Dein Restaurant wurde erfolgreich erstellt!');
    }
}