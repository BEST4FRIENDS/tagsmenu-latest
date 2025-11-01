<?php

namespace App\Http\Controllers;

use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Session;

class LanguageController extends Controller
{
    /**
     * Wechselt die Sprache der Anwendung für den aktuellen Benutzer.
     */
    public function switch(string $locale): RedirectResponse
    {
        // VERBESSERUNG: Überprüft, ob die Sprache im 'available_locales' Array in config/app.php existiert.
        if (array_key_exists($locale, config('app.available_locales'))) {
            // Speichert die gewählte Sprache in der Session
            Session::put('locale', $locale);
        }

        // Leitet den Benutzer zurück zur vorherigen Seite
        return redirect()->back();
    }
}