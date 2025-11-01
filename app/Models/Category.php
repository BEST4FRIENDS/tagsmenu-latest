<?php

namespace App\Models;

use Astrotomic\Translatable\Contracts\Translatable as TranslatableContract;
use Astrotomic\Translatable\Translatable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Category extends Model implements TranslatableContract
{
    use HasFactory, Translatable;

    public array $translatedAttributes = ['name'];
    // KORREKTUR: 'position' hinzugefügt
    protected $fillable = ['restaurant_id', 'type', 'position'];
    
    public string $translationModel = CategoryTranslation::class;
    public string $translationForeignKey = 'category_id';

    protected string $localeKey = 'locale';

    public function restaurant(): BelongsTo
    {
        return $this->belongsTo(Restaurant::class);
    }

    public function dishes(): HasMany
    {
        return $this->hasMany(Dish::class);
    }

    // Die Beziehung translations() ist durch das Translatable Trait abgedeckt.
}