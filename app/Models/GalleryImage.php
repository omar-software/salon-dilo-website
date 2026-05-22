<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class GalleryImage extends Model
{
    // Felder, die gespeichert werden dürfen
    protected $fillable = [
        'image_name',
        'alt_text',
    ];
}