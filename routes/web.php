<?php

use App\Http\Controllers\SettingsController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Models\Admin;
use Illuminate\Support\Facades\Hash;
use App\Http\Controllers\GalleryController;

Route::get('/', function () {
    return view('welcome');
});

// Login-Seite für den Admin anzeigen
Route::get('/admin-login', function () {
    return view('welcome');
});

// Admin-Login über die Datenbank prüfen
Route::post('/admin-login', function (Request $request) {
    // Eingaben aus dem Formular lesen
    $email = $request->input('email');
    $password = $request->input('password');

    // Admin anhand der E-Mail-Adresse suchen
    $admin = Admin::where('email', $email)->first();

    // Prüfen, ob Admin existiert und Passwort korrekt ist
    if ($admin && Hash::check($password, $admin->password)) {
        // Admin-Status in der Session speichern
        session([
            'is_admin' => true,
            'admin_id' => $admin->id,
            'admin_email' => $admin->email,
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Login erfolgreich.',
        ]);
    }

    // Fehlermeldung bei falschen Zugangsdaten
    return response()->json([
        'success' => false,
        'message' => 'Falsche E-Mail oder falsches Passwort.',
    ], 401);
});

// Admin-Seite nur anzeigen, wenn der Admin eingeloggt ist
Route::get('/admin', function () {
    // Prüfen, ob Admin in der Session gespeichert ist
    if (!session('is_admin')) {
        return redirect('/admin-login');
    }

    return view('welcome');
});

// Admin ausloggen
Route::post('/admin-logout', function () {
    // Admin-Session löschen
    session()->forget('is_admin');

    return response()->json([
        'success' => true,
        'message' => 'Logout erfolgreich.',
    ]);
});

// API-Endpunkt für die Seiteneinstellungen
Route::get('/api/settings', [SettingsController::class, 'getSettings']);

// API-Endpunkt zum Hochladen eines neuen Header-Bildes
Route::post('/api/header-image', [SettingsController::class, 'updateHeaderImage']);

// API-Endpunkte für die Galerie
Route::get('/api/gallery', [GalleryController::class, 'index']);
Route::post('/api/gallery', [GalleryController::class, 'store']);
Route::delete('/api/gallery/{id}', [GalleryController::class, 'destroy']);