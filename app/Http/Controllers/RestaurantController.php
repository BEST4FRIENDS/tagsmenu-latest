<?php

namespace App\Http\Controllers;

use App\Models-Restaurant;
use Illuminate-Http-Request;
use Illuminate-Http-RedirectResponse;
use Illuminate-View-View;

class RestaurantController extends Controller
{
    /**
     * Show the form for creating a new restaurant.
     */
    public function create(): View|RedirectResponse
    {
        // Zeigt das Formular nur an, wenn der Benutzer noch kein Restaurant hat.
        if (auth()->user()->restaurant) {
            return redirect()->route('dashboard');
        }
        return view('restaurant.create');
    }

    /**
     * Store a newly created restaurant in storage.
     */
    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'subdomain' => 'required|string|lowercase|alpha_dash|max:50|unique:restaurants,subdomain',
        ]);

        $request->user()->restaurant()->create([
            'name' => $validated['name'],
            'subdomain' => $validated['subdomain'],
            'status' => 'active', // Standardmäßig auf aktiv setzen
        ]);

        // KORREKTUR: Die Erfolgsmeldung wird jetzt an die Session "geflasht".
        return redirect()->route('plans.index')
                         ->with('success', "Ihr Restaurant '{$validated['name']}' wurde erfolgreich erstellt! Wählen Sie jetzt den passenden Plan, um loszulegen.");
    }
}