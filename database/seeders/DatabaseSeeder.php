<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seeder für die Datenbank starten.
     */
    public function run(): void
    {
        // AdminSeeder ausführen
        $this->call(AdminSeeder::class);
    }
}