<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\RedirectResponse;

class SettingsController extends Controller
{
    /**
     * Show the application settings page.
     */
    public function index()
    {
        // Get the currently logged-in user's restaurant
        $restaurant = Auth::user()->restaurant;

        // Pass the restaurant data to the view
        return view('settings.index', ['restaurant' => $restaurant]);
    }

    /**
     * Update the application settings.
     */
    public function update(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'logo_url' => 'nullable|url|max:255',
        ]);

        $restaurant = Auth::user()->restaurant;
        $restaurant->update($validated);

        return redirect()->route('settings.index')->with('success', 'Einstellungen erfolgreich gespeichert!');
    }
}