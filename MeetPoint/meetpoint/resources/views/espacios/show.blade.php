<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $espacio->nombre }}</title>
</head>
<body>
    <h1>{{ $espacio->nombre }}</h1>
    <p>{{ $espacio->descripcion }}</p>
    <p>Capacidad: {{ $espacio->capacidad }}</p>
    <p>Precio: ${{ $espacio->precio }}</p>
    <!-- Aquí puedes agregar el botón de reserva o detalles adicionales -->
</body>
</html>
