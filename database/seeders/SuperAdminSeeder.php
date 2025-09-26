<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str; // Wichtig: Str-Helfer importieren

class SuperAdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Schritt 1: Erstelle den Superadmin-Benutzer und speichere ihn in einer Variable
        $superAdmin = User::create([
            'name' => 'Super Admin',
            'email' => 'admin@tagsmenu.app',
            'password' => Hash::make('Master.2025*TM-mc'),  
            'role' => 'superadmin',
            'email_verified_at' => now(),
        ]);

        // Schritt 2: Erstelle direkt ein zugehöriges Restaurant für diesen Benutzer
        $superAdmin->restaurant()->create([
            'name' => 'TAGS.MENU',
            'subdomain' => Str::slug('live'),
            'currency' => 'EUR',
            'status' => 'active',
        ]);
    }
}