<?php

namespace App\Livewire;

use Livewire\Component;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class AiRecommender extends Component
{
    public string $prompt = '';
    public bool $isLoading = false;

    public function getRecommendation()
    {
        $this->validate(['prompt' => 'required|string|min:10|max:255']);
        $this->isLoading = true;

        try {
            // KORREKTUR 1: Modellname und Key werden jetzt korrekt aus der Config geladen
            $apiKey = config('services.gemini.key');
            $modelName = config('services.gemini.model');

            if (!$apiKey || !$modelName) {
                throw new \Exception('Gemini API Key oder Modellname ist nicht konfiguriert.');
            }

            $engineeredPrompt = "Du bist ein Experte für Restaurantsuche. Deine Aufgabe ist es, aus dem folgenden Benutzereingabentext relevante Suchbegriffe und Hashtags zu extrahieren. Gib NUR eine durch Kommas getrennte Liste der Begriffe zurück, ohne einleitenden Text oder Erklärungen. Die Ausgabe muss direkt für eine Suchmaschine verwendbar sein. Beispiel-Ausgabe: 'scharf, asiatisch, #Terrasse'. Der Text lautet: \"{$this->prompt}\"";

            // KORREKTUR 2: API-Endpunkt auf v1 aktualisiert und Modellname dynamisch eingefügt
            $response = Http::timeout(30)->post("https://generativelanguage.googleapis.com/v1/models/{$modelName}:generateContent?key={$apiKey}", [
                'contents' => [['parts' => [['text' => $engineeredPrompt]]]],
                'generationConfig' => ['temperature' => 0.2]
            ]);

            if ($response->successful() && !empty($response->json('candidates.0.content.parts.0.text'))) {
                $searchQuery = $response->json('candidates.0.content.parts.0.text');
                $cleanedQuery = str_replace(['"', "'", "\n", "`"], '', trim($searchQuery));
                return redirect()->route('search.index', ['query' => $cleanedQuery]);
            } else {
                Log::info('Gemini API Response Body: ' . $response->body());
                session()->flash('ai_error', 'Die KI konnte keine passenden Suchbegriffe finden. Bitte formulieren Sie Ihre Anfrage anders.');
            }

        } catch (\Exception $e) {
            session()->flash('ai_error', 'Ein technischer Fehler ist aufgetreten. Bitte versuchen Sie es später erneut.');
            Log::error('Gemini API Exception: ' . $e->getMessage());
        }

        $this->isLoading = false;
    }

    public function render()
    {
        return view('livewire.ai-recommender');
    }
}