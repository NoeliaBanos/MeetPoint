<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    public function reservas() {
        return $this->hasMany(Reserva::class, 'user_id');
    }

    public function resenas() {
        return $this->hasMany(Resena::class, 'user_id');
    }

    public function mensajes() {
        return $this->hasMany(MensajeContacto::class, 'user_id');
    }
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
    public function favorites()
{
    return $this->hasMany(Favorite::class);
}

public function favoritedEspacios()
{
    return $this->belongsToMany(
        Espacio::class,
        'favorites'
    );
}

public function hasFavorited(Espacio $espacio): bool
{
    return $this->favoritedEspacios()
                ->where('espacio_id', $espacio->id)
                ->exists();
}
}
