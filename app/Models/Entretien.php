<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Entretien extends Model
{
    protected $fillable = [
        'user_id',
        'vehicule_id',
        'type',
        'date_entretien',
        'kilometrage',
        'prix',
        'note',
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
