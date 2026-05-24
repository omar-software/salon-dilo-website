<?php

use App\Http\Controllers\GalleryController;
use App\Http\Controllers\SettingsController;
use App\Http\Requests\AdminLoginRequest;
use App\Models\Admin;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Route;

// Startseite anzeigen
Route::get('/', function () {
    return view('welcome');
});

// Admin-Login-Seite anzeigen
Route::get('/admin-login', function () {
    return view('welcome');
});

// Admin-Login prüfen
Route::post('/admin-login', function (AdminLoginRequest $request) {

    // E-Mail und Passwort aus dem geprüften Formular lesen
    $email = $request->input('email');
    $password = $request->input('password');

    // Admin in der Datenbank suchen
    $admin = Admin::where('email', $email)->first();

    // Prüfen, ob Admin existiert und Passwort richtig ist
    if ($admin && Hash::check($password, $admin->password)) {

        // Admin-Daten in der Session speichern
        session([
            'is_admin' => true,
            'admin_id' => $admin->id,
            'admin_email' => $admin->email,
        ]);

        // Erfolgreiche Antwort an Vue senden
        return response()->json([
            'success' => true,
            'message' => 'Login erfolgreich.',
        ]);
    }

    // Fehlermeldung bei falschen Login-Daten
    return response()->json([
        'success' => false,
        'message' => 'Falsche E-Mail oder falsches Passwort.',
    ], 401);
});

// Admin-Seite schützen
Route::get('/admin', function () {
    return view('welcome');
})->middleware('admin.auth');

// Admin ausloggen
Route::post('/admin-logout', function () {

    // Admin-Session löschen
    session()->forget([
        'is_admin',
        'admin_id',
        'admin_email',
    ]);

    // Erfolgreiche Logout-Antwort an Vue senden
    return response()->json([
        'success' => true,
        'message' => 'Logout erfolgreich.',
    ]);
});

// Öffentliche API: Einstellungen lesen
Route::get('/api/settings', [SettingsController::class, 'getSettings']);

// Öffentliche API: Galerie lesen
Route::get('/api/gallery', [GalleryController::class, 'index']);

// Geschützte API: Header-Bild ändern
Route::post('/api/header-image', [SettingsController::class, 'updateHeaderImage'])
    ->middleware('admin.auth');

// Geschützte API: Galerie-Bild hinzufügen
Route::post('/api/gallery', [GalleryController::class, 'store'])
    ->middleware('admin.auth');

// Geschützte API: Galerie-Bild löschen
Route::delete('/api/gallery/{id}', [GalleryController::class, 'destroy'])
    ->middleware('admin.auth');