<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class AdminAuthMiddleware
{
    /**
     * Prüft, ob der Admin eingeloggt ist.
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Prüfen, ob die Admin-Session existiert
        if (!session('is_admin')) {
            // Bei normalen Seiten zur Login-Seite weiterleiten
            if (!$request->expectsJson()) {
                return redirect('/admin-login');
            }

            // Bei API-Anfragen JSON-Fehler zurückgeben
            return response()->json([
                'message' => 'Nicht autorisiert.',
            ], 401);
        }

        // Anfrage weiterlaufen lassen
        return $next($request);
    }
}