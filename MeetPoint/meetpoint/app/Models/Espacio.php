<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Espacio extends Model
{
     protected $fillable = [
          'nombre',
        'precio_hora',
        'capacidad',
        'descripcion',
        'equipamiento',
        'imagen_url',
        'estado_espacio',
        'hora_apertura',
        'hora_cierre',
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
