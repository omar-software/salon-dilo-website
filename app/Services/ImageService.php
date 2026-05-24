<?php

namespace App\Services;

use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\File;

class ImageService
{
    /**
     * Bild in den public/images Ordner hochladen.
     */
    public function uploadImage(UploadedFile $image): string
    {
        // Eindeutigen Dateinamen erstellen
        $imageName = time() . '_' . uniqid() . '.' . $image->getClientOriginalExtension();

        // Bild in public/images speichern
        $image->move(public_path('images'), $imageName);

        // Dateinamen zurückgeben
        return $imageName;
    }

    /**
     * Bild aus dem public/images Ordner löschen.
     */
    public function deleteImage(string $imageName): void
    {
        // Vollständigen Pfad zum Bild erstellen
        $imagePath = public_path('images/' . $imageName);

        // Prüfen, ob das Bild existiert
        if (File::exists($imagePath)) {
            // Bild löschen
            File::delete($imagePath);
        }
    }
}