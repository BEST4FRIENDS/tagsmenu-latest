<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
// Wichtig: Importieren Sie den Client direkt.
use Gemini\Client as GeminiClient;
use Illuminate\Support\Facades\Log;

class AiController extends Controller
{
    protected $geminiClient;
    // KORREKTUR: Aktualisiert auf das korrekte Modell aus Ihrer Liste
    protected $modelName = 'gemini-2.5-flash';

    // Konstruktor zur Injektion des Gemini Clients
    public function __construct(GeminiClient $geminiClient)
    {
        $this->geminiClient = $geminiClient;
    }

    public function suggestDescription(Request $request)
    {
        // --- Abonnement-Prüfung (Bleibt unverändert) ---
        $user = $request->user();

        $premiumPlanId = config('services.stripe.plans.premium');
        $conciergePlanId = config('services.stripe.plans.concierge');

        if (!$premiumPlanId) {
             Log::error("Premium Plan ID is missing in config/services.php for AiController.");
            return response()->json(['error' => 'Konfigurationsfehler.'], 500);
        }

        $hasAiAccess = false;
        if ($user->role === 'superadmin') {
            $hasAiAccess = true;
        } else {
             $subscription = $user->subscription('default');
            if ($subscription && (
                $subscription->hasPrice($premiumPlanId) || 
                ($conciergePlanId && $subscription->hasPrice($conciergePlanId))
            )) {
                $hasAiAccess = true;
            }
        }
        
        if (!$hasAiAccess) {
            return response()->json(['error' => 'Diese Funktion ist nur für Premium- oder Concierge-Abonnenten verfügbar.'], 403);
        }

        // --- Validierung und API Aufruf (Verwendet nun das korrekte Modell) ---
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string|max:1000',
        ]);

        // Prompt
        $prompt = "Du bist ein professioneller Food-Texter für eine gehobene Speisekarte. Formuliere eine kurze, verlockende und appetitliche Beschreibung (maximal 3 Sätze) für das folgende Gericht. Antworte nur mit dem reinen Beschreibungstext, ohne Einleitung oder extra Formatierung.\n\nGericht: {$validated['name']}\nBisherige Beschreibung: {$validated['description']}";

        try {
            // Verwendung der generativeModel Methode mit dem korrekten Modellnamen
            $result = $this->geminiClient->generativeModel($this->modelName)->generateContent($prompt);

            // Antwort als JSON zurückgeben
            return response()->json(['suggestion' => $result->text()]);
        
        } catch (\Exception $e) {
            // Logging für API-Fehler
            Log::error("Gemini API call failed (Admin Suggestion): " . $e->getMessage(), [
                'User ID' => $user->id,
                'Model' => $this->modelName,
                'Exception' => $e->getMessage()
            ]);
            return response()->json(['error' => 'Fehler bei der Kommunikation mit der KI.'], 500);
        }
    }
}