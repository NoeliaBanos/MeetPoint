@extends('layouts.app')

@section('title', 'Detalle')

@section('content')
    <div class="hero-size position-relative">
        <img src="{{ asset($espacio->imagen_url) }}"
             alt="Foto de {{ $espacio->nombre }}">
        <div class="hero-text">
            <p><b>Aforo máximo:</b> {{ $espacio->capacidad }}</p>
            <h1 class="display-m">{{ $espacio->nombre }}</h1>
            <p><b>Precio:</b> {{ number_format($espacio->precio_hora, 2) }} €/hora</p>
        </div>
    </div>

    <p>{{ $espacio->descripcion }}</p>

    @auth
     @auth
<a href="{{ route('reservas.create', $espacio) }}" class="btn-custom">
    Reservar sala
</a>
@endauth

    @else
        <a href="{{ route('login') }}" class="btn-custom">
            Inicia sesión para reservar
        </a>
    @endauth

    <h2>Equipamiento</h2>
    <p>{{ $espacio->equipamiento }}</p>

    <hr>
    <h2>Reseñas</h2>

    @if($espacio->resenas->isEmpty())
        <p>Aún no hay reseñas para este espacio.</p>
    @else
        <section>
            @foreach($espacio->resenas as $resena)
                <article class="flex gap-4 p-4 border-b">
                    <div class="img-avatar">
                        <img src="https://ui-avatars.com/api/?name={{ urlencode($resena->user->name) }}&size=64"
                             alt="Avatar de {{ $resena->user->name }}"
                             width="64" height="64"
                             class="rounded-full object-cover">
                    </div>
                    <div class="flex-1">
                        <header class="flex justify-between items-center">
                            <strong>{{ $resena->user->name }}</strong>
                            <small>{{ $resena->created_at->format('d/m/Y') }}</small>
                        </header>
                        <div class="flex items-center mt-1 mb-2">
                            @for($i = 1; $i <= 5; $i++)
                                @if($i <= $resena->calificacion)
                                    <img src="{{ asset('images/star-2.png') }}"
                                         alt="★"
                                         style="width:50px; height:50px;">
                                @else
                                    <img src="{{ asset('images/star-0.png') }}"
                                         alt="☆"
                                         style="width:50px; height:50px;">
                                @endif
                            @endfor
                        </div>
                        <p>{{ $resena->comentario }}</p>
                    </div>
                </article>
            @endforeach
        </section>
    @endif

    @include('partials.footer')
@endsection
