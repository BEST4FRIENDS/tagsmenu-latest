<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Ruft unseren neuen Seeder auf
        $this->call([
            SuperAdminSeeder::class,
        ]);
    }
}
