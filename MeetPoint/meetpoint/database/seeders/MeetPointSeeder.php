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
        // ------------------------------------------------------------
        // 1) Usuarios
        // ------------------------------------------------------------
        $users = [
            ['name'=>'Admin','apellidos'=>'Superuser','email'=>'admin@example.com','imagen_url'=>'img_subidas/users/admin.jpg','password'=>Hash::make('password'),'role'=>'admin'],
            ['name'=>'Juan','apellidos'=>'Pérez','email'=>'juan@example.com','imagen_url'=>'img_subidas/users/juan.jpg','password'=>Hash::make('password'),'role'=>'user'],
            ['name'=>'Ana','apellidos'=>'García','email'=>'ana@example.com','imagen_url'=>'img_subidas/users/ana.jpg','password'=>Hash::make('password'),'role'=>'user'],
            ['name'=>'Pedro','apellidos'=>'López','email'=>'pedro@example.com','imagen_url'=>'img_subidas/users/pedro.jpg','password'=>Hash::make('password'),'role'=>'user'],
            ['name'=>'María','apellidos'=>'Fernández','email'=>'maria@example.com','imagen_url'=>'img_subidas/users/maria.jpg','password'=>Hash::make('password'),'role'=>'user'],
            // Nuevos según captura
            ['name'=>'Aitor','apellidos'=>'Martínez','email'=>'aitor@example.com','imagen_url'=>'img_subidas/users/aitor.jpg','password'=>Hash::make('password'),'role'=>'user'],
            ['name'=>'Paloma','apellidos'=>'Rodríguez','email'=>'paloma@example.com','imagen_url'=>'img_subidas/users/paloma.jpg','password'=>Hash::make('password'),'role'=>'user'],
            ['name'=>'Antonio','apellidos'=>'Gómez','email'=>'antonio@example.com','imagen_url'=>'img_subidas/users/antonio.jpg','password'=>Hash::make('password'),'role'=>'user'],
        ];

        collect($users)->each(fn($data) => User::create($data));

        // ------------------------------------------------------------
        // 2) Espacios
        // ------------------------------------------------------------
        $espacios = [
            [
                'nombre'=>'Sala de Reuniones A',
                'descripcion'=>'Espacio ideal para reuniones pequeñas.',
                'equipamiento'=>'Proyector, Pizarra, WiFi',
                'estado_espacio'=>'disponible',
                'precio_hora'=>25.00,
                'imagen_url'=>'img_subidas/salaA.jpg',
                'capacidad'=>10,
                'hora_apertura'=>'09:00:00',
                'hora_cierre'=>'21:00:00',
            ],
            [
                'nombre'=>'Sala de Conferencias B',
                'descripcion'=>'Perfecta para presentaciones y charlas.',
                'equipamiento'=>'Micrófono, Pantalla, Climatización',
                'estado_espacio'=>'no_disponible',
                'precio_hora'=>50.00,
                'imagen_url'=>'img_subidas/salaB.jpg',
                'capacidad'=>15,
                'hora_apertura'=>'09:00:00',
                'hora_cierre'=>'21:00:00',
            ],
            [
                'nombre'=>'Coworking Zona C',
                'descripcion'=>'Mesa abierta con enchufes y luz natural.',
                'equipamiento'=>'WiFi, Enchufes, Cafetera',
                'estado_espacio'=>'disponible',
                'precio_hora'=>15.00,
                'imagen_url'=>'img_subidas/zonaC.jpg',
                'capacidad'=>8,
                'hora_apertura'=>'09:00:00',
                'hora_cierre'=>'21:00:00',
            ],
            [
                'nombre'=>'Oficina Privada D',
                'descripcion'=>'Espacio cerrado para 2 personas.',
                'equipamiento'=>'Escritorios, Sillas, Aire Acondicionado',
                'estado_espacio'=>'disponible',
                'precio_hora'=>35.00,
                'imagen_url'=>'img_subidas/oficinaD.jpg',
                'capacidad'=>2,
                'hora_apertura'=>'09:00:00',
                'hora_cierre'=>'21:00:00',
            ],
            [
                'nombre'=>'Terraza Exterior E',
                'descripcion'=>'Ideal para descansos al aire libre.',
                'equipamiento'=>'Mesas, Sillas, Sombrillas',
                'estado_espacio'=>'no_disponible',
                'precio_hora'=>20.00,
                'imagen_url'=>'img_subidas/terrazaE.jpg',
                'capacidad'=>12,
                'hora_apertura'=>'09:00:00',
                'hora_cierre'=>'21:00:00',
            ],
        ];

        collect($espacios)->each(fn($data) => Espacio::create($data));

        // ------------------------------------------------------------
        // 3) Reservas de ejemplo
        // ------------------------------------------------------------
        $reservas = [
            ['user_id'=>2,'espacio_id'=>1],
            ['user_id'=>3,'espacio_id'=>3],
            ['user_id'=>4,'espacio_id'=>2],
            ['user_id'=>5,'espacio_id'=>4],
            ['user_id'=>2,'espacio_id'=>5],
        ];

        foreach ($reservas as $i => $r) {
            $date = Carbon::now()->addDays($i + 1)->toDateString();
            $entrada = '09:00:00';
            $salida  = '10:00:00';
            Reserva::create([
                'user_id'      => $r['user_id'],
                'espacio_id'   => $r['espacio_id'],
                'fecha_hora'   => Carbon::parse("$date $entrada"),
                'fecha'        => $date,
                'hora_entrada' => $entrada,
                'hora_salida'  => $salida,
                'pago_estado'  => 'pendiente',
                'importe'      => 0,
            ]);
        }

        // Reserva antigua fija
        $old = Carbon::create(2025, 6, 5, 10, 0, 0);
        Reserva::create([
            'user_id'      => 2,
            'espacio_id'   => 1,
            'fecha_hora'   => $old,
            'fecha'        => $old->toDateString(),
            'hora_entrada' => $old->format('H:i:s'),
            'hora_salida'  => $old->copy()->addHour()->format('H:i:s'),
            'pago_estado'  => 'pendiente',
            'importe'      => 0,
        ]);

        // ------------------------------------------------------------
        // 4) Reseñas actualizadas según captura
        // ------------------------------------------------------------
        $resenas = [
            ['user_id'=>5,'espacio_id'=>4,'calificacion'=>2,'comentario'=>'Cómodo, aunque algo ruidoso por momentos.'],
            ['user_id'=>2,'espacio_id'=>5,'calificacion'=>4,'comentario'=>'Buen ambiente en la terraza, con vistas agradables.'],
            ['user_id'=>6,'espacio_id'=>1,'calificacion'=>5,'comentario'=>'Espacio muy bien equipado, aunque hubo un pequeño percance cerca de la papelera en la entrada que dejó un olor desagradable.'],
            ['user_id'=>6,'espacio_id'=>1,'calificacion'=>2,'comentario'=>'Encontré un derrame bajo la silla que generó un olor fuerte; recomendaría mejorar la limpieza posterior.'],
            ['user_id'=>7,'espacio_id'=>1,'calificacion'=>1,'comentario'=>'Había un olor muy intenso al entrar, sería bueno reforzar la limpieza periódica.'],
            ['user_id'=>6,'espacio_id'=>3,'calificacion'=>5,'comentario'=>'No es mi ambiente favorito, pero las conversaciones fueron muy amenas. Por cierto, Antonio tuvo un percance con su mascota; ¡espero que se recupere pronto!'],
            ['user_id'=>8,'espacio_id'=>3,'calificacion'=>5,'comentario'=>'La gente es muy amable; un compañero con quien charlé me alegró el día. Muy recomendable por su vibra.'],
        ];

        collect($resenas)->each(fn($r) => Resena::create($r));

        // ------------------------------------------------------------
        // 5) Mensajes de contacto
        // ------------------------------------------------------------
        $mensajes = [
            ['user_id'=>null,'asunto'=>'Disponibilidad viernes por la tarde','email'=>'carlos@gmail.com','telefono'=>'987456374','mensaje'=>'¿Tienen disponibilidad este viernes por la tarde?'],
            ['user_id'=>2,'asunto'=>'Cómo reservar la sala de conferencias','email'=>'laura@gmail.com','telefono'=>'612345789','mensaje'=>'¿Cómo reservo la sala de conferencias?'],
            ['user_id'=>null,'asunto'=>'Tarifa por hora de la terraza','email'=>'miguel@gmail.com','telefono'=>'698765432','mensaje'=>'¿Cuál es la tarifa por hora de la terraza?'],
            ['user_id'=>3,'asunto'=>'Cancelar una reserva existente','email'=>'raquel@gmail.com','telefono'=>'600111222','mensaje'=>'¿Puedo cancelar una reserva ya hecha?'],
            ['user_id'=>null,'asunto'=>'Descuento para reservas recurrentes','email'=>'sergio@gmail.com','telefono'=>'611222333','mensaje'=>'Me gustaría un descuento para reservas recurrentes.'],
        ];

        collect($mensajes)->each(fn($m) => MensajeContacto::create($m));
    }
}
