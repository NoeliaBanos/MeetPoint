<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Resena extends Model
{
    protected $fillable = ['user_id', 'espacio_id', 'calificacion', 'comentario'];

    public function user() {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function espacio() {
        return $this->belongsTo(Espacio::class, 'espacio_id');
    }
}
