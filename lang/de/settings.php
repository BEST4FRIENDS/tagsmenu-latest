<?php

return [
    'title' => 'Einstellungen',
    'success_message' => 'Einstellungen erfolgreich aktualisiert.',

    // Abschnitte
    'general_section' => [
        'title' => 'Allgemeine Informationen & Kontakt',
        'name' => 'Restaurant-Name',
        'currency' => 'Währung',
        'contact_email' => 'Kontakt E-Mail',
        'contact_phone' => 'Telefonnummer',
        'subdomain' => 'Ihre Subdomain',
        'subdomain_help' => 'Nur Kleinbuchstaben, Zahlen und Bindestriche sind erlaubt.',
        'subdomain_warning' => 'Achtung: Wenn Sie die Subdomain ändern, funktionieren bestehende QR-Codes und Links nicht mehr!',
        'address' => 'Adresse',
    ],

    'design_section' => [
        'title' => 'Design & Branding',
        'logo' => 'Logo hochladen',
        'logo_help' => 'Akzeptierte Formate: PNG, JPG, WEBP. Max. 2MB.',
        'current_logo' => 'Aktuelles Logo:',
        'accent_color' => 'Akzentfarbe der Speisekarte (Hex-Code)',
    ],

    'social_section' => [
        'title' => 'Social Media & Links',
        'website' => 'Webseite (URL)',
        'google' => 'Google Maps/Business (URL)',
        'facebook' => 'Facebook Seite (URL)',
        'instagram' => 'Instagram Profil (URL)',
        'tiktok' => 'TikTok Profil (URL)',
        'other' => 'Anderer Link (z.B. Reservierung, Lieferdienst)',
    ],

    'seo_section' => [
        'title' => 'SEO & Sichtbarkeit',
        'seo_title' => 'SEO Title',
        'seo_title_help' => 'Erscheint im Browser-Tab und in den Google-Suchergebnissen (max. 60 Zeichen empfohlen).',
        'meta_description' => 'Meta Description',
        'meta_description_help' => 'Kurze Zusammenfassung für Suchmaschinen (max. 160 Zeichen empfohlen).',
        'og_image_url' => 'Social Media Image URL (Open Graph Image)',
        'og_image_url_help' => 'Das Bild, das beim Teilen auf Facebook, WhatsApp etc. erscheint. (Optimal: 1200x630px).',
    ],
    
    'portal_profile' => [
        'title' => 'Öffentliches Profil (Discovery Plattform)',
        'subtitle' => 'Verwalten Sie, wie Ihr Restaurant auf tagsmenu.app erscheint.',

        'visibility_title' => 'Sichtbarkeit',
        'visibility_label' => 'Mein Restaurant öffentlich listen.',
        'visibility_helper' => 'Wenn deaktiviert, ist Ihre Speisekarte nur über den direkten Link erreichbar, aber nicht über die Suche auffindbar.',

        'about_us_title' => 'Über Uns Beschreibung',
        'about_us_placeholder' => 'Erzählen Sie potenziellen Gästen etwas über Ihr Restaurant...',

        'categories_title' => 'Kategorien (Küchenstil)',
        'categories_helper' => 'Wählen Sie die passenden Kategorien aus. Dies hilft Nutzern, Sie zu finden.',

        'hashtags_title' => 'Hashtags (Merkmale)',
        'hashtags_helper' => 'Fügen Sie spezifische Merkmale hinzu (z.B. #Terrasse, #VeganFreundlich). Trennen Sie diese durch Kommas.',
        'hashtags_placeholder' => 'z.B. #Terrasse, #Barrierefrei',

        'media_title' => 'Medien',
        'logo' => 'Logo',
        'cover_image' => 'Titelbild (Cover)',
    ],

    'staff_access_section' => [
        'title' => 'Mitarbeiter-Zugang (Verfügbarkeit)',
        'description' => 'Verwenden Sie diesen geheimen Link, damit Ihre Mitarbeiter (z.B. in der Küche) Gerichte schnell als "ausverkauft" markieren können, ohne sich im Dashboard anmelden zu müssen.',
        'copy' => 'Kopieren',
        'copied' => 'Kopiert!',
        'warning' => 'Wichtig:',
        'warning_text' => 'Behandeln Sie diesen Link vertraulich! Jeder, der den Link kennt, kann die Verfügbarkeit ändern.',
    ],

    'billing_section' => [
        'title' => 'Abonnement & Abrechnung',
        'description' => 'Hier können Sie Ihr Abonnement verwalten, Ihre Rechnungen einsehen oder Ihre Zahlungsmethode ändern. Sie werden sicher zum Stripe Billing Portal weitergeleitet.',
        'manage_billing' => 'Abrechnung verwalten',
    ],
    
    'save_changes' => 'Änderungen speichern',
];