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
            // Wir fügen alle neuen Portal-Felder an einer Stelle hinzu
            $table->boolean('is_publicly_listed')->default(true)->after('status');
            $table->text('about_us')->nullable()->after('is_publicly_listed');
            $table->string('cover_image_path')->nullable()->after('about_us');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('restaurants', function (Blueprint $table) {
            // Wichtig: Auch die down-Methode anpassen
            $table->dropColumn(['is_publicly_listed', 'about_us', 'cover_image_path']);
        });
    }
};