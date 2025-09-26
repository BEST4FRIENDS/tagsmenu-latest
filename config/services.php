<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Third Party Services
    |--------------------------------------------------------------------------
    |
    | This file is for storing the credentials for third party services such
    | as Mailgun, Postmark, AWS and more. This file provides the de facto
    | location for this type of information, allowing packages to have
    | a conventional file to locate the various service credentials.
    |
    */

    'postmark' => [
        'token' => env('POSTMARK_TOKEN'),
    ],

    'resend' => [
        'key' => env('RESEND_KEY'),
    ],

    'ses' => [
        'key' => env('AWS_ACCESS_KEY_ID'),
        'secret' => env('AWS_SECRET_ACCESS_KEY'),
        'region' => env('AWS_DEFAULT_REGION', 'us-east-1'),
    ],

    'slack' => [
        'notifications' => [
            'bot_user_oauth_token' => env('SLACK_BOT_USER_OAUTH_TOKEN'),
            'channel' => env('SLACK_BOT_USER_DEFAULT_CHANNEL'),
        ],
    ],

    // --- NEU: Stripe-Konfiguration hinzugefügt ---
    'stripe' => [
        // Diese Zeilen lesen die Werte aus Ihrer .env-Datei
        'key' => env('STRIPE_KEY'),
        'secret' => env('STRIPE_SECRET'),
        'webhook' => [
            'secret' => env('STRIPE_WEBHOOK_SECRET'),
        ],

        // Dies ist unsere "Übersetzungs-Tabelle" für die Plan-Namen
        'plans' => [
            // BITTE ERSETZEN SIE DIESE PLATZHALTER MIT IHREN ECHTEN STRIPE PREIS-IDS
            'price_1S7yu2HZisIzMiCRgFU5d97U' => 'Basis Tarif',
            'price_1S7yw7HZisIzMiCR2mOAJ2iq' => 'Premium AI - Tarif',
            'price_1S7z09HZisIzMiCRbrs4i4ql' => 'Concierge-Tarif',
        ],
    ],

];