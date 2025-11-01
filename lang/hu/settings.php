<?php

return [
    'title' => 'Beállítások',
    'success_message' => 'Beállítások sikeresen frissítve.',

    // Szekciók
    'general_section' => [
        'title' => 'Általános Információk & Kapcsolat',
        'name' => 'Étterem neve',
        'currency' => 'Pénznem',
        'contact_email' => 'Kapcsolattartó E-mail',
        'contact_phone' => 'Telefonszám',
        'subdomain' => 'Az Ön aldoménje',
        'subdomain_help' => 'Csak kisbetűk, számok és kötőjelek engedélyezettek.',
        'subdomain_warning' => 'Figyelem: Ha megváltoztatja az aldomént, a meglévő QR-kódok és linkek többé nem fognak működni!',
        'address' => 'Cím',
    ],

    'design_section' => [
        'title' => 'Dizájn & Márkaépítés',
        'logo' => 'Logó feltöltése',
        'logo_help' => 'Elfogadott formátumok: PNG, JPG, WEBP. Max. 2MB.',
        'current_logo' => 'Jelenlegi logó:',
        'accent_color' => 'Étlap kiemelő színe (Hex-kód)',
    ],

    'social_section' => [
        'title' => 'Közösségi Média & Linkek',
        'website' => 'Weboldal (URL)',
        'google' => 'Google Maps/Business (URL)',
        'facebook' => 'Facebook oldal (URL)',
        'instagram' => 'Instagram profil (URL)',
        'tiktok' => 'TikTok profil (URL)',
        'other' => 'Egyéb link (pl. Foglalás, Kiszállítás)',
    ],

    'seo_section' => [
        'title' => 'SEO & Láthatóság',
        'seo_title' => 'SEO Cím',
        'seo_title_help' => 'A böngésző fülén és a Google találati listáján jelenik meg (max. 60 karakter ajánlott).',
        'meta_description' => 'Meta Leírás',
        'meta_description_help' => 'Rövid összefoglaló a keresőmotorok számára (max. 160 karakter ajánlott).',
        'og_image_url' => 'Közösségi Média Kép URL (Open Graph Image)',
        'og_image_url_help' => 'A kép, amely megosztáskor (Facebook, WhatsApp stb.) megjelenik. (Optimális: 1200x630px).',
    ],
    
    'portal_profile' => [
        'title' => 'Nyilvános profil (Felfedező platform)',
        'subtitle' => 'Kezelje étterme megjelenését a tagsmenu.app oldalon.',

        'visibility_title' => 'Láthatóság',
        'visibility_label' => 'Étteremem nyilvános listázása.',
        'visibility_helper' => 'Ha le van tiltva, az étlapja csak a közvetlen linken keresztül érhető el, de a keresőben nem található meg.',

        'about_us_title' => 'Rólunk leírás',
        'about_us_placeholder' => 'Mondjon valamit étterméről a potenciális vendégeknek...',

        'categories_title' => 'Kategóriák (Konyha stílusa)',
        'categories_helper' => 'Válassza ki a megfelelő kategóriákat. Ez segít a felhasználóknak megtalálni Önt.',

        'hashtags_title' => 'Címkék (Jellemzők)',
        'hashtags_helper' => 'Adjon hozzá egyedi jellemzőket (pl. #Terasz, #VegánBarát). Vesszővel válassza el őket.',
        'hashtags_placeholder' => 'pl. #Terasz, #Akadálymentes',

        'media_title' => 'Média',
        'logo' => 'Logó',
        'cover_image' => 'Borítókép',
    ],

    'staff_access_section' => [
        'title' => 'Személyzeti Hozzáférés (Elérhetőség)',
        'description' => 'Használja ezt a titkos linket, hogy munkatársai (pl. a konyhán) gyorsan "elfogyott" státuszra állíthassanak ételeket anélkül, hogy bejelentkeznének a vezérlőpultra.',
        'copy' => 'Másolás',
        'copied' => 'Másolva!',
        'warning' => 'Fontos:',
        'warning_text' => 'Kezelje bizalmasan ezt a linket! Bárki, aki ismeri a linket, módosíthatja az elérhetőséget.',
    ],

    'billing_section' => [
        'title' => 'Előfizetés & Számlázás',
        'description' => 'Itt kezelheti előfizetését, megtekintheti számláit vagy módosíthatja fizetési módját. Biztonságosan átirányítjuk a Stripe Billing Portálra.',
        'manage_billing' => 'Számlázás kezelése',
    ],
    
    'save_changes' => 'Módosítások mentése',
];