<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Espacios</title>
</head>

<body>
    <nav>
        <p>MeetPoint
            <a href="{{ route('espacios.index') }}">Espacios</a>
            <a href="{{ route('resenas.index') }}">Reseñas</a>
            <a href="{{ route('contacto.create') }}">Contacto</a></p>
    </nav>
    <h1>Lista de Espacios</h1>
    <img src="https://picsum.photos/600/300" alt="">
    <h2>Espacios en Utrera</h2>

    @foreach ($espacios as $espacio)
        <div style="border: 1px solid black; padding:10px; margin:10px; width:25%">
            <img src="https://picsum.photos/200/200" alt="">
            <h2>
                <a href="{{ route('espacios.show', $espacio->id) }}">{{ $espacio->nombre }}</a>
            </h2>
            <hr>
            <p>Precio: <b>{{ $espacio->precio_hora }} €</b></p>
            <p>Equipamiento: <b>{{ $espacio->equipamiento }}</b></p>
            <p>Reseñas: <b>2,4</b></p>
            <a href="{{ route('espacios.show', $espacio->id) }}">+ INFO</a>
        </div>
    @endforeach

    <footer style="background-color: rgb(197, 197, 197); text-decoration:none;">
    
        <a href="{{ route('espacios.index') }}">Espacios</a>
        <a href="{{ route('resenas.index') }}">Reseñas</a>
        {{-- <a href="">Iniciar sesión</a> --}}
        <a href="{{ route('contacto.create') }}">Contacta con nosotros</a>
        <a href="{{ route('legal') }}">Información legal</a>
 <p>MeetPoint &copy; 2025</p>
   </footer>

</body>

</html>
