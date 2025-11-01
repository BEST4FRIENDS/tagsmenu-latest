<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('restaurants', function (Blueprint $table) {
            // SEO Slug (Einzigartig, für die Hub-URL)
            // Nullable, da er erst beim Speichern durch den Observer generiert wird.
            $table->string('seo_slug')->unique()->nullable()->after('name');

            // Geodaten (Wichtig für Meilisearch Geo-Suche)
            // Decimal-Typ für hohe Präzision.
            $table->decimal('latitude', 10, 8)->nullable()->after('address');
            $table->decimal('longitude', 11, 8)->nullable()->after('latitude');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('restaurants', function (Blueprint $table) {
            // Wichtig: Zuerst den Unique-Index entfernen, bevor die Spalte gelöscht wird
            // Prüfen, ob die Spalte existiert, bevor der Index entfernt wird (für Robustheit)
            if (Schema::hasColumn('restaurants', 'seo_slug')) {
                $table->dropUnique(['seo_slug']);
            }
            $table->dropColumn(['seo_slug', 'latitude', 'longitude']);
        });
    }
};