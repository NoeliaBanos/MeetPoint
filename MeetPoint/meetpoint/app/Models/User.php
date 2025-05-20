<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use App\Models\Espacio;   
use App\Models\Favorite;  

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $fillable = [
        'name',
        'apellidos',
        'email',
        'password',
        'imagen_url',
        'role',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
        'password'          => 'hashed',
    ];

    // Relaciones existentes...
    public function reservas()
    {
        return $this->hasMany(Reserva::class, 'user_id');
    }

    public function resenas()
    {
        return $this->hasMany(Resena::class, 'user_id');
    }

    public function mensajes()
    {
        return $this->hasMany(MensajeContacto::class, 'user_id');
    }

    /**
     * Espacios que este usuario ha marcado como favorito.
     */
    public function favoritedEspacios()
    {
        return $this->belongsToMany(
            Espacio::class,
            'favorites',
            'user_id',
            'espacio_id'
        );
    }

    /**
     * Comprueba si el usuario ya ha marcado como favorito el espacio dado.
     */
    public function hasFavorited(Espacio $espacio): bool
    {
        return $this->favoritedEspacios()
                    ->where('espacio_id', $espacio->id)
                    ->exists();
    }
}
