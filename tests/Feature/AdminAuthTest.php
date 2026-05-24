<?php

namespace Tests\Feature;

use App\Models\Admin;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class AdminAuthTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Test: Besucher ohne Login wird von /admin zur Login-Seite weitergeleitet.
     */
    public function test_guest_is_redirected_from_admin_page_to_login_page(): void
    {
        // Admin-Seite ohne Login öffnen
        $response = $this->get('/admin');

        // Prüfen, ob der Benutzer zur Login-Seite weitergeleitet wird
        $response->assertRedirect('/admin-login');
    }

    /**
     * Test: Admin kann sich mit richtigen Login-Daten einloggen.
     */
    public function test_admin_can_login_with_correct_credentials(): void
    {
        // Admin in der Test-Datenbank erstellen
        Admin::create([
            'email' => 'admin@salondilo.com',
            'password' => Hash::make('123456'),
        ]);

        // Login-Anfrage senden
        $response = $this->post('/admin-login', [
            'email' => 'admin@salondilo.com',
            'password' => '123456',
        ]);

        // Prüfen, ob Login erfolgreich war
        $response->assertStatus(200);

        // Prüfen, ob die JSON-Antwort success true enthält
        $response->assertJson([
            'success' => true,
            'message' => 'Login erfolgreich.',
        ]);

        // Prüfen, ob Admin in der Session gespeichert wurde
        $this->assertTrue(session('is_admin'));
    }

    /**
     * Test: Admin kann sich mit falschem Passwort nicht einloggen.
     */
    public function test_admin_cannot_login_with_wrong_password(): void
    {
        // Admin in der Test-Datenbank erstellen
        Admin::create([
            'email' => 'admin@salondilo.com',
            'password' => Hash::make('123456'),
        ]);

        // Login-Anfrage mit falschem Passwort senden
        $response = $this->post('/admin-login', [
            'email' => 'admin@salondilo.com',
            'password' => 'wrong-password',
        ]);

        // Prüfen, ob Laravel den Fehler-Code 401 zurückgibt
        $response->assertStatus(401);

        // Prüfen, ob die JSON-Antwort success false enthält
        $response->assertJson([
            'success' => false,
            'message' => 'Falsche E-Mail oder falsches Passwort.',
        ]);
    }

    /**
     * Test: Geschützte API kann ohne Admin-Login nicht benutzt werden.
     */
    public function test_protected_gallery_api_returns_unauthorized_without_login(): void
    {
        // API ohne Login aufrufen
        $response = $this->postJson('/api/gallery', []);

        // Prüfen, ob der Zugriff verweigert wird
        $response->assertStatus(401);

        // Prüfen, ob eine passende Fehlermeldung kommt
        $response->assertJson([
            'message' => 'Nicht autorisiert.',
        ]);
    }

        /**
     * Test: Login ohne E-Mail wird abgelehnt.
     */
    public function test_admin_login_requires_email(): void
    {
        // Login-Anfrage ohne E-Mail senden
        $response = $this->post('/admin-login', [
            'password' => '123456',
        ]);

        // Prüfen, ob Laravel einen Redirect zurückgibt
        // Das passiert bei normaler Formular-Validierung
        $response->assertStatus(302);

        // Prüfen, ob ein Fehler für das Feld email vorhanden ist
        $response->assertSessionHasErrors('email');
    }

    /**
     * Test: Login ohne Passwort wird abgelehnt.
     */
    public function test_admin_login_requires_password(): void
    {
        // Login-Anfrage ohne Passwort senden
        $response = $this->post('/admin-login', [
            'email' => 'admin@salondilo.com',
        ]);

        // Prüfen, ob Laravel einen Redirect zurückgibt
        // Das passiert bei normaler Formular-Validierung
        $response->assertStatus(302);

        // Prüfen, ob ein Fehler für das Feld password vorhanden ist
        $response->assertSessionHasErrors('password');
    }
}