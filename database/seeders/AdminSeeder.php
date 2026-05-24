<?php

namespace Database\Seeders;

use App\Models\Admin;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class AdminSeeder extends Seeder
{
    /**
     * Erstellt einen Admin-Benutzer für das Projekt.
     */
    public function run(): void
    {
        // Prüfen, ob der Admin schon existiert
        $admin = Admin::where('email', 'admin@salondilo.com')->first();

        // Wenn der Admin noch nicht existiert, wird er erstellt
        if (!$admin) {
            Admin::create([
                'email' => 'admin@salondilo.com',
                'password' => Hash::make('123456'),
            ]);
        }
    }
}