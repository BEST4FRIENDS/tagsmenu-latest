<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
// Stellen Sie sicher, dass diese Imports vorhanden sind
use Illuminate\View\View;
// Entfernt oder behalten, wird aber nicht mehr als alleiniger Return Type genutzt:
// use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Log;
// WICHTIG: Importieren Sie die Symfony Response Klasse
use Symfony\Component\HttpFoundation\Response;

class SubscriptionController extends Controller
{
    // Hinweis: Diese Methode wird eventuell nicht benötigt, wenn die Plan-Anzeige durch einen PlanController verwaltet wird (wie aktuell implementiert).
    public function index(): View
    {
        $plans = config('services.stripe.plans', []);
        // Stellt sicher, dass der Pfad korrekt ist, falls diese Methode genutzt wird.
        return view('subscriptions.plans', ['plans' => $plans]);
    }

    /**
     * Erstellt eine Stripe Checkout Session.
     *
     * KORREKTUR: Rückgabetyp von RedirectResponse zu Response geändert.
     * Dies erlaubt die Rückgabe von RedirectResponse ODER Laravel\Cashier\Checkout.
     */
    public function create(Request $request)
    {
        // Validiert den Parameter 'plan' (der von der plans/index.blade.php kommt)
        $request->validate([
            'plan' => 'required|string|starts_with:price_'
        ]);

        $user = Auth::user();
        $priceId = $request->input('plan');

        // Wenn bereits ein bezahltes Abo besteht (d.h. ein Eintrag in der subscriptions Tabelle existiert), zum Billing Portal leiten.
        // Dies gibt eine RedirectResponse zurück.
        if ($user->subscribed('default')) {
            session()->flash('info', 'Sie haben bereits ein aktives Abonnement. Sie werden zum Kundenportal weitergeleitet.');
            return redirect()->route('billing.portal');
        }

        // Erstellt die Checkout Session.
        // Cashier erkennt die verbleibende Zeit aus 'trial_ends_at' automatisch und verwendet diese als Trial für Stripe.
        try {
            // Dies gibt ein Laravel\Cashier\Checkout Objekt zurück.
            return $user->newSubscription('default', $priceId)
                ->checkout([
                    // Stellt sicher, dass absolute URLs für die Weiterleitung von Stripe verwendet werden (true Parameter)
                    'success_url' => route('dashboard', ['payment' => 'setup_success'], true),
                    'cancel_url' => route('plans.index', ['payment' => 'cancelled'], true),
                ]);
        } catch (\Exception $e) {
            // Fehlerbehandlung. Dies gibt eine RedirectResponse zurück.
            Log::error("Stripe Checkout creation failed for user {$user->id}: " . $e->getMessage());
            return redirect()->route('plans.index')->withErrors(['error' => 'Fehler beim Starten des Bezahlvorgangs. Bitte kontaktieren Sie den Support.']);
        }
    }

    // Optional: Methode für die Erfolgsseite, falls benötigt
    /*
    public function success()
    {
        return view('subscriptions.success');
    }
    */
}