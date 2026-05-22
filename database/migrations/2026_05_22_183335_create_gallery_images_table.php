<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Galerie-Bilder-Tabelle erstellen
     */
    public function up(): void
    {
        Schema::create('gallery_images', function (Blueprint $table) {
            $table->id();

            // Dateiname des Bildes im public/images Ordner
            $table->string('image_name');

            // Alternativtext für Barrierefreiheit und SEO
            $table->string('alt_text')->nullable();

            $table->timestamps();
        });
    }

    /**
     * Galerie-Bilder-Tabelle löschen
     */
    public function down(): void
    {
        Schema::dropIfExists('gallery_images');
    }
};