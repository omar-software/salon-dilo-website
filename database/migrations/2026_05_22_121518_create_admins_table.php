<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Admin-Tabelle erstellen
     */
    public function up(): void
    {
        Schema::create('admins', function (Blueprint $table) {
            $table->id();

            // E-Mail-Adresse für den Admin-Login
            $table->string('email')->unique();

            // Verschlüsseltes Passwort
            $table->string('password');

            $table->timestamps();
        });
    }

    /**
     * Admin-Tabelle löschen, falls Migration zurückgesetzt wird
     */
    public function down(): void
    {
        Schema::dropIfExists('admins');
    }
};