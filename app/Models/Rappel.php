<?php

namespace App\Models;

// app/Models/Rappel.php
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Rappel extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'vehicule_id',
        'type',
        'date_rappel',
        'notes',
        'envoye'
    ];

    protected $casts = [
        'date_rappel' => 'datetime',
        'envoye' => 'boolean'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function vehicule()
    {
        return $this->belongsTo(Vehicule::class);
    }
}
