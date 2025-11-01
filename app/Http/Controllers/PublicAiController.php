<?php

namespace App\Http\Controllers;

use App\Models\Dish;
use Illuminate\Http\Request;
// Wichtig: Importieren Sie den Client direkt.
use Gemini\Client as GeminiClient; 
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Log;

class PublicAiController extends Controller
{
    protected $geminiClient;
    // KORREKTUR: Aktualisiert auf das korrekte Modell aus Ihrer Liste
    protected $modelName = 'gemini-2.5-flash'; 

    // Konstruktor zur Injektion des Gemini Clients
    public function __construct(GeminiClient $geminiClient)
    {
        $this->geminiClient = $geminiClient;
    }

    public function getPoeticDescription(Request $request, Dish $dish)
    {
        // --- Abonnement-Prüfung (Bleibt unverändert) ---
        $restaurant = $dish->category->restaurant;
        $owner = $restaurant->user;
        $language = $request->input('language', 'de');

        $premiumPlanId = config('services.stripe.plans.premium');
        $conciergePlanId = config('services.stripe.plans.concierge');

        if (!$premiumPlanId) {
            Log::error("Premium Plan ID is missing in config/services.php.");
            return response()->json(['error' => 'Konfigurationsfehler.'], 500);
        }

        $hasAiAccess = false;
        if ($owner) {
            if ($owner->role === 'superadmin') {
                $hasAiAccess = true;
            } else {
                $subscription = $owner->subscription('default');
                if ($subscription && (
                    $subscription->hasPrice($premiumPlanId) || 
                    ($conciergePlanId && $subscription->hasPrice($conciergePlanId))
                )) {
                    $hasAiAccess = true;
                }
            }
        }

        if (!$hasAiAccess) {
            return response()->json(['error' => 'Funktion nicht aktiviert.'], 403);
        }

        // --- Caching und API Aufruf (Verwendet nun das korrekte Modell) ---
        $cacheKey = "poetic_description_{$dish->id}_{$language}";

        $poeticText = Cache::remember($cacheKey, now()->addDays(7), function () use ($dish, $language) {
            // 3. Prompt definieren
            $prompt = "Du bist ein Poet und Food-Kritiker. Beschreibe das Gericht '{$dish->getTranslation('name', $language)}' in einer blumigen, metaphorischen und höchst appetitlichen Weise. Max. 2-3 Sätze. Antworte ausschließlich in der Sprache: {$language}.";
            
            // 4. Gemini API aufrufen
            try {
                // Verwendung der generativeModel Methode mit dem korrekten Modellnamen
                $result = $this->geminiClient->generativeModel($this->modelName)->generateContent($prompt);
                return $result->text();

            } catch (\Exception $e) {
                // Logging
                Log::error("Gemini API call failed (Public Poetic): " . $e->getMessage(), [
                    'Dish ID' => $dish->id,
                    'Language' => $language,
                    'Model' => $this->modelName,
                    'Exception' => $e->getMessage()
                ]);
                return ''; 
            }
        });

        if (empty($poeticText)) {
            return response()->json(['error' => 'Fehler bei der Generierung.'], 500);
        }

        return response()->json(['poetic_text' => $poeticText]);
    }
}