<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mis Reservas</title>
</head>
<body>
    <h1>Mis Reservas</h1>
    <ul>
        @foreach ($reservas as $reserva)
            <li>
                <strong>Espacio:</strong> {{ $reserva->espacio->nombre }} <br>
                <strong>Fecha:</strong> {{ $reserva->fecha }} <br>
                <form action="{{ route('reservas.destroy', $reserva->id) }}" method="POST">
                    @csrf
                    @method('DELETE')
                    <button type="submit">Eliminar Reserva</button>
                </form>
            </li>
        @endforeach
    </ul>
</body>
</html>
