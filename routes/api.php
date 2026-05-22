<?php

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Route;

// API-Endpunkt für die Seiteneinstellungen
Route::get('/settings', function () {
    // Einstellungen aus der Datenbank lesen
    $settings = DB::table('settings')->where('id', 1)->first();

    // Falls keine Einstellungen gefunden wurden, Standardbild verwenden
    if (!$settings) {
        return response()->json([
            'header_image' => 'header.img.png',
        ]);
    }

    // Daten als JSON an Vue zurückgeben
    return response()->json([
        'header_image' => $settings->header_image,
    ]);
});