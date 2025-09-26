<?php

namespace App\Http\Controllers\Superadmin;

use App\Http\Controllers\Controller;
use App\Models\Restaurant;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse; // Wichtig für die korrekten Rückgabetypen

class ClientController extends Controller
{
    /**
     * Display a list of all clients (restaurants).
     */
    public function index(): View
    {
        $restaurants = Restaurant::with('user.subscriptions')->latest()->get();

        return view('superadmin.clients.index', [
            'restaurants' => $restaurants,
        ]);
    }

    /**
     * Show the form for editing the specified client.
     */
    public function edit(Restaurant $restaurant): View
    {
        return view('superadmin.clients.edit', ['restaurant' => $restaurant]);
    }

    /**
     * Update the specified client in storage.
     */
    public function update(Request $request, Restaurant $restaurant): RedirectResponse
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'subdomain' => 'required|string|lowercase|alpha_dash|max:50|unique:restaurants,subdomain,'.$restaurant->id,
        ]);

        $restaurant->update($validated);

        return redirect()->route('superadmin.clients.index')->with('success', 'Kundendaten erfolgreich aktualisiert.');
    }

    /**
     * Toggle the status of the specified client.
     */
    public function toggleStatus(Restaurant $restaurant): RedirectResponse
    {
        $restaurant->status = $restaurant->status === 'active' ? 'suspended' : 'active';
        $restaurant->save();

        return redirect()->route('superadmin.clients.index')->with('success', 'Status erfolgreich geändert.');
    }

    /**
     * Remove the specified client from storage.
     * This is the method for the "Löschen" button.
     */
    public function destroy(Restaurant $restaurant): RedirectResponse
    {
        // Hole den zugehörigen Benutzer, bevor wir das Restaurant löschen
        $user = $restaurant->user;

        // --- WICHTIGE SCHRITTE FÜR EINE SAUBERE LÖSCHUNG ---

        // 1. (Optional aber empfohlen) Das Stripe-Abonnement kündigen
        // Dies verhindert, dass Stripe weiterhin Rechnungen an einen gelöschten Kunden schickt.
        if ($user && $user->subscribed('default')) {
            // 'cancelNow()' kündigt das Abo sofort und macht es inaktiv.
            $user->subscription('default')->cancelNow();
        }

        // 2. Das Restaurant löschen
        // Da wir in den Models eine Kaskadierung eingerichtet haben (sollten),
        // werden alle zugehörigen Gerichte, Kategorien etc. mitgelöscht.
        $restaurant->delete();

        // 3. Den Benutzer löschen
        // Nachdem das Restaurant weg ist, können wir auch den Benutzer-Account entfernen.
        if ($user) {
            $user->delete();
        }

        return redirect()->route('superadmin.clients.index')->with('success', 'Der Kunde wurde endgültig gelöscht.');
    }
}