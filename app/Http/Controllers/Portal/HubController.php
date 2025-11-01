<?php

namespace App\Http\Controllers\Portal;

use App\Http\Controllers\Controller;
use App\Models\Restaurant;
use Illuminate\Http\Request;
use Illuminate\View\View;

class HubController extends Controller
{
    /**
     * Zeigt die öffentliche Profilseite (Hub) für ein einzelnes Restaurant.
     * Nutzt Laravels Route Model Binding, um das Restaurant anhand des 'seo_slug' zu finden.
     *
     * @param Restaurant $restaurant Das automatisch geladene Restaurant-Model.
     * @return View
     */
    public function show(Restaurant $restaurant): View
    {
        // Sicherheits-Check: Auch wenn das Restaurant gefunden wurde,
        // stelle sicher, dass es öffentlich zugänglich und aktiv sein soll.
        // abort_if() zeigt automatisch eine 404-Seite, wenn die Bedingung nicht erfüllt ist.
        abort_if(
            !$restaurant->is_publicly_listed || $restaurant->status !== 'active',
            404,
            'Dieses Restaurant ist derzeit nicht verfügbar.'
        );

        // Hier könnten Sie bei Bedarf weitere Daten laden, z.B. eine Vorschau
        // auf einige Top-Gerichte. Für den Anfang reicht das Restaurant-Objekt.
        // $restaurant->load('categories.dishes');

        // Übergib das gefundene Restaurant an die Blade-View.
        // Sie müssen die View 'resources/views/portal/hub.blade.php' erstellen.
        return view('portal.hub', [
            'restaurant' => $restaurant,
        ]);
    }
}