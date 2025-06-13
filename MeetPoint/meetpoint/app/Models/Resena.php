<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Resena extends Model
{
    use HasFactory;

    /*----------------------------------------------
    |  Asignación masiva y casteo de atributos
    |----------------------------------------------*/
    protected $fillable = [
        'user_id',
        'espacio_id',
        'calificacion',
        'comentario',
        'visible',          //  ← añade la nueva columna
    ];

    protected $casts = [
        'visible' => 'boolean',
    ];

    /*----------------------------------------------
    |  Relaciones
    |----------------------------------------------*/
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function espacio()
    {
        return $this->belongsTo(Espacio::class);
    }

    /*----------------------------------------------
    |  Scopes reutilizables
    |----------------------------------------------*/
    public function scopeVisibles($query)
    {
        return $query->where('visible', true);
    }

    public function scopeOcultas($query)
    {
        return $query->where('visible', false);
    }

    /*----------------------------------------------
    |  Helper opcional para marcar como visible
    |  (sin redirecciones; sólo cambia el estado)
    |----------------------------------------------*/
    public function marcarVisible(): bool
    {
        return $this->update(['visible' => true]);
    }
}
