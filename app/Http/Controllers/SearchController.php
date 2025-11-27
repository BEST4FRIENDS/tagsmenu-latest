<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\View\View;
use App\Models\Restaurant;
use App\Models\PortalCategory;
use Illuminate\Support\Facades\Log;
use Meilisearch\Exceptions\ApiException;

class SearchController extends Controller
{
    public function index(Request $request): View
    {
        $searchQuery = $request->input('query', '');
        $selectedCategories = $request->input('categories', []);

        // Extrahiert Hashtags (#tag) aus der Suchanfrage
        preg_match_all('/#(\w+)/u', $searchQuery, $matches);
        $hashtags = $matches[1]; // $matches[1] enthält nur den Text ohne '#'
        
        // Entfernt die Hashtags, um nur den reinen Suchtext zu erhalten
        $textSearch = trim(preg_replace('/#(\w+)/u', '', $searchQuery));

        // Wrap entire Meilisearch operation in try-catch to handle connection/index errors
        try {
            // Startet die Scout/Meilisearch-Abfrage
            $query = Restaurant::search($textSearch);

            // Filtert nach den ausgewählten Kategorien
            if (!empty($selectedCategories)) {
                try {
                    // KORREKTUR: Verwende den korrekten Feldnamen 'categories' aus dem Suchindex
                    $query->whereIn('categories', $selectedCategories);
                } catch (ApiException $e) {
                    // Log error but continue without category filter
                    Log::warning('Meilisearch category filter failed: ' . $e->getMessage());
                }
            }

            // Wendet die Hashtag-Filter an. Mehrere 'where'-Bedingungen wirken in Meilisearch wie ein AND-Filter.
            foreach ($hashtags as $hashtag) {
                try {
                    // Dies ist die korrekte Syntax für Meilisearch-Filter
                    $query->where('hashtags', $hashtag);
                } catch (ApiException $e) {
                    // Log error but continue without hashtag filter
                    Log::warning('Meilisearch hashtag filter failed: ' . $e->getMessage());
                }
            }
            
            // Führt die Suche aus und paginiert die Ergebnisse
            $results = $query->paginate(12)->withQueryString();
        } catch (\Exception $e) {
            // If Meilisearch fails completely (connection error, index missing, etc.), fallback to database search
            Log::error('Meilisearch search failed, falling back to database: ' . $e->getMessage(), [
                'query' => $textSearch,
                'hashtags' => $hashtags,
                'categories' => $selectedCategories,
                'exception' => get_class($e),
            ]);
            
            // Fallback to database search
            $dbQuery = Restaurant::where('is_publicly_listed', true)
                ->where('status', 'active');
            
            if (!empty($textSearch)) {
                $dbQuery->where(function ($q) use ($textSearch) {
                    $q->where('name', 'LIKE', "%{$textSearch}%")
                      ->orWhere('description', 'LIKE', "%{$textSearch}%")
                      ->orWhere('address', 'LIKE', "%{$textSearch}%");
                });
            }
            
            $results = $dbQuery->paginate(12)->withQueryString();
        }

        // Holt alle Kategorien für die Filter-Anzeige
        $allCategories = PortalCategory::orderBy('name')->get();

        return view('search.index', [
            'results' => $results,
            'searchQuery' => $searchQuery,
            'allCategories' => $allCategories,
            'selectedCategories' => $selectedCategories,
        ]);
    }
}