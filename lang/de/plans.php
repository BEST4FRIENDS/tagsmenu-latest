<?php
// in resources/lang/de/plans.php

return [
    // Meta & Header
    'meta_title' => 'Pläne & Preise - TAGS.MENU',
    'title'      => 'Wählen Sie den perfekten Plan für Ihr Restaurant',
    'subtitle'   => 'Starten Sie heute und digitalisieren Sie Ihre Speisekarte in wenigen Minuten.',

    // Status Messages
    'status' => [
        'error_title' => 'Aktion fehlgeschlagen:',
    ],

    // Basic Plan
    'basic' => [
        'name'     => 'Basis Tarif',
        'price'    => '29',
        'interval' => '/Monat',
        'features' => [
            'digital_menu'      => 'Digitale Speisekarte',
            'qr_generator'      => 'QR-Code Generator',
            'unlimited_dishes'  => 'Unbegrenzte Gerichte',
        ],
        'cta'      => 'Jetzt starten',
    ],

    // Premium Plan
    'premium' => [
        'name'     => 'Premium AI',
        'badge'    => 'Beliebtester Plan',
        'price'    => '99',
        'interval' => '/Monat',
        'features' => [
            'all_basic'         => 'Alle Features vom Basis Tarif',
            'ai_descriptions'   => 'KI-gestützte Beschreibungen',
            'advanced_designs'  => 'Erweiterte Designs',
        ],
        'cta'      => 'Jetzt abonnieren',
    ],

    // Concierge Plan
    'concierge' => [
        'name'     => 'Concierge Tarif',
        'price'    => '249',
        'interval' => '/Monat',
        'features' => [
            'all_premium'       => 'Alle Features vom Premium Tarif',
            'onboarding'        => 'Persönlicher Onboarding-Service',
            'phone_support'     => 'Telefon-Support',
        ],
        'cta'      => 'Jetzt starten',
    ],
];