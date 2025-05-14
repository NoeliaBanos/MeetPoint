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
        // Usuarios (1 admin + 4 users)
        DB::table('users')->insert([
            [
                'name'         => 'Admin',
                'apellidos'    => 'Superuser',
                'email'        => 'admin@example.com',
                'imagen_url'   => 'img_subidas/users/admin.jpg',
                'password'     => Hash::make('password'),
                'role'         => 'admin',
                'created_at'   => now(),
                'updated_at'   => now(),
            ],
            [
                'name'         => 'Juan',
                'apellidos'    => 'Pérez',
                'email'        => 'juan@example.com',
                'imagen_url'   => 'img_subidas/users/juan.jpg',
                'password'     => Hash::make('password'),
                'role'         => 'user',
                'created_at'   => now(),
                'updated_at'   => now(),
            ],
            [
                'name'         => 'Ana',
                'apellidos'    => 'García',
                'email'        => 'ana@example.com',
                'imagen_url'   => 'img_subidas/users/ana.jpg',
                'password'     => Hash::make('password'),
                'role'         => 'user',
                'created_at'   => now(),
                'updated_at'   => now(),
            ],
            [
                'name'         => 'Pedro',
                'apellidos'    => 'López',
                'email'        => 'pedro@example.com',
                'imagen_url'   => 'img_subidas/users/pedro.jpg',
                'password'     => Hash::make('password'),
                'role'         => 'user',
                'created_at'   => now(),
                'updated_at'   => now(),
            ],
            [
                'name'         => 'María',
                'apellidos'    => 'Fernández',
                'email'        => 'maria@example.com',
                'imagen_url'   => 'img_subidas/users/maria.jpg',
                'password'     => Hash::make('password'),
                'role'         => 'user',
                'created_at'   => now(),
                'updated_at'   => now(),
            ],
        ]);

        // Espacios (5)
        DB::table('espacios')->insert([
            [
                'nombre'         => 'Sala de Reuniones A',
                'descripcion'    => 'Espacio ideal para reuniones pequeñas.',
                'equipamiento'   => 'Proyector, Pizarra, WiFi',
                'estado_espacio' => 'disponible',
                'precio_hora'    => 25.00,
                'imagen_url'     => 'img_subidas/salaA.jpg',
                'capacidad'      => 10,
                'created_at'     => now(),
                'updated_at'     => now(),
            ],
            [
                'nombre'         => 'Sala de Conferencias B',
                'descripcion'    => 'Perfecta para presentaciones y charlas.',
                'equipamiento'   => 'Micrófono, Pantalla, Climatización',
                'estado_espacio' => 'no_disponible',
                'precio_hora'    => 50.00,
                'imagen_url'     => 'img_subidas/salaB.jpg',
                'capacidad'      => 15,
                'created_at'     => now(),
                'updated_at'     => now(),
            ],
            [
                'nombre'         => 'Coworking Zona C',
                'descripcion'    => 'Mesa abierta con enchufes y luz natural.',
                'equipamiento'   => 'WiFi, Enchufes, Cafetera',
                'estado_espacio' => 'disponible',
                'precio_hora'    => 15.00,
                'imagen_url'     => 'img_subidas/zonaC.jpg',
                'capacidad'      => 8,
                'created_at'     => now(),
                'updated_at'     => now(),
            ],
            [
                'nombre'         => 'Oficina Privada D',
                'descripcion'    => 'Espacio cerrado para 2 personas.',
                'equipamiento'   => 'Escritorios, Sillas, Aire Acondicionado',
                'estado_espacio' => 'disponible',
                'precio_hora'    => 35.00,
                'imagen_url'     => 'img_subidas/oficinaD.jpg',
                'capacidad'      => 2,
                'created_at'     => now(),
                'updated_at'     => now(),
            ],
            [
                'nombre'         => 'Terraza Exterior E',
                'descripcion'    => 'Ideal para descansos al aire libre.',
                'equipamiento'   => 'Mesas, Sillas, Sombrillas',
                'estado_espacio' => 'no_disponible',
                'precio_hora'    => 20.00,
                'imagen_url'     => 'img_subidas/terrazaE.jpg',
                'capacidad'      => 12,
                'created_at'     => now(),
                'updated_at'     => now(),
            ],
        ]);

        // Reservas (5)
        DB::table('reservas')->insert([
            [
                'user_id'     => 2,
                'espacio_id'  => 1,
                'fecha_hora'  => Carbon::now()->addDays(1)->toDateTimeString(),
                'created_at'  => now(),
                'updated_at'  => now(),
            ],
            [
                'user_id'     => 3,
                'espacio_id'  => 3,
                'fecha_hora'  => Carbon::now()->addDays(2)->toDateTimeString(),
                'created_at'  => now(),
                'updated_at'  => now(),
            ],
            [
                'user_id'     => 4,
                'espacio_id'  => 2,
                'fecha_hora'  => Carbon::now()->addDays(3)->toDateTimeString(),
                'created_at'  => now(),
                'updated_at'  => now(),
            ],
            [
                'user_id'     => 5,
                'espacio_id'  => 4,
                'fecha_hora'  => Carbon::now()->addDays(4)->toDateTimeString(),
                'created_at'  => now(),
                'updated_at'  => now(),
            ],
            [
                'user_id'     => 2,
                'espacio_id'  => 5,
                'fecha_hora'  => Carbon::now()->addDays(5)->toDateTimeString(),
                'created_at'  => now(),
                'updated_at'  => now(),
            ],
        ]);

        // Reseñas (5)
        DB::table('resenas')->insert([
            [
                'user_id'       => 2,
                'espacio_id'    => 1,
                'calificacion'  => 5,
                'comentario'    => 'Excelente espacio, muy cómodo.',
                'created_at'    => now(),
                'updated_at'    => now(),
            ],
            [
                'user_id'       => 3,
                'espacio_id'    => 2,
                'calificacion'  => 4,
                'comentario'    => 'Buena acústica, aunque un poco caro.',
                'created_at'    => now(),
                'updated_at'    => now(),
            ],
            [
                'user_id'       => 4,
                'espacio_id'    => 3,
                'calificacion'  => 5,
                'comentario'    => 'Perfecto para coworking, muy luminoso.',
                'created_at'    => now(),
                'updated_at'    => now(),
            ],
            [
                'user_id'       => 5,
                'espacio_id'    => 4,
                'calificacion'  => 3,
                'comentario'    => 'Cómodo, pero algo ruidoso.',
                'created_at'    => now(),
                'updated_at'    => now(),
            ],
            [
                'user_id'       => 2,
                'espacio_id'    => 5,
                'calificacion'  => 4,
                'comentario'    => 'Buen ambiente en la terraza.',
                'created_at'    => now(),
                'updated_at'    => now(),
            ],
        ]);

        // Mensajes de contacto (5)
        DB::table('mensaje_contactos')->insert([
            [
                'user_id'     =>  null,
                'nombre'      => 'Carlos Sánchez',
                'email'       => 'carlos@gmail.com',
                'telefono'    => '987456374',
                'mensaje'     => '¿Tienen disponibilidad este viernes por la tarde?',
                'created_at'  => now(),
                'updated_at'  => now(),
            ],
            [
                'user_id'     =>  2,
                'nombre'      => 'Laura Gómez',
                'email'       => 'laura@gmail.com',
                'telefono'    => '612345789',
                'mensaje'     => '¿Cómo reservo la sala de conferencias?',
                'created_at'  => now(),
                'updated_at'  => now(),
            ],
            [
                'user_id'     =>  null,
                'nombre'      => 'Miguel Torres',
                'email'       => 'miguel@gmail.com',
                'telefono'    => '698765432',
                'mensaje'     => '¿Cuál es la tarifa por hora de la terraza?',
                'created_at'  => now(),
                'updated_at'  => now(),
            ],
            [
                'user_id'     =>  3,
                'nombre'      => 'Raquel Díaz',
                'email'       => 'raquel@gmail.com',
                'telefono'    => '600111222',
                'mensaje'     => '¿Puedo cancelar una reserva ya hecha?',
                'created_at'  => now(),
                'updated_at'  => now(),
            ],
            [
                'user_id'     =>  null,
                'nombre'      => 'Sergio Martín',
                'email'       => 'sergio@gmail.com',
                'telefono'    => '611222333',
                'mensaje'     => 'Me gustaría un descuento para reservas recurrentes.',
                'created_at'  => now(),
                'updated_at'  => now(),
            ],
        ]);
    }
}
