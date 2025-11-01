<?php

namespace App\Listeners;

use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Log;
use Laravel\Cashier\Events\WebhookReceived;

class StripeEventListener
{
    /**
     * Create the event listener.
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     */
    public function handle(WebhookReceived $event): void
    {
        $payload = $event->payload;

        // Dies ist der wichtigste Teil:
        // Wir schreiben den kompletten Inhalt jedes Webhooks in die Log-Datei.
        Log::info('Stripe Webhook Received:', $payload);

        // Hier können Sie später Ihre eigene Logik hinzufügen, wenn Sie
        // auf bestimmte Events wie 'customer.subscription.created' reagieren wollen.
        // Für die Fehlersuche ist aber erstmal nur das Logging oben entscheidend.
        
        // if ($payload['type'] === 'customer.subscription.created') {
        //     // Eigene Logik hier...
        // }
    }
}