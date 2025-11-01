<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('restaurants', function (Blueprint $table) {
            // Stellt sicher, dass logo_url nullable ist (falls es Änderungen gab)
            if (Schema::hasColumn('restaurants', 'logo_url')) {
                $table->string('logo_url')->nullable()->change();
            }

            // WICHTIG: 'currency' wird NICHT hinzugefügt, da es bereits existiert.
            // Wir verwenden die bestehende 'currency' Spalte als Ankerpunkt für die neuen Spalten.

            // Kontaktinformationen (Neu)
            // Wir prüfen vor dem Hinzufügen, ob die Spalte existiert.
            if (!Schema::hasColumn('restaurants', 'contact_email')) {
                // Wir nutzen 'currency' als Ankerpunkt.
                $table->string('contact_email')->nullable()->after('currency');
            }
            if (!Schema::hasColumn('restaurants', 'contact_phone')) {
                // Wir nutzen 'contact_email' als Ankerpunkt (existiert bereits oder wird gerade hinzugefügt).
                $table->string('contact_phone')->nullable()->after('contact_email');
            }
            if (!Schema::hasColumn('restaurants', 'address')) {
                $table->text('address')->nullable()->after('contact_phone');
            }

            // Design (Neu)
            if (!Schema::hasColumn('restaurants', 'accent_color')) {
                $table->string('accent_color', 7)->nullable()->after('address'); // Hex-Code
            }

            // SEO Einstellungen (werden nach 'status' eingefügt)
            if (!Schema::hasColumn('restaurants', 'seo_title')) {
                $table->string('seo_title')->nullable()->after('status');
            }
            if (!Schema::hasColumn('restaurants', 'meta_description')) {
                $table->text('meta_description')->nullable()->after('seo_title');
            }
            if (!Schema::hasColumn('restaurants', 'og_image_url')) {
                $table->string('og_image_url')->nullable()->after('meta_description');
            }

            // Social Media Links (JSON)
            if (!Schema::hasColumn('restaurants', 'social_links')) {
                $table->json('social_links')->nullable()->after('og_image_url');
            }
        });
    }

    public function down(): void
    {
        Schema::table('restaurants', function (Blueprint $table) {
            // Entfernt nur die Spalten, die in dieser Migration hinzugefügt wurden.
            // 'currency' wird NICHT entfernt, da es nicht von dieser Migration stammt.
            $table->dropColumn([
                'contact_email', 'contact_phone', 'address', 'accent_color',
                'seo_title', 'meta_description', 'og_image_url', 'social_links',
            ]);
        });
    }
};