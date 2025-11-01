<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDishTranslationsTable extends Migration
{
    public function up(): void
    {
        Schema::create('dish_translations', function (Blueprint $table) {
            $table->id();
            $table->foreignId('dish_id')->constrained()->onDelete('cascade');
            $table->string('locale')->index();
            
            $table->string('name');
            $table->text('description')->nullable();

            $table->unique(['dish_id', 'locale']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('dish_translations');
    }
}