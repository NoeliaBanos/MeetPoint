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
        'hora_entrada',
        'fecha_hora', 
        'hora_salida',
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
    public function resena()
    {
        return $this->hasOne(\App\Models\Resena::class, 'espacio_id', 'espacio_id')
            ->where('user_id', $this->user_id);
    }
}
