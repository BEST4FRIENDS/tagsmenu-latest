<?php
// in resources/lang/sk/plans.php

return [
    // Meta & Header
    'meta_title' => 'Plány a Ceny - TAGS.MENU',
    'title'      => 'Vyberte si ideálny plán pre vašu reštauráciu',
    'subtitle'   => 'Začnite ešte dnes a digitalizujte svoje menu za pár minút.',

    // Status Messages
    'status' => [
        'error_title' => 'Akcia zlyhala:',
    ],

    // Basic Plan
    'basic' => [
        'name'     => 'Základný balík',
        'price'    => '29',
        'interval' => '/mesiac',
        'features' => [
            'digital_menu'      => 'Digitálne menu',
            'qr_generator'      => 'Generátor QR kódov',
            'unlimited_dishes'  => 'Neobmedzený počet jedál',
        ],
        'cta'      => 'Začať teraz',
    ],

    // Premium Plan
    'premium' => [
        'name'     => 'Premium AI',
        'badge'    => 'Najpopulárnejší',
        'price'    => '99',
        'interval' => '/mesiac',
        'features' => [
            'all_basic'         => 'Všetky funkcie zo Základného balíka',
            'ai_descriptions'   => 'Popisy s podporou UI',
            'advanced_designs'  => 'Pokročilé dizajny',
        ],
        'cta'      => 'Predplatiť teraz',
    ],

    // Concierge Plan
    'concierge' => [
        'name'     => 'Concierge balík',
        'price'    => '249',
        'interval' => '/mesiac',
        'features' => [
            'all_premium'       => 'Všetky funkcie z Prémiového balíka',
            'onboarding'        => 'Osobný onboarding servis',
            'phone_support'     => 'Telefonická podpora',
        ],
        'cta'      => 'Začať teraz',
    ],
];