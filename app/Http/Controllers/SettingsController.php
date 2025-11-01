<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;
use Illuminate\Support\Str;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;

class SettingsController extends Controller
{
    /**
     * Zeigt die Einstellungsseite an.
     * Die Logik zum Laden von Portal-Kategorien und Hashtags wurde entfernt,
     * da die Livewire-Komponente diese Aufgabe übernimmt und der Fehler hier seinen Ursprung hatte.
     */
    public function index(): View
    {
        $restaurant = Auth::user()->restaurant;
        if (!$restaurant) {
            abort(404, 'Restaurantprofil nicht gefunden.');
        }

        // Die Daten werden jetzt sauber getrennt:
        // - Die Basis-Daten ('restaurant') werden hier an die View übergeben.
        // - Die Portal-Daten werden von der Livewire-Komponente selbst geladen.
        return view('settings.index', compact('restaurant'));
    }

    /**
     * Aktualisiert die Basis-Einstellungen des Restaurants.
     * Diese Methode ist unverändert und bleibt für die alten Formularfelder verantwortlich.
     */
    public function update(Request $request): RedirectResponse
    {
        $restaurant = Auth::user()->restaurant;

        // Validierung der Basis-Daten
        $validatedData = $request->validate([
            'name' => ['required', 'string', 'max:255', 'min:3'],
            'currency' => ['required', 'string', 'size:3'],
            'subdomain' => [
                'required', 'string', 'alpha_dash', 'max:50',
                Rule::unique('restaurants')->ignore($restaurant->id),
            ],
            'logo' => ['nullable', 'image', 'mimes:jpeg,png,webp,jpg', 'max:2048'],
            'seo_title' => ['nullable', 'string', 'max:255'],
            'meta_description' => ['nullable', 'string', 'max:1000'],
            'og_image_url' => ['nullable', 'url', 'max:255'],
            'social_links' => ['nullable', 'array'],
            'social_links.*' => ['nullable', 'url'],
            'accent_color' => ['nullable', 'regex:/^#[0-9a-fA-F]{6}$/'],
            'contact_email' => ['nullable', 'email', 'max:255'],
            'contact_phone' => ['nullable', 'string', 'max:50'],
            // ENTFERNT: Die Validierung für 'address' wird entfernt, da sie von Livewire verwaltet wird.
            // 'address' => ['nullable', 'string', 'max:1000'],
        ]);

        // Subdomain Normalisierung
        $validatedData['subdomain'] = Str::lower($validatedData['subdomain']);

        // Logo-Upload Verarbeitung
        if ($request->hasFile('logo')) {
            if ($restaurant->logo_url && Storage::disk('public')->exists($restaurant->logo_url)) {
                Storage::disk('public')->delete($restaurant->logo_url);
            }
            $path = $request->file('logo')->store('logos', 'public');
            $validatedData['logo_url'] = $path;
            unset($validatedData['logo']);
        }

        // Social Links säubern
        if (isset($validatedData['social_links'])) {
            $validatedData['social_links'] = array_filter($validatedData['social_links']);
        }

        // Daten speichern
        $restaurant->update($validatedData);

        return redirect()->route('settings.index')->with('success', 'Einstellungen erfolgreich aktualisiert.');
    }

    /**
     * Leitet zum Stripe Billing Portal weiter.
     */
    public function billingPortal(Request $request): RedirectResponse
    {
        return $request->user()->redirectToBillingPortal(route('settings.index'));
    }
}