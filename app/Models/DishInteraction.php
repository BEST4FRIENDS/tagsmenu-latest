<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class DishInteraction extends Model
{
    use HasFactory;

    /**
     * Felder, die massen-zugewiesen werden dürfen.
     *
     * @var array
     */
    protected $fillable = [
        'dish_id',
        'restaurant_id',
        'interaction_type',
        'session_id',
    ];

    /**
     * Ruft das Gericht (Dish) ab, zu dem diese Interaktion gehört.
     */
    public function dish(): BelongsTo
    {
        return $this->belongsTo(Dish::class);
    }

    /**
     * Ruft das Restaurant ab, zu dem diese Interaktion gehört.
     */
    public function restaurant(): BelongsTo
    {
        return $this->belongsTo(Restaurant::class);
    }
}