<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Espacio extends Model
{
    public function reservas() {
        return $this->hasMany(Reserva::class, 'espacio_id');
    }

    public function resenas() {
        return $this->hasMany(Resena::class, 'espacio_id');
    }
}
