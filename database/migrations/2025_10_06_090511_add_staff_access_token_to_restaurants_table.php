<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('restaurants', function (Blueprint $table) {
            if (!Schema::hasColumn('restaurants', 'staff_access_token')) {
                // Fügt einen einzigartigen, sicheren Token hinzu (64 Zeichen). Zunächst nullable.
                $table->string('staff_access_token', 64)->unique()->nullable()->after('status');
            }
        });

        // Füllt den Token für bestehende Restaurants automatisch aus
        // Wir verwenden cursor() für Effizienz bei großen Tabellen.
        DB::table('restaurants')->whereNull('staff_access_token')->cursor()->each(function ($restaurant) {
            DB::table('restaurants')
                ->where('id', $restaurant->id)
                // Generiert einen sicheren, zufälligen String
                ->update(['staff_access_token' => Str::random(64)]);
        });

        // Stellt sicher, dass das Feld nicht leer sein kann (nachdem es gefüllt wurde)
        Schema::table('restaurants', function (Blueprint $table) {
            $table->string('staff_access_token', 64)->nullable(false)->change();
        });
    }

    public function down(): void
    {
        Schema::table('restaurants', function (Blueprint $table) {
            $table->dropColumn('staff_access_token');
        });
    }
};