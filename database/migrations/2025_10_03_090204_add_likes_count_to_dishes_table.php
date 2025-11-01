<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('dishes', function (Blueprint $table) {
            // Fügt einen Zähler für Likes hinzu, Start bei 0
            if (!Schema::hasColumn('dishes', 'likes_count')) {
                // Positionieren Sie dies am besten am Ende der Tabelle oder nach einem relevanten Feld
                $table->unsignedBigInteger('likes_count')->default(0);
            }
        });
    }

    public function down(): void
    {
        Schema::table('dishes', function (Blueprint $table) {
            $table->dropColumn('likes_count');
        });
    }
};