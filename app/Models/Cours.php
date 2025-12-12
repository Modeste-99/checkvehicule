<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Cours extends Model
{
    protected $fillable = [
        'user_id',
        'titre',
        'description',
        'fichier_pdf',
        'categorie',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the URL to download the PDF file
     */
    public function getPdfUrlAttribute()
    {
        return $this->fichier_pdf ? asset('storage/cours/' . $this->fichier_pdf) : null;
    }
}
