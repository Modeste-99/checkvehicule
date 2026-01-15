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
        'prix_pieces',
        'prix_main_oeuvre',
        'note',
    ];

    /**
     * Les attributs qui doivent être convertis.
     *
     * @var array
     */
    protected $casts = [
        'date_entretien' => 'date',
        'prix' => 'decimal:2',
        'prix_pieces' => 'decimal:2',
        'prix_main_oeuvre' => 'decimal:2',
    ];

    /**
     * Calcule automatiquement le prix total avant la sauvegarde
     */
    protected static function booted()
    {
        static::saving(function ($entretien) {
            $entretien->prix = (float)($entretien->prix_pieces ?? 0) + (float)($entretien->prix_main_oeuvre ?? 0);
        });
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function vehicule()
    {
        return $this->belongsTo(Vehicule::class);
    }
}
