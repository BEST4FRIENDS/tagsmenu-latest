<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

// NEU: Trait importieren
use Spatie\Translatable\HasTranslations;

class PortalCategory extends Model
{
    // NEU: Trait verwenden
    use HasFactory, HasTranslations;

    // NEU: Definieren, welche Attribute übersetzbar sind
    public $translatable = ['name'];

    // Erlaubt Mass Assignment für diese Felder (aus Ihrer Original-Datei)
    protected $fillable = ['name', 'slug', 'image_path'];

    /**
     * Get the restaurants that belong to this category.
     */
    public function restaurants(): BelongsToMany
    {
        // Wichtig: Der zweite Parameter muss dem Namen der Pivot-Tabelle entsprechen.
        return $this->belongsToMany(Restaurant::class, 'portal_category_restaurant');
    }
}