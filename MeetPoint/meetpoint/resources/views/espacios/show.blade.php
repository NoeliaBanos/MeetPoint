@extends('layouts.app')

@section('title', 'Detalle')

@section('content')

    <div class="hero-size">
        {{-- La imagen de fondo (desde BBDD, ruta en imagen_url) --}}
        <img src="{{ asset($espacio->imagen_url) }}" alt="Foto de {{ $espacio->nombre }}">

        {{-- Texto superpuesto --}}
        <div class="hero-text">
            <p><b>Aforo máximo:</b> {{ $espacio->capacidad }}</p>
            <h1 class="display-m">{{ $espacio->nombre }}</h1>
            <p><b>Precio:</b> {{ number_format($espacio->precio_hora, 2) }} €/hora</p>
        </div>
    </div>


    <p>{{ $espacio->descripcion }}</p>
    <p><b>Añadir a favoritos</b></p>
    {{-- Botón para reservar una sala --}}
    @auth
        <a href="{{ route('reservas.create', ['espacio' => $espacio]) }}" class="btn">Reservar sala</a>
    @else
        <a href="{{ route('login') }}" class="btn">Inicia sesión para reservar</a>
    @endauth
    <h2>Equipamiento</h2>
    <p>{{ $espacio->equipamiento }}</p>
    <hr>
    <h2>Reseñas</h2>
    {{-- === Reseñas del espacio ============================================== --}}
    @if ($espacio->resenas->isEmpty())
        <p>Aún no hay reseñas para este espacio.</p>
    @else
        <section>
            @foreach ($espacio->resenas as $resena)
                <article style="display:flex; gap:1rem; padding:1rem 0; border-bottom:1px solid #ccc;">
                    {{-- Avatar del usuario (puedes sustituir src por tu propio campo/asset) --}}
                    <div class="img-avatar">
                        <img src="https://ui-avatars.com/api/?name={{ urlencode($resena->user->name) }}&size=64"
                            alt="Avatar de {{ $resena->user->name }}" width="64" height="64"
                            style="border-radius:50%; object-fit:cover;">

                    </div>

                    <div style="flex:1;">
                        {{-- Nombre y fecha --}}
                        <header style="display:flex; justify-content:space-between; align-items:center;">
                            <strong>{{ $resena->user->name }}</strong>
                            <small>{{ $resena->created_at->format('d/m/Y') }}</small>
                        </header>

                        {{-- Puntuación con estrellas --}}
                        <div aria-label="Calificación: {{ $resena->calificacion }} de 5">
                            @for ($i = 1; $i <= 5; $i++)
                                @if ($i <= $resena->calificacion)
                                    <span style="color:gold;">&#9733;</span>
                                @else
                                    <span style="color:#d3d3d3;">&#9733;</span>
                                @endif
                            @endfor
                        </div>

                        {{-- Comentario --}}
                        <p style="margin:.5rem 0 0 0;">{{ $resena->comentario }}</p>
                    </div>
                </article>
            @endforeach
        </section>
    @endif
    <!-- Aquí puedes agregar el botón de reserva o detalles adicionales -->
    {{-- FOOTER --}}
    @include('partials.footer')


@endsection
