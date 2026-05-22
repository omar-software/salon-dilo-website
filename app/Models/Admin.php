<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Admin extends Model
{
    // Felder, die in der Datenbank gespeichert werden dürfen
    protected $fillable = [
        'email',
        'password',
    ];

    // Passwort soll bei JSON-Ausgaben nicht sichtbar sein
    protected $hidden = [
        'password',
    ];
}