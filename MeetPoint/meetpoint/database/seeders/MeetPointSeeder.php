<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Carbon\Carbon;
use App\Models\User;
use App\Models\Espacio;
use App\Models\Reserva;
use App\Models\Resena;
use App\Models\MensajeContacto;

class MeetPointSeeder extends Seeder
{
    public function run(): void
    {
        // Usuarios
        $users = [
            [
                'name' => 'Admin',
                'apellidos' => 'Superuser',
                'email' => 'admin@example.com',
                'imagen_url' => 'img_subidas/users/admin.jpg',
                'password' => Hash::make('password'),
                'role' => 'admin',
            ],
            [
                'name' => 'Juan',
                'apellidos' => 'Pérez',
                'email' => 'juan@example.com',
                'imagen_url' => 'img_subidas/users/juan.jpg',
                'password' => Hash::make('password'),
                'role' => 'user',
            ],
            [
                'name' => 'Ana',
                'apellidos' => 'García',
                'email' => 'ana@example.com',
                'imagen_url' => 'img_subidas/users/ana.jpg',
                'password' => Hash::make('password'),
                'role' => 'user',
            ],
            [
                'name' => 'Pedro',
                'apellidos' => 'López',
                'email' => 'pedro@example.com',
                'imagen_url' => 'img_subidas/users/pedro.jpg',
                'password' => Hash::make('password'),
                'role' => 'user',
            ],
            [
                'name' => 'María',
                'apellidos' => 'Fernández',
                'email' => 'maria@example.com',
                'imagen_url' => 'img_subidas/users/maria.jpg',
                'password' => Hash::make('password'),
                'role' => 'user',
            ],
        ];

        $userModels = collect($users)->map(fn($data) => User::create($data));

        // Espacios
        $espacios = [
            [
                'nombre' => 'Sala de Reuniones A',
                'descripcion' => 'Espacio ideal para reuniones pequeñas.',
                'equipamiento' => 'Proyector, Pizarra, WiFi',
                'estado_espacio' => 'disponible',
                'precio_hora' => 25.00,
                'imagen_url' => 'img_subidas/salaA.jpg',
                'capacidad' => 10,
            ],
            [
                'nombre' => 'Sala de Conferencias B',
                'descripcion' => 'Perfecta para presentaciones y charlas.',
                'equipamiento' => 'Micrófono, Pantalla, Climatización',
                'estado_espacio' => 'no_disponible',
                'precio_hora' => 50.00,
                'imagen_url' => 'img_subidas/salaB.jpg',
                'capacidad' => 15,
            ],
            [
                'nombre' => 'Coworking Zona C',
                'descripcion' => 'Mesa abierta con enchufes y luz natural.',
                'equipamiento' => 'WiFi, Enchufes, Cafetera',
                'estado_espacio' => 'disponible',
                'precio_hora' => 15.00,
                'imagen_url' => 'img_subidas/zonaC.jpg',
                'capacidad' => 8,
            ],
            [
                'nombre' => 'Oficina Privada D',
                'descripcion' => 'Espacio cerrado para 2 personas.',
                'equipamiento' => 'Escritorios, Sillas, Aire Acondicionado',
                'estado_espacio' => 'disponible',
                'precio_hora' => 35.00,
                'imagen_url' => 'img_subidas/oficinaD.jpg',
                'capacidad' => 2,
            ],
            [
                'nombre' => 'Terraza Exterior E',
                'descripcion' => 'Ideal para descansos al aire libre.',
                'equipamiento' => 'Mesas, Sillas, Sombrillas',
                'estado_espacio' => 'no_disponible',
                'precio_hora' => 20.00,
                'imagen_url' => 'img_subidas/terrazaE.jpg',
                'capacidad' => 12,
            ],
        ];

        $espacioModels = collect($espacios)->map(fn($data) => Espacio::create($data));

        // Reservas estándar
        $reservas = [
            [ 'user_id' => 2, 'espacio_id' => 1 ],
            [ 'user_id' => 3, 'espacio_id' => 3 ],
            [ 'user_id' => 4, 'espacio_id' => 2 ],
            [ 'user_id' => 5, 'espacio_id' => 4 ],
            [ 'user_id' => 2, 'espacio_id' => 5 ],
        ];

        foreach ($reservas as $i => $reserva) {
            $fechaHora = Carbon::now()->addDays($i + 1);

            Reserva::create([
                'user_id'     => $reserva['user_id'],
                'espacio_id'  => $reserva['espacio_id'],
                'fecha_hora'  => $fechaHora,
                'fecha'       => $fechaHora->toDateString(),
                'pago_estado' => 'pendiente',
                'importe'     => 0,
            ]);
        }

        // ✅ Reserva adicional para Juan antes del 9 de junio de 2025
        $reservaAntigua = Carbon::create(2025, 6, 5, 10, 0, 0); // 5 de junio a las 10:00
        Reserva::create([
            'user_id'     => 2, // Juan
            'espacio_id'  => 1, // Sala de Reuniones A
            'fecha_hora'  => $reservaAntigua,
            'fecha'       => $reservaAntigua->toDateString(),
            'pago_estado' => 'pendiente',
            'importe'     => 0,
        ]);

        // Reseñas (algunas con comentario vacío)
        $resenas = [
            ['user_id' => 2, 'espacio_id' => 1, 'calificacion' => 5, 'comentario' => 'Excelente espacio, muy cómodo.'],
            ['user_id' => 3, 'espacio_id' => 2, 'calificacion' => 4, 'comentario' => null],
            ['user_id' => 4, 'espacio_id' => 3, 'calificacion' => 5, 'comentario' => null],
            ['user_id' => 5, 'espacio_id' => 4, 'calificacion' => 3, 'comentario' => 'Cómodo, pero algo ruidoso.'],
            ['user_id' => 2, 'espacio_id' => 5, 'calificacion' => 4, 'comentario' => 'Buen ambiente en la terraza.'],
        ];

        foreach ($resenas as $resena) {
            Resena::create($resena);
        }

        // Mensajes de contacto
        $mensajes = [
            ['user_id' => null, 'nombre' => 'Carlos Sánchez', 'email' => 'carlos@gmail.com', 'telefono' => '987456374', 'mensaje' => '¿Tienen disponibilidad este viernes por la tarde?'],
            ['user_id' => 2, 'nombre' => 'Laura Gómez', 'email' => 'laura@gmail.com', 'telefono' => '612345789', 'mensaje' => '¿Cómo reservo la sala de conferencias?'],
            ['user_id' => null, 'nombre' => 'Miguel Torres', 'email' => 'miguel@gmail.com', 'telefono' => '698765432', 'mensaje' => '¿Cuál es la tarifa por hora de la terraza?'],
            ['user_id' => 3, 'nombre' => 'Raquel Díaz', 'email' => 'raquel@gmail.com', 'telefono' => '600111222', 'mensaje' => '¿Puedo cancelar una reserva ya hecha?'],
            ['user_id' => null, 'nombre' => 'Sergio Martín', 'email' => 'sergio@gmail.com', 'telefono' => '611222333', 'mensaje' => 'Me gustaría un descuento para reservas recurrentes.'],
        ];

        foreach ($mensajes as $msg) {
            MensajeContacto::create($msg);
        }
    }
}
