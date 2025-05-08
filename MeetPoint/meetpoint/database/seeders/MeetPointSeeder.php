<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Carbon\Carbon;

class MeetPointSeeder extends Seeder
{
    public function run(): void
    {
        // Usuarios
        DB::table('users')->insert([
            [
                'name'       => 'Juan',
                'email'      => 'juan@example.com',
                'password'   => Hash::make('password'),
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name'       => 'Ana',
                'email'      => 'ana@example.com',
                'password'   => Hash::make('password'),
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);

        // Espacios
        DB::table('espacios')->insert([
            [
                'estado_espacio' => 'disponible',
                'nombre'         => 'Sala de Reuniones A',
                'precio_hora'    => 25.00,
                'capacidad'    => 10,

                'equipamiento'   => 'Proyector, Pizarra, WiFi',
                'descripcion'    => 'Espacio ideal para reuniones pequeñas.',
                'imagen_url'     => 'img/salaA.jpg',
                'created_at'     => now(),
                'updated_at'     => now(),
            ],
            [
                'estado_espacio' => 'no_disponible',
                'nombre'         => 'Sala de Conferencias B',
                'precio_hora'    => 50.00,
                'capacidad'    => 15,
                'equipamiento'   => 'Micrófono, Pantalla grande, Climatización',
                'descripcion'    => 'Ideal para presentaciones y charlas.',
                'imagen_url'     => 'img/salaB.jpg',
                'created_at'     => now(),
                'updated_at'     => now(),
            ],
        ]);

        // Reservas
        $reservaDt = Carbon::now()->addDays(2);
        DB::table('reservas')->insert([
            [
                'fecha'       => $reservaDt->toDateString(),       // YYYY-MM-DD
                'fecha_hora'  => $reservaDt->toDateTimeString(),   // YYYY-MM-DD HH:MM:SS
                'user_id'     => 1,
                'espacio_id'  => 1,
                'created_at'  => now(),
                'updated_at'  => now(),
            ],
        ]);

        // Reseñas
        DB::table('resenas')->insert([
            [
                'calificacion'  => 5,                              // coincide con $table->tinyInteger('calificacion')
                'comentario'    => 'Excelente espacio, muy cómodo.', // coincide con $table->text('comentario')
                'user_id'       => 2,
                'espacio_id'    => 1,
                'created_at'    => now(),
                'updated_at'    => now(),
            ],
        ]);


        DB::table('mensaje_contactos')->insert([
            [
                'nombre'    => 'Carlos',
                'email'     => 'carlos@gmail.com',
                'telefono'     => '987456374',
                'mensaje'    => 'Quisiera saber si hay disponibilidad para este viernes.',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
