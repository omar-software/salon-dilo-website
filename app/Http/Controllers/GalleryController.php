<?php

namespace App\Http\Controllers;

use App\Models\GalleryImage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;

class GalleryController extends Controller
{
    // Alle Galerie-Bilder aus der Datenbank lesen
    public function index()
    {
        $images = GalleryImage::orderBy('id', 'desc')->get();

        return response()->json($images);
    }

    // Neues Galerie-Bild hochladen und speichern
    public function store(Request $request)
    {
        // Prüfen, ob eine gültige Bilddatei gesendet wurde
        $request->validate([
            'gallery_image' => 'required|image|mimes:jpg,jpeg,png,gif|max:4096',
            'alt_text' => 'nullable|string|max:255',
        ]);

        // Bild aus dem Request holen
        $image = $request->file('gallery_image');

        // Eindeutigen Dateinamen erstellen
        $imageName = time() . '_' . uniqid() . '.' . $image->getClientOriginalExtension();

        // Bild im public/images Ordner speichern
        $image->move(public_path('images'), $imageName);

        // Bildinformationen in der Datenbank speichern
        $galleryImage = GalleryImage::create([
            'image_name' => $imageName,
            'alt_text' => $request->input('alt_text') ?? 'Galerie-Bild von Salon Dilo',
        ]);

        return response()->json([
            'message' => 'Galerie-Bild wurde erfolgreich hinzugefügt.',
            'image' => $galleryImage,
        ]);
    }

    // Galerie-Bild löschen
    public function destroy($id)
    {
        // Bild anhand der ID suchen
        $galleryImage = GalleryImage::find($id);

        if (!$galleryImage) {
            return response()->json([
                'message' => 'Galerie-Bild wurde nicht gefunden.',
            ], 404);
        }

        // Pfad zur Bilddatei erstellen
        $imagePath = public_path('images/' . $galleryImage->image_name);

        // Bilddatei löschen, falls sie existiert
        if (File::exists($imagePath)) {
            File::delete($imagePath);
        }

        // Datensatz aus der Datenbank löschen
        $galleryImage->delete();

        return response()->json([
            'message' => 'Galerie-Bild wurde erfolgreich gelöscht.',
        ]);
    }
}