<?php
// in config/services.php

return [
    /* ... (deine anderen Services wie postmark, resend, etc. bleiben unverändert) ... */
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

    // --- Korrigierte Stripe-Konfiguration ---
    'stripe' => [
        'key'    => env('STRIPE_KEY'),
        'secret' => env('STRIPE_SECRET'),
        'webhook' => [
            'secret' => env('STRIPE_WEBHOOK_SECRET'),
        ],

        // NUR die Plan-IDs gehören hierher. Das ist die Konfiguration.
        // Die Texte (Namen, Preise etc.) gehören in die Sprachdateien.
        'plans' => [
            'basic'     => env('PLAN_BASIC_ID'),
            'premium'   => env('PLAN_PREMIUM_ID'),
            'concierge' => env('PLAN_CONCIERGE_ID'),
        ]
    ],
    'gemini' => [
        'key' => env('GEMINI_API_KEY'),
        'model' => env('GEMINI_MODEL', 'gemini-pro'), 
    ],
];