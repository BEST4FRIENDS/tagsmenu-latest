<?php

namespace App\Http\Controllers;

use App\Models\Dish;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use App\Models\DishInteraction;

class InteractionController extends Controller
{
    /**
     * Verarbeitet einen 'Like' für ein Gericht.
     */
    public function likeDish(Dish $dish, Request $request): JsonResponse
    {
        $sessionId = $request->session()->getId();
        $today = now()->startOfDay();

        $existingInteraction = DishInteraction::where('dish_id', $dish->id)
            ->where('session_id', $sessionId)
            ->where('interaction_type', 'like')
            ->where('created_at', '>=', $today)
            ->first();

        if ($existingInteraction) {
            return response()->json([
                'success' => false,
                'message' => 'Bereits für heute gelikt.',
                'new_likes_count' => $dish->likes_count,
            ], 409); 
        }

        // === KORREKTUR: Finde die restaurant_id über die Kategorie ===
        // Wir laden die Kategorie-Beziehung des Gerichts
        $dish->load('category');
        $restaurantId = $dish->category ? $dish->category->restaurant_id : null;

        // Sicherheitscheck, falls ein Gericht keine Kategorie hat
        if (!$restaurantId) {
            // Logge diesen Fehler, das sollte nicht passieren
            \Illuminate\Support\Facades\Log::error("Gericht (ID: {$dish->id}) ohne Kategorie oder Kategorie ohne Restaurant wurde gelikt.");
            return response()->json(['success' => false, 'message' => 'Fehlerhafte Daten.'], 500);
        }

        // 4a. Speichere die Interaktion in unserer NEUEN Analyse-Tabelle
        DishInteraction::create([
            'dish_id' => $dish->id,
            'restaurant_id' => $restaurantId, // <-- KORRIGIERTER WERT
            'interaction_type' => 'like',
            'session_id' => $sessionId,
        ]);

        // 4b. Erhöhe den Zähler (alte Logik)
        $dish->increment('likes_count');

        return response()->json([
            'success' => true,
            'message' => 'Like erfolgreich registriert.',
            'new_likes_count' => $dish->likes_count,
        ]);
    }
}