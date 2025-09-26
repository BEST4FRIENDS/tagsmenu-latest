<?php

namespace App.Http.Controllers;

use Illuminate.Http.Request;
use Gemini.Laravel.Facades.Gemini;

class AiController extends Controller
{
    /**
     * Suggest a better dish description using the Gemini API.
     */
    public function suggestDescription(Request $request)
    {
        $user = $request->user();

        // Sicherheits-Check
        $premiumPlanId = array_search('Premium AI - Tarif', config('services.stripe.plans'));
        if ($user->role !== 'superadmin' && !$user->subscription('default')?->hasPrice($premiumPlanId)) {
            return response()->json(['error' => 'Diese Funktion ist nur für Premium-Abonnenten verfügbar.'], 403);
        }

        // Validierung
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string|max:1000',
        ]);

        // Prompt
        $prompt = "Du bist ein professioneller Food-Texter für eine gehobene Speisekarte. Formuliere eine kurze, verlockende und appetitliche Beschreibung (maximal 3 Sätze) für das folgende Gericht. Antworte nur mit dem reinen Beschreibungstext, ohne Einleitung oder extra Formatierung.\n\nGericht: {$validated['name']}\nBisherige Beschreibung: {$validated['description']}";

        // --- IHRE KORREKTUR WURDE HIER UMGESETZT ---
        // Die korrekte Syntax: Den 'text'-Service aufrufen und dann den Inhalt generieren.
        $result = Gemini::text()->generateContent($prompt);

        // Antwort als JSON zurückgeben
        return response()->json(['suggestion' => $result->text()]);
    }
}