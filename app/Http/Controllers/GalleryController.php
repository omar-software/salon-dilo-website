<?php

namespace App\Http\Controllers;

use App\Models\GalleryImage;
use App\Services\ImageService;
use Illuminate\Http\Request;

class GalleryController extends Controller
{
    // Alle Galerie-Bilder aus der Datenbank lesen
    public function index()
    {
        // Bilder nach ID absteigend sortieren
        $images = GalleryImage::orderBy('id', 'desc')->get();

        // Bilder als JSON zurückgeben
        return response()->json($images);
    }

    // Neues Galerie-Bild hochladen und speichern
    public function store(Request $request, ImageService $imageService)
    {
        // Prüfen, ob eine gültige Bilddatei gesendet wurde
        $request->validate([
            'gallery_image' => 'required|image|mimes:jpg,jpeg,png,gif|max:4096',
            'alt_text' => 'nullable|string|max:255',
        ]);

        // Bild aus dem Request holen
        $image = $request->file('gallery_image');

        // Bild mit dem ImageService hochladen
        $imageName = $imageService->uploadImage($image);

        // Alternativtext aus dem Formular lesen
        $altText = $request->input('alt_text');

        // Falls kein Alternativtext eingegeben wurde, Standardtext verwenden
        if (!$altText) {
            $altText = 'Galerie-Bild von Salon Dilo';
        }

        // Bildinformationen in der Datenbank speichern
        $galleryImage = GalleryImage::create([
            'image_name' => $imageName,
            'alt_text' => $altText,
        ]);

        // Erfolgreiche Antwort an Vue zurückgeben
        return response()->json([
            'message' => 'Galerie-Bild wurde erfolgreich hinzugefügt.',
            'image' => $galleryImage,
        ]);
    }

    // Galerie-Bild löschen
    public function destroy($id, ImageService $imageService)
    {
        // Bild anhand der ID suchen
        $galleryImage = GalleryImage::find($id);

        // Prüfen, ob das Bild existiert
        if (!$galleryImage) {
            return response()->json([
                'message' => 'Galerie-Bild wurde nicht gefunden.',
            ], 404);
        }

        // Bilddatei mit dem ImageService löschen
        $imageService->deleteImage($galleryImage->image_name);

        // Datensatz aus der Datenbank löschen
        $galleryImage->delete();

        // Erfolgreiche Antwort an Vue zurückgeben
        return response()->json([
            'message' => 'Galerie-Bild wurde erfolgreich gelöscht.',
        ]);
    }
}