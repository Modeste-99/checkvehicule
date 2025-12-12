<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Vehicule extends Model
{
    protected $fillable = [
        'user_id',
        'marque',
        'modele',
        'immatriculation',
        'annee',
        'kilometrage',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function entretiens()
    {
        return $this->hasMany(Entretien::class);
    }

}

