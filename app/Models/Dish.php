<?php

namespace App\Models;

use Astrotomic\Translatable\Contracts\Translatable as TranslatableContract;
use Astrotomic\Translatable\Translatable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\MorphToMany;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasOneThrough; // <-- NEU: Importieren

class Dish extends Model implements TranslatableContract
{
    use HasFactory, Translatable;

    /**
     * The attributes that are mass assignable.
     * (Ich habe 'restaurant_id' entfernt, da es die Spalte nicht gibt)
     */
    protected $fillable = [
        'category_id',
        'price',
        'image_url',
        'is_available',
        'is_special',
        'is_vegetarian',
        'position',
        'likes_count',
    ];

    /**
     * The attributes that are translatable.
     */
    public array $translatedAttributes = ['name', 'description'];

    public string $translationModel = DishTranslation::class;
    public string $translationForeignKey = 'dish_id';
    protected string $localeKey = 'locale';


    /**
     * Ruft die (interne) Kategorie ab, zu der dieses Gericht gehört (z.B. "Vorspeisen").
     */
    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    /**
     * === KORRIGIERT: Ruft das Restaurant über die Kategorie ab ===
     * * Definiert eine "Hat-Eins-Durch"-Beziehung.
     * Ein "Dish" hat ein "Restaurant" DURCH eine "Category".
     */
    public function restaurant(): HasOneThrough
    {
        // Parameter:
        // 1. Das endgültige Modell, das wir wollen (Restaurant::class)
        // 2. Das Zwischenmodell (Category::class)
        // 3. Der Fremdschlüssel auf dem Zwischenmodell ('restaurant_id')
        // 4. Der Fremdschlüssel auf diesem Modell ('category_id')
        return $this->hasOneThrough(
            Restaurant::class,
            Category::class,
            'id', // Schlüssel auf Category (wird von Dish.category_id referenziert)
            'id', // Schlüssel auf Restaurant (wird von Category.restaurant_id referenziert)
            'category_id', // Lokaler Schlüssel auf Dish
            'restaurant_id' // Lokaler Schlüssel auf Category
        );
    }

    /**
     * Get the translations for the dish.
     */
    public function translations(): HasMany
    {
        return $this->hasMany(DishTranslation::class);
    }

    /**
     * Get the Hashtags for the dish.
     */
    public function hashtags(): MorphToMany
    {
        return $this->morphToMany(Hashtag::class, 'taggable');
    }
    
    /**
     * Ruft die (internen) Kategorien ab (für Pivot-Tabelle).
     */
    public function categories(): BelongsToMany
    {
        return $this->belongsToMany(Category::class);
    }
}