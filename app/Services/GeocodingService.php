<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class GeocodingService
{
    /**
     * Versucht, Koordinaten (Latitude/Longitude) für eine gegebene Adresse zu finden.
     *
     * @param string|null $address Die vollständige Adresse.
     * @return array|null Array mit ['lat' => ..., 'lng' => ...] oder null bei Fehler.
     */
    public function getCoordinatesForAddress(?string $address): ?array
    {
        if (empty($address)) {
            return null;
        }

        // --- HIER KOMMT IHRE ZUKÜNFTIGE API-LOGIK HIN ---

        /*
         * BEISPIEL (Annahme: Sie nutzen eine API wie OpenCage):
         *
         * $apiKey = config('services.opencage.key'); // Key muss in config/services.php definiert werden
         * try {
         *     $response = Http::get("https://api.opencagedata.com/geocode/v1/json", [
         *         'q' => $address,
         *         'key' => $apiKey,
         *         'limit' => 1
         *     ]);
         *
         *     if ($response->successful() && !empty($response->json('results'))) {
         *         $geometry = $response->json('results.0.geometry');
         *         return [
         *             'lat' => $geometry['lat'],
         *             'lng' => $geometry['lng'],
         *         ];
         *     }
         * } catch (\Exception $e) {
         *     Log::error("Geocoding exception: " . $e->getMessage());
         * }
         */

        // --- PLATZHALTER FÜR DIE ENTWICKLUNG ---
        // Solange keine API integriert ist, geben wir feste Koordinaten zurück,
        // um den Observer testen zu können (z.B. Zentrum von Budapest).
        if (config('app.env') === 'local') {
            Log::warning("GeocodingService: Using placeholder coordinates for address: " . $address);
            return [
                'lat' => 47.497913,
                'lng' => 19.040235,
            ];
        }
        
        return null;
    }
}