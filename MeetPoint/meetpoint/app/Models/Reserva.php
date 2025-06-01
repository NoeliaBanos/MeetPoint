<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class Reserva extends Model
{
    use HasFactory;

    /* ---------- columnas que se pueden asignar en masa ---------- */
    protected $fillable = [
        'user_id',
        'espacio_id',
        'fecha',
        'fecha_hora',
        'importe',
        'pago_estado',   // «pendiente» o «pagado»
    ];

    /* ---------- casts automáticos ---------- */
    protected $casts = [
        'fecha'      => 'date',
        'fecha_hora' => 'datetime',
    ];

    /* ---------- relaciones ---------- */
    public function usuario()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function espacio()
    {
        return $this->belongsTo(Espacio::class);
    }

    /* ---------- accesor opcional: solo la hora en formato 0-23 ---------- */
    public function getHoraAttribute(): int
    {
        return Carbon::parse($this->fecha_hora)->format('H');
    }
}
