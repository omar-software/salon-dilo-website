<?php

namespace App\Http\Controllers;

use App\Services\ImageService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class SettingsController extends Controller
{
    // Seiteneinstellungen aus der Datenbank lesen
    public function getSettings()
    {
        // Einstellung mit ID 1 laden
        $settings = DB::table('settings')->where('id', 1)->first();

        // Standardbild zurückgeben, falls keine Einstellung existiert
        if (!$settings) {
            return response()->json([
                'header_image' => 'header.img.png',
            ]);
        }

        // Header-Bild als JSON zurückgeben
        return response()->json([
            'header_image' => $settings->header_image,
        ]);
    }

    // Neues Header-Bild hochladen und in der Datenbank speichern
    public function updateHeaderImage(Request $request, ImageService $imageService)
    {
        // Prüfen, ob eine gültige Bilddatei gesendet wurde
        $request->validate([
            'header_image' => 'required|image|mimes:jpg,jpeg,png,gif|max:4096',
        ]);

        // Bild aus dem Request holen
        $image = $request->file('header_image');

        // Bild mit dem ImageService hochladen
        $imageName = $imageService->uploadImage($image);

        // Bildname in der Datenbank aktualisieren
        DB::table('settings')->where('id', 1)->update([
            'header_image' => $imageName,
        ]);

        // Erfolgreiche Antwort an Vue zurückgeben
        return response()->json([
            'message' => 'Header-Bild wurde erfolgreich aktualisiert.',
            'header_image' => $imageName,
        ]);
    }
}