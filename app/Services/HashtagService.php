<?php

namespace App\Services;

use App\Models\Hashtag;
use Illuminate\Support\Collection;

class HashtagService
{
    /**
     * Verarbeitet einen Input-String (z.B. "#Vegan, #Neu, Scharf") und gibt ein Array von Hashtag-IDs zurück.
     * Erstellt neue Hashtags in der Datenbank, falls sie noch nicht existieren.
     *
     * @param string|null $inputString Der kommagetrennte Input aus dem Formular.
     * @return array Array von IDs, bereit für Eloquent sync().
     */
    public function processHashtags(?string $inputString): array
    {
        if (empty($inputString)) {
            return [];
        }

        // 1. String bereinigen und in einzelne Tags aufteilen
        $tagNames = collect(explode(',', $inputString))
            ->map(function ($tagName) {
                // Entfernt Leerzeichen und das #-Symbol am Anfang
                return trim(ltrim(trim($tagName), '#'));
            })
            ->filter() // Entfernt leere Strings
            ->unique();

        // 2. IDs finden oder neue Hashtags erstellen
        $hashtagIds = $tagNames->map(function ($name) {
            // Nutzt firstOrCreate, um Duplikate zu vermeiden
            $hashtag = Hashtag::firstOrCreate(['name' => $name]);
            return $hashtag->id;
        });

        return $hashtagIds->toArray();
    }
}