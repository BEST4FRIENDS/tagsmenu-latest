<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\PortalCategory;
use Illuminate\Support\Str;

class PortalCategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $categories = [
            'Italienisch',
            'Asiatisch',
            'Vegan',
            'Burger',
            'Sushi',
            'Mexikanisch',
            'Café & Kuchen',
            'Frühstück & Brunch'
        ];

        foreach ($categories as $categoryName) {
            PortalCategory::firstOrCreate([
                'slug' => Str::slug($categoryName)
            ], [
                'name' => $categoryName
            ]);
        }
    }
}