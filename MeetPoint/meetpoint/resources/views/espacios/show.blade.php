@extends('layouts.app')

@section('title', 'Detalle')

@section('content')

    <h3>Aforo máximo: {{ $espacio->capacidad }}</h3>
    <h3>Precio: {{ $espacio->precio_hora }} €/hora</h3>
    <h1>{{ $espacio->nombre }}</h1>
    <img width="100%" src="https://picsum.photos/1200/400" alt="">
    <img src="https://picsum.photos/120/50" alt="">
    <img src="https://picsum.photos/120/51" alt="">
    <img src="https://picsum.photos/120/52" alt="">
    <div width="100%"></div>
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
                    <img src="https://ui-avatars.com/api/?name={{ urlencode($resena->user->name) }}&size=64"
                        alt="Avatar de {{ $resena->user->name }}" width="64" height="64"
                        style="border-radius:50%; object-fit:cover;">

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
