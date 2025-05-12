@extends('layouts.app')

@section('title', 'Reseñas')

@section('content')

    {{-- MAIN CONTENT --}}
    <h1>Reseñas</h1>

    @if ($resenas->isEmpty())
        <p>Aún no hay reseñas.</p>
    @else
        <section>
            @foreach ($resenas as $resena)
                <article style="display:flex; gap:1rem; padding:1rem 0; border-bottom:1px solid #ccc;">
                    {{-- Avatar del usuario --}}
                    <div style="width:70px">
    <img src="https://ui-avatars.com/api/?name={{ urlencode($resena->user->name) }}&size=64"
                        alt="Avatar de {{ $resena->user->name }}" width="64" height="64"
                        style="border-radius:50%; object-fit:cover;">
                    </div>
                

                    <div style="flex:1;">
                        {{-- Nombre de usuario, espacio y fecha --}}
                        <header style="display:flex; justify-content:space-between; align-items:center;">
                            <div>
                                <strong>{{ $resena->user->name }}</strong>
                                <small style="margin-left:.5rem; color:#555;">
                                    en {{ $resena->espacio->nombre }}
                                </small>
                            </div>
                            <small style="color:#888;">
                                {{ $resena->created_at->format('d/m/Y') }}
                            </small>
                        </header>

                        {{-- Puntuación con estrellas --}}
                        <div aria-label="Calificación: {{ $resena->calificacion }} de 5" style="margin:.5rem 0;">
                            @for ($i = 1; $i <= 5; $i++)
                                @if ($i <= $resena->calificacion)
                                    <span style="color:gold; font-size:1.1rem;">&#9733;</span>
                                @else
                                    <span style="color:#d3d3d3; font-size:1.1rem;">&#9733;</span>
                                @endif
                            @endfor
                        </div>

                        {{-- Comentario --}}
                        <p style="margin:0;">{{ $resena->comentario }}</p>
                    </div>
                </article>
            @endforeach
        </section>
    @endif

    {{-- FOOTER --}}
  @include('partials.footer')

@endsection
