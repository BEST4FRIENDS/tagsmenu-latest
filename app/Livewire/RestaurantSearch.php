<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Restaurant;
use Illuminate\Support\Collection;
use Illuminate\Support\Str;
use App\Services\GeocodingService; // <-- NEU: Geocoding Service importieren

class RestaurantSearch extends Component
{
    public string $searchQuery = '';
    public string $locationQuery = ''; // <-- NEU: Für das "Wo?"-Feld
    public Collection $results;
    public ?array $coordinates = null; // <-- NEU: Speichert lat/lng

    // Service per Dependency Injection holen
    protected GeocodingService $geocoder;

    public function boot(GeocodingService $geocoder)
    {
        $this->geocoder = $geocoder;
    }

    public function mount()
    {
        $this->results = new Collection();
    }

    // Diese Methode wird aufgerufen, wenn sich searchQuery ODER locationQuery ändern
    public function updated($propertyName)
    {
        // Nur updaten, wenn sich einer der Suchbegriffe geändert hat
        if (!in_array($propertyName, ['searchQuery', 'locationQuery'])) {
            return;
        }

        // --- NEU: Geocoding auslösen, wenn sich der Ort ändert ---
        if ($propertyName === 'locationQuery' && strlen($this->locationQuery) > 2) {
            $this->coordinates = $this->geocoder->getCoordinatesForAddress($this->locationQuery);
        } elseif (strlen($this->locationQuery) <= 2) {
            $this->coordinates = null; // Koordinaten zurücksetzen, wenn Ort leer ist
        }
        // --- Ende Geocoding ---

        // Suchlogik nur starten, wenn mindestens ein Feld lang genug ist
        if (strlen($this->searchQuery) < 2 && strlen($this->locationQuery) < 2) {
            $this->results = new Collection();
            return;
        }

        $this->runSearch();
    }

    // The actual search (combines text, hashtags, and location)
    protected function runSearch()
    {
        // Separate text and hashtags (as before)
        preg_match_all('/#(\w+)/u', $this->searchQuery, $matches);
        $hashtags = $matches[1];
        $textSearch = trim(preg_replace('/#(\w+)/u', '', $this->searchQuery));

        // Start Meilisearch query
        $query = Restaurant::search($textSearch);

        // Apply hashtag filters (as before)
        foreach ($hashtags as $hashtag) {
            $query->where('hashtags', $hashtag);
        }

        // --- Apply Geo-Filter if coordinates exist ---
        if ($this->coordinates) {
            $lat = $this->coordinates['lat'];
            $lng = $this->coordinates['lng'];
            $radiusInMeters = 10000; // 10 km

            // === CORRECTION 2: Use options() for Meilisearch filters ===
            $query->options([
                'filter' => "_geoRadius($lat, $lng, $radiusInMeters)"
            ]);
            // === END CORRECTION 2 ===

            // Optional: Sort by distance (You might need to add '_geo' to sortable attributes in Meilisearch config)
            // $query->orderBy('_geoPoint(' . $lat . ', ' . $lng . '):asc');
        }
        // --- End Geo-Filter ---

        // Get results (as before)
        $this->results = $query->take(5)->get();
    }


    public function performSearch()
    {
        // --- NEU: Übergibt beide Suchbegriffe an die Suchergebnisseite ---
        return redirect()->route('search.index', [
            'query' => $this->searchQuery,
            'location' => $this->locationQuery // Neuer Parameter für den Ort
        ]);
    }

    public function render()
    {
        return view('livewire.restaurant-search');
    }
}