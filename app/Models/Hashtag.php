<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
// NEU: Imports
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\MorphToMany;

class Hashtag extends Model
{
    use HasFactory;

    // NEU: Erlaubt Mass Assignment. Wichtig für Hashtag::firstOrCreate(['name' => ...])
    protected $fillable = ['name'];

    /*
     * Optional: Inverse Beziehungen definieren. Nützlich, wenn man wissen will,
     * welche Restaurants/Gerichte einen bestimmten Hashtag nutzen.
     */

    /**
     * NEU: Get all of the restaurants that are assigned this hashtag.
     */
    public function restaurants(): MorphToMany
    {
        return $this->morphedByMany(Restaurant::class, 'taggable');
    }

    /**
     * NEU: Get all of the dishes that are assigned this hashtag.
     */
    public function dishes(): MorphToMany
    {
        return $this->morphedByMany(Dish::class, 'taggable');
    }
}