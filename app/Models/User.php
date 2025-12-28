<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use App\Models\Rappel;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'photo',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    public function vehicules()
    {
        return $this->hasMany(Vehicule::class);
    }

    public function entretiens()
    {
        return $this->hasMany(Entretien::class);
    }

    public function garages()
    {
        return $this->hasMany(Garage::class);
    }

    public function cours()
    {
        return $this->hasMany(Cours::class);
    }

    public function rappels()
    {
        return $this->hasMany(Rappel::class);
    }

    /**
     * Get the URL to the user's photo
     */
    public function getPhotoUrlAttribute()
    {
        return $this->photo ? asset('storage/profiles/' . $this->photo) : asset('images/default-avatar.png');
    }
}
