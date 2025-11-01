<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('categories', function (Blueprint $table) {
            if (!Schema::hasColumn('categories', 'order')) {
                // Fügt die Spalte hinzu (unsignedInteger ist ideal für Sortierungen)
                $table->unsignedInteger('order')->default(0);
            }
        });

        // Initialisiert die Reihenfolge für bestehende Kategorien basierend auf ihrer ID.
        // Dies stellt sicher, dass die Reihenfolge pro Restaurant korrekt ist.
        DB::table('restaurants')->select('id')->cursor()->each(function ($restaurant) {
            $order = 0;
            DB::table('categories')
                ->where('restaurant_id', $restaurant->id)
                ->orderBy('id')
                ->cursor()
                ->each(function ($category) use (&$order) {
                    DB::table('categories')
                        ->where('id', $category->id)
                        ->update(['order' => $order++]);
                });
        });
    }

    public function down(): void
    {
        Schema::table('categories', function (Blueprint $table) {
            $table->dropColumn('order');
        });
    }
};