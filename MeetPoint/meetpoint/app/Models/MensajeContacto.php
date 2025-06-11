<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MensajeContacto extends Model
{
     protected $fillable = [
        'asunto',
        'email',
        'telefono',
        'mensaje',
    ];
    
    public function user() {
        return $this->belongsTo(User::class, 'user_id');
    }
}
