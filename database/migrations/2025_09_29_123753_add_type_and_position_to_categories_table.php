<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('categories', function (Blueprint $table) {
            // Fügt die 'type' Spalte hinzu (enum ist ideal für feste Werte)
            if (!Schema::hasColumn('categories', 'type')) {
                $table->enum('type', ['food', 'drink'])->default('food')->after('restaurant_id');
            }
            // Fügt die 'position' Spalte für die Sortierung hinzu
            if (!Schema::hasColumn('categories', 'position')) {
                $table->unsignedInteger('position')->default(0)->after('type');
            }
        });
    }

    public function down(): void
    {
        Schema::table('categories', function (Blueprint $table) {
            $table->dropColumn('type');
            $table->dropColumn('position');
        });
    }
};