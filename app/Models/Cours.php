<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Cours extends Model
{
    protected $fillable = [
        'user_id',
        'titre',
        'description',
        'fichier',
        'type_fichier',
    ];
    
    protected $appends = ['fichier_url'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the URL to download the file
     */
    public function getFichierUrlAttribute()
    {
        return $this->fichier ? asset('storage/cours/' . $this->fichier) : null;
    }
}
