<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;

return Application::configure(basePath: dirname(__DIR__))

    // Hier werden die Routen-Dateien von Laravel geladen
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )

    // Hier registrieren wir eigene Middleware
    ->withMiddleware(function (Middleware $middleware): void {

        // Alias für unsere Admin-Middleware
        // Danach können wir in routes/web.php einfach "admin.auth" benutzen
        $middleware->alias([
            'admin.auth' => \App\Http\Middleware\AdminAuthMiddleware::class,
        ]);
    })

    // Hier können später Fehler-Einstellungen gemacht werden
    ->withExceptions(function (Exceptions $exceptions): void {
        //
    })

    // Laravel-App erstellen
    ->create();