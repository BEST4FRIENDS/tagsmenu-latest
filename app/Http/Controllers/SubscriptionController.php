<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class SubscriptionController extends Controller
{
    /**
     * Redirect the user to the Stripe checkout page to create a new subscription.
     */
    public function create(Request $request)
    {
        $user = $request->user();
        
        $planPriceId = $request->validate([
            'plan' => 'required|string',
        ])['plan'];

        return $user->newSubscription('default', $planPriceId)
                    ->checkout([
                        'success_url' => route('subscribe.success', [], true),
                        'cancel_url' => route('plans.index', [], true),
                    ]);
    }

    /**
     * Handle the successful subscription callback from Stripe.
     */
    public function success(Request $request)
    {
        // Wir setzen jetzt eine spezifische Session-Variable als "einmaligen VIP-Pass".
        // Zusätzlich zur normalen Erfolgsmeldung.
        return redirect()->route('dashboard')
                         ->with('success', 'Vielen Dank! Ihr Abonnement wurde erfolgreich aktiviert.')
                         ->with('newly_subscribed', true); // <-- DAS IST DER VIP-PASS
    }
}