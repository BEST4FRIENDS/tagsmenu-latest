<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\View\View;
use App\Models\Restaurant;
use App\Models\PortalCategory;

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

        // Startet die Scout/Meilisearch-Abfrage
        $query = Restaurant::search($textSearch);

        // Filtert nach den ausgewählten Kategorien
        if (!empty($selectedCategories)) {
            // KORREKTUR: Verwende den korrekten Feldnamen 'categories' aus dem Suchindex
            $query->whereIn('categories', $selectedCategories);
        }

        // Wendet die Hashtag-Filter an. Mehrere 'where'-Bedingungen wirken in Meilisearch wie ein AND-Filter.
        foreach ($hashtags as $hashtag) {
            // Dies ist die korrekte Syntax für Meilisearch-Filter
            $query->where('hashtags', $hashtag);
        }
        
        // Führt die Suche aus und paginiert die Ergebnisse
        $results = $query->paginate(12)->withQueryString();

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