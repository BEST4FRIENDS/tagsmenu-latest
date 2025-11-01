<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('portal_categories', function (Blueprint $table) {
            // Ändert die Spalte 'name', um JSON-Übersetzungen zu speichern
            $table->text('name')->change();
        });
    }

    public function down(): void
    {
        Schema::table('portal_categories', function (Blueprint $table) {
            // Macht die Änderung rückgängig, falls nötig
            $table->string('name')->change();
        });
    }
};