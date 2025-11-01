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
        // Erstellt die Tabelle zum Speichern JEDER einzelnen Interaktion
        Schema::create('dish_interactions', function (Blueprint $table) {
            $table->id();

            // Foreign Key zum Gericht (Dish)
            // onDelete('cascade') löscht die Interaktion, wenn das Gericht gelöscht wird.
            $table->foreignId('dish_id')->constrained('dishes')->onDelete('cascade');
            
            // Foreign Key zum Restaurant (Restaurant)
            // Wichtig für die Analyse (z.B. "Top Gerichte in Restaurant X")
            $table->foreignId('restaurant_id')->constrained('restaurants')->onDelete('cascade');
            
            // Art der Interaktion (fürs Erste 'like', später erweiterbar)
            $table->string('interaction_type')->default('like');
            
            // Wer hat die Interaktion ausgelöst?
            // Da Gäste nicht eingeloggt sind, verwenden wir die Session-ID.
            $table->string('session_id')->index(); 
            
            // $table->timestamps() fügt 'created_at' hinzu.
            // Dies ist die WICHTIGSTE Spalte für die Trend-Analyse.
            $table->timestamps();

            // Index für schnellere Abfragen bei der Analyse
            $table->index(['created_at', 'restaurant_id', 'dish_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('dish_interactions');
    }
};