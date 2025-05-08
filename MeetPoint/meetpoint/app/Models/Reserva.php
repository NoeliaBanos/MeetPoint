<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Reserva extends Model
{
    public function user() {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function espacio() {
        return $this->belongsTo(Espacio::class, 'espacio_id');
    }
}
