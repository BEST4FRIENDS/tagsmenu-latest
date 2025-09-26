<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class DishTranslation extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'dish_id',
        'locale',
        'name',
        'description',
    ];

    /**
     * Get the dish that owns the translation.
     */
    public function dish(): BelongsTo
    {
        return $this->belongsTo(Dish::class);
    }
}