<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reseñas</title>
</head>

<body>
    <nav>
        <p>MeetPoint
            <a href="{{ route('espacios.index') }}">Espacios</a>
            <a href="{{ route('resenas.index') }}">Reseñas</a>
            <a href="{{ route('contacto.create') }}">Contacto</a></p>
    </nav>
    <h1>Reseñas</h1>
    <ul>
        @foreach ($resenas as $resena)
            <img src="https://picsum.photos/100/100" alt="">
            <strong>Espacio:</strong> {{ $resena->espacio->nombre }} <br>
            <p>{{ $resena->comentario }}</p>
            <strong>Calificación:</strong> {{ $resena->calificacion }} <br>
            {{-- <form action="{{ route('resenas.destroy', $resena->id) }}" method="POST">
                    @csrf
                    @method('DELETE')
                    <button type="submit">Eliminar Reseña</button>
                </form> --}}
        @endforeach
    </ul>
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
