<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CategoryTranslation extends Model
{
    use HasFactory;

    // This model does not need its own timestamps.
    public $timestamps = false;
    
    // Define all columns that can be filled with data.
    protected $fillable = ['category_id', 'locale', 'name'];
}