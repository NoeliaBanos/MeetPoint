<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Espacio extends Model
{
     protected $fillable = [
        'estado_espacio',
        'nombre',
        'precio_hora',
        'equipamiento',
        'descripcion',
        'imagen',
        // cualquier otro campo de tu tabla espacios
    ];
    public function reservas() {
        return $this->hasMany(Reserva::class, 'espacio_id');
    }

    public function resenas() {
        return $this->hasMany(Resena::class, 'espacio_id');
    }
    public function favoritedBy()
{
    return $this->belongsToMany(
        User::class,
        'favorites'
    );
}
}
