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
        Schema::table('portal_categories', function (Blueprint $table) {
            // Nur löschen, wenn die Spalte auch wirklich existiert.
            if (Schema::hasColumn('portal_categories', 'image_path')) {
                $table->dropColumn('image_path');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('portal_categories', function (Blueprint $table) {
            // Nur hinzufügen, wenn die Spalte noch nicht existiert.
            if (!Schema::hasColumn('portal_categories', 'image_path')) {
                $table->string('image_path')->nullable();
            }
        });
    }
};