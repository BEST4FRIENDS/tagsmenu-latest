<?php
// in resources/lang/en/plans.php

return [
    // Meta & Header
    'meta_title' => 'Plans & Pricing - TAGS.MENU',
    'title'      => 'Choose the perfect plan for your restaurant',
    'subtitle'   => 'Start today and digitize your menu in minutes.',

    // Status Messages
    'status' => [
        'error_title' => 'Action failed:',
    ],

    // Basic Plan
    'basic' => [
        'name'     => 'Basic Plan',
        'price'    => '29',
        'interval' => '/month',
        'features' => [
            'digital_menu'      => 'Digital Menu',
            'qr_generator'      => 'QR Code Generator',
            'unlimited_dishes'  => 'Unlimited Dishes',
        ],
        'cta'      => 'Get Started',
    ],

    // Premium Plan
    'premium' => [
        'name'     => 'Premium AI',
        'badge'    => 'Most Popular',
        'price'    => '99',
        'interval' => '/month',
        'features' => [
            'all_basic'         => 'All features from the Basic Plan',
            'ai_descriptions'   => 'AI-powered Descriptions',
            'advanced_designs'  => 'Advanced Designs',
        ],
        'cta'      => 'Subscribe Now',
    ],

    // Concierge Plan
    'concierge' => [
        'name'     => 'Concierge Plan',
        'price'    => '249',
        'interval' => '/month',
        'features' => [
            'all_premium'       => 'All features from the Premium Plan',
            'onboarding'        => 'Personal Onboarding Service',
            'phone_support'     => 'Phone Support',
        ],
        'cta'      => 'Get Started',
    ],
];