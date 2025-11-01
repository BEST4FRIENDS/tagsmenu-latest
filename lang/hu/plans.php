<?php
// in resources/lang/hu/plans.php

return [
    // Meta & Header
    'meta_title' => 'Csomagok és Árak - TAGS.MENU',
    'title'      => 'Válassza ki a tökéletes csomagot éttermének',
    'subtitle'   => 'Kezdje el ma, és digitalizálja étlapját percek alatt.',

    // Status Messages
    'status' => [
        'error_title' => 'A művelet sikertelen:',
    ],

    // Basic Plan
    'basic' => [
        'name'     => 'Alap Csomag',
        'price'    => '29',
        'interval' => '/hó',
        'features' => [
            'digital_menu'      => 'Digitális étlap',
            'qr_generator'      => 'QR-kód generátor',
            'unlimited_dishes'  => 'Korlátlan számú étel',
        ],
        'cta'      => 'Kezdés most',
    ],

    // Premium Plan
    'premium' => [
        'name'     => 'Prémium MI',
        'badge'    => 'Legnépszerűbb',
        'price'    => '99',
        'interval' => '/hó',
        'features' => [
            'all_basic'         => 'Minden az Alap csomagból',
            'ai_descriptions'   => 'MI-alapú leírások',
            'advanced_designs'  => 'Bővített dizájnok',
        ],
        'cta'      => 'Előfizetés most',
    ],

    // Concierge Plan
    'concierge' => [
        'name'     => 'Concierge Csomag',
        'price'    => '249',
        'interval' => '/hó',
        'features' => [
            'all_premium'       => 'Minden a Prémium csomagból',
            'onboarding'        => 'Személyes bevezetési szolgáltatás',
            'phone_support'     => 'Telefonos támogatás',
        ],
        'cta'      => 'Kezdés most',
    ],
];