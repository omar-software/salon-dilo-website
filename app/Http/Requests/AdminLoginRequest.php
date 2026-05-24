<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AdminLoginRequest extends FormRequest
{
    /**
     * Prüfen, ob diese Anfrage erlaubt ist.
     */
    public function authorize(): bool
    {
        // Jeder darf versuchen, sich einzuloggen
        return true;
    }

    /**
     * Regeln für das Login-Formular.
     */
    public function rules(): array
    {
        return [
            // E-Mail muss vorhanden sein und eine gültige E-Mail sein
            'email' => 'required|email',

            // Passwort muss vorhanden sein
            'password' => 'required|string',
        ];
    }

    /**
     * Eigene Fehlermeldungen für die Validierung.
     */
    public function messages(): array
    {
        return [
            'email.required' => 'Bitte geben Sie eine E-Mail-Adresse ein.',
            'email.email' => 'Bitte geben Sie eine gültige E-Mail-Adresse ein.',
            'password.required' => 'Bitte geben Sie ein Passwort ein.',
        ];
    }
}