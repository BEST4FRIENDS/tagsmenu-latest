<?php

namespace App\Observers;

use App\Models\Restaurant;
// WICHTIG: Imports für Service und String-Helper
use App\Services\GeocodingService;
use Illuminate\Support\Str;

class RestaurantObserver
{
    protected $geocodingService;

    /**
     * Dependency Injection für den GeocodingService.
     */
    public function __construct(GeocodingService $geocodingService)
    {
        $this->geocodingService = $geocodingService;
    }

    /**
     * Handle the Restaurant "saving" event.
     * Wird ausgelöst, BEVOR das Model gespeichert wird (bei create und update).
     */
    public function saving(Restaurant $restaurant)
    {
        // 1. SEO Slug generieren
        if (empty($restaurant->seo_slug) || $restaurant->isDirty('name')) {
            $this->generateUniqueSlug($restaurant);
        }

        // 2. Geocoding durchführen (Wenn sich die 'address' geändert hat)
        if ($restaurant->isDirty('address')) {
             $this->updateCoordinates($restaurant);
        }
    }

    /**
     * Generiert einen einzigartigen SEO-Slug basierend auf dem Namen.
     */
    protected function generateUniqueSlug(Restaurant $restaurant)
    {
        $slug = Str::slug($restaurant->name);
        $originalSlug = $slug;
        $count = 1;

        // Sicherstellen, dass der Slug einzigartig ist
        while (Restaurant::where('seo_slug', $slug)->where('id', '!=', $restaurant->id)->exists()) {
            $slug = $originalSlug . '-' . $count++;
        }
        $restaurant->seo_slug = $slug;
    }

    /**
     * Aktualisiert die Koordinaten mithilfe des GeocodingService.
     */
    protected function updateCoordinates(Restaurant $restaurant)
    {
        // Wir greifen direkt auf das 'address' Feld zu.
        $address = $restaurant->address ?? ''; 
        
        $coords = $this->geocodingService->getCoordinatesForAddress($address);

        if ($coords) {
            $restaurant->latitude = $coords['lat'];
            $restaurant->longitude = $coords['lng'];
        } else {
            $restaurant->latitude = null;
            $restaurant->longitude = null;
        }
    }
    
    // Die Standard-Methoden (created, updated, deleted etc.) werden nicht benötigt und können entfernt werden.
}