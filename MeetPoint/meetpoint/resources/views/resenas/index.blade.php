<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mis Reseñas</title>
</head>
<body>
    <h1>Mis Reseñas</h1>
    <ul>
        @foreach ($resenas as $resena)
            <li>
                <strong>Espacio:</strong> {{ $resena->espacio->nombre }} <br>
                <strong>Calificación:</strong> {{ $resena->calificacion }} <br>
                <p>{{ $resena->comentario }}</p>
                <form action="{{ route('resenas.destroy', $resena->id) }}" method="POST">
                    @csrf
                    @method('DELETE')
                    <button type="submit">Eliminar Reseña</button>
                </form>
            </li>
        @endforeach
    </ul>
</body>
</html>
