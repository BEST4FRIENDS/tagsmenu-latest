<?php

return [
    'title' => 'Nastavenia',
    'success_message' => 'Nastavenia úspešne aktualizované.',

    // Sekcie
    'general_section' => [
        'title' => 'Všeobecné informácie & Kontakt',
        'name' => 'Názov reštaurácie',
        'currency' => 'Mena',
        'contact_email' => 'Kontaktný e-mail',
        'contact_phone' => 'Telefónne číslo',
        'subdomain' => 'Vaša subdoména',
        'subdomain_help' => 'Povolené sú iba malé písmená, čísla a pomlčky.',
        'subdomain_warning' => 'Upozornenie: Ak zmeníte subdoménu, existujúce QR kódy a odkazy prestanú fungovať!',
        'address' => 'Adresa',
    ],

    'design_section' => [
        'title' => 'Dizajn & Branding',
        'logo' => 'Nahrať logo',
        'logo_help' => 'Akceptované formáty: PNG, JPG, WEBP. Max. 2MB.',
        'current_logo' => 'Aktuálne logo:',
        'accent_color' => 'Farba akcentu menu (Hex kód)',
    ],

    'social_section' => [
        'title' => 'Sociálne médiá & Odkazy',
        'website' => 'Webstránka (URL)',
        'google' => 'Google Maps/Business (URL)',
        'facebook' => 'Facebook stránka (URL)',
        'instagram' => 'Instagram profil (URL)',
        'tiktok' => 'TikTok profil (URL)',
        'other' => 'Iný odkaz (napr. Rezervácia, Donáška)',
    ],

    'seo_section' => [
        'title' => 'SEO & Viditeľnosť',
        'seo_title' => 'SEO Názov',
        'seo_title_help' => 'Zobrazí sa na karte prehliadača a vo výsledkoch vyhľadávania Google (odporúča sa max. 60 znakov).',
        'meta_description' => 'Meta Popis',
        'meta_description_help' => 'Krátke zhrnutie pre vyhľadávače (odporúča sa max. 160 znakov).',
        'og_image_url' => 'URL obrázka pre sociálne médiá (Open Graph Image)',
        'og_image_url_help' => 'Obrázok, ktorý sa zobrazí pri zdieľaní na Facebooku, WhatsApp atď. (Optimálne: 1200x630px).',
    ],
    
    'portal_profile' => [
        'title' => 'Verejný profil (Platforma na objavovanie)',
        'subtitle' => 'Spravujte, ako sa vaša reštaurácia zobrazuje na tagsmenu.app.',

        'visibility_title' => 'Viditeľnosť',
        'visibility_label' => 'Zverejniť moju reštauráciu.',
        'visibility_helper' => 'Ak je vypnuté, vaše menu je prístupné iba cez priamy odkaz, ale nie je možné ho nájsť vo vyhľadávaní.',

        'about_us_title' => 'Popis O nás',
        'about_us_placeholder' => 'Povedzte potenciálnym hosťom niečo o vašej reštaurácii...',

        'categories_title' => 'Kategórie (Štýl kuchyne)',
        'categories_helper' => 'Vyberte príslušné kategórie. Pomôže to používateľom nájsť vás.',

        'hashtags_title' => 'Hashtagy (Vlastnosti)',
        'hashtags_helper' => 'Pridajte špecifické vlastnosti (napr. #Terasa, #VeganFriendly). Oddeľte ich čiarkami.',
        'hashtags_placeholder' => 'napr. #Terasa, #BezbariérovýPrístup',

        'media_title' => 'Médiá',
        'logo' => 'Logo',
        'cover_image' => 'Titulný obrázok',
    ],

    'staff_access_section' => [
        'title' => 'Prístup pre zamestnancov (Dostupnosť)',
        'description' => 'Použite tento tajný odkaz, aby vaši zamestnanci (napr. v kuchyni) mohli rýchlo označiť položky ako "vypredané" bez prihlásenia do dashboardu.',
        'copy' => 'Kopírovať',
        'copied' => 'Skopírované!',
        'warning' => 'Dôležité:',
        'warning_text' => 'Zaobchádzajte s týmto odkazom ako s dôverným! Ktokoľvek, kto pozná tento odkaz, môže zmeniť dostupnosť.',
    ],

    'billing_section' => [
        'title' => 'Predplatné & Fakturácia',
        'description' => 'Tu môžete spravovať svoje predplatné, prezerať si faktúry alebo zmeniť spôsob platby. Budete bezpečne presmerovaný na Stripe Billing Portal.',
        'manage_billing' => 'Spravovať fakturáciu',
    ],
    
    'save_changes' => 'Uložiť zmeny',
];